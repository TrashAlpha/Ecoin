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
            </div>

            <div class="form-detail">
  <div class="jenis-sampah">
    <label>Jenis Sampah</label>
    <div class="tabs">
      <button
        class="tab-button"
        :class="{ active: jenis === 'Botol' }"
        @click="jenis = 'Botol'"
      >
        <img src="/public/images/botol-icon.png" class="tab-icon" />
        <span>Botol</span>
        <div class="triangle" v-if="jenis === 'Botol'"></div>
      </button>

      <button
        class="tab-button"
        :class="{ active: jenis === 'Kertas' }"
        @click="jenis = 'Kertas'"
      >
        <img src="/public/images/kertas-icon.png" class="tab-icon" />
        <span>Kertas</span>
        <div class="triangle" v-if="jenis === 'Kertas'"></div>
      </button>

      <button
        class="tab-button"
        :class="{ active: jenis === 'Baju' }"
        @click="jenis = 'Baju'"
      >
        <img src="/public/images/baju-icon.png" class="tab-icon" />
        <span>Baju</span>
        <div class="triangle" v-if="jenis === 'Baju'"></div>
      </button>
    </div>
  </div>

                <div class="berat">
                    <label>Berat Sampah</label>
                    <div class="range-wrapper">
                        <span>1</span>
                        <input type="range" min="1" max="50" v-model="berat" />
                        <span>50</span>
                    </div>

                    <div class="berat-indikator-wrapper">
                        <div
                            class="berat-display"
                            :style="{ left: `calc(${sliderPos}% - 20px)` }"
                        >
                            {{ berat }}
                        </div>
                        <div
                            class="berat-display-label"
                            :style="{ left: `calc(${sliderPos}% - 16px)` }"
                        >
                            Kg
                        </div>
                    </div>
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

                <div class="actions">
                    <button
                        class="btn-icon"
                        :class="{ active: tambahClicked }"
                        @click="tambahBarang"
                    >
                        + Barang
                    </button>

                    <button
                        class="btn-icon"
                        :class="{ active: simpanClicked }"
                        @click="handleSimpan"
                    >
                        <img src="/public/images/save-icon.png" alt="save" />
                        Simpan Penukaran
                    </button>
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
            berat: 1,
            tanggal: "",
            waktu: "",
            mainImage: null,
            jenis: "Botol",
            tambahClicked: false,
            simpanClicked: false,
        };
    },
    methods: {
        redirectToStep2() {
            window.location.href = "/penukaran2";
        },
        onMainImageChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.mainImage = URL.createObjectURL(file);
            }
        },
        removeMainImage() {
            const confirmed = window.confirm(
                "Apakah Anda yakin ingin menghapus gambar ini?"
            );
            if (confirmed) {
                this.mainImage = null;
            }
        },
        tambahBarang() {
            this.tambahClicked = true;
            console.log("+ Barang diklik");
        },
        handleSimpan() {
            this.simpanClicked = true;
            this.redirectToStep2();
        },
    },
    computed: {
        sliderPos() {
            return ((this.berat - 1) / 49) * 100;
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
    /* padding: 0 32px; */
}

.hero-image {
    width: 100%;
    max-height: 500px;
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
    border-radius: 5px;
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
    width: 150px;
    display: flex;
    flex-direction: column;
    align-items: center; /* Pusatkan horizontal */
    justify-content: center;
    padding: 10px 20px;
    margin: 0 5px;
    color: var(--backgroundWhite);
    font-weight: var(--fontWeightBold);
    cursor: pointer;
    border-radius: 5px;
    text-align: center;
}

.kategori-tabs.inline .tab {
    background-color: var(--textField);
    color: var(--textBlack);
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
    border-radius: 4px;
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

.range-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* style tengah*/
/* Kontainer utama */
.konten-detail {
    display: flex;
    flex-wrap: wrap;
    padding: 40px 32px;
    gap: 32px;
}

/* Upload gambar */
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
    border-radius: 4px;
}

.upload-box:hover {
    border-color: #006662;
}

.gambar-detail {
    flex: 1;
    min-width: 300px;
}

.gambar-utama {
    margin-bottom: 12px;
    height: 500px;
    max-height: 500px;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    max-height: 200px;
}

.remove-button {
    position: absolute;
    top: 6px;
    right: 6px;
    background-color: rgba(255, 0, 0, 0.8);
    color: white;
    border: none;
    width: 24px;
    height: 24px;
    font-size: 16px;
    line-height: 1;
    cursor: pointer;
    z-index: 10;
    border-radius: 4px;
}

/* Form */
.form-detail {
    flex: 1;
    min-width: 300px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-detail label {
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    color: #006662;
}

/* Tabs Sampah */
.jenis-sampah label {
    display: block;
    margin-bottom: 8px;
}

.tabs {
    display: flex;
    gap: 12px;
    overflow: visible;
}

.tabs button {
    margin-right: 8px;
    padding: 12px;
    border: none;
    background-color: #98b0b0;
    cursor: pointer;
    font-family: "Poppins", sans-serif;
    font-size: 16px;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: white;
    transition: background-color 0.2s;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius: 4px;
}

.tabs button:not(.active):hover {
    background-color: #006662;
    transition: background-color 0.2s ease-in-out;
}

.tabs .active {
    background-color: #006662 !important;
}

.tab-icon {
    width: 32px;
    height: 32px;
}

.tab-button {
    position: relative;
}

.tab-button .triangle {
    position: absolute;
    bottom: -8px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-top: 8px solid #006662;
}

/* Berat Sampah */
.range-wrapper span {
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    color: #006662;
}

/* Slider hijau dan kotak */
input[type="range"] {
    width: 100%;
    -webkit-appearance: none;
    background: transparent;
    height: 8px;
}

input[type="range"]::-webkit-slider-runnable-track {
    height: 8px;
    background: #006662;
    border-radius: 4px;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px;
    height: 16px;
    background: #006662;
    cursor: pointer;
    margin-top: -4px;
    border-radius: 4px;
}

.berat-indikator-wrapper {
    position: relative;
    height: 40px;
    margin-top: 12px;
}

.berat-display {
    position: absolute;
    top: 0;
    background-color: var(--primaryGreen);
    padding: 6px 12px;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    color: white;
    white-space: nowrap;
    transition: left 0.15s ease-in-out;
    border-radius: 4px;
}

.range-wrapper {
    position: relative;
    margin-top: 10px;
}

.berat-display-label {
    position: absolute;
    top: -24px;
    /* naik ke atas */
    transform: translateX(-50%);
    background-color: white;
    padding: 2px 6px;
    border: 1px solid #ccc;
    color: #006662;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 14px;
    transition: left 0.2s ease-in-out;
    pointer-events: none;
    border-radius: 4px;
}

/* Input Tanggal */
input[type="date"] {
    background-color: #98b0b0;
    color: white;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    border: none;
    padding: 8px;
    border-radius: 4px;
}

/* Waktu Penukaran */
.jam {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.jam button {
    flex: 1 1 30%;
    min-width: 100px;
    padding: 8px 16px;
    border: none;
    background-color: #98b0b0;
    color: white;
    font-family: "Poppins", sans-serif;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    border-radius: 4px;
    text-align: center;
}

.jam button.active {
    background-color: #006662 !important;
}

.jam button:not(.active):hover {
    background-color: #006662;
}

.btn-icon,
.jam button {
    transition: background-color 0.2s ease-in-out;
}

/* +Barang & Simpan */
.btn-icon {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background-color: #98b0b0;
    color: white;
    font-family: "Poppins", sans-serif;
    font-size: 16px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

.btn-icon img {
    width: 20px;
    height: 20px;
}

.btn-icon.active {
    background-color: #006662 !important;
}

.btn-icon:not(.active):hover {
    background-color: #006662;
}

.actions {
    display: flex;
    align-items: center;
    gap: 8px;
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
}

.btn.send {
    background-color: var(--primaryGreen);
    padding: 12px;
}

.btn.send img {
    height: 20px;
}

.btn.send:hover {
    background-color: var(--primaryGreen);
}
</style>
