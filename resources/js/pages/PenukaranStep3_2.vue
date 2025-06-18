<script setup lang="ts">
import { ref } from 'vue';
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';
import RedeemMoneyModal from "@/components/RedeemMoneyModal.vue";
import KonfirmasiPenukaranModal from '@/components/KonfirmasiPenukaran.vue';
import {onMounted, computed } from 'vue';
import axios from 'axios';


function redirectToStep2() {
  window.location.href = '/penukaran3';
}

const showModal = ref(false);
const selectedBank = ref<any>(null);
const showConfirmationModal = ref(false);


function openModal(bank: any) {
  selectedBank.value = bank;
}

function handleTukarkan() {
  if (!selectedMethod.value) {
    alert("Pilih bank atau e-wallet terlebih dahulu.");
    return;
  }
  showModal.value = true;
}

function handleCancel() {
  showModal.value = false;
}

// Tukar Rupiah logic
// Data untuk tukar rupiah
const transferMethods = ref([]);
const selectedMethod = ref(null);
const coinAmount = ref('');
const jumlahKoin = computed({
  get: () => coinAmount.value,
  set: (val) => (coinAmount.value = val)
});

const konversiRupiah = computed(() => {
  if (!selectedMethod.value || !coinAmount.value) return 0;
  const amount = parseInt(coinAmount.value);
  if (isNaN(amount) || amount <= 0) return 0;
  const rupiahAmount = (amount * 1000) - selectedMethod.value.admin_fee;
  return rupiahAmount > 0 ? rupiahAmount : 0;
});
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
            await fetchUserData(); // fetch ulang data user
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            alert(response.data.message || 'Penukaran gagal.');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    } catch (error) {
        console.error('Gagal konfirmasi penukaran:', error);
        alert(error.response?.data?.message || 'Terjadi kesalahan saat konfirmasi penukaran.');
    }
};

const user = ref(JSON.parse(localStorage.getItem('user')));

const fetchUserData = async () => {
  try {
    const response = await axios.get('/api/get-user', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      }
    });

    if (response.data.user) {
      user.value = response.data.user;
      localStorage.setItem('user', JSON.stringify(user.value));
    }
  } catch (error) {
    console.error('Gagal mengambil data user:', error);
  }
};

onMounted(() => {
  fetchUserData();
  loadTransferMethods();
});
</script>

<template>
  <div class="penukaran-step-3-2">
    <Navbar />

    <section class="hero">
      <img src="/public/images/heroPenukaran.png" alt="Penukaran Sampah" class="hero-image" />
      <div class="kategori-tabs">
        <div class="tab"><img src="/public/images/ic_plastic.png" alt=""> Non Organik</div>
        <div class="tab"><img src="/public/images/ic_leaf.png" alt=""> Organik</div>
        <div class="tab"><img src="/public/images/ic_mask.png" alt=""> Limbah Medis</div>
      </div>
    </section>

    <section class="step-indikator">
      <div class="step-heading">
        <div class="heading-line"></div>
        <p>Detail Sampah <br /> Yang Ditukarkan</p>
      </div>
      <div class="steps">
        <div class="step active"><span>1</span> Detail Sampah</div>
        <div class="step active"><span>2</span> Lokasi Penukaran</div>
        <div class="step active"><span>3</span> Konfirmasi Penukaran</div>
      </div>
    </section>

    <section class="konten">
      <div class="form">
        <form>
          <label for="saldo-koin">Saldo Koin</label><br>
          <input type="text" id="saldo_koin" :value="user?.saldo_koin || 0" readonly><br>

          <label for="koin-yang-ditukar">Koin yang ditukarkan</label><br>
          <input
            type="number"
            id="koin_yang_ditukar"
            v-model="jumlahKoin"
            min="0"
            onwheel="this.blur()"
          ><br>

          <label for="konversi-rupiah">Konversi ke Rupiah</label><br>
          <input type="text" id="konversi_rupiah" :value="`Rp ${konversiRupiah.toLocaleString('id-ID')}`" readonly><br>

          <button type="button" @click="redirectToStep2">Kembali</button>
          <button type="button" @click="handleTukarkan">Tukarkan</button>
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
            @click="selectMethod(method)"
          >
            <img :src="`/images/ic_${method.id}.png`" alt="">
            <div class="info">
              <span class="nama-bank">{{ method.name }}</span>
              <span class="total-judul">Biaya Admin</span>
              <span class="total-nominal">
                Rp. {{ method.admin_fee.toLocaleString("id-ID") }}
              </span>
            </div>
          </div>
        </div>

        <a href="/penukaran3" style="color: blue;">Atau tukar ke voucher</a>
      </div>
    </section>

    <section class="langganan">
      <h2>Berlangganan ECOIN</h2>
      <h3>Untuk Mendapatkan Informasi Terbaru</h3>
      <p>Masukkan emailmu dan dapatkan notifikasi informasi terbaru<br />dan terupdate tentang aplikasi</p>
      <div class="email-box">
        <input type="email" placeholder="Tulis Emailmu Disini ..." />
        <button class="btn send"><img src="/public/images/ic_send.png" alt="Send" /></button>
      </div>
    </section>

    <RedeemMoneyModal
      v-if="showModal"
      :visible="showModal"
      :coins="koinDitukar"
      :bankName="selectedBank?.name"
      :icon="'/images/GroupMoney.png'"
      @cancel="handleCancel"
      @confirm="handleConfirm"
    />

    <KonfirmasiPenukaranModal
      v-if="showConfirmationModal"
      :visible="showConfirmationModal"
      :icon="'/images/VerificationIcon.png'"
      :coins="parseInt(coinAmount)"
      :adminFee="selectedMethod?.admin_fee || 0"
      :bankName="selectedMethod?.nama_bank || 'Bank tidak dikenal'"
      @confirm="handleConfirm"
    />

    <Footer />
  </div>
