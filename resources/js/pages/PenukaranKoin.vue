<script setup>
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const scrollToSection = (id) => {
    const el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
    }
};

const totalSaldo = computed(() => {
    const user = JSON.parse(localStorage.getItem('user'));
    return user ? user.saldo_koin : 0;
});

const vouchers = ref([]);
const isLoading = ref(true);
const errorMessage = ref('');

onMounted(async () => {
    try {
        isLoading.value = true;
        const response = await axios.get('/api/vouchers', {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        
        // Pastikan response.data memiliki array vouchers
        if (response.data && Array.isArray(response.data.vouchers)) {
            vouchers.value = response.data.vouchers;
            console.log("Vouchers data:", vouchers.value);
        } else {
            throw new Error('Format data voucher tidak valid');
        }
    } catch (error) {
        console.error("Error fetching vouchers:", error);
        errorMessage.value = 'Gagal memuat data voucher. Silakan coba lagi.';
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
                            <button class="tukar-btn">Tukar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="tukar-rupiah">
            <div class="form">
                <h1>Tukar ke Rupiah</h1>
                <form action="">
                    <label for="koin-yang-ditukar">Koin yang ditukarkan</label><br>
                    <input type="text" name="" id="koin_yang_ditukar" readonly>
                    <br>
                    <label for="konversi-rupiah">Konversi ke Rupiah</label><br>
                    <input type="text" name="" id="konversi_rupiah" readonly>
                    <br>

                    <button type="button" @click="redirectToStep2">Kembali</button>
                    <button type="submit">Tukarkan</button>
                </form>
            </div>
            <div class="opsi-transfer">
                <label>Opsi Transfer</label>
                <div class="opsi-grid">
                    <div class="bank-card">
                        <img src="/public/images/ic_bni.png" alt="">
                        <div class="info">
                            <span class="nama-bank">BNI</span><br>
                            <span class="total-judul">Total Transfer</span><br>
                            <span class="total-nominal">Rp. xxx.xxx.xxx,00</span>
                        </div>
                    </div>
                    <div class="bank-card">
                        <img src="/public/images/ic_bca.png" alt="">
                        <div class="info">
                            <span class="nama-bank">BCA</span><br>
                            <span class="total-judul">Total Transfer</span><br>
                            <span class="total-nominal">Rp. xxx.xxx.xxx,00</span>
                        </div>
                    </div>
                    <div class="bank-card">
                        <img src="/public/images/ic_bri.png" alt="">
                        <div class="info">
                            <span class="nama-bank">BRI</span><br>
                            <span class="total-judul">Total Transfer</span><br>
                            <span class="total-nominal">Rp. xxx.xxx.xxx,00</span>
                        </div>
                    </div>
                    <div class="bank-card">
                        <img src="/public/images/ic_mandiri.png" alt="">
                        <div class="info">
                            <span class="nama-bank">Mandiri</span><br>
                            <span class="total-judul">Total Transfer</span><br>
                            <span class="total-nominal">Rp. xxx.xxx.xxx,00</span>
                        </div>
                    </div>
                    <div class="bank-card">
                        <img src="/public/images/ic_bsi.png" alt="">
                        <div class="info">
                            <span class="nama-bank">BSI</span><br>
                            <span class="total-judul">Total Transfer</span><br>
                            <span class="total-nominal">Rp. xxx.xxx.xxx,00</span>
                        </div>
                    </div>
                    <div class="bank-card">
                        <img src="/public/images/ic_btn.png" alt="">
                        <div class="info">
                            <span class="nama-bank">BTN</span><br>
                            <span class="total-judul">Total Transfer</span><br>
                            <span class="total-nominal">Rp. xxx.xxx.xxx,00</span>
                        </div>
                    </div>
                    <div class="bank-card">
                        <img src="/public/images/ic_gopay.png" alt="">
                        <div class="info">
                            <span class="nama-bank">Gopay</span><br>
                            <span class="total-judul">Total Transfer</span><br>
                            <span class="total-nominal">Rp. xxx.xxx.xxx,00</span>
                        </div>
                    </div>
                    <div class="bank-card">
                        <img src="/public/images/ic_dana.png" alt="">
                        <div class="info">
                            <span class="nama-bank">Dana</span><br>
                            <span class="total-judul">Total Transfer</span><br>
                            <span class="total-nominal">Rp. xxx.xxx.xxx,00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Footer/>
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
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .form button {
        background-color: var(--accentGreen1);
        margin-right: 10px;
        padding: 10px;
        width: 150px;
        color: var(--textField);
        font-size: 20px;
        font-weight: bold;
    }
    .form button:hover {
        background-color: var(--primaryGreen);
    }

    /* Opsi Transfer */
    .opsi-transfer {
        flex: 1;
        max-width: 600px;
        margin-left: 200px;
    }

    .opsi-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    /* card */
    .bank-card {
        background-color: var(--accentGreen1);
        display: flex;
        align-items: center;
        padding: 12px 16px;
        gap: 12px;
    }

    .bank-card img {
        width: 75px;
        height: auto;
        object-fit: contain;
    }

    .bank-card .info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .nama-bank {
        background-color: var(--primaryGreen);
        width: 60px;
        padding: 2px 8px;
        color: var(--textField);
        font-size: 14px;
        font-weight: bold;
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

</style>
