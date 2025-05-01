<template>
    <div class="penukaran-step1">
        <Navbar />

        <section class="hero">
            <img
                src="/public/images/heroPenukaran.png"
                alt="Penukaran Sampah"
                class="hero-image"
            />
            <div class="kategori-tabs">
                <div class="tab">
                    <img src="/public/images/ic_plastic.png" alt="" /> Non
                    Organik
                </div>
                <div class="tab">
                    <img src="/public/images/ic_leaf.png" alt="" /> Organik
                </div>
                <div class="tab">
                    <img src="/public/images/ic_mask.png" alt="" /> Limbah Medis
                </div>
            </div>
        </section>

        <section class="step-indikator">
            <div class="step-heading">
                <div class="heading-line"></div>
                <p>
                    Detail Sampah <br />
                    Yang Ditukarkan
                </p>
            </div>
            <div class="steps">
                <div class="step active"><span>1</span> Detail Sampah</div>
                <div class="step inactive"><span>2</span> Lokasi Penukaran</div>
                <div class="step inactive">
                    <span>3</span> Konfirmasi Penukaran
                </div>
            </div>
        </section>

        <section class="konten-detail">
            <div class="gambar-detail">
                <!-- Gambar Utama -->
                <label class="gambar-utama upload-box">
                    <input
                        type="file"
                        accept="image/*"
                        @change="onMainImageChange"
                        hidden
                    />
                    <img
                        v-if="mainImage"
                        :src="mainImage"
                        class="preview-image"
                    />
                    <div v-else>Tambah Gambar</div>
                    <button
                        v-if="mainImage"
                        @click.stop.prevent="removeMainImage"
                        class="remove-button"
                    >
                        ✕
                    </button>
                </label>

                <!-- Gambar List -->
                <div class="gambar-list">
                    <label
                        v-for="(img, index) in imageList"
                        :key="index"
                        class="gambar-item upload-box"
                    >
                        <input
                            type="file"
                            accept="image/*"
                            @change="(e) => onListImageChange(e, index)"
                            hidden
                        />
                        <img v-if="img" :src="img" class="preview-image" />
                        <div v-else>Tambah Gambar</div>
                        <button
                            v-if="img"
                            @click.stop.prevent="removeListImage(index)"
                            class="remove-button"
                        >
                            ✕
                        </button>
                    </label>
                </div>
            </div>

            <div class="form-detail">
                <div class="jenis-sampah">
                    <label>Jenis Sampah</label>
                    <div class="tabs">
                        <button class="active">Botol</button>
                        <button>Kertas</button>
                        <button>Baju</button>
                    </div>
                </div>
                <div class="berat">
                    <label>Berat Sampah</label>
                    <div class="range-wrapper">
                        <span>1 Kg</span>
                        <input type="range" min="1" max="50" v-model="berat" />
                        <span>50 Kg</span>
                    </div>
                    <div class="berat-display">{{ berat }} Kg</div>
                </div>

                <label>Tanggal Penukaran</label>
                <input type="date" v-model="tanggal" />
                <label>Waktu Penukaran</label>
                <div class="jam">
                    <button
                        :class="{ active: waktu === '08:00 - 09:00' }"
                        @click="waktu = '08:00 - 09:00'"
                    >
                        08:00 - 09:00
                    </button>
                    <button
                        :class="{ active: waktu === '09:00 - 10:00' }"
                        @click="waktu = '09:00 - 10:00'"
                    >
                        09:00 - 10:00
                    </button>
                    <button
                        :class="{ active: waktu === '16:00 - 17:00' }"
                        @click="waktu = '16:00 - 17:00'"
                    >
                        16:00 - 17:00
                    </button>
                </div>
                <label>Koin yang Didapat</label>
                <div class="koin">50 Koin</div>
                <div class="actions">
                    <button>+ Barang</button>
                    <button>Simpan Penukaran</button>
                </div>
            </div>
        </section>
        <section class="langganan">
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
        </section>

        <Footer />
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";

export default {
    name: "PenukaranStep1",
    components: {
        Navbar,
        Footer,
    },
    data() {
        return {
            berat: 7,
            tanggal: "",
            waktu: "",
            mainImage: null,
            imageList: [null, null, null],
        };
    },
    methods: {
        redirectToStep2() {
            window.location.href = "/penukaran-step2";
        },
        onMainImageChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.mainImage = URL.createObjectURL(file);
            }
        },
        onListImageChange(e, index) {
            const file = e.target.files[0];
            if (file) {
                const newList = [...this.imageList];
                newList[index] = URL.createObjectURL(file);
                this.imageList = newList;
            }
        },
        removeMainImage() {
            this.mainImage = null;
        },
        removeListImage(index) {
            const newList = [...this.imageList];
            newList[index] = null;
            this.imageList = newList;
        },
    },
};
</script>

<style scoped>
.penukaran-step1 {
    font-family: var(--fontFamily);
    background-color: var(--backgroundWhite);
    color: var(--textBlack);
}

/* Hero */
.hero {
    position: relative;
    display: flex;
    justify-content: center;
    padding: 0 32px;
}

