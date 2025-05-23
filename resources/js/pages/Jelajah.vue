<script setup>
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';

</script>

<template>
    <div class="jelajah">
        <Navbar/>

        <section class="hero">
            <img src="/public/images/heroJelajah.png" alt="Gambar Jelajah" class="hero-image" />
            <div class="hero-konten">
                <h1 class="judul">Ayo Jelajah dan<br>Telusuri</h1>
                <p>Cari dan gali informasi lebih mendalam mengenai<br>sampah serta manfaatnya</p>
            </div>
        </section>

        <section class="konten">
        <div class="konten-heading">
            <div class="heading-line"></div>
            <p>Informasi Mengenai <br> Sampah dan Manfaaatnya</p>
        </div>
        <div class="kegiatan-grid">
            <!-- BARIS ATAS: TEKS + GAMBAR -->
            <div class="baris-atas">
            <div class="kegiatan-teks">
                <h2>Kegiatan Peduli Lingkungan</h2>
                <p>
                Beberapa kegiatan positif untuk menjaga lingkungan telah dilakukan seperti
                bakti sosial dan seminar tentang pentingnya kebersihan.
                </p>
                <button>Lihat Lebih</button>
            </div>
            <div class="gambar-atas">
                <img src="/public/images/jelajahGambar1.png" alt="Gambar 1">
            </div>
            </div>

            <!-- BARIS BAWAH: 2 GAMBAR -->
            <div class="gambar-bawah">
                <img src="/public/images/jelajahGambar2.png" alt="Gambar 2">
                <img src="/public/images/jelajahGambar3.png" alt="Gambar 3">
            </div>
        </div>
        </section>

        <section class="artikel">
            <div class="artikel-heading">
                <h2>Artikel</h2>
                <h1>Bacaan Ecoin</h1>
                <div class="artikel-button">
                    <button>Semua</button>
                    <button>Terpopuler</button>
                    <button>Terbaru</button>
                </div>
            </div>
            <div class="artikel-grid">
                <div class="artikel-card">
                    <span class="koin-label">10 Koin</span>
                    <img src="/public/images/jelajahArtikel1.png" alt="Artikel">
                    <div class="card-body">
                        <h3>Memilah Sampah</h3>
                        <p>Menyesuaikan sampah dengan kategorinya dan kelompoknya...</p>
                        <div class="card-links">
                            <a href="#"><img src="/public/images/iconamoon_eye_light.png" class="icon"/> Baca Artikel</a>
                            <a href="#"><img src="/public/images/jam_write.png" class="icon"/> Buat Kuis</a>
                        </div>
                    </div>
                </div>
                <div class="artikel-card">
                    <span class="koin-label">10 Koin</span>
                    <img src="/public/images/jelajahArtikel2.png" alt="Artikel">
                    <div class="card-body">
                        <h3>Memilah Sampah</h3>
                        <p>Menyesuaikan sampah dengan kategorinya dan kelompoknya...</p>
                        <div class="card-links">
                            <a href="#"><img src="/public/images/iconamoon_eye_light.png" class="icon"/> Baca Artikel</a>
                            <a href="#"><img src="/public/images/jam_write.png" class="icon"/> Buat Kuis</a>
                        </div>
                    </div>
                </div>
                <div class="artikel-card">
                    <span class="koin-label">10 Koin</span>
                    <img src="/public/images/jelajahArtikel3.png" alt="Artikel">
                    <div class="card-body">
                        <h3>Memilah Sampah</h3>
                        <p>Menyesuaikan sampah dengan kategorinya dan kelompoknya...</p>
                        <div class="card-links">
                            <a href="#"><img src="/public/images/iconamoon_eye_light.png" class="icon"/> Baca Artikel</a>
                            <a href="#"><img src="/public/images/jam_write.png" class="icon"/> Buat Kuis</a>
                        </div>
                    </div>
                </div>
                <div class="artikel-card">
                    <span class="koin-label">10 Koin</span>
                    <img src="/public/images/jelajahArtikel1.png" alt="Artikel">
                    <div class="card-body">
                        <h3>Memilah Sampah</h3>
                        <p>Menyesuaikan sampah dengan kategorinya dan kelompoknya...</p>
                        <div class="card-links">
                            <a href="#"><img src="/public/images/iconamoon_eye_light.png" class="icon"/> Baca Artikel</a>
                            <a href="#"><img src="/public/images/jam_write.png" class="icon"/> Buat Kuis</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="artikel-button">
                <button>Selengkapnya</button>
            </div>
        </section>

        <!-- TODO: Benerin CARD dan Gambarnya -->
        <section class="konten">
            <div class="konten-heading">
                <div class="heading-line"></div>
                <p>Beberapa Produk Daur <br> Ulang Sampah</p>
            </div>
            <div class="belanja">
                <div class="produk-card">
                    <img src="/public/images/jelajahBelanja1.png" alt="Produk 1" />
                    <div class="produk-info">
                        <p class="keterangan">Dompet Kecil</p>
                        <p class="harga">Rp 20.500</p>
                    </div>
                </div>
                <div class="produk-card">
                    <img src="/public/images/jelajahBelanja2.png" alt="Produk 1" />
                    <div class="produk-info">
                        <p class="keterangan">Tas Besar</p>
                        <p class="harga">Rp 30.000</p>
                    </div>
                </div>
                <div class="produk-card">
                    <img src="/public/images/jelajahBelanja3.png" alt="Produk 1" />
                    <div class="produk-info">
                        <p class="keterangan">Kandang Hewan</p>
                        <p class="harga">Rp 200.500</p>
                    </div>
                </div>
                <div class="produk-card">
                    <img src="/public/images/jelajahBelanja4.png" alt="Produk 1" />
                    <div class="produk-info">
                        <p class="keterangan">Tas Belanja</p>
                        <p class="harga">Rp 30.500</p>
                    </div>
                </div>
            </div>
        </section>

        <Footer/>
    </div>
