<template>
    <div class="daftartransaksi">
        <div class="container-card">
            <div class="header">
                <button class="back-button" @click="goBack">
                    <img
                        src="/public/images/back.png"
                        alt="Back"
                        class="icon"
                    />
                </button>

                <h1 class="title">Daftar Transaksi</h1>
            </div>

            <div
                class="list-card"
                v-for="(item, index) in transaksi"
                :key="index"
            >
                <div>
                    <strong>Tanggal</strong><br />
                    {{ item.tanggal }}
                </div>
                <div>
                    <strong>Jenis Transaksi</strong><br />
                    {{ item.jenis }}
                </div>
                <div>
                    <strong>Koin</strong><br />
                    {{ item.koin }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { theme } from "@/config/theme";
import axios from "axios";

const transaksi = ref([]);

onMounted(async () => {
  const semuaTransaksi = []; // array penampung sementara semua transaksi
  let userId = null;

  // Ambil user ID dari localStorage
  try {
    const userData = localStorage.getItem("user");
    if (userData) {
      const user = JSON.parse(userData);
      userId = user.id;
    }
  } catch (e) {
    console.error("Gagal parsing user data dari localStorage:", e);
  }

  // Ambil transaksi umum (misalnya transaksi global)
  try {
    const responseUmum = await axios.get("/api/log-transaksi");
    const dataUmum = responseUmum.data.map(item => ({
      tanggal: new Date(item.tanggal_transaksi).toLocaleDateString('id-ID', {
        day: 'numeric', month: 'long', year: 'numeric'
      }),
      jenis: item.jenis_transaksi,
      koin: item.jumlah_koin > 0 ? `+${item.jumlah_koin}` : `${item.jumlah_koin}`
    }));
    semuaTransaksi.push(...dataUmum);
  } catch (error) {
    console.error("Gagal mengambil transaksi umum:", error);
  }

  // Ambil transaksi user (penukaran)
  if (userId) {
    try {
      const responseUser = await axios.get(`/api/log-transaksi/${userId}`);
      const dataUser = responseUser.data.data.map((item) => ({
        tanggal: new Date(item.tanggal_penukaran).toLocaleDateString("id-ID", {
          day: "numeric",
          month: "long",
          year: "numeric",
        }),
        jenis: "Penukaran Sampah",
        koin: item.total_koin > 0 ? `+${item.total_koin}` : `${item.total_koin}`,
      }));
      semuaTransaksi.push(...dataUser);
    } catch (error) {
      console.error("Gagal mengambil transaksi user:", error);
    }
  } else {
    console.warn("User ID tidak ditemukan.");
  }

  // Masukkan hasil gabungan ke reactive state
 transaksi.value = semuaTransaksi.sort((a, b) => {
  return new Date(b.tanggal) - new Date(a.tanggal); // terbaru duluan
});

  // Atur tema
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

function goBack() {
    window.location.href = "/profile";
}
</script>

<style scoped>
.daftartransaksi {
    background-color: var(--primaryGreen);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: stretch;
    padding: 20px;
    font-family: var(--fontFamily);
}

.container-card {
    background-color: var(--backgroundWhite);
    border-radius: 8px;
    padding: 24px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    min-height: calc(100vh - 40px);
    display: flex;
    flex-direction: column;
}

.header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.back-button .icon {
    width: 45px;
    height: 45px;
    cursor: pointer;
}

.title {
    flex: 1;
    text-align: center;
    font-size: 40px;
    font-family: "DM Sans", sans-serif;
    font-weight: 700;
    color: var(--textGrey);
    margin: 0;
}

.list-card {
    background-color: var(--accentGreen2);
    border-radius: 4px;
    padding: 16px;
    margin-bottom: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    display: flex;
    justify-content: space-between;
    font-family: var(--fontFamily);
    flex-wrap: wrap;
    gap: 8px;
}

.list-card > div > strong {
    display: block;
    font-size: 20px;
    font-weight: 600;
    font-family: "Poppins", sans-serif;
    color: var(--primaryGreen);
}

.list-card > div {
    font-size: 16px;
    font-weight: 400;
    font-family: "Poppins", sans-serif;
    color: var(--primaryGreen);
}
</style>
