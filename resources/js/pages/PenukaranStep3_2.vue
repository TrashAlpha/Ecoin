<script setup lang="ts">
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';

function redirectToStep2(){
    window.location.href = '/penukarans2';
}
</script>

<template>
    <div class="penukaran-step-3-2">
        <Navbar/>

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
                <form action="">
                    <label for="saldo-koin">Saldo Koin</label><br>
                    <input type="text" name="" id="saldo_koin" readonly>
                    <br>
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
                <a href="/penukarans3" style="color: blue;">Atau tukar ke voucher</a>
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

        <Footer/>
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
        max-height: 100%;
        object-fit: cover;
        padding:0 32px;
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
        z-index: 2;
    }
    .tab {
        display: flex;
        flex-direction: column;
        align-items: center;     /* Pusatkan horizontal */
        justify-content: center;
        padding: 10px 20px;
        margin: 0 5px;
        color: var(--backgroundWhite);
        font-weight: var(--fontWeightBold);
        cursor: pointer;
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
        min-width: 400px;
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