.hero-image {
    width: 100%;
    max-height: 100%;
    object-fit: cover;
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
    z-index: 2;
}

.kategori-tabs.inline {
    position: static;
    transform: none;
    box-shadow: none;
    background: transparent;
    padding: 0;
    gap: 10px;
}

.tab {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    margin: 0 5px;
    color: var(--backgroundWhite);
    font-weight: var(--fontWeightBold);
    cursor: pointer;
    text-align: center;
    background-color: transparent;
}

.kategori-tabs.inline .tab {
    background-color: var(--textField);
    color: var(--textBlack);
    border-radius: 4px;
}

.tab img {
    height: 20px;
    margin-bottom: 6px;
}

.tab:hover {
    background-color: var(--accentGreen1);
    color: white;
}

/* Step Indicator */
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
    padding: 0 32px;
    gap: 40px;
    flex-wrap: wrap;
    margin-top: 32px;
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
}

.step span {
    background-color: var(--primaryGreen);
    color: white;
    padding: 6px 12px;
    font-weight: var(--fontWeightBold);
    opacity: 0.5;
}

.step.active span {
    opacity: 1;
}

.step.inactive {
    opacity: 0.5;
}

/* Konten */
.konten {
    padding: 60px 32px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-container {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 40px;
    width: 100%;
    max-width: 1000px;
}

.upload-section {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.upload-section label {
    font-weight: var(--fontWeightSemiBold);
    margin-bottom: 8px;
}

.hidden-input {
    display: none;
}

.upload-box {
    border: 2px dashed var(--textGrey);
    border-radius: 8px;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: var(--textField);
}

.upload-btn {
    padding: 10px 20px;
    background-color: var(--primaryGreen);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: var(--fontWeightSemiBold);
}

.detail-section {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

input[type="range"],
input[type="date"] {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--textGrey);
    border-radius: 4px;
    background-color: var(--textField);
}

.time-options {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.time-option {
    padding: 12px;
    background-color: var(--textField);
    border-radius: 4px;
    cursor: pointer;
}

.time-option:hover {
    background-color: var(--accentGreen1);
    color: white;
}

.info-box {
    background-color: var(--primaryGreen);
    color: white;
    padding: 30px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    width: 100%;
    max-width: 300px;
}

.info-box h3 {
    font-size: var(--fontSizeMedium);
    font-weight: var(--fontWeightBold);
}

.coin-display {
    font-size: 32px;
    font-weight: var(--fontWeightBold);
}

.info-text {
    font-size: var(--fontSizeNormal);
}

.action-buttons {
    display: flex;
    gap: 16px;
    margin-top: 40px;
}

.btn {
    padding: 12px 24px;
    font-weight: var(--fontWeightSemiBold);
    cursor: pointer;
    border: none;
    border-radius: 4px;
}

.btn:first-child {
    background-color: white;
    color: var(--primaryGreen);
    border: 1px solid var(--primaryGreen);
}

.btn:last-child {
    background-color: var(--primaryGreen);
    color: white;
}

.btn:hover {
    opacity: 0.9;
}

.range-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}
.range-wrapper input[type="range"] {
    flex: 1;
}

/* Konten Detail (FORM) */
.konten-detail {
    display: flex;
    flex-wrap: wrap;
    padding: 40px 32px;
    gap: 32px;
}
.upload-box {
    background-color: #f5f5f5;
    padding: 60px;
    text-align: center;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #90a4ae;
    font-weight: 600;
    font-size: 16px;
    border: 2px dashed #cfd8dc;
    transition: border-color 0.3s ease;
}

.upload-box:hover {
    border-color: #90caf9;
}

.gambar-detail {
    flex: 1;
    min-width: 300px;
}

.gambar-utama {
    margin-bottom: 12px;
}

.gambar-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.gambar-item {
    padding: 30px;
}

.preview-image {
    width: 100%;
    height: auto;
    object-fit: cover;
    max-height: 200px;
}

.remove-button {
    position: absolute;
    top: 6px;
    right: 6px;
    background-color: rgba(255, 0, 0, 0.8);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 16px;
    line-height: 1;
    cursor: pointer;
    z-index: 10;
}

.form-detail {
    flex: 1;
    min-width: 300px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.form-detail label {
    font-family: 'Poppins', sans-serif; 
    font-weight: 600; 
    color: #006662; 
}

.tabs button {
    margin-right: 8px;
    padding: 8px 16px;
    border: none;
    background-color: #ccc;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
}
.jam .active {
    background-color: #F5FFFF; 
    color: white;
}
.berat input[type="range"] {
    width: 100%;
}
.berat-display {
    font-weight: bold;
    margin-top: -8px;
}
.jam button {
    margin-right: 8px;
    padding: 8px 16px;
    border: none;
    background-color: #ccc;
    cursor: pointer;
}
.jam .active {
    background-color: var(--primaryGreen);
    color: white;
}
.koin {
    background-color: var(--primaryGreen);
    color: #FFFFFF;
    padding: 8px 16px;
    width: fit-content;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
}
.actions button {
    padding: 10px 20px;
    margin-right: 8px;
    border: none;
    background-color: #ccc;
    cursor: pointer;
}

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
</style>
