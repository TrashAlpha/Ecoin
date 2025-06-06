<script setup>
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import RedeemMoneyModal from '@/components/RedeemMoneyModal.vue';

const scrollToSection = (id) => {
    const el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
    }
};

const user = ref(JSON.parse(localStorage.getItem('user')));
const userKoin = computed(() => user.value?.saldo_koin || 0);

const totalSaldo = computed(() => userKoin.value);

// Tukar Voucher logic
const vouchers = ref([]);
const isLoading = ref(true);
const errorMessage = ref('');

const exchangeVoucher = async (voucher) => {    
    console.log('Voucher yang diklik:', voucher);
    console.log('Nilai koin voucher:', voucher.nilai_koin);
    console.log('Saldo koin user:', user.value.saldo_koin);
    console.log('Voucher ID yang dikirim:', voucher.id);

    try {
        const response = await axios.post(
            '/api/exchange-voucher',
            { voucher_id: voucher.id },
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                },
            }
        );

        if (response.data.success) {
            const confirmed = confirm(response.data.confirmation.message);
            if (confirmed) {
                await confirmExchange(voucher.id);
            }
        } else {
            alert(response.data.message || 'Penukaran gagal.');
        }
    } catch (error) {
        console.error('Gagal menukar voucher:', error);
        console.log('Response data:', error.response ? error.response.data : 'Tidak ada response data');
        alert(error.response?.data?.message || 'Terjadi kesalahan saat memproses penukaran.');
    }
};

const confirmExchange = async (voucherId) => {
    try {
        const response = await axios.post(
            '/api/confirm-exchange',
            { voucher_id: voucherId },
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                },
            }
        );

        if (response.data.success) {
            alert('Penukaran berhasil!');
            // Update saldo di localStorage
            user.value.saldo_koin = response.data.updated_coin_balance;
            localStorage.setItem('user', JSON.stringify(user.value));
            window.location.reload();
        } else {
            alert(response.data.message || 'Penukaran gagal.');
        }
    } catch (error) {
        console.error('Gagal konfirmasi penukaran:', error);
        alert('Terjadi kesalahan saat konfirmasi penukaran.');
    }
};

// Tukar Rupiah logic
// Data untuk tukar rupiah
const transferMethods = ref([]);
const selectedMethod = ref(null);
const coinAmount = ref('');
const showModal = ref(false);

// Fungsi untuk memuat metode transfer
const loadTransferMethods = async () => {
    try {
        const response = await axios.get('/api/transfer-methods', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'application/json',
            }
        });
        
        if (response.data.success) {
            transferMethods.value = response.data.methods;
        } else {
            console.error('Gagal memuat metode transfer');
        }
    } catch (error) {
        console.error('Error:', error);
    }
};

// Fungsi untuk memilih metode transfer
const selectMethod = (method) => {
    selectedMethod.value = method;
    calculateRupiah();
};

// Fungsi untuk menghitung konversi ke rupiah
const calculateRupiah = () => {
    if (!selectedMethod.value || !coinAmount.value) return;
    
    const amount = parseInt(coinAmount.value);
    if (isNaN(amount) || amount <= 0) return;
    
    const rupiahAmount = (amount * 1000) - selectedMethod.value.admin_fee;
    return rupiahAmount > 0 ? rupiahAmount : 0;
};

// Fungsi untuk memproses penukaran koin ke rupiah
const exchangeToMoney = async () => {
    if (!selectedMethod.value) {
        alert('Pilih metode transfer terlebih dahulu');
        return;
    }
    
    const amount = parseInt(coinAmount.value);
    if (isNaN(amount)) {
        alert('Masukkan jumlah koin yang valid');
        return;
    }
    
    if (amount <= 0) {
        alert('Jumlah koin harus lebih dari 0');
        return;
    }
    
    if (amount > user.value.saldo_koin) {
        alert('Saldo koin tidak mencukupi');
        return;
    }
    
    showModal.value = true;
};

// Fungsi untuk konfirmasi penukaran
const handleConfirm = (data) => {
    showModal.value = false;
    processMoneyExchange(data);
    alert(`Penukaran berhasil! Anda mendapatkan Rp ${calculateRupiah().toLocaleString('id-ID')}`);
    // Reset form
    selectedMethod.value = null;
    coinAmount.value = '';
};

const processMoneyExchange = async (data) => {
    try {
        const response = await axios.post(
            '/api/confirm-money-exchange',
            {
                transfer_method: selectedMethod.value.id,
                coin_amount: coinAmount.value,
                account_number: data.rekening,
                password: data.password
            },
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                },
            }
        );

        if (response.data.success) {
            // Update saldo user
            user.value.saldo_koin -= parseInt(coinAmount.value);
            localStorage.setItem('user', JSON.stringify(user.value));
        } else {
            alert(response.data.message || 'Penukaran gagal.');
        }
    } catch (error) {
        console.error('Gagal konfirmasi penukaran:', error);
        alert(error.response?.data?.message || 'Terjadi kesalahan saat konfirmasi penukaran.');
    }
};

