<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { theme } from "@/config/theme";

const user = ref(null);

// Form binding fields
const name = ref('');
const email = ref('');
const akunFacebook = ref('');
const akunTwitter = ref('');

function daftarTransaksi() {
    window.location.href = '/daftartransaksi';
}

function beranda() {
    window.location.href = '/beranda';
}

async function logout() {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        await axios.post('/api/logout', {}, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            withCredentials: true
        });

        localStorage.removeItem('user');
        window.location.href = '/beranda';
    } catch (error) {
        console.error('Logout failed:', error);
        if (error.response && error.response.status === 419) {
            window.location.reload();
        }
    }
}

async function fetchUserData() {
    try {
        const saved = localStorage.getItem('user');
        if (saved) {
            user.value = JSON.parse(saved);
        }

        const response = await axios.get('http://localhost:8000/api/get-user', {
            withCredentials: true,
            headers: { 'Accept': 'application/json' }
        });

        if (response.data && response.data.user) {
            user.value = response.data.user;
            localStorage.setItem('user', JSON.stringify(user.value));

            // Isi form
            name.value = user.value.name || '';
            email.value = user.value.email || '';
            akunFacebook.value = user.value.akun_facebook || '';
            akunTwitter.value = user.value.akun_twitter || '';
        } else {
            user.value = null;
            localStorage.removeItem('user');
        }
    } catch (error) {
        console.error('Error fetching user data:', error);
        if (error.response && error.response.status === 401) {
            user.value = null;
            localStorage.removeItem('user');
        }
    }
}

async function updateProfile() {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await axios.put('/api/update-profile', {
            name: name.value,
            email: email.value,
            akun_facebook: akunFacebook.value,
            akun_twitter: akunTwitter.value
        }, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            withCredentials: true
        });

        if (response.data.success) {
            alert('Profil berhasil diperbarui');
            fetchUserData(); // Refresh user data
        } else {
            alert('Gagal memperbarui profil');
        }
    } catch (error) {
        console.error('Gagal update profil:', error);
        alert('Terjadi kesalahan saat memperbarui profil');
    }
}

onMounted(() => {
    fetchUserData();

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

const stylePengguna = {
    color: "var(--textBlack)",
    fontFamily: "var(--fontFamily)",
    fontSize: theme.fonts.size.subheading,
    fontWeight: theme.fonts.weight.semibold,
};

const styleEmail = {
    color: "var(--textGrey)",
    fontFamily: "var(--fontFamily)",
    fontSize: theme.fonts.size.small,
    fontWeight: theme.fonts.weight.regular,
};

const styleEcoinText = {
    fontFamily: "'DM Sans', sans-serif",
    fontSize: "40px",
    fontWeight: 700,
    color: "var(--backgroundWhite)",
};

const showVoucherModal = ref(false);
const vouchers = ref([
    { id: 1, title: "Diskon 10% Belanja", desc: "Berlaku hingga 30 Juni 2025" },
    { id: 2, title: "Gratis Ongkir", desc: "Min. belanja Rp50.000" },
    { id: 3, title: "Potongan Rp25.000", desc: "Untuk pengguna baru" },
    { id: 4, title: "Cashback 20%", desc: "Untuk pembelian makanan" },
    { id: 5, title: "Diskon 50% Tiket", desc: "Event tertentu" },
    { id: 6, title: "Voucher Kopi Gratis", desc: "Khusus member" },
]);

// Edit profile
const isEditModalOpen = ref(false);
const editedName = ref('');
const editedEmail = ref('');
const editedFacebook = ref('');
const editedTwitter = ref('');

const showEditModal = ref(false);
function toggleEditModal() {
    // Salin data asli ke variabel lokal
    editedName.value = name.value;
    editedEmail.value = email.value;
    editedFacebook.value = akunFacebook.value;
    editedTwitter.value = akunTwitter.value;
    isEditModalOpen.value = true;
}

async function saveProfileChanges() {
    name.value = editedName.value;
    email.value = editedEmail.value;
    akunFacebook.value = editedFacebook.value;
    akunTwitter.value = editedTwitter.value;

    await updateProfile(); // Kirim ke server
    isEditModalOpen.value = false;
}

function toggleVoucherModal() {
    showVoucherModal.value = !showVoucherModal.value;
}

function voucherAnda() {
    window.location.href = '/voucheranda';
}
</script>

<template>
    <div class="profil">
        <button class="tutup" @click="beranda">✕</button>

        <section class="profil-isi">
            <!-- KIRI -->
            <div class="sisi-kiri">
                <img
                    src="/public/images/user-icon.png"
                    alt="User Icon"
                    class="ikon"
                />
                <h2 :style="stylePengguna">{{ user ? user.name : 'Pengguna' }}</h2>
                <p :style="styleEmail">{{ user ? user.email : 'pengguna@contoh.com' }}</p>
                <button class="keluar" @click="logout">Keluar</button>
            </div>

            <!-- KANAN -->
            <div class="sisi-kanan">
                <div class="kanan-wrapper">
                    <div class="ecoin-header">
                        <img src="/public/images/logo.png" alt="Logo" />
                        <span :style="styleEcoinText">ECOIN</span>
                    </div>

                    <h1 class="judul">Profil</h1>

                    <!-- Tambahkan pembungkus form -->
                    <div class="form-container">
                        <label>Nama</label>
                        <input type="text" :value="name" readonly class="readonly-field" />

                        <label>Email</label>
                        <input type="email" :value="email" readonly class="readonly-field" />

                        <label>Saldo Koin</label>
                        <input
                            type="text"
                            :value="user ? user.saldo_koin + '' : '0.000000'"
                            readonly
                            class="readonly-field"
                        />

                        <label>Facebook</label>
                        <input type="text" :value="akunFacebook" readonly class="readonly-field" />

                        <label>Twitter</label>
                        <input type="text" :value="akunTwitter" readonly class="readonly-field" />

                        <div class="aksi">
                            <div class="aksi-row">
                            <button class="transaksi" @click="daftarTransaksi">Daftar Transaksi</button>
                            <button class="voucher" @click="voucherAnda">Voucher Anda</button>
                            </div>
                            <button class="edit" @click="toggleEditModal">Edit Profil</button>
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

        <!-- MODAL EDIT PROFIL -->
        <div v-if="isEditModalOpen" class="modal-overlay" @click.self="isEditModalOpen = false">
            <div class="modal-content">
                <h2>Edit Profil</h2>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" v-model="editedName" placeholder="Nama" />

                    <label>Email</label>
                    <input type="email" v-model="editedEmail" placeholder="Email" />

                    <label>Facebook</label>
                    <input type="text" v-model="editedFacebook" placeholder="https://facebook.com/..." />

                    <label>Twitter</label>
                    <input type="text" v-model="editedTwitter" placeholder="https://x.com/..." />
                </div>

                <div class="modal-actions">
                    <button @click="saveProfileChanges">Simpan</button>
                    <button @click="isEditModalOpen = false">Batal</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
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

/* Modal Edit Profil */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  background: #fff;
  padding: 2rem;
  border-radius: 12px;
  width: 90%;
  max-width: 500px;
  position: relative;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.close-modal {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
}

.form-group input {
  display: block;
  width: 100%;
  margin-bottom: 1rem;
  padding: 0.5rem;
  border: 1px solid var(--textBlack);
  border-radius: 4px;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 1rem;
}

.modal-actions button {
  padding: 0.5rem 1rem;
  background-color: var(--primaryGreen);
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

/* Responsive */
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
    .edit {
        width: 100%;
    }
}
</style>
