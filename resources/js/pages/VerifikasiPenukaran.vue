<template>
    <div class="verifikasi-penukaran">
        <Navbar />

        <section class="header-section">
            <h1>Verifikasi Penukaran</h1>
            <p>
                Kelola penukaran yang masuk dan lakukan verifikasi sesuai dengan
                bukti transaksi.
            </p>
        </section>

        <section class="filter-section">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Cari berdasarkan nama pengguna..."
                class="search-input"
            />
            <select v-model="filterStatus" class="filter-select">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
        </section>

        <section class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Penukaran</th>
                        <th>Berat</th>
                        <th>Detail</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="isLoading">
                        <td colspan="8" style="text-align: center">
                            Memuat data...
                        </td>
                    </tr>
                    <tr v-else-if="filteredExchanges.length === 0">
                        <td colspan="8" style="text-align: center">
                            Tidak ada data penukaran yang cocok.
                        </td>
                    </tr>
                    <tr
                        v-for="exchange in filteredExchanges"
                        :key="exchange.id"
                    >
                        <td>{{ exchange.nama_pengguna || "N/A" }}</td>
                        <td>{{ exchange.email_pengguna || "N/A" }}</td>
                        <td>{{ formatDate(exchange.created_at) }}</td>
                        <td>{{ exchange.berat }} Kg</td>
                        <td>
                            <a
                                href="#"
                                class="show-detail"
                                @click.prevent="showDetailOverlay(exchange)"
                                >Lihat detail</a
                            >
                        </td>
                        <td>
                            <span :class="getStatusClass(exchange.status)">{{
                                formatStatus(exchange.status)
                            }}</span>
                        </td>
                        <td>
                            <button
                                class="btn approve"
                                @click="updateStatus(exchange.id, 'approved')"
                                :disabled="exchange.status === 'approved'"
                            >
                                ✔
                            </button>
                            <button
                                class="btn reject"
                                @click="updateStatus(exchange.id, 'rejected')"
                                :disabled="exchange.status === 'rejected'"
                            >
                                ✖
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Detail Overlay -->
        <div v-if="showDetail" class="overlay">
            <div class="overlay-card">
                <div class="overlay-header">
                    <button class="close-btn" @click="closeDetail">×</button>
                </div>
                <div class="overlay-content">
                    <div class="left-column">
                        <img
                            src="/public/images/ic_profile.png"
                            alt="profile"
                            class="profile-pic"
                        />
                        <div class="info-group">
                            <p>
                                <strong>Nama</strong><br />{{
                                    selectedTransaction.nama_pengguna || "N/A"
                                }}
                            </p>
                            <p>
                                <strong>Email</strong><br />{{
                                    selectedTransaction.email_pengguna || "N/A"
                                }}
                            </p>
                            <p>
                                <strong>Jenis Sampah</strong><br />
                                {{
                                    selectedTransaction.bukti_transaksi?.[0]?.nama_sampah || "N/A"
                                }}
                            </p>
                            <p>
                                <strong>Berat sampah (kg)</strong><br />{{
                                    selectedTransaction.berat
                                }}
                                Kg
                            </p>
                            <p>
                                <strong>Tanggal Penukaran</strong><br />{{
                                    formatDate(selectedTransaction.created_at)
                                }}
                            </p>
                            <p>
                                <strong>Waktu Penukaran</strong><br />{{
                                    selectedTransaction.waktu_penukaran ||
                                    "Belum ada data"
                                }}
                            </p>
                            <p>
                                <strong>Lokasi Penukaran</strong><br />{{
                                    selectedTransaction.lokasi_penukaran ||
                                    "Belum ada data"
                                }}
                            </p>
                        </div>
                    </div>
                    <div class="right-column">
                        <h3 class="image-title">Bukti Transaksi</h3>
                        <div
                            v-if="
                                selectedTransaction.bukti_transaksi &&
                                selectedTransaction.bukti_transaksi.length > 0
                            "
                            class="image-grid"
                        >
                            <div
                                class="image-box"
                                v-for="(img, index) in selectedTransaction.bukti_transaksi"
                                :key="index"
                            >
                                <img
                                    :src="getImageUrl(img)"
                                    alt="Bukti Transaksi"
                                />
                            </div>
                        </div>
                        <p v-else>Tidak ada bukti gambar.</p>
                    </div>
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import axios from "axios";

const API_BASE_URL = "https://ecoin-hosted.vercel.app";