onMounted(async () => {
    try {
        isLoading.value = true;
        // Load vouchers
        const vouchersResponse = await axios.get('/api/vouchers', {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (vouchersResponse.data && Array.isArray(vouchersResponse.data.vouchers)) {
            vouchers.value = vouchersResponse.data.vouchers;
        } else {
            throw new Error('Format data voucher tidak valid');
        }

        // Load transfer methods
        await loadTransferMethods();
    } catch (error) {
        console.error("Error:", error);
        errorMessage.value = 'Gagal memuat data. Silakan coba lagi.';
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <div class="penukaran-koin">
        <Navbar/>

        <div class="hero">
            <h1 class="title">Saldo Anda</h1>
            <div id="tampilan-saldo">
                <p id="total-saldo">{{ totalSaldo.toLocaleString() }}</p>
            </div>
            <h1 class="title">Ayo tukarkan Koin Anda</h1>
            <p class="subtitle">Tukar sekarang, bantu lingkungan & dapatkan reward!</p>

            <div class="btn-container">
                <button @click="scrollToSection('tukar-voucher')">Tukar ke Voucher</button>
                <button @click="scrollToSection('tukar-rupiah')">Tukar ke Rupiah</button>
            </div>
        </div>

        <!-- Tukar ke Voucher Section -->
        <div id="tukar-voucher">
            <h1>Tukar ke Voucher</h1>

            <!-- Loading state -->
            <div v-if="isLoading" class="loading-message">
                Memuat data voucher...
            </div>

            <!-- Error message -->
            <div v-if="errorMessage" class="error-message">
                {{ errorMessage }}
            </div>

            <!-- Voucher list -->
             <div class="container">
                <div v-for="voucher in vouchers" :key="voucher.id" class="card">
                    <img :src="voucher.image_url || '/images/logo.png'" alt="Voucher Image">
                    <div class="info">
                        <h3 class="nama-voucher">{{ voucher.nama_voucher }}</h3>
                        <p class="nilai-koin">{{ voucher.nilai_koin.toLocaleString() }} Koin</p>
                        <div class="deskripsi-container">
                            <p class="deskripsi">{{ voucher.deskripsi }}</p>
                        </div>
                        <div class="button-container">
                            <button
                                class="tukar-btn"
                                @click="exchangeVoucher(voucher)">
                                Tukar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tukar ke Rupiah Section -->
        <div id="tukar-rupiah">
            <div class="form">
                <h1>Tukar ke Rupiah</h1>
                <form @submit.prevent="exchangeToMoney">
                    <label for="koin-yang-ditukar">Koin yang ditukarkan</label><br>
                    <input 
                        type="number" 
                        v-model="coinAmount" 
                        id="koin_yang_ditukar" 
                        placeholder="Masukkan jumlah koin"
                        :disabled="!selectedMethod"
                        @input="calculateRupiah">
                    <br>
                    
                    <label for="konversi-rupiah">Konversi ke Rupiah</label><br>
                    <input 
                        type="text" 
                        :value="calculateRupiah() > 0 ? 'Rp ' + calculateRupiah().toLocaleString('id-ID') : ''" 
                        id="konversi_rupiah" 
                        readonly>
                    <br>

                    <button type="button" @click="selectedMethod = null; coinAmount = ''">Kembali</button>
                    <button 
                        type="submit" 
                        :disabled="!selectedMethod || !coinAmount">
                        Tukarkan
                    </button>
                </form>
            </div>
            
            <div class="opsi-transfer">
                <label>Opsi Transfer</label>
                <div class="opsi-grid">
                    <div 
                        v-for="method in transferMethods" 
                        :key="method.id"
                        class="bank-card"
                        :class="{ selected: selectedMethod?.id === method.id }"
                        @click="selectMethod(method)">
                        <img :src="`/images/ic_${method.id}.png`" :alt="method.name">
                        <div class="info">
                            <span class="nama-bank">{{ method.name }}</span>
                            <span class="total-judul">Biaya Admin</span>
                            <span class="total-nominal">Rp {{ method.admin_fee.toLocaleString('id-ID') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Footer/>

        <!-- Modal untuk konfirmasi penukaran -->
        <RedeemMoneyModal
            v-if="showModal"
            :visible="showModal"
            :coins="coinAmount"
            :bankName="selectedMethod?.name"
            :adminFee="selectedMethod?.admin_fee"
            icon="/images/GroupMoney.png"
            @cancel="showModal = false"
            @confirm="handleConfirm"
        />

    </div>
</template>

<style scoped>
    .penukaran-koin {
        font-family: var(--fontfamily);
        background-color: var(--backgroundWhite);
        color: var(--textBlack);
    }

    /* Hero */
    .hero {
        background-color: var(--primaryGreen);
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        align-items: center;
        padding: 50px;
        width: auto;
        height: 550px;
    }
    .title {
        color: var(--textField);
        font-weight: bold;
        font-size: 32px;
    }
    .hero #tampilan-saldo {
        padding: 10px;
        background-color: var(--textField);
        width: 550px;
        height: 50px;
        margin-top: 30px;
        margin-bottom: 30px;
        border-radius: 4px;
    }
    .hero #total-saldo {
        color: var(--textBlack);
        font-size: 20px;
        font-weight: 600;
    }
    .subtitle {
        margin-top: 20px;
        color: var(--textField);
        font-size: 20px;
        font-weight: 400;
    }
    .btn-container {
        display: flex;
        flex-direction: row;
        margin-top: 50px;
        gap: 20px;

    }
    .btn-container button {
        background-color: var(--accentGreen2);
        padding: 20px;
        color: var(--textBlack);
        font-size: 24px;
        font-weight: 600;
        border-radius: 4px;
    }
    .btn-container button:hover {
        background-color: var(--accentGreen1);
    }

    /* Tambahkan style untuk loading dan error message */
    .loading-message, .error-message {
        text-align: center;
        padding: 20px;
        font-size: 18px;
        color: var(--primaryGreen);
    }

    .error-message {
        color: var(--accentRed);
    }

    /* Tukar ke Voucher */
    #tukar-voucher {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px 5%;
    }
    #tukar-voucher h1 {
        color: var(--primaryGreen);
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 25px;
    }
    .container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%; /* Pastikan semua card memiliki tinggi yang sama */
    }

    .card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .info {
        padding: 15px;
        display: flex;
        flex-direction: column;
        flex-grow: 1; /* Mengisi ruang tersisa */
    }

    .nama-voucher {
        color: var(--primaryGreen);
        font-size: 20px;
        margin-bottom: 10px;
        min-height: 24px; /* Tinggi tetap untuk judul */
    }

    .nilai-koin {
        font-weight: bold;
        color: var(--textBlack);
        font-size: 18px;
        margin-bottom: 10px;
        min-height: 20px; /* Tinggi tetap untuk nilai koin */
    }

    .deskripsi-container {
        flex-grow: 1; /* Mengisi ruang tersisa */
        margin-bottom: 15px;
        overflow: hidden; /* Untuk deskripsi yang panjang */
    }

    .deskripsi {
        color: var(--textGrey);
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Batasi jumlah baris */
        -webkit-box-orient: vertical;
        line-clamp: 3;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .button-container {
        margin-top: auto; /* Dorong tombol ke bawah */
        padding-top: 10px;
    }

    .tukar-btn {
        background-color: var(--primaryGreen);
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        font-weight: bold;
        margin-top: auto; /* Pastikan tombol selalu di bawah */
    }

    .tukar-btn:hover {
        background-color: var(--accentGreen1);
    }

    /* Tukar ke Rupiah */
    #tukar-rupiah {
        display: flex;
        justify-content: space-between;
        gap: 24px;
        padding: 40px 5%;
        flex-wrap: wrap;
    }
    #tukar-rupiah h1 {
        color: var(--primaryGreen);
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 25px;
    }
    #tukar-rupiah label {
        color: var(--primaryGreen);
        font-size: 24px;
        font-weight: bold;
    }

    /* Form */
    .form input {
        background-color: var(--accentGreen1);
        padding: 12px;
        margin-top: 20px;
        margin-bottom: 20px;
        width: 500px;
        border-radius: 4px;
    }
    .form button {
        background-color: var(--accentGreen1);
        margin-right: 10px;
        padding: 10px;
        width: 150px;
        color: var(--textField);
        font-size: 20px;
        font-weight: bold;
        border-radius: 4px;
    }
    .form button:hover {
        background-color: var(--primaryGreen);
    }

    /* Opsi Transfer */
    .opsi-transfer {
        flex: 1;
        min-width: 400px;
        max-width: 800px;
        margin-left: 200px;
    }

    .opsi-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 16px;
    }

    .bank-card {
        background-color: var(--accentGreen1);
        display: flex;
        align-items: center;
        padding: 12px 16px;
        gap: 12px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .bank-card img {
        width: 75px;
        height: auto;
        object-fit: contain;
        border-radius: 4px;
    }

    .bank-card .info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .nama-bank {
        background-color: var(--primaryGreen);
        padding: 2px 8px;
        color: var(--textField);
        font-size: 14px;
        font-weight: bold;
        border-radius: 4px;
    }

    .total-judul {
        margin-top: 4px;
        font-size: 16px;
        font-weight: bold;
        color: var(--textBlack);
    }

    .total-nominal {
        color: var(--textGrey);
        font-size: 14px;
    }

    /* Style untuk card yang dipilih */
    .bank-card.selected {
        background-color: var(--primaryGreen);
        color: white;
    }

    .bank-card.selected .nama-bank {
        background-color: var(--backgroundWhite);
        color: var(--primaryGreen);
    }

    .bank-card.selected .total-judul {
        color: var(--backgroundWhite);
    }

    .bank-card.selected .total-nominal {
        color: var(--backgroundWhite);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #tukar-rupiah {
            flex-direction: column;
        }
        
        .opsi-transfer {
            margin-left: 0;
            margin-top: 30px;
        }
        
        .form input {
            width: 100%;
        }
    }

    @media (max-width: 500px) {
        .opsi-transfer {
            min-width: 100%;
            margin-left: 0;
        }

        .opsi-grid {
            grid-template-columns: 1fr;
        }

        .bank-card {
            flex-direction: row;
            align-items: center;
        }
    }

</style>
