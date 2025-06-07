<script setup>
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';

import { onMounted, ref } from 'vue';

const artikels = ref([]);
const userRole = ref(null);
const produkList = ref([
  {
    nama: 'Dompet Kecil',
    harga: 18000,
    gambar: '/images/jelajahBelanja1.png',
    link: 'https://tk.tokopedia.com/ZShnfgnaG/'
  },
  {
    nama: 'Tas Besar',
    harga: 30000,
    gambar: '/images/jelajahBelanja2.png',
    link: 'https://www.lazada.co.id/products/pdp-i5784198953-s14699096519.html?c=&channelLpJumpArgs=&clickTrackInfo=query%253Atempat%252Bpenyimpanan%252Bbarang%252Bbekas%253Bnid%253A5784198953%253Bsrc%253ALazadaMainSrp%253Brn%253Ae9b1de42a381c7184087f4cb792f8753%253Bregion%253Aid%253Bsku%253A5784198953_ID%253Bprice%253A11900%253Bclient%253Adesktop%253Bsupplier_id%253A400618356013%253Bbiz_source%253Ah5_internal%253Bslot%253A5%253Butlog_bucket_id%253A470687%253Basc_category_id%253A16413%253Bitem_id%253A5784198953%253Bsku_id%253A14699096519%253Bshop_id%253A3843756%253BtemplateInfo%253A-1_A3_C%25231103_L%2523107879_D_E%2523&freeshipping=1&fs_ab=2&fuse_fs=&lang=en&location=Kota%20Tangerang&price=1.19E%204&priceCompare=skuId%3A14699096519%3Bsource%3Alazada-search-voucher%3Bsn%3Ae9b1de42a381c7184087f4cb792f8753%3BoriginPrice%3A1190000%3BdisplayPrice%3A1190000%3BsinglePromotionId%3A-1%3BsingleToolCode%3AmockedSalePrice%3BvoucherPricePlugin%3A0%3Btimestamp%3A1747928664820&ratingscore=4.81&request_id=e9b1de42a381c7184087f4cb792f8753&review=100&sale=329&search=1&source=search&spm=a2o4j.searchlist.list.5&stock=1'
  },
  {
    nama: 'Kandang Hewan',
    harga: 200500,
    gambar: '/images/jelajahBelanja3.png',
    link: '/produk/dompet-kecil.html'
  },
  {
    nama: 'Tas Belanja',
    harga: 23000,
    gambar: '/images/jelajahBelanja4.png',
    link: 'https://tk.tokopedia.com/ZShnPfoxa/'
  },
  // Tambahkan produk baru langsung di sini
]);
const carousel = ref(null);

const next = () => {
  carousel.value.scrollLeft += 300;
};

const prev = () => {
  carousel.value.scrollLeft -= 300;
};

const openProduct = (produk) => {
  alert(`Detail produk:\nNama: ${produk.nama}\nHarga: Rp ${produk.harga}`);
  // Anda bisa ganti alert dengan modal atau link eksternal seperti:
  // window.location.href = produk.link;
};

const formatHarga = (angka) => {
  return angka.toLocaleString('id-ID');
};

function fetchAllArtikel(){
    fetch("http://localhost:8000/api/artikel")
    .then((res) => res.json())
    .then((data) => {
        artikels.value = data.data;
    })
    .catch((err) => {
        console.error("Gagal ambil data artikel: ", err);
    })
}

async function fetchUserRole() {
    try {
        const response = await fetch('http://localhost:8000/api/get-user', {
            credentials: 'include',
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        userRole.value = data.user ? data.user.role : null;
    } catch (error) {
        userRole.value = null;
        console.error('Gagal mengambil role pengguna:', error);
    }
}

onMounted(()=>{
    fetchAllArtikel();
    fetchUserRole();
})
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
                <a href="https://youtu.be/As67nnwVnIU?si=WXANbp9jUOs6KYyP" target="_blank">
                    <button>Lihat Lebih</button>
                </a>
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
                <!-- <div class="artikel-button">
                    <button>Semua</button>
                    <button>Terpopuler</button>
                    <button>Terbaru</button>
                </div> -->
            </div>
            <div class="artikel-grid">
                <div class="artikel-card" v-for="artikel in artikels">
                    <a :href="`/artikel/${artikel.id}`">
                        <span class="koin-label">{{artikel.reward_koin}} Koin</span>
                        <img :src="artikel.gambar_url" alt="Artikel">
                        <div class="card-body">
                            <h3>{{artikel.judul}}</h3>
                            <p>{{ artikel.konten }}</p>
                            <div class="card-links">
                                <a v-if="userRole === 'admin'" href="#"><img src="/public/images/jam_write.png" class="icon"/> Buat Kuis</a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="konten">
        <div class="konten-heading">
            <div class="heading-line"></div>
            <p>Beberapa Produk Daur <br />Ulang Sampah</p>
        </div>

        <div class="carousel-container">
            <button @click="prev" class="arrow-btn">‹</button>
            <div class="carousel" ref="carousel">
            <a
                v-for="(produk, index) in produkList"
                :key="index"
                :href="produk.link"
                class="produk-card"
                target="_blank"
                rel="noopener noreferrer"
            >
                <img :src="produk.gambar" :alt="produk.nama" />
                <div class="produk-info">
                <p class="keterangan">{{ produk.nama }}</p>
                <p class="harga">Rp {{ formatHarga(produk.harga) }}</p>
                </div>
            </a>
            </div>
            <button @click="next" class="arrow-btn">›</button>
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
        height: 600px;      /* tinggi hero */
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
        padding: 20px;
        margin: 0 auto;
        max-width: 1200px;
        box-sizing: border-box;
    }
    .konten-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: var(--fontWeightBold);
        color: var(--primaryGreen);
        font-size: var(--fontSizeMedium);
        margin-bottom: 20px;
        margin-top: 25px;
    }
    .heading-line {
        width: 100px;
        height: 5px;
        background-color: var(--primaryGreen);
    }
    .carousel-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: auto; /* gunakan lebar viewport penuh */
        padding: 0 20px;
        box-sizing: border-box;
        overflow: hidden;
    }
    .arrow-btn {
        font-size: 30px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 10px;
    }
    .carousel {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        gap: 20px;
        padding: 10px 0;
        flex: 1;
    }
    .produk-card {
        min-width: 200px;
        border: 1px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        flex-shrink: 0;
        background: #f5f5f5;
        transition: transform 0.2s;
    }
    .produk-card:hover {
        transform: scale(1.03);
    }
    .produk-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    .produk-info {
        padding: 10px;
        text-align: center;
    }
    .keterangan {
        font-weight: bold;
    }
    .harga {
        color: #004d4a;
    }

    /* Baris atas: Teks dan 1 gambar */
    .baris-atas {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        align-items: center;
        justify-content: center;
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
        justify-content: center;
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
    }
    .artikel-heading h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 30px;
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
        border-radius: 8px;
        border-width: 3px;
        border-color: var(--primaryGreen);
    }
    .artikel-card:hover {
        background-color: var(--accentGreen2);
        transition-duration: 0.3s;
        h3, p, a{
            color: var(--primaryGreen);
        }
        img{
            filter: brightness(110%);
            transition-duration: 0.3s;
        }
    }
    .artikel-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 4px;
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
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
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