export default {
    components: {
        Navbar,
        Footer,
    },
    data() {
        return {
            showDetail: false,
            selectedTransaction: {},
            exchanges: [],
            isLoading: true,
            searchQuery: "",
            filterStatus: "",
        };
    },
    computed: {
        filteredExchanges() {
            let filtered = this.exchanges;

            // Filter berdasarkan query pencarian nama
            if (this.searchQuery) {
                filtered = filtered.filter(
                    (exchange) =>
                        exchange.nama_pengguna &&
                        exchange.nama_pengguna
                            .toLowerCase()
                            .includes(this.searchQuery.toLowerCase())
                );
            }

            // Filter berdasarkan status
            if (this.filterStatus) {
                filtered = filtered.filter(
                    (exchange) => exchange.status === this.filterStatus
                );
            }

            return filtered;
        },
    },
    methods: {
        async fetchExchanges() {
            this.isLoading = true;
            try {
                // Ganti URL '/api/penukaran' dengan endpoint API Anda yang sebenarnya jika berbeda
                const response = await axios.get(
                    `${API_BASE_URL}/api/penukaran`
                ); // Sesuaikan endpoint jika berbeda
                if (response.data.success) {
                    this.exchanges = response.data.data;
                    console.log("Seluruh properti transaksi pertama:", JSON.stringify(this.exchanges[0], null, 2));


                    console.log("Data exchanges:", this.exchanges);

                    // Tambahkan debug detail di sini
                    if (this.exchanges.length > 0) {
                        const first = this.exchanges[0];
                        console.log("Transaksi pertama:", first);
                        console.log("Tipe bukti_transaksi:", typeof first.bukti_transaksi);
                        console.log("Isi bukti_transaksi:", first.bukti_transaksi);

                        // Coba parse jika string
                        if (typeof first.bukti_transaksi === "string") {
                            try {
                                const parsed = JSON.parse(first.bukti_transaksi);
                                console.log("Setelah di-parse:", parsed);
                            } catch (e) {
                                console.warn("Gagal parse bukti_transaksi:", e);
                            }
                        }
                    }
                } else {
                    console.error(
                        "Gagal mengambil data penukaran:",
                        response.data.message
                    );
                    alert(
                        "Gagal mengambil data penukaran. Lihat konsol untuk detail."
                    );
                }
            } catch (error) {
                console.error("Error fetching exchanges:", error);
                // Anda mungkin ingin menampilkan pesan error ke pengguna di sini
                alert(
                    "Terjadi kesalahan saat menghubungi server. Lihat konsol untuk detail."
                );
            } finally {
                this.isLoading = false;
            }
        },
        showDetailOverlay(transaction) {
            // Kita akan pass seluruh objek transaction ke selectedTransaction
            // Default values untuk waktu, lokasi, dan buktiGambar akan diambil dari objek transaction jika ada,
            // atau akan menjadi undefined/null jika tidak ada di backend.
            this.selectedTransaction = { ...transaction }; // Salin objek untuk menghindari mutasi langsung

            // Jika bukti_gambar adalah string JSON, parse dulu
            if (typeof this.selectedTransaction.bukti_transaksi === "string") {
                try {
                    this.selectedTransaction.bukti_transaksi = JSON.parse(
                        this.selectedTransaction.bukti_transaksi
                    );
                } catch (e) {
                    console.warn(
                        "Gagal parse bukti_transaksi:",
                        this.selectedTransaction.bukti_transaksi,
                        e
                    );
                    this.selectedTransaction.bukti_transaksi = []; // Set ke array kosong jika gagal parse
                }
            }
            // Pastikan bukti_gambar adalah array
            if (!Array.isArray(this.selectedTransaction.bukti_transaksi)) {
                this.selectedTransaction.bukti_transaksi = [];
            }

            this.showDetail = true;
        },
        closeDetail() {
            this.showDetail = false;
            this.selectedTransaction = {};
        },
        formatDate(dateString) {
            if (!dateString) return "N/A";
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(dateString).toLocaleDateString("id-ID", options);
        },
        getStatusClass(status) {
            if (status === "pending") return "status status-pending";
            if (status === "approved") return "status status-approved";
            if (status === "rejected") return "status status-rejected";
            return "status"; // default
        },
        formatStatus(status) {
            switch (status) {
                case "pending":
                    return "Menunggu";
                case "approved":
                    return "Disetujui";
                case "rejected":
                    return "Ditolak";
                default:
                    return status;
            }
        },
        getImageUrl(imagePath) {
            // Jika imagePath berupa array (dari JSON), ambil elemen pertama
            if (Array.isArray(imagePath) && imagePath.length > 0) {
                imagePath = imagePath[0];
            }

            // Jika sudah berupa URL lengkap (http atau https)
            if (
                imagePath &&
                (imagePath.startsWith("http://") || imagePath.startsWith("https://"))
            ) {
                return imagePath;
            }

            // Jika berupa base64 data URL (data:image/png;base64,...)
            if (imagePath && imagePath.startsWith("data:image")) {
                return imagePath;
            }

            // Jika path dimulai dengan 'storage/' dari Laravel backend
            if (imagePath && imagePath.startsWith("storage/")) {
                return `${API_BASE_URL}/${imagePath}`;
            }

            // Fallback ke placeholder
            return "/images/placeholder.png";
        },
        async updateStatus(exchangeId, newStatus) {
            try {
                // Anda perlu membuat endpoint API di Laravel untuk mengupdate status
                // Misalnya: PUT /api/penukaran/{id}/status
                const response = await axios.put(
                    `${API_BASE_URL}/api/penukaran/${exchangeId}/status`,
                    {
                        status: newStatus,
                    }
                );

                if (response.data.success) {
                    // Update status di frontend secara lokal untuk responsivitas instan
                    const index = this.exchanges.findIndex(
                        (ex) => ex.id === exchangeId
                    );
                    if (index !== -1) {
                        this.exchanges[index].status = newStatus;
                    }
                    alert(
                        `Status penukaran berhasil diubah menjadi ${this.formatStatus(
                            newStatus
                        )}`
                    );
                } else {
                    alert(`Gagal mengubah status: ${response.data.message}`);
                }
            } catch (error) {
                console.error(
                    `Error updating status for exchange ${exchangeId}:`,
                    error
                );
                alert("Terjadi kesalahan saat mengubah status. Lihat konsol.");
            }
        },
    },
    mounted() {
        this.fetchExchanges(); // Panggil method untuk mengambil data saat komponen dimuat
    },
};
</script>

