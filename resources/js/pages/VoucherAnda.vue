<template>
    <div class="voucher-anda">
        <div class="container-card">
            <div class="header">
                <button class="back-button" @click="goBack">
                    <img
                        src="/public/images/back.png"
                        alt="Back"
                        class="icon"
                    />
                </button>

                <h1 class="title">Voucher Anda</h1>
            </div>

            <div v-if="vouchers.length === 0" class="empty-state">
                Anda belum memiliki voucher
            </div>

            <div
                class="voucher-card"
                v-for="(voucher, index) in vouchers"
                :key="index"
            >
                <div class="voucher-header">
                    <h3>{{ voucher.nama_voucher }}</h3>
                    <span class="status-badge" :class="voucher.status">{{ voucher.status }}</span>
                </div>
                <div class="voucher-detail">
                    <div class="detail-row">
                        <span class="label">Nilai Voucher:</span>
                        <span class="value">{{ voucher.nilai_voucher }} ecoin</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Diperoleh pada:</span>
                        <span class="value">{{ voucher.tanggal_diperoleh }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { theme } from "@/config/theme";
import axios from "axios";

const vouchers = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get("/api/user-vouchers"); // Sesuaikan endpoint dengan API yang tersedia
        vouchers.value = response.data.map(item => ({
            nama_voucher: item.nama_voucher,
            nilai_voucher: item.nilai_voucher,
            tanggal_diperoleh: item.tanggal_diperoleh,
            status: item.status
        }));
    } catch (error) {
        console.error("Gagal mengambil data voucher:", error);
    }

    // Set CSS variables for theme colors
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
.voucher-anda {
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

.empty-state {
    text-align: center;
    padding: 20px;
    color: var(--textGrey);
    font-size: 18px;
}

.voucher-card {
    background-color: var(--accentGreen2);
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    font-family: var(--fontFamily);
}

.voucher-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    border-bottom: 1px solid var(--accentGreen1);
    padding-bottom: 8px;
}

.voucher-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: var(--primaryGreen);
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
}

.status-badge.active {
    background-color: #4CAF50;
    color: white;
}

.status-badge.expired {
    background-color: #F44336;
    color: white;
}

.status-badge.used {
    background-color: #FF9800;
    color: white;
}

.voucher-detail {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
}

.label {
    font-weight: 500;
    color: var(--primaryGreen);
    font-size: 14px;
}

.value {
    font-weight: 400;
    color: var(--textBlack);
    font-size: 14px;
}

.value.code {
    font-family: monospace;
    font-size: 16px;
    letter-spacing: 1px;
    color: var(--primaryGreen);
    font-weight: 600;
}
</style>