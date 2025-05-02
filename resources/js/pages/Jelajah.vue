<script setup>
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';

</script>

<template>
    <div class="jelajah">
        <Navbar/>

        <section class="hero">
            <div class="hero-konten">
                <h1 class="judul">Ayo Jelajah dan<br>Telusuri</h1>
                <p>Cari dan gali informasi lebih mendalam mengenai<br>sampah serta manfaatnya</p>
            </div>
            <img src="/public/images/heroJelajah.png" alt="Gambar Jelajah" class="hero-image">
        </section>

        <section class="konten">
            <div class="konten-heading">
                <div class="heading-line"></div>
                <p>Informasi Mengenai <br/> Sampah dan Manfaaatnya</p>
            </div>
            <div class="konten-isi">
                <div class="kegiatan-utama">
                    <img src="/public/images/jelajahGambar1.png" alt="">
                    <div class="kegiatan-teks">
                        <h2>Kegiatan Peduli Lingkungan</h2>
                        <p>Beberapa kegiatan positif untuk menjaga lingkungan telah dilakukan seperti bakti sosial dan seminar tentang pentingnya kebersihan</p>
                        <button>Lihat Lebih</button>
                    </div>
                </div>
                <div class="kegiatan-galeri">
                    <img src="/public/images/jelajahGambar2.png" alt="">
                    <img src="/public/images/jelajahGambar3.png" alt="">
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
                            <a href="#">📖 Baca Artikel</a>
                            <a href="#">📝 Buat Kuis</a>
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
                            <a href="#">📖 Baca Artikel</a>
                            <a href="#">📝 Buat Kuis</a>
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
                            <a href="#">📖 Baca Artikel</a>
                            <a href="#">📝 Buat Kuis</a>
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
                            <a href="#">📖 Baca Artikel</a>
                            <a href="#">📝 Buat Kuis</a>
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
        position: relative;
        display: flex;
        justify-content: center;
        padding: 0 32px;
    }
    .hero-image {
        width: 100%;
        max-height: 850px;
        object-fit: cover;
    }
    .hero-konten {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-210%, -50%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: start;
        padding: 40px 20px;
        background-color: var(--primaryGreen);
    }
    .hero-konten h1 {
        font-size: 32px;
        font-weight: bold;
        color: var(--backgroundWhite);
    }
    .hero-konten p {
        font-size: 16px;
        font-weight: 500;
        color: var(--backgroundWhite);
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

    .kegiatan-utama {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 40px;
        margin-bottom: 24px;
    }
    .kegiatan-utama img {
        width: 100%;
        max-width: 700px;
        object-fit: cover;
    }

    .kegiatan-teks {
        max-width: 500px;
        margin-left: 160px;
    }
    .kegiatan-teks h2 {
        font-size: 28px;
        font-weight: bold;
        color: var(--primaryGreen);
    }
    .kegiatan-teks p {
        margin: 12px 0;
        font-size: 16px;
        color: var(--textBlack);
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

    .kegiatan-galeri {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    .kegiatan-galeri img {
        width: calc(50% - 8px);
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
        padding: 20px;
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


</style>
