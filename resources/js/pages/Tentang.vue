<template>
    <div class="tentang">
        <Navbar />

        <!-- Header Section -->
        <section class="header-section">
            <h1 class="section-title">Tentang Kami</h1>
        </section>

        <!-- Apa itu ECOIN -->
        <section class="section-content">
            <div class="content-left">
                <div class="section-header-line">
                    <h2 class="section-subtitle">Apa Itu ECOIN</h2>
                    <div class="horizontal-line"></div>
                </div>

                <p class="section-text justify-text">
                    Ecoin merupakan aplikasi yang bertujuan sebagai wadah
                    pertukaran sampah antara pengepul dan masyarakat. Dimana
                    sampah tersebut akan ditukarkan menjadi koin dan koin dapat
                    ditukarkan dengan berbagai pilihan kupon seperti saldo
                    e-wallet, potongan pembelanjaan, dan lainnya. Aplikasi ini
                    bertujuan untuk mengurangi dampak lingkungan dari sampah
                    yang dihasilkan. Dengan adanya aplikasi ini sampah yang
                    khususnya plastik akan jauh lebih berkurang penggunaannya
                    karena akan diolah kembali.
                </p>
            </div>
            <div class="content-right image-container">
                <img
                    src="/public/images/recycle-woman.png"
                    alt="Recycle"
                    class="image-box"
                />
            </div>
        </section>

        <!-- Misi Kami -->
        <section class="section-content alt-bg">
            <div class="content-right image-container">
                <img
                    src="/public/images/team-cleaning.png"
                    alt="Tim ECOIN"
                    class="image-box"
                />
            </div>
            <div class="content-left">
                <h2 class="section-subtitle subtitle-white">Misi Kami</h2>
                <div class="mission-list">
                    <div class="mission-item">
                        <div class="number-box">1</div>
                        <p>Mendorong Kesadaran Lingkungan</p>
                    </div>
                    <div class="mission-item">
                        <div class="number-box">2</div>
                        <p>Memberikan Insentif untuk Pengelolaan Sampah</p>
                    </div>
                    <div class="mission-item">
                        <div class="number-box">3</div>
                        <p>
                            Meningkatkan Efisiensi dan Digitalisasi Pengelolaan
                            Sampah
                        </p>
                    </div>
                    <div class="mission-item">
                        <div class="number-box">4</div>
                        <p>Mengurangi Dampak Lingkungan dari Sampah</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mengapa ECOIN -->
        <section class="section-content">
            <div class="content-left">
                <div class="section-header-line">
                    <h2 class="section-subtitle">Mengapa ECOIN?</h2>
                    <div class="horizontal-line"></div>
                </div>

                <p class="section-text justify-text">
                    Ecoin merupakan solusi inovatif yang mengubah sampah menjadi
                    nilai. Masyarakat dapat menukarkan sampah dengan koin yang
                    bisa ditukar dengan kupon menarik seperti saldo e-wallet dan
                    potongan belanja. Dengan Ecoin, pengelolaan sampah lebih
                    mudah, bermanfaat, dan membantu mengurangi dampak
                    lingkungan.
                </p>
            </div>
            <div class="content-right image-container">
                <img
                    src="/public/images/sorting-trash.png"
                    alt="Sorting Trash"
                    class="image-box"
                />
            </div>
        </section>

        <!-- Hubungi Kami -->
        <section class="hubungi-kami-section">
            <h2 class="hubungi-title">Hubungi Kami</h2>
            <form class="contact-form">
                <input type="email" placeholder="Email" class="contact-input" />

                <div class="textarea-wrapper">
                    <textarea
                        placeholder="Pesan yang ingin disampaikan"
                        class="contact-textarea"
                    ></textarea>

                    <!-- Tombol kirim di pojok kiri bawah -->
                    <button type="submit" class="send-button">
                        <img
                            src="/public/images/plane-icon.png"
                            alt="Kirim"
                            class="plane-icon"
                        />
                    </button>
                </div>
            </form>
        </section>

        <Footer />
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";

export default {
    name: "Tentang",
    components: {
        Navbar,
        Footer,
    },
};
</script>

<style scoped>
.tentang {
    font-family: "Poppins", sans-serif;
    background-color: var(--backgroundWhite);
    color: var(--textBlack);
}

.header-section {
    background-color: var(--primaryGreen);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 10rem 1rem;
    min-height: 300px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 600;
}

.section-content {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
    padding: 4rem 1.5rem;
}

@media (min-width: 768px) {
    .section-content {
        flex-direction: row;
        align-items: center;
        padding: 4rem 6rem;
    }
}

.alt-bg {
    background-color: var(--primaryGreen);
    color: white;
}

.content-left,
.content-right {
    flex: 1;
}

.section-header-line {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.vertical-bar {
    width: 4px;
    height: 40px;
    background-color: var(--primaryGreen);
    margin-right: 0.75rem;
}

/* Misi*/
.section-subtitle {
    font-size: 24px;
    font-weight: 600;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    color: var(--primaryGreen);
    margin: 0;
    white-space: nowrap;
    position: relative;
    /* margin: 0 0 1.5rem 0; */
}

.subtitle-white {
    color: white;
}

.horizontal-line {
    width: 100px;
    height: 5px;
    background-color: var(--primaryGreen);
    border: none;
    margin-left: 1rem;
}

.section-text {
    font-size: 14px;
    font-weight: 400;
    font-family: "Poppins", sans-serif;
    line-height: 1.8;
}

.justify-text {
    text-align: justify;
}

/* Misi list */
.mission-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.mission-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: nowrap;
}

.number-box {
    background-color: white;
    color: var(--primaryGreen);
    font-weight: 600;
    font-family: "Poppins", sans-serif;
    font-size: 24px;
    min-width: 2.5rem;
    min-height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 5px 8px 0 rgba(152, 176, 176, 0.4);
}

.image-container {
    display: flex;
    justify-content: center;
}

.image-box {
    border-radius: var(--borderRadius);
    box-shadow: var(--shadowLight);
    width: 20rem;
    height: auto;
}

/* HUBUNGI KAMI */
.hubungi-kami-section {
    background-color: var(--primaryGreen);
    color: white;
    padding: 4rem 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.hubungi-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 2rem;
}

.contact-form {
    width: 100%;
    max-width: 500px;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contact-input {
    padding: 0.75rem 1rem;
    border: none;
    /* border-radius: 4px; */
    background-color: white;
    color: var(--primaryGreen);
    font-family: "Poppins", sans-serif;
}

.textarea-wrapper {
    position: relative;
}

.contact-textarea {
    width: 100%;
    padding: 1rem;
    min-height: 150px;
    border: none;
    /* border-radius: 4px; */
    background-color: white;
    color: var(--primaryGreen);
    resize: none;
    font-family: "Poppins", sans-serif;
}

.send-button {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background-color: var(--primaryGreen);
    padding: 6px;
    border: none;
    /* border-radius: 4px; */
    cursor: pointer;
}

.plane-icon {
    width: 16px;
    height: 16px;
}
</style>
