<script setup>
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const scrollToSection = (id) => {
    const el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
    }
};

const totalSaldo = ref(0);
const vouchers = ref([]);

onMounted(async () => {
    try {
        const user = JSON.parse(localStorage.getItem('user'));
        if (user) {
            // Fetch Saldo User
            const response = await axios.get(`/api/users/${user.id}/saldo`);
            totalSaldo.value = response.data.saldo;
            console.log("Saldo User:", totalSaldo.value);
        } else {
            console.warn("User not found in localStorage.");
        }
    } catch (error) {
        console.error("Error fetching saldo:", error);
        totalSaldo.value = 0; // Default jika terjadi error
    }

    try {
        // Fetch Voucher Terlepas dari Error Saldo
        const voucherResponse = await axios.get('/api/vouchers');
        vouchers.value = voucherResponse.data;
        console.log("Vouchers:", vouchers.value);
    } catch (error) {
        console.error("Error fetching vouchers:", error);
    }
});

</script>

<template>
    <div class="penukaran-koin">
        <Navbar/>

        <div class="hero">
            <h1 class="title">Saldo Anda</h1>
            <div id="tampilan-saldo">
                <p id="total-saldo">{{ totalSaldo }}</p>
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
            <div class="container">
                <div v-for="voucher in vouchers" :key="voucher.id" class="card">
                    <img :src="voucher.image_url || '/public/images/ic_blank.png'" alt="">
                    <div class="info">
                        <span class="nama-bank">{{ voucher.nama_voucher }}</span><br>
                        <span class="total-judul">{{ voucher.nilai_koin }} Koin</span><br>
                        <span class="total-nominal">{{ voucher.deskripsi }}</span>
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
        grid-template-columns: repeat(4, 2fr);
        gap: 16px;
    }
    .card {
        background-color: var(--accentGreen1);
        display: flex;
        align-items: center;
        padding: 12px 16px;
        gap: 12px;
    }
    .card img {
        width: 75px;
        height: auto;
        object-fit: contain;
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
