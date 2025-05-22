<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { theme } from "@/config/theme";

// Navigasi ke halaman daftar transaksi
function daftarTransaksi() {
    window.location.href = "/daftartransaksi";
}

// Navigasi ke beranda
function beranda() {
    window.location.href = "/beranda";
}

// Logout user
function logout() {
    axios.get('/api/logout')
        .then(() => {
            localStorage.removeItem('user');
            window.location.href = '/beranda';
        })
        .catch(error => {
            console.error('Logout failed:', error);
        });
}

// Tema saat mount
onMounted(() => {
    const root = document.documentElement;
    root.style.setProperty("--primaryGreen", theme.colors.primaryGreen);
    root.style.setProperty("--accentGreen1", theme.colors.accentGreen1);
    root.style.setProperty("--accentGreen2", theme.colors.accentGreen2);
    root.style.setProperty("--textGrey", theme.colors.textGrey);
    root.style.setProperty("--textBlack", theme.colors.textBlack);
    root.style.setProperty("--textField", theme.colors.textField);
    root.style.setProperty("--backgroundWhite", theme.colors.backgroundWhite);
    root.style.setProperty("--fontFamily", theme.fonts.family);
});

// Gaya teks ECOIN
const styleEcoinText = {
    fontFamily: "'DM Sans', sans-serif",
    fontSize: "40px",
    fontWeight: 700,
    color: "var(--backgroundWhite)",
};

// Modal & voucher dummy
const showVoucherModal = ref(false);
const vouchers = ref([
    { id: 1, title: "Diskon 10% Belanja", desc: "Berlaku hingga 30 Juni 2025" },
    { id: 2, title: "Gratis Ongkir", desc: "Min. belanja Rp50.000" },
    { id: 3, title: "Potongan Rp25.000", desc: "Untuk pengguna baru" },
    { id: 4, title: "Cashback 20%", desc: "Untuk pembelian makanan" },
    { id: 5, title: "Diskon 50% Tiket", desc: "Event tertentu" },
    { id: 6, title: "Voucher Kopi Gratis", desc: "Khusus member" },
]);

function toggleVoucherModal() {
    showVoucherModal.value = !showVoucherModal.value;
}
</script>

<template>
    <div class="profil">
        <button class="tutup" @click="beranda">✕</button>

        <section class="profil-isi">
            <!-- SISI KIRI -->
            <div class="sisi-kiri">
                <img src="/public/images/user-icon.png" alt="User Icon" class="ikon" />
                <h2>Pengguna</h2>
                <p>pengguna@contoh.com</p>
                <button class="keluar" @click="logout">Keluar</button>
            </div>

            <!-- SISI KANAN -->
            <div class="sisi-kanan">
                <div class="kanan-wrapper">
                    <div class="ecoin-header">
                        <img src="/public/images/logo.png" alt="Logo" />
                        <span :style="styleEcoinText">ECOIN</span>
                    </div>

                    <h1 class="judul">Profil</h1>

                    <div class="form-container">
                        <label>Nama</label>
                        <input type="text" placeholder="Pengguna" />

                        <label>Email</label>
                        <input type="email" placeholder="pengguna@contoh.com" />

                        <label>Saldo Koin</label>
                        <input type="text" placeholder="0.000000" readonly class="readonly-field" />

                        <label>Facebook</label>
                        <input type="text" placeholder="https://facebook.com/..." />

                        <label>Twitter</label>
                        <input type="text" placeholder="https://x.com/..." />

                        <div class="aksi">
                            <div class="aksi-row">
                                <button class="transaksi" @click="daftarTransaksi">Daftar Transaksi</button>
                                <button class="voucher" @click="toggleVoucherModal">Voucher Anda</button>
                            </div>
                            <button class="edit">Edit Profil</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- MODAL VOUCHER -->
        <div v-if="showVoucherModal" class="modal-overlay" @click.self="toggleVoucherModal">
            <div class="modal-content">
                <h2>Voucher Anda</h2>
                <div class="voucher-list">
                    <div v-for="voucher in vouchers" :key="voucher.id" class="voucher-item">
                        <h3>{{ voucher.title }}</h3>
                        <p>{{ voucher.desc }}</p>
                    </div>
                </div>
                <button class="close-modal" @click="toggleVoucherModal">Tutup</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* === Struktur Profil === */
