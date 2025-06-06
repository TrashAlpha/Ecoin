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
    try {
        const response = await axios.get("/api/log-transaksi"); // sesuaikan dengan baseURL
        transaksi.value = response.data.map(item => ({
            tanggal: new Date(item.tanggal_transaksi).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'long', year: 'numeric'
            }),
            jenis: item.jenis_transaksi,
            koin: item.jumlah_koin > 0 ? `+${item.jumlah_koin}` : `${item.jumlah_koin}`
        }));
    } catch (error) {
        console.error("Gagal mengambil data transaksi:", error);
    }

    // Set CSS variables for theme colors
    const root = document.documentElement;
    root.style.setProperty("--primaryGreen", theme.colors.primaryGreen);
    root.style.setProperty("--accentGreen1", theme.colors.accentGreen1);
    root.style.setProperty("--accentGreen2", theme.colors.accentGreen2); // <- ini penting!
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