<style scoped>
.verifikasi-penukaran {
    font-family: var(--fontFamily);
    background-color: var(--backgroundWhite);
}

.header-section {
    text-align: center;
    margin-bottom: 24px;
    padding: 20px 32px;
    background-color: var(--primaryGreen);
}
.header-section h1 {
    color: var(--backgroundWhite);
    font-size: 24px;
    font-weight: var(--fontWeightBold);
}
.header-section p {
    color: var(--backgroundWhite);
    margin-top: 8px;
}

.filter-section {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 12px;
    padding: 0 32px;
}

.search-input {
    padding: 10px;
    flex: 1;
    min-width: 200px;
    background-color: var(--textField);
    border: none;
}

.filter-select {
    padding: 10px;
    background-color: var(--textField);
    border: none;
}

.table-section {
    overflow-x: auto;
    padding: 0 32px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

th,
td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: var(--primaryGreen);
    color: white;
    font-weight: 600;
}

.show-detail {
    color: blue;
    text-decoration: underline;
    cursor: pointer;
}

.bukti-img {
    width: 60px;
    height: auto;
    border-radius: 4px;
}

.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 12px;
}
.status-pending {
    background-color: orange;
    color: white;
}
.status-approved {
    background-color: green;
    color: white;
}
.status-rejected {
    background-color: red;
    color: white;
}

.btn {
    border: none;
    cursor: pointer;
    padding: 6px 10px;
    margin: 0 2px;
    font-size: 16px;
    border-radius: 4px;
}
.btn.approve {
    background-color: #27ae60;
    color: white;
}
.btn.reject {
    background-color: #c0392b;
    color: white;
}

.btn:hover {
    opacity: 0.85;
}

/* Detail Overlay Styles */
.overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
}

.overlay-card {
    background: #f4f1f5;
    width: 90%;
    max-width: 900px;
    border-radius: 12px;
    position: relative;
}

.overlay-header {
    background-color: var(--accentGreen1);
    padding: 8px 16px;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.close-btn {
    background: none;
    border: none;
    font-size: 24px;
    color: var(--textBlack);
    cursor: pointer;
}

.overlay-content {
    display: flex;
    gap: 32px;
    flex-wrap: wrap;
    padding: 12px;
}

.left-column {
    flex: 1;
    min-width: 250px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.profile-pic {
    width: 80px;
    height: 80px;
    margin-bottom: 16px;
}

.info-group {
    text-align: center;
}

.info-group p {
    margin: 12px 0;
}

.right-column {
    flex: 2;
    min-width: 300px;
}

.image-title {
    font-weight: var(--fontWeightBold);
    color: var(--textGrey);
    font-size: var(--fontSizeLarge);
    text-align: center;
    margin-bottom: 12px;
}

.image-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.image-box {
    background-color: #eefaf9;
    border-radius: 8px;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