.profil {
    font-family: var(--fontFamily);
    height: 100vh;
    background-color: #fff;
    position: relative;
}

.tutup {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: var(--primaryGreen);
    color: white;
    border: none;
    padding: 6px 12px;
    font-size: 20px;
    cursor: pointer;
    z-index: 10;
    border-radius: 4px;
}

.profil-isi {
    display: flex;
    height: 100%;
}

.sisi-kiri {
    flex: 1;
    background-color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 20px;
    text-align: center;
}

.ikon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid var(--primaryGreen);
    padding: 10px;
}

.keluar {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--fontFamily);
    margin-top: 10px;
    padding: 8px 20px;
    background-color: var(--primaryGreen);
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

.sisi-kanan {
    flex: 1;
    background-color: var(--primaryGreen);
    color: white;
    padding: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.kanan-wrapper {
    width: 100%;
    max-width: 700px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.ecoin-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.ecoin-header span {
    margin-left: -2px;
}

.ecoin-header img {
    width: 60px;
}

.judul {
    font-size: 24px;
    font-weight: 600;
    font-family: var(--fontFamily);
    margin-bottom: 10px;
    color: white;
}

.form-container {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-container label {
    font-size: 14px;
    font-weight: 400;
    font-family: var(--fontFamily);
    color: white;
    margin-top: 10px;
}

.form-container input {
    padding: 8px;
    border: 2px solid var(--textField);
    border-radius: 4px;
    background-color: white;
    color: black;
    font-size: 14px;
    font-family: var(--fontFamily);
}

.form-container input::placeholder {
    color: var(--textGrey);
}

.readonly-field,
input[readonly],
input:disabled {
    background-color: #e0e0e0;
    color: #555;
    cursor: not-allowed;
}

.aksi {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
    align-items: center;
}
.aksi-row {
    display: flex;
    gap: 10px;
    width: 100%;
    justify-content: center;
    flex-wrap: wrap;
}

.aksi-row button {
    flex: 1;
    min-width: 120px;
}

.transaksi,
.edit,
.voucher {
    width: 200px;
    border: 1px solid white;
    background-color: transparent;
    color: white;
    padding: 10px 0;
    text-align: center;
    border-radius: 4px;
    font-weight: 600;
    font-size: 16px;
    font-family: var(--fontFamily);
    transition: background-color 0.3s ease, color 0.3s ease;
    cursor: pointer;
}

.transaksi:hover,
.edit:hover,
.voucher:hover {
    background-color: var(--accentGreen1);
    color: white;
}

/* === MODAL === */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 400px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 8px 16px rgba(0,0,0,0.3);
    text-align: center;
}

.modal-content h2 {
    font-size: 20px;
    margin-bottom: 10px;
    color: var(--primaryGreen);
}

.voucher-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 15px;
}

.voucher-item {
    padding: 10px;
    border: 1px solid var(--textGrey);
    border-radius: 6px;
    text-align: left;
}

.voucher-item h3 {
    margin: 0;
    font-size: 16px;
    color: var(--textBlack);
}

.voucher-item p {
    margin: 2px 0 0;
    font-size: 13px;
    color: var(--textGrey);
}

.close-modal {
    padding: 8px 16px;
    background-color: var(--primaryGreen);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* === RESPONSIVE === */
@media screen and (max-width: 768px) {
    .profil-isi {
        flex-direction: column;
    }

    .sisi-kiri,
    .sisi-kanan {
        width: 100%;
        padding: 30px 20px;
    }

    .tutup {
        top: 10px;
        left: 10px;
        padding: 4px 8px;
    }

    .ecoin-header img {
        width: 40px;
    }

    .ecoin-header span {
        font-size: 28px;
    }

    .transaksi,
    .edit,
    .voucher {
        width: 100%;
    }
}
</style>