</template>



<style scoped>
    .penukaran-step-3-2 {
        font-family: var(--fontFamily);
        background-color: var(--backgroundWhite);
        color: var(--textBlack);
    }
    /* Hero */
    .hero {
        position: relative;
        display: flex;
        justify-content: center;
    }

    .hero-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        /* padding:0 32px; */
    }

    /* Tabs di atas gambar */
    .kategori-tabs {
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        background-color: var(--primaryGreen);
        padding: 10px 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        z-index: 2;
    }
    .tab {
        width: 150px;
        display: flex;
        flex-direction: column;
        align-items: center;     /* Pusatkan horizontal */
        justify-content: center;
        padding: 10px 20px;
        margin: 0 5px;
        color: var(--backgroundWhite);
        font-weight: var(--fontWeightBold);
        cursor: pointer;
        border-radius: 5px;
        text-align: center;
    }
    .tab img {
        height: 20px;
        margin: 0 0 6px 0;
    }
    .tab:hover {
        background-color: var(--accentGreen1);
        color: var(--textBlack);
    }

    /* Step Indicator */
    .step-indikator {
    text-align: start;
    margin-top: 60px;
    }

    .step-heading {
        display: flex;
        align-items: center; /* tengah secara vertikal */
        padding-left: 32px;
        gap: 12px;
        font-weight: var(--fontWeightBold);
        color: var(--primaryGreen);
        font-size: var(--fontSizeMedium);
        margin-bottom: 8px;
    }

    .heading-line {
        width: 100px;            /* Panjang garis */
        height: 5px;            /* Tebal garis */
        background-color: var(--primaryGreen);
        border-radius: 2px;
    }

    .steps {
        display: flex;
        justify-content: space-between;  /* Center seluruh steps */
        width: 100%;
        margin-top: 32px;
        padding: 0 32px;
        gap: 40px; /* Jarak antar step */
        flex-wrap: wrap;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--primaryGreen);
        font-weight: var(--fontWeightSemiBold);
        font-size: var(--fontSizeNormal);
        min-width: 120px; /* Menjaga ukuran proporsional */
        justify-content: center; /* Center isi step */
        text-align: center;
    }

    .step span {
        background-color: var(--primaryGreen);
        color: white;
        padding: 6px 12px;
        font-weight: var(--fontWeightBold);
        box-shadow: -5px 5px 0 rgba(0, 0, 0, 0.25);
        opacity: 0.5; /* default non-aktif */
    }

    .step-active,
    .step.active {
        color: var(--primaryGreen);
    }

    .step-active span,
    .step.active span {
        opacity: 1;
    }

    .step.inactive {
        opacity: 0.5;
    }

    /* Langganan */
    .langganan {
        text-align: center;
        padding: 80px 20px 100px;
        background-color: #f9fdfb;
    }
    .langganan h2 {
        color: var(--primaryGreen);
        font-size: 24px;
        font-weight: 700;
    }
    .langganan h3 {
        color: var(--textBlack);
        font-size: 20px;
        margin-top: 8px;
    }
    .langganan p {
        color: var(--textGrey);
        font-size: 14px;
        margin: 12px 0;
    }
    .email-box {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .email-box input {
        padding: 12px;
        width: 400px;
        border: none;
        background-color: var(--textField);
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .btn.send {
        background-color: var(--primaryGreen);
        padding: 12px;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .btn.send img {
        height: 20px;
    }

    .btn.send:hover {
        background-color: var(--primaryGreen);
    }

    /* Konten */
    .konten {
        display: flex;
        justify-content: space-between;
        align-items: center; /* Center vertical */
        gap: 24px;
        margin-top: 30px;
        padding: 60px 32px;
        flex-wrap: nowrap; /* Hindari wrap agar vertical alignment bisa bekerja */
    }

    @media (max-width: 768px) {
        .konten {
            flex-direction: column;
            align-items: stretch; /* Agar responsif di mobile */
            flex-wrap: wrap;
        }
    }

    .konten label {
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

    .bank-card.selected {
      background-color: var(--primaryGreen);
      color: white;
      transition-duration: 0.5s;
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

    /* Media query untuk layar kecil */
    @media (max-width: 500px) {
        .opsi-transfer {
            min-width: 100%;
            margin-left: 0;
            margin-right: 0;
        }

        .bank-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .bank-card img {
            width: 100%;
            max-width: 100px;
        }
    }

</style>
