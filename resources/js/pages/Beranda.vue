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

    <Navbar/>

    <section>
        <div class="flex w-full h-[600px] bg-emerald-900">
            <div class="flex flex-col justify-center w-1/2 pl-10 bg-emerald-900">
                <div class="max-w-lg p-8 ml-40 text-white">
                    <h2 class="mb-2 text-4xl font-bold">Ayo Tukarkan Sampahmu</h2>
                    <p class="text-xl">Jadikan lingkungan lebih bersih dengan cara menukar sampah kembali</p>
                </div>
            </div>
            <div class="flex justify-end w-1/2 bg-emerald-900">
                <img
                    src="/public/images/hero.png"
                    alt="Anak menukar sampah"
                    class="w-full h-full object-cover"
                />
            </div>
        </div>
        <div class="mt-24 ml-50 mr-50 px-10">
            <div class="mb-16 flex items-center gap-4">
                <hr class="h-1 w-24 bg-[#006662]" />
                <h1 class="text-3xl font-semibold text-[#006662]">
                    Fitur Unggulan Yang<br />
                    Tawarkan
                </h1>
            </div>
            <div class="flex flex-wrap justify-between">
                <FeatureItem :icon="'/images/phone.png'" title="Mudah Cepat" description="Proses penukaran yang mudah dipelajari dan dipahami" />
                <FeatureItem
                    :icon="'/images/calculator.png'"
                    title="Atur Jadwal"
                    description="Penukaran dapat disesuaikan berdasarkan tanggal dan waktu"
                />
                <FeatureItem :icon="'/images/paper.png'" title="Mudah Cepat" description="Banyak informasi mengenai sampah dan manfaatnya" />
            </div>
        </div>
        <div class="flex items-center gap-10 ml-50 mr-50 px-10 pt-24">
            <img src="/public/images/image.png" alt="" />
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-4">
                    <h1 class="text-3xl font-semibold text-[#006662]">Tentang Kami<br />ECOIN Merupakan</h1>
                    <hr class="h-1 w-24 bg-[#006662]" />
                </div>
                <p>
                    Ecoin merupakan aplikasi yang bertujuan sebagai wadah pertukaran sampah antara pengepul dan masyrakat. Dimana sampah tersebut akan
                    ditukarkan menjadi koin dan koin dapat ditukarkan dengan berbagai pilihan kupon seperti saldo e-wallet, potongan pembelanjaan, dan
                    lainnya. Aplikasi ini bertujuan untuk mengurangi dampak lingkungan dari sampah yang dihasilkan. Dengan adanya aplikasi ini sampah
                    yang khusunya plastik akan jauh lebih berkurang penggunaannya karena akan diolah Kembali
                </p>
                <img src="/public/images/app.png" alt="" class="size-fit" />
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 pt-24">
            <h1 class="text-center text-3xl font-semibold text-[#006662]">Cara Menukarkan<br />untuk mendapatkan poin</h1>
            <div class="flex flex-col justify-between gap-8 p-4 md:flex-row">
                <StepCard
                    :step="1"
                    title="Buat Akun"
                    description="Langkah Pertama, buat akun untuk bisa login dan bertransaksi"
                    linkText="Registrasi Akun"
                    linkHref="/login"
                />
                <StepCard
                    :step="2"
                    title="Tukar Sampah"
                    description="Langkah Kedua, pilih sampah dan tukarkan sesuai langkah-langkah"
                    linkText="Penukaran Sampah"
                    linkHref="/penukaran1"
                />
                <StepCard
                    :step="3"
                    title="Tukar koin"
                    description="Langkah Ketiga, dapatkan koin lalu tukar koin dengan kupon"
                    linkText="Dapatkan Kupon"
                    linkHref="/penukaran_koin"
                />
            </div>
        </div>
        <div class="flex flex-col items-center justify-center pt-9">
            <iframe
                width="560"
                height="315"
                src="https://www.youtube.com/embed/pnuiEGuThsI"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
            >
            </iframe>
            <div class="h-6 w-96 bg-teal-800"></div>
        </div>
        <div class="mt-16 flex items-center justify-between px-10 ml-50 mr-50">
            <div class="flex items-center gap-4">
                <hr class="h-1 w-24 bg-[#006662]" />
                <h1 class="text-3xl font-semibold text-[#006662]">
                    Tukar Koin Anda<br />
                    Menjadi Voucher
                </h1>
            </div>
            <div class="relative inline-block">
                <img src="/public/images/button.png" alt="" />
                <p class="absolute top-2 left-6 text-xl font-semibold text-white">Pilih Voucher</p>
            </div>
        </div>
        <div class="grid grid-cols-1 place-items-center gap-6 p-6 sm:grid-cols-2 md:grid-cols-3 ml-30 mr-30">
            <VoucherCard
                v-for="voucher in vouchers"
                :key="voucher.id"
                :voucher="voucher"
                @redeem="exchangeVoucher(voucher)"
            />
        </div>


        <div class="langganan">
            <h2>Berlangganan ECOIN</h2>
            <h3>Untuk Mendapatkan Informasi Terbaru</h3>
            <p>
                Masukkan emailmu dan dapatkan notifikasi informasi terbaru<br />dan
                terupdate tentang aplikasi
            </p>
            <div class="email-box">
                <input type="email" placeholder="Tulis Emailmu Disini ..." />
                <button class="btn send">
                    <img src="/public/images/ic_send.png" alt="Send" />
                </button>
            </div>
        </div>
    </section>

    <Footer/>

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
