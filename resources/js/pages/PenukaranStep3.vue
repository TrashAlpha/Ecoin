<script setup lang="ts">
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';

function redirectToStep2(){
    window.location.href = '/penukaran2';
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
                    <label for="koin-yang-didapat">Koin yang Didapat</label><br>
                    <input type="text" name="" id="koin_yang_ditukar" readonly>
                    <br>

                    <button type="button" @click="redirectToStep2">Kembali</button>
                    <button type="submit">Tukarkan</button>
                </form>
            </div>
            <div class="opsi-transfer">
                <label>Opsi Transfer</label><br>
                <div class="opsi-grid">
                    <div class="voucher-card">
                        <img src="/public/images/pluxxe.png" alt="">
                        <div class="info">
                            <span class="voucher-name"> Koin</span><br>
                            <span class="total-judul">Detail Voucher</span><br>
                            <span class="total-nominal">detail</span>
                        </div>
                    </div>
                    <div class="voucher-card">
                        <img src="/public/images/shell.png" alt="">
                        <div class="info">
                            <span class="voucher-name"> Koin</span><br>
                            <span class="total-judul">Detail Voucher</span><br>
                            <span class="total-nominal">detail</span>
                        </div>
                    </div>
                    <div class="voucher-card">
                        <img src="/public/images/steam.jpg" alt="">
                        <div class="info">
                            <span class="voucher-name"> Koin</span><br>
                            <span class="total-judul">Detail Voucher</span><br>
                            <span class="total-nominal">detail</span>
                        </div>
                    </div>
                    <div class="voucher-card">
                        <img src="/public/images/indomaret.png" alt="">
                        <div class="info">
                            <span class="voucher-name"> Koin</span><br>
                            <span class="total-judul">Detail Voucher</span><br>
                            <span class="total-nominal">detail</span>
                        </div>
                    </div>
                    <div class="voucher-card">
                        <img src="/public/images/familymart.png" alt="">
                        <div class="info">
                            <span class="voucher-name"> Koin</span><br>
                            <span class="total-judul">Detail Voucher</span><br>
                            <span class="total-nominal">detail</span>
                        </div>
                    </div>
                    <div class="voucher-card">
                        <img src="/public/images/amazon.png" alt="">
                        <div class="info">
                            <span class="voucher-name"> Koin</span><br>
                            <span class="total-judul">Detail Voucher</span><br>
                            <span class="total-nominal">detail</span>
                        </div>
                    </div>
                    <div class="voucher-card">
                        <img src="/public/images/alfamidi.png" alt="">
                        <div class="info">
                            <span class="voucher-name"> Koin</span><br>
                            <span class="total-judul">Detail Voucher</span><br>
                            <span class="total-nominal">detail</span>
                        </div>
                    </div>
                    <div class="voucher-card">
                        <img src="/public/images/alfamart.png" alt="">
                        <div class="info">
                            <span class="voucher-name"> Koin</span><br>
                            <span class="total-judul">Detail Voucher</span><br>
                            <span class="total-nominal">detail</span>
                        </div>
                    </div>
                </div>
                <a href="/penukaran3_2" style="color: blue;">Atau tukar ke rupiah</a>
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
        align-items: center;   
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

    .step-indikator {
    text-align: start;
    margin-top: 60px;
    }

    .step-heading {
        display: flex;
        align-items: center;
        padding-left: 32px;
        gap: 12px;
        font-weight: var(--fontWeightBold);
        color: var(--primaryGreen);
        font-size: var(--fontSizeMedium);
        margin-bottom: 8px;
    }

    .heading-line {
        width: 100px;
        height: 5px;
        background-color: var(--primaryGreen);
        border-radius: 2px;
    }

    .steps {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-top: 32px;
        padding: 0 32px;
        gap: 40px;
        flex-wrap: wrap;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--primaryGreen);
        font-weight: var(--fontWeightSemiBold);
        font-size: var(--fontSizeNormal);
        min-width: 120px;
        justify-content: center;
        text-align: center;
    }

    .step span {
        background-color: var(--primaryGreen);
        color: white;
        padding: 6px 12px;
        font-weight: var(--fontWeightBold);
        box-shadow: -5px 5px 0 rgba(0, 0, 0, 0.25);
        opacity: 0.5;
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

    .konten {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
        margin-top: 30px;
        padding: 60px 32px;
        flex-wrap: nowrap;
    }

    @media (max-width: 768px) {
        .konten {
            flex-direction: column;
            align-items: stretch;
            flex-wrap: wrap;
        }
    }

    .konten label {
        color: var(--primaryGreen);
        font-size: 24px;
        font-weight: bold;
    }

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

    .voucher-card {
        background-color: var(--accentGreen1);
        display: flex;
        align-items: center;
        padding: 12px 16px;
        gap: 12px;
    }

    .voucher-card img {
        width: 75px;
        height: auto;
        object-fit: contain;
    }

    .voucher-card .info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .voucher-name {
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