</template>

<style scoped>
    .jelajah {
        font-family: var(--fontFamily);
        background-color: var(--backgroundWhite);
        color: var(--textBlack);
    }
    .hero {
        position: relative; /* tetap supaya .hero-konten absolute bisa relatif ke sini, tapi kita akan ubah */
        display: flex;      /* aktifkan flexbox */
        height: 550px;      /* tinggi hero */
        width: 100%;
        overflow: hidden;
    }

    .hero-image {
        width: 70%;
        height: 100%;
        object-fit: cover;
    }

    .hero-konten {
        position: relative; 
        width: 30%;            /* lebar 30% di kiri */
        background-color: var(--primaryGreen);
        color: var(--backgroundWhite);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px;  
    }


    .hero-konten h1 {
        font-size: 40px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .hero-konten p {
        font-size: 16px;
        font-weight: 500;
        line-height: 1.5;
    }


    /* Konten */
    .konten {
        text-align: start;
        margin-top: 60px;
        padding: 40px 5%;
    }
    .konten-heading {
        display: flex;
        align-items: center;
        padding-left: 32px;
        gap: 12px;
        font-weight: var(--fontWeightBold);
        color: var(--primaryGreen);
        font-size: var(--fontSizeMedium);
        margin-bottom: 30px;
    }
    .heading-line {
        width: 100px;
        height: 5px;
        background-color: var(--primaryGreen);
    }

    .kegiatan-grid {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 24px;
        padding: 20px;
    }

    .kegiatan-teks {
        max-width: 500px;
    }

    .kegiatan-teks h2 {
        font-size: 28px;
        font-weight: bold;
        color: var(--primaryGreen);
    }

    .kegiatan-teks p {
        margin: 12px 0;
        font-size: 16px;
        color: var(--primaryGreen);
    }

    .kegiatan-teks button {
        background-color: var(--primaryGreen);
        color: var(--backgroundWhite);
        padding: 10px 16px;
        border: none;
        font-weight: bold;
        cursor: pointer;
    }
    .kegiatan-teks button:hover {
        background-color: var(--accentGreen1);
        transition-duration: 0.3s;
    }

    /* Baris atas: Teks dan 1 gambar */
    .baris-atas {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        align-items: center;
    }

    .kegiatan-teks {
        flex: 1;
        min-width: 280px;
        max-width: 500px;
    }

    .kegiatan-teks h2 {
        font-size: 24px;
        margin-bottom: 12px;
    }

    .kegiatan-teks p {
        font-size: 16px;
        margin-bottom: 16px;
        line-height: 1.5;
    }

    .kegiatan-teks button {
        background-color: #006662;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .kegiatan-teks button:hover {
        background-color: #004d4a;
    }

    .gambar-atas img {
        width: 100%;
        max-width: 400px;
        border-radius: 10px;
        object-fit: cover;
    }

    /* Baris bawah: 2 gambar sejajar */
    .gambar-bawah {
        display: flex;
        margin-top: 20px;
        gap: 16px;
    }

    .gambar-bawah img {
        width: 455px;
        border-radius: 10px;
        object-fit: cover;
    }


    /* Artikel */
    .artikel {
        align-items: center;
        text-align: center;
    }
    .artikel-heading {
        color: var(--primaryGreen);
        margin-top: 40px;
    }
    .artikel-heading h2 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 15px;
    }
    .artikel-heading h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .artikel-button {
        margin-top: 50px;
        display: flex;
        gap: 16px;
        color: var(--backgroundWhite);
        justify-content: center;
    }
    .artikel-button button {
        border: 1px solid var(--primaryGreen);
        background-color: var(--primaryGreen);
        padding: 8px 24px; /* 12px atas-bawah, 24px kiri-kanan */
        border-radius: 4px;
        color: white; /* pastikan teks terlihat */
        font-size: 16px; /* opsional: atur ukuran teks */
    }
    .artikel-button button:hover {
        background-color: var(--accentGreen2);
        color: var(--primaryGreen);
        color: var(--primaryGreen);
        transition-duration: 0.3s;
    }
    .artikel-grid {
        margin: 25px auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 16px;
        max-width: 1200px;
        justify-items: center;
    }
    .artikel-card {
        background-color: var(--primaryGreen);
        overflow: hidden;
        width: 100%;
        max-width: 260px;
        position: relative;
    }
    .artikel-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .koin-label {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: var(--primaryGreen);
        color: white;
        font-size: 12px;
        padding: 4px 8px;
        z-index: 1;
        border-radius: 4px;
    }
    .card-body {
        padding: 16px;
        text-align: left;
    }
    .card-body h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: white;
    }
    .card-body p {
        margin: 8px 0 16px;
        font-size: 14px;
        color: white;
    }
    .card-links {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
    }
    .card-links a {
        color: white;
        text-decoration: none;
    }
    .card-links a:hover {
        text-decoration: underline;
    }

    /* Belanja */
    .belanja {
        margin: 25px auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 16px;
        max-width: 1200px;
        justify-items: center;
    }
    .produk-card {
        background-color: var(--textField);
        overflow: hidden;
        width: 100%;
        max-width: 260px;
        position: relative;
    }
    .produk-info {
        padding: 10px;
        color: var(--textBlack);
    }
    .keterangan {
        font-weight: normal;
        margin: 6px 0;
    }
    .harga {
        font-weight: 600;
    }
        .card-links a img.icon {
        width: 16px !important;
        height: 16px !important;
        display: inline-block;
        vertical-align: middle;
        margin-right: 6px;
        object-fit: contain;
    }


</style>
