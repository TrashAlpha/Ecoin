<script setup>
import axios from 'axios';

function daftarTransaksi(){
    window.location.href = '/daftartransaksi';
}

function beranda(){
    window.location.href = '/beranda';
}

async function logout() {
    try {
        // Tambahkan CSRF token dari meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const response = await axios.post('/api/logout', {}, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            withCredentials: true
        });
        
        // Hapus data user dari localStorage
        localStorage.removeItem('user');
        
        // Redirect ke halaman beranda
        window.location.href = '/beranda';
        
    } catch (error) {
        console.error('Logout failed:', error);
        
        // Jika error karena CSRF token mismatch, reload halaman
        if (error.response && error.response.status === 419) {
            window.location.reload();
        }
    }
}
</script>
<template>
    <div class="profil">
        <!-- Tombol close -->
        <button class="tutup" @click="beranda">✕</button>

        <section class="profil-isi">
            <!-- Kiri -->
            <div class="sisi-kiri">
                <img
                    src="/public/images/user-icon.png"
                    alt="User Icon"
                    class="ikon"
                />
                <h2>Pengguna</h2>
                <p>pengguna@contoh.com</p>
                <button class="keluar" @click="logout">Keluar</button>
            </div>

            <!-- KANAN -->
            <div class="sisi-kanan">
                <img
                    src="/public/images/logo+ecoin.png"
                    alt="Logo"
                    class="logo"
                />
                <h1>Profil</h1>

                <!-- Tambahkan pembungkus form -->
                <div class="form-container">
                    <label>Nama</label>
                    <input type="text" placeholder="Pengguna" />

                    <label>Email</label>
                    <input type="email" placeholder="pengguna@contoh.com" />

                    <label>Saldo Koin</label>
                    <input type="text" placeholder="0.000000" />

                    <label>Facebook</label>
                    <input
                        type="text"
                        placeholder="https://facebook.com/..."
                        readonly
                    />

                    <label>Twitter</label>
                    <input type="text" placeholder="https://twitter.com/..." />

                    <div class="aksi">
                        <button class="transaksi" @click="daftarTransaksi">Daftar Transaksi</button>
                        <button class="edit">Edit Profil</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.profil {
    font-family: "Segoe UI", sans-serif;
    height: 100vh;
    background-color: #fff;
    position: relative;
}

.tutup {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: #075e54;
    color: white;
    border: none;
    padding: 6px 12px;
    font-size: 20px;
    cursor: pointer;
    z-index: 10;
}

.profil-isi {
    display: flex;
    height: 100%;
}

/* KIRI */
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

.sisi-kiri .ikon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid #075e54;
    padding: 10px;
}

.sisi-kiri h2 {
    font-size: 24px;
    color: #075e54;
}

.sisi-kiri p {
    color: gray;
    margin: 0;
}

.keluar {
    margin-top: 10px;
    padding: 8px 20px;
    background-color: #2c6251;
    color: white;
    border: none;
    cursor: pointer;
}

/* KANAN */
.sisi-kanan {
    flex: 1;
    background-color: #075e54;
    color: white;
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center; /* pusatkan secara horizontal */
    justify-content: center; /* pusatkan secara vertikal */
}

.sisi-kanan .logo {
    width: 100px;
    margin-bottom: 10px;
}

.sisi-kanan h1 {
    font-size: 32px;
    margin-bottom: 10px;
}

.sisi-kanan label {
    font-size: 14px;
    margin-top: 10px;
    align-self: flex-start; /* label rata kiri */
}

.sisi-kanan input {
    padding: 8px;
    border: none;
    border-radius: 4px;
    margin-bottom: 5px;
    width: 100%;
    max-width: 300px;
    color: black;
    background-color: white;
}

.aksi {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
    align-items: center;
}

/* Container form untuk mengunci lebar dan posisi konten kanan */
.form-container {
    width: 100%;
    max-width: 400px;
    display: flex;
    flex-direction: column;
    align-items: stretch; /* Biar label dan input sejajar kiri */
    gap: 6px;
}

.form-container label {
    font-size: 14px;
    margin-top: 10px;
}

.form-container input {
    padding: 8px;
    border: none;
    border-radius: 4px;
    background-color: white;
    color: black;
    width: 100%;
    box-sizing: border-box;
}

/* Pastikan tombol juga ada di dalam container dan konsisten */
.form-container .aksi {
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.form-container .transaksi,
.form-container .edit {
    width: 200px;
    border: 1px solid white;
    background-color: transparent;
    color: white;
    padding: 10px 0;
    text-align: center;
    border-radius: 4px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.form-container .transaksi:hover,
.form-container .edit:hover {
    background-color: #2c6251;
    color: white;
}

/* RESPONSIVE */
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

    .sisi-kanan .logo {
        width: 80px;
        align-self: center;
    }

    .aksi {
        flex-direction: column;
        align-items: center;
    }

    .transaksi,
    .edit {
        width: 100%;
    }
}
</style>
