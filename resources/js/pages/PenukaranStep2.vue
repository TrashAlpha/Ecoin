<template>
    <div class="penukaran-step2">
      <Navbar />

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
            <div class="step inactive"><span>3</span> Konfirmasi Penukaran</div>
        </div>
      </section>

      <section class="konten">
        <div class="map-container">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63311.78130854193!2d110.80794602762312!3d-6.81934883222186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e712e2c25f3c4ab%3A0xc2bc9dba6e37dd3d!2sPDU%20Kudus!5e0!3m2!1sid!2sid!4v1714411111111!5m2!1sid!2sid"
            width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
        <div class="form-lokasi">
          <label>Lokasi Awal</label>
          <input type="text" placeholder="Masukkan lokasi awal..." />
          <label>Rekomendasi Penukaran</label>
          <div class="rekomendasi">
            <button class="btn">Kudus <span>✈</span></button>
            <button class="btn">Semarang <span>✈</span></button>
          </div>
          <div class="action-buttons">
            <button class="btn">Kembali</button>
            <button class="btn" @click="redirectToStep3">Konfirmasi</button>
          </div>
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

      <Footer />
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue'
import Footer from '../components/Footer.vue'

export default {
components: {
    Navbar,
    Footer
},
methods: {
    redirectToStep3() {
      window.location.href = '/penukarans3';
    }
  }
}
</script>

<style scoped>
.penukaran-step2 {
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

.map-container {
    flex: 1;
    min-width: 300px;
    height: 100%;
}

.form-lokasi {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 16px;
    justify-content: center;
    height: 100%;
}

.form-lokasi label {
    font-weight: 600;
}

.form-lokasi input {
    padding: 10px;
    background-color: var(--textField);
    border: none;
}

.rekomendasi {
    display: flex;
    gap: 12px;
}

.action-buttons {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 10px 20px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    background-color: var(--accentGreen1);
    color: var(--backgroundWhite);
}

.btn:hover {
    background-color: var(--primaryGreen);
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
