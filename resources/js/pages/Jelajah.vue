<script setup>
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';

import { onMounted, ref } from 'vue';

const artikels = ref([]);
const userRole = ref(null);
const produkList = ref([]);
const showQuizModal = ref(false);
const selectedArtikelId = ref(null);
const carousel = ref(null);

const next = () => {
  carousel.value.scrollLeft += 300;
};

const prev = () => {
  carousel.value.scrollLeft -= 300;
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

function fetchProdukList() {
    fetch("http://localhost:8000/api/produk")
        .then((res) => res.json())
        .then((data) => {
            produkList.value = data.data;
        })
        .catch((err) => {
            console.error("Gagal ambil data produk: ", err);
        });
}

function openQuizModal(artikelId) {
    selectedArtikelId.value = artikelId;
    showQuizModal.value = true;
}
function closeQuizModal() {
    showQuizModal.value = false;
    selectedArtikelId.value = null;
}

const quizForm = ref({
    pertanyaan: '',
    jawabanA: '',
    jawabanB: '',
    jawabanC: '',
    jawabanD: '',
    jawaban_benar: ''
});

async function submitQuizForm() {
    // Validasi: semua field harus terisi
    if (!quizForm.value.pertanyaan || !quizForm.value.jawabanA || !quizForm.value.jawabanB || !quizForm.value.jawabanC || !quizForm.value.jawabanD || !quizForm.value.jawaban_benar) {
        alert('Semua field harus diisi!');
        return;
    }
    // Buat object jawaban
    const allAnswers = {
        A: quizForm.value.jawabanA,
        B: quizForm.value.jawabanB,
        C: quizForm.value.jawabanC,
        D: quizForm.value.jawabanD
    };
    const payload = {
        pertanyaan: quizForm.value.pertanyaan,
        pilihan_jawaban: allAnswers,
        jawaban_benar: quizForm.value.jawaban_benar
    };
    try {
        const res = await fetch(`http://localhost:8000/api/admin/artikel/${selectedArtikelId.value}/quiz`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include', // penting agar cookie session Laravel ikut
            body: JSON.stringify(payload)
        });
        if (!res.ok) {
            const text = await res.text();
            alert('Gagal menambah quiz. Status: ' + res.status + '\n' + text);
            return;
        }
        const data = await res.json();
        if (data.success) {
            alert('Quiz berhasil ditambahkan!');
            // Reset form
            quizForm.value = {
                pertanyaan: '',
                jawabanA: '',
                jawabanB: '',
                jawabanC: '',
                jawabanD: '',
                jawaban_benar: ''
            };
            showQuizModal.value = false;
            selectedArtikelId.value = null;
        } else {
            alert(data.message || 'Gagal menambahkan quiz');
        }
    } catch (e) {
        alert('Error terjadi, gagal menambah quiz \n' + e.message);
        console.error('Error saat menambah quiz:', e);
    }
}

onMounted(()=>{
    fetchAllArtikel();
    fetchUserRole();
    fetchProdukList();
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
                                <a v-if="userRole === 'admin'" href="#" @click.prevent="openQuizModal(artikel.id)"><img src="/public/images/jam_write.png" class="icon"/> Buat Kuis</a>
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
                    :href="produk.link_beli"
                    class="produk-card"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <img :src="produk.gambar_url" :alt="produk.nama" />
                    <div class="produk-info">
                        <p class="keterangan">{{ produk.nama_produk }}</p>
                        <p class="harga">Rp {{ formatHarga(produk.harga) }}</p>
                    </div>
                </a>
                </div>
                <button @click="next" class="arrow-btn">›</button>
            </div>
        </section>
        <Footer/>
    </div>

    <!-- Modal Buat Kuis -->
    <div v-if="showQuizModal" class="modal-overlay">
        <div class="modal-content">
            <div class="popup-form">
                <h1>Buat Kuis untuk Artikel ID: {{ selectedArtikelId }}</h1>
                <form @submit.prevent="submitQuizForm">
                    <label>Pertanyaan:</label>
                    <input v-model="quizForm.pertanyaan" required />

                    <label>Jawaban A:</label>
                    <input v-model="quizForm.jawabanA" required />

                    <label>Jawaban B:</label>
                    <input v-model="quizForm.jawabanB" required />

                    <label>Jawaban C:</label>
                    <input v-model="quizForm.jawabanC" required />

                    <label>Jawaban D:</label>
                    <input v-model="quizForm.jawabanD" required />

                    <label>Pilih Jawaban Benar:</label>
                    <select v-model="quizForm.jawaban_benar" required>
                        <option disabled value="">-- Pilih jawaban benar --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                    <div class="btn-container">
                        <button type="submit" class="btn btn-add">Buat Kuis</button>
                        <button @click="closeQuizModal" class="btn btn-delete" type="button">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
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
    .card-links img.icon{
        filter: invert(1);
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

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
.btn-container {
    display: flex;
    justify-content: space-between;
}
.btn {
    border: none;
    cursor: pointer;
    padding: 6px 10px;
    margin: 2px 0;
    font-size: 16px;
    border-radius: 4px;
}
.btn-delete {
    background-color: var(--color-red-500);
    color: white;
}
.btn-add {
    background-color: var(--color-blue-500);
    color: white;
}
.btn-back {
    background-color: grey;
    color: white;
}

.popup-form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    min-width: 300px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    max-height: 600px;
    overflow-y: auto;
}
.popup-form input,
.popup-form select {
  width: 100%;
  padding: 6px 10px;
  margin: 5px 0 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.popup-form h1 {
    margin-bottom: 20px;
    font-size: larger;
    font-weight: 700;
}
</style>
