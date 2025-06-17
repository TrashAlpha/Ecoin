<script setup lang="ts">
import FeatureItem from '../components/FeatureItem.vue';
import StepCard from '../components/StepCard.vue';
import VoucherCard from '../components/VoucherCard.vue';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

import { ref, onMounted } from 'vue';
import axios from 'axios';

const vouchers = ref([]);
const isLoading = ref(true);

const exchangeVoucher = async (voucher: any) => {
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
    } catch (error: any) {
        alert(error?.response?.data?.message || 'Terjadi kesalahan saat menukar voucher.');
    }
};

const confirmExchange = async (voucherId: number) => {
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
        } else {
            alert(response.data.message || 'Penukaran gagal.');
        }
    } catch (error: any) {
        alert('Terjadi kesalahan saat konfirmasi penukaran.');
    }
};

onMounted(async () => {
    try {
        const res = await axios.get('/api/vouchers', {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        if (res.data && Array.isArray(res.data.vouchers)) {
            vouchers.value = res.data.vouchers;
        }
    } catch (e) {
        console.error('Gagal mengambil data voucher:', e);
    } finally {
        isLoading.value = false;
    }
});

</script>

<template>
  <Head title="Beranda" />
  <Navbar />

  <!-- Hero Section -->
  <section>
    <div class="flex flex-col md:flex-row w-full min-h-[400px] md:h-[600px] bg-emerald-900">
      <div class="flex flex-col justify-center w-full md:w-1/2 px-6 md:pl-10 text-white">
        <div class="max-w-xl py-8 mx-auto md:ml-40">
          <h2 class="mb-2 text-3xl md:text-4xl font-bold">Ayo Tukarkan Sampahmu</h2>
          <p class="text-lg md:text-xl">
            Jadikan lingkungan lebih bersih dengan cara menukar sampah kembali
          </p>
        </div>
      </div>
      <div class="flex justify-end w-full md:w-1/2">
        <img
          src="/public/images/hero.png"
          alt="Anak menukar sampah"
          class="w-full h-full object-cover max-h-[300px] md:max-h-none"
        />
      </div>
    </div>

    <!-- Fitur Unggulan -->
    <div class="mt-16 px-4 md:px-10 max-w-screen-xl mx-auto">
      <div class="mb-10 flex items-center gap-4">
        <hr class="h-1 w-16 md:w-24 bg-[#006662]" />
        <h1 class="text-2xl md:text-3xl font-semibold text-[#006662]">
          Fitur Unggulan Yang<br />Tawarkan
        </h1>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <FeatureItem icon="/images/phone.png" title="Mudah Cepat" description="Proses penukaran yang mudah dipelajari dan dipahami" />
        <FeatureItem icon="/images/calculator.png" title="Atur Jadwal" description="Penukaran dapat disesuaikan berdasarkan tanggal dan waktu" />
        <FeatureItem icon="/images/paper.png" title="Selalu Terkini" description="Banyak informasi mengenai sampah dan manfaatnya" />
      </div>
    </div>

    <!-- Tentang Kami -->
    <div class="flex flex-col md:flex-row items-center gap-10 px-4 md:px-10 pt-24 max-w-screen-xl mx-auto">
      <img src="/public/images/image.png" alt="" class="w-full md:w-[40%] object-cover" />
      <div class="flex flex-col gap-4 md:w-1/2">
        <div class="flex items-center gap-4">
          <h1 class="text-2xl md:text-3xl font-semibold text-[#006662]">
            Tentang Kami<br />ECOIN Merupakan
          </h1>
          <hr class="h-1 w-16 md:w-24 bg-[#006662]" />
        </div>
        <p class="text-sm md:text-base">
          Ecoin merupakan aplikasi yang bertujuan sebagai wadah pertukaran sampah antara pengepul dan masyrakat. Dimana sampah tersebut akan ditukarkan menjadi koin dan koin dapat ditukarkan dengan berbagai pilihan kupon seperti saldo e-wallet, potongan pembelanjaan, dan lainnya...
        </p>
        <img src="/public/images/app.png" alt="" class="h-auto max-w-[160px] md:max-w-[200px] lg:max-w-[250px] self-start" />
      </div>
    </div>

    <!-- Langkah -->
    <div class="flex flex-col items-center justify-center gap-4 pt-24 px-4 md:px-10">
      <h1 class="text-center text-2xl md:text-3xl font-semibold text-[#006662]">
        Cara Menukarkan<br />untuk mendapatkan poin
      </h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 p-4">
        <StepCard step="1" title="Buat Akun" description="Langkah Pertama, buat akun untuk bisa login dan bertransaksi" linkText="Registrasi Akun" linkHref="/login" />
        <StepCard step="2" title="Tukar Sampah" description="Langkah Kedua, pilih sampah dan tukarkan sesuai langkah-langkah" linkText="Penukaran Sampah" linkHref="/penukaran1" />
        <StepCard step="3" title="Tukar koin" description="Langkah Ketiga, dapatkan koin lalu tukar koin dengan kupon" linkText="Dapatkan Kupon" linkHref="/penukaran_koin" />
      </div>
    </div>

    <!-- Video -->
    <div class="flex flex-col items-center justify-center pt-12 px-4">
    <div class="w-full max-w-2xl aspect-video relative">
        <iframe
        class="absolute top-0 left-0 w-full h-full rounded-lg"
        src="https://www.youtube.com/embed/pnuiEGuThsI"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
        ></iframe>
    </div>
    <div class="h-2 w-32 bg-teal-800 mt-4"></div>
    </div>

    <!-- Voucher -->
    <div class="mt-16 px-4 md:px-10 max-w-screen-xl mx-auto">
      <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
          <hr class="h-1 w-16 md:w-24 bg-[#006662]" />
          <h1 class="text-2xl md:text-3xl font-semibold text-[#006662]">
            Tukar Koin Anda<br />Menjadi Voucher
          </h1>
        </div>
        <div class="relative">
          <img src="/public/images/button.png" alt="" class="w-36" />
          <p class="absolute top-2 left-4 text-sm md:text-xl font-semibold text-white">Pilih Voucher</p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 place-items-center">
        <VoucherCard
          v-for="voucher in vouchers"
          :key="voucher.id"
          :voucher="voucher"
          @redeem="exchangeVoucher(voucher)"
        />
      </div>
    </div>

    <!-- Langganan -->
    <div class="langganan">
        <h2>Berlangganan ECOIN</h2>
        <h3>Untuk Mendapatkan Informasi Terbaru</h3>
        <p>
            Masukkan emailmu dan dapatkan notifikasi informasi terbaru<br />
            dan terupdate tentang aplikasi
        </p>
        <div class="email-box">
            <input type="email" placeholder="Tulis Emailmu Disini ..." />
            <button class="btn send">
                <img src="/public/images/ic_send.png" alt="Send" />
            </button>
        </div>
    </div>
  </section>

  <Footer />
</template>


<style scoped>

/* Langganan */
.langganan {
    text-align: center;
    padding: 40px 20px 80px;
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

</style>
