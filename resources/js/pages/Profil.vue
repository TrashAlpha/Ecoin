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
                <h2 :style="stylePengguna">Pengguna</h2>
                <p :style="styleEmail">pengguna@contoh.com</p>
                <button class="keluar">Keluar</button>
            </div>

            <!-- KANAN -->
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
                        <input
                            type="text"
                            placeholder="0.000000"
                            readonly
                            class="readonly-field"
                        />

                        <label>Facebook</label>
                        <input
                            type="text"
                            placeholder="https://facebook.com/..."
                        />

                        <label>Twitter</label>
                        <input type="text" placeholder="https://x.com/..." />

                        <div class="aksi">
                            <button class="transaksi" @click="daftarTransaksi">
                                Daftar Transaksi
                            </button>
                            <button class="edit">Edit Profil</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { theme } from "@/config/theme";

function daftarTransaksi() {
    window.location.href = "/daftartransaksi";
}
function beranda() {
    window.location.href = "/beranda";
}

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
</script>


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

.transaksi,
.edit {
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
.edit:hover {
    background-color: var(--accentGreen1);
    color: white;
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
