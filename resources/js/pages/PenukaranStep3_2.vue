<script setup lang="ts">
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';

</script>

<template>
    <div class="penukaran-step-3-2">
        <Navbar/>

        <section class="hero">
            <img src="/public/images/heroPenukaran.png" alt="Penukaran Sampah" class="hero-image" />
        </section>

        <!-- Nunggu dari alhtaf -->
        <!-- <section class="kategori">
            <div class="kategori-tabs">
            <div class="tab active"><img src="/public/images/ic_plastic.png" alt=""> Non Organik</div>
            <div class="tab">Organik</div>
            <div class="tab">Limbah Medis</div>
            </div>
        </section> -->

        <section class="step-indikator">
            <p>Detail Sampah <br /> Yang Ditukarkan</p>
            <div class="steps">
            <div class="step "><span>1</span> Detail Sampah</div>
            <div class="step "><span>2</span> Lokasi Penukaran</div>
            <div class="step active"><span>3</span> Konfirmasi Penukaran</div>
            </div>
        </section>

        <section class="konten">
            <h3>Saldo Koin</h3>
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

    /* Tabs */
    .kategori-tabs {
        position: absolute;
        bottom: +60px; /* membuat setengah bagian menutupi gambar */
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        background-color: var(--primaryGreen);
        padding: 10px 20px;
        z-index: 2;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .tab {
        padding: 10px 20px;
        margin: 0 5px;
        color: var(--backgroundWhite);
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .tab img {
        height: 20px;
        margin-right: 8px;
    }

    .tab.active {
        background-color: var(--accentGreen1);
        color: var(--textBlack);
    }

    /* Step Indicator */
    .step-indikator {
        text-align: center;
    }
    .steps {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 10px;
    }
    .step {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--textGrey);
    }
    .step span {
        background-color: var(--accentGreen2);
        padding: 6px 12px;
        border-radius: 4px;
        font-weight: bold;
        color: var(--backgroundWhite);
    }
    .step.active {
        color: var(--textBlack);
    }
    .step.active span {
        background-color: var(--primaryGreen);
    }

    /* Konten */
    .konten {
        display: flex;
        justify-content: space-between;
        gap: 24px;
        padding: 40px 5%;
        flex-wrap: wrap;
    }

</style>
