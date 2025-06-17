<template>
    <div class="penukaran-step1">
        <Navbar />

        <section class="hero">
            <img
                src="/public/images/heroPenukaran.png"
                alt="Penukaran Sampah"
                class="hero-image"
            />
                <div class="kategori-tabs">
                    <div
                    class="tab"
                    :class="{ active: activeTab === 'non' }"
                    @click="activeTab = 'non'"
                    >
                    <img src="/public/images/ic_plastic.png" alt="" /> Non Organik
                    </div>
                    <div
                    class="tab"
                    :class="{ active: activeTab === 'organik' }"
                    @click="activeTab = 'organik'"
                    >
                    <img src="/public/images/ic_leaf.png" alt="" /> Organik
                    </div>
                    <div
                    class="tab"
                    :class="{ active: activeTab === 'medis' }"
                    @click="activeTab = 'medis'"
                    >
                    <img src="/public/images/ic_mask.png" alt="" /> Limbah Medis
                    </div>
                </div>
        </section>

        <section class="step-indikator">
            <div class="step-heading">
                <div class="heading-line"></div>
                <p>
                    Detail Sampah <br />
                    Yang Ditukarkan
                </p>
            </div>
            <div class="steps">
                <div class="step active"><span>1</span> Detail Sampah</div>
                <div class="step inactive"><span>2</span> Lokasi Penukaran</div>
                <div class="step inactive">
                    <span>3</span> Konfirmasi Penukaran
                </div>
            </div>
        </section>

        <section
            class="konten-detail"
            v-for="(item, index) in filteredItems"
            :key="item.id"
        >
            <div class="gambar-detail">
                <!-- Multi Gambar Preview -->
                <label class="gambar-utama upload-box">
                    <input
                        type="file"
                        accept="image/*"
                        @change="onMainImageChange($event, item)"
                        hidden
                    />
                    <div v-if="item.buktiTransaksiUrls.length">
                        <img
                            v-for="(url, i) in item.buktiTransaksiUrls"
                            :key="i"
                            :src="url"
                            class="preview-image"
                            style="max-width: 100px; margin: 4px"
                        />
                    </div>
                    <button
                    v-if="item.buktiTransaksiUrls && item.buktiTransaksiUrls.length"
                    @click.stop.prevent="removeMainImage(item)"
                    class="remove-button"
                    >
                    ✕
                    </button>
                </label>
            </div>

            <div class="form-detail">
                <div class="jenis-sampah">
                    <label>Jenis Sampah</label>
                    <div class="tabs">
                        <button
                            v-for="sampah in jenisSampahByKategori[activeTab]"
                            :key="sampah.label"
                            class="tab-button"
                            :class="{ active: item.nama_sampah === sampah.label }"
                            @click="item.nama_sampah = sampah.label"
                        >
                            <img :src="sampah.icon" class="tab-icon" />
                            <span>{{ sampah.label }}</span>
                            <div class="triangle" v-if="item.nama_sampah === sampah.label"></div>
                        </button>
                    </div>
                </div>

                <div class="berat">
                    <label>Berat Sampah</label>
                    <div class="range-wrapper">
                        <span>1</span>
                        <input
                            type="range"
                            min="1"
                            max="50"
                            v-model.number="item.berat"
                        />
                        <span>50</span>
                    </div>

                    <div class="berat-indikator-wrapper">
                        <div
                            class="berat-display"
                            :style="{
                                left: `calc(${getSliderPos(
                                    item.berat
                                )}% - 20px)`,
                            }"
                        >
                            {{ item.berat }}
                        </div>
                        <div
                            class="berat-display-label"
                            :style="{
                                left: `calc(${getSliderPos(
                                    item.berat
                                )}% - 16px)`,
                            }"
                        >
                            Kg
                        </div>
                    </div>
                </div>

                <label>Tanggal Penukaran</label>
                <input
                    type="date"
                    v-model="item.tanggal"
                    @change="handleDateChangeForItem(item)"
                    :min="getMinTimeForItem(item)"
                />

                <label>Waktu Penukaran</label>
                <input type="time" v-model="item.waktu" />

                <div class="actions">
                    <button
                        v-if="items.length > 1"
                        @click="hapusBarang(index)"
                        class="btn-icon btn-hapus-item"
                        style="background-color: #dc3545; margin-left: auto"
                    >
                        Hapus Barang Ini
                    </button>
                </div>
            </div>
        </section>

        <section
            style="
                padding: 20px;
                background-color: #f8f9fa;
                text-align: center;
                margin-top: 20px;
                border-radius: 8px;
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
                max-width: 800px;
                margin: 20px auto;
            "
        >
            <button
                class="btn-icon"
                :class="{ active: tambahClicked }"
                @click="tambahBarang"
                style="margin-right: 10px"
            >
                + Tambah Barang Lain
            </button>
            <button
                class="btn-icon"
                :class="{ active: simpanClicked }"
                @click="handleSimpanSemua"
            >
                <img
                    src="/public/images/save-icon.png"
                    alt="save"
                    style="width: 16px; height: 16px; margin-right: 5px"
                />
                Simpan & Lanjutkan
            </button>
        </section>

        <section class="langganan">
            <h2>Berlangganan ECOIN</h2>
            <h3>Untuk Mendapatkan Informasi Terbaru</h3>
            <p>
                Masukkan emailmu dan dapatkan notifikasi informasi terbaru<br />dan
                terupdate tentang aplikasi
            </p>
            <div class="email-box">
                <input type="email" placeholder="Tulis Emailmu Disini ..." />
                <button class="btn send">
                    <img src="/public/images/ic_send.png" alt="Send" />
                </button>
            </div>
        </section>

        <Footer />
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import { ref } from 'vue';
const activeKategori = ref('non-organik'); // default tab yang aktif

export default {
    name: "PenukaranStep1",
    components: {
        Navbar,
        Footer,
    },
    data() {
        return {
            items: [],
            nextItemId: 1,
            tambahClicked: false,
            simpanClicked: false,
            minDateToday: "", // Akan di-set di created
            minTimeToday: "",
            uploadedImageUrl: "",
            cloudinaryUrl: "https://api.cloudinary.com/v1_1/daigocnje/image/upload",
            cloudinaryPreset: "ecoin2",
            activeTab: 'non',
            kategoriTabs: ['organik', 'anorganik', 'medis'],
            selectedKategori: 'organik', // default
            semuaSampah: [], // data asli dari database
            filteredSampah: [], // data hasil filter berdasarkan kategori
            jenisSampahByKategori: {
                non: [
                    { label: 'Botol Plastik', icon: '/images/botol-icon.png' },
                    { label: 'Kertas', icon: '/images/kertas-icon.png' },
                    { label: 'Baju', icon: '/images/baju-icon.png' },
                ],
                organik: [
                    { label: 'Sisa Makanan', icon: '/images/sisa-makanan-icon.png' },
                    { label: 'Daun Kering', icon: '/images/daun-icon.png' },
                    { label: 'Buah Busuk', icon: '/images/buah-icon.png' },
                ],
                medis: [
                    { label: 'Masker Bekas', icon: '/images/ic_mask.png' },
                    { label: 'Sarung Tangan', icon: '/images/sarung-icon.png' },
                    { label: 'Jarum Suntik', icon: '/images/jarum-icon.png' },
                ]
            }
        };
    },
    created() {
        const today = new Date();
        this.minDateToday = this.formatDate(today);
        this.minTimeToday = this.formatTime(today);
        this.loadItemsFromLocalStorage();
        this.fetchSampah();
    },
    methods: {
        formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, "0");
            const day = String(date.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },
        formatTime(date) {
            const hours = String(date.getHours()).padStart(2, "0");
            const minutes = String(date.getMinutes()).padStart(2, "0");
            return `${hours}:${minutes}`;
        },
        loadItemsFromLocalStorage() {
            const storedItems = localStorage.getItem("itemsToExchange");
            if (storedItems) {
                try {
                    const parsedItems = JSON.parse(storedItems);
                    if (Array.isArray(parsedItems) && parsedItems.length > 0) {
                        this.items = parsedItems.map((item) => ({
                            ...item,
                            mainImage: null,
                            imageFile: null,
                            kategori: item.kategori || 'non',
                        }));

                        const maxId = parsedItems.reduce(
                            (max, item) => Math.max(max, item.id || 0),
                            0
                        );
                        this.nextItemId = maxId + 1;

                        console.log(
                            "Items loaded from localStorage:",
                            this.items
                        );
                        return;
                    }
                } catch (e) {
                    console.error("Error parsing items from localStorage:", e);
                    localStorage.removeItem("itemsToExchange");
                }
            }
            this.tambahBarang();
        },
        createNewItem() {
            const today = new Date();
            return {
                id: this.nextItemId++,
                mainImage: null, // bisa dihapus jika tidak digunakan lagi
                imageFile: null,
                nama_sampah: "Botol Plastik",
                berat: 1,
                tanggal: this.formatDate(today),
                waktu: this.formatTime(today),
                kategori: this.activeTab,
                buktiTransaksiUrls: [], // <--- Tambahan penting di sini
            };
        },
        getMinTimeForItem(item) {
            if (item.tanggal === this.minDateToday) {
                // Jika pengguna baru saja mengubah tanggal ke hari ini,
                // pastikan minTimeToday adalah waktu saat ini yang terbaru
                const now = new Date();
                const currentTime = this.formatTime(now);
                // Jika minTimeToday (saat komponen dimuat) sudah lewat, gunakan waktu saat ini
                return currentTime > this.minTimeToday
                    ? currentTime
                    : this.minTimeToday;
            }
            return "00:00"; // Tidak ada batasan untuk tanggal di masa depan
        },
        handleDateChangeForItem(item) {
            // Jika tanggal yang dipilih lebih kecil dari hari ini (seharusnya dicegah oleh :min="minDateToday")
            // maka paksa kembali ke hari ini.
            if (item.tanggal < this.minDateToday) {
                item.tanggal = this.minDateToday;
            }

            // Jika tanggal yang dipilih adalah hari ini,
            // dan waktu yang sudah ada pada item tersebut kurang dari waktu minimum hari ini,
            // maka reset waktu atau set ke waktu minimum hari ini.
            const minTimeCurrent = this.getMinTimeForItem(item);
            if (
                item.tanggal === this.minDateToday &&
                item.waktu < minTimeCurrent
            ) {
                item.waktu = minTimeCurrent;
            }
        },
        redirectToStep2() {
            localStorage.setItem("itemsToExchange", JSON.stringify(this.items));
            console.log("Data yang akan dibawa ke step 2:", this.items);
            window.location.href = "/penukaran2";
        },
        async onMainImageChange(event, item) {
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append("file", file);
            formData.append("upload_preset", this.cloudinaryPreset);

            try {
                const response = await fetch(this.cloudinaryUrl, {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                if (!item.buktiTransaksiUrls) {
                    item.buktiTransaksiUrls = []; // pastikan array-nya ada
                }

                // Tambahkan URL baru ke array
                item.buktiTransaksiUrls.push(data.secure_url);

                console.log("Upload berhasil:", data.secure_url);
            } catch (error) {
                console.error("Gagal upload ke Cloudinary:", error);
                alert("Upload gambar gagal. Coba lagi.");
            }

            event.target.value = null;
        },
        removeMainImage(item) {
            const confirmed = window.confirm(
                "Apakah Anda yakin ingin menghapus gambar ini?"
            );
            if (confirmed) {
                if (item.mainImage) {
                    URL.revokeObjectURL(item.mainImage);
                }
                item.mainImage = null;
                item.imageFile = null;
                item.buktiTransaksiUrls = []; // ini penting!
            }
        },
        tambahBarang() {
            const newItem = this.createNewItem();
            newItem.kategori = this.activeTab;
            this.items.push(newItem);
            this.tambahClicked = true;
            setTimeout(() => {
                this.tambahClicked = false;
            }, 200);
        },
        hapusBarang(index) {
            if (this.items[index] && this.items[index].mainImage) {
                URL.revokeObjectURL(this.items[index].mainImage);
            }
            this.items.splice(index, 1);
            if (this.items.length === 0) {
                this.tambahBarang();
            }
        },
        handleSimpanSemua() {
            this.simpanClicked = true;

            for (const item of this.items) {
                // Loop untuk validasi setiap item
                if (!item.buktiTransaksiUrls || item.buktiTransaksiUrls.length === 0) {
                    alert(`Mohon unggah minimal satu gambar untuk barang "${item.nama_sampah}".`);
                    this.simpanClicked = false;
                    return;
                }
                if (!item.tanggal || !item.waktu) {
                    alert(
                        "Mohon isi tanggal dan waktu penukaran untuk setiap barang."
                    );
                    this.simpanClicked = false;
                    return;
                }
                // Validasi tanggal tidak boleh sebelum hari ini
                if (item.tanggal < this.minDateToday) {
                    alert(
                        `Tanggal penukaran untuk barang "${item.nama_sampah}" tidak boleh sebelum ${this.minDateToday}.`
                    );
                    this.simpanClicked = false;
                    return;
                }
                // Validasi waktu jika tanggal adalah hari ini
                const minTimeForThisItem = this.getMinTimeForItem(item);
                if (
                    item.tanggal === this.minDateToday &&
                    item.waktu < minTimeForThisItem
                ) {
                    alert(
                        `Waktu penukaran untuk barang "${item.nama_sampah}" pada hari ini tidak boleh sebelum jam ${minTimeForThisItem}.`
                    );
                    this.simpanClicked = false;
                    return;
                }
            }

            console.log("Semua item untuk disimpan:", this.items);
            setTimeout(() => {
                this.redirectToStep2();
                this.simpanClicked = false;
            }, 200);
        },
        getSliderPos(beratValue) {
            const min = 1;
            const max = 50;
            const value = Math.max(min, Math.min(max, Number(beratValue)));
            return ((value - min) / (max - min)) * 100;
        },
        async fetchSampah() {
            try {
                // Ganti URL di bawah ini dengan endpoint API/database Anda
                const response = await fetch('https://api.example.com/jenis-sampah');
                const data = await response.json();

                this.semuaSampah = data;
                this.filterSampahByKategori(); // Filter awal berdasarkan kategori default
            } catch (error) {
                console.error('Gagal mengambil data sampah:', error);
            }
        },

        filterSampahByKategori() {
            this.filteredSampah = this.semuaSampah.filter(
                item => item.tipe_sampah.toLowerCase() === this.selectedKategori.toLowerCase()
            );
        },

        onKategoriTabClick(kategori) {
            this.selectedKategori = kategori;
            this.filterSampahByKategori();
        }
        
    },
    computed: {
        filteredItems() {
            // Kembalikan hanya item dengan kategori sesuai tab aktif
            return this.items.filter(item => item.kategori === this.activeTab);
        }
    },
    watch: {
        activeTab(newVal) {
        }
    },
};
</script>

<style scoped>
.penukaran-step1 {
    font-family: var(--fontFamily);
    background-color: var(--backgroundWhite);
    color: var(--textBlack);
}

/* Hero */
.hero {
    position: relative;
    display: flex;
    justify-content: center;
    /* padding: 0 32px; */
}

.hero-image {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
}

.kategori-tabs {
    position: absolute;
    bottom: -40px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    background-color: var(--primaryGreen);
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 2;
}

.kategori-tabs.inline {
    position: static;
    transform: none;
    box-shadow: none;
    background: transparent;
    padding: 0;
    gap: 10px;
}

.tab {
    width: 150px;
    display: flex;
    flex-direction: column;
    align-items: center; /* Pusatkan horizontal */
    justify-content: center;
    padding: 10px 20px;
    margin: 0 5px;
    color: var(--backgroundWhite);
    font-weight: var(--fontWeightBold);
    cursor: pointer;
    border-radius: 5px;
    text-align: center;
}

.tab.active {
    background-color: var(--accentGreen1);
    color: white;
}

.kategori-tabs.inline .tab {
    background-color: var(--textField);
    color: var(--textBlack);
}

.tab img {
    height: 20px;
    margin-bottom: 6px;
}

.tab:hover {
    background-color: var(--accentGreen1);
    color: white;
}

.kategori-tabs .tab.active {
    background-color: var(--accentGreen1) !important;
    color: white !important;
}

.kategori-tabs.inline .tab.active {
    background-color: var(--accentGreen1) !important;
    color: white !important;
}

/* Step Indicator */
.step-indikator {
    text-align: start;
    margin-top: 60px;
}

.step-heading {
    display: flex;
    align-items: center;
    padding-left: 32px;
    gap: 12px;
    font-weight: var(--fontWeightBold);
    color: var(--primaryGreen);
    font-size: var(--fontSizeMedium);
    margin-bottom: 8px;
}

.heading-line {
    width: 100px;
    height: 5px;
    background-color: var(--primaryGreen);
    border-radius: 4px;
}

.steps {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-top: 32px;
    padding: 0 32px;
    gap: 40px;
    flex-wrap: wrap;
}

.step {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--primaryGreen);
    font-weight: var(--fontWeightSemiBold);
    font-size: var(--fontSizeNormal);
    min-width: 120px;
    justify-content: center;
    text-align: center;
}

.step span {
    background-color: var(--primaryGreen);
    color: white;
    padding: 6px 12px;
    font-weight: var(--fontWeightBold);
    box-shadow: -5px 5px 0 rgba(0, 0, 0, 0.25);
    opacity: 0.5;
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

.range-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* style tengah*/
/* Kontainer utama */
.konten-detail {
    display: flex;
    flex-wrap: wrap;
    padding: 40px 32px;
    gap: 32px;
}

/* Upload gambar */
.upload-box {
    background-color: #f5f5f5;
    padding: 60px;
    text-align: center;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #90a4ae;
    font-weight: 600;
    font-size: 16px;
    border: 2px dashed #cfd8dc;
    transition: border-color 0.3s ease;
    border-radius: 4px;
}

.upload-box:hover {
    border-color: #006662;
}

.gambar-detail {
    flex: 1;
    min-width: 300px;
}

.gambar-utama {
    margin-bottom: 12px;
    height: 500px;
    max-height: 500px;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    max-height: 200px;
}

.remove-button {
    position: absolute;
    top: 6px;
    right: 6px;
    background-color: rgba(255, 0, 0, 0.8);
    color: white;
    border: none;
    width: 24px;
    height: 24px;
    font-size: 16px;
    line-height: 1;
    cursor: pointer;
    z-index: 10;
    border-radius: 4px;
}

/* Form */
.form-detail {
    flex: 1;
    min-width: 300px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-detail label {
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    color: #006662;
}

/* Tabs Sampah */
.jenis-sampah label {
    display: block;
    margin-bottom: 8px;
}

.tabs {
    display: flex;
    gap: 12px;
    overflow: visible;
}

.tabs button {
    margin-right: 8px;
    padding: 12px;
    border: none;
    background-color: #98b0b0;
    cursor: pointer;
    font-family: "Poppins", sans-serif;
    font-size: 16px;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: white;
    transition: background-color 0.2s;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius: 4px;
}

.tabs button:not(.active):hover {
    background-color: #006662;
    transition: background-color 0.2s ease-in-out;
}

.tabs .active {
    background-color: #006662 !important;
}

.tab-icon {
    width: 32px;
    height: 32px;
}

.tab-button {
    position: relative;
}

.tab-button .triangle {
    position: absolute;
    bottom: -8px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-top: 8px solid #006662;
}

/* Berat Sampah */
.range-wrapper span {
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    color: #006662;
}

/* Slider hijau dan kotak */
input[type="range"] {
    width: 100%;
    -webkit-appearance: none;
    background: transparent;
    height: 8px;
}

input[type="range"]::-webkit-slider-runnable-track {
    height: 8px;
    background: #006662;
    border-radius: 4px;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px;
    height: 16px;
    background: #006662;
    cursor: pointer;
    margin-top: -4px;
    border-radius: 4px;
}

.berat-indikator-wrapper {
    position: relative;
    height: 40px;
    margin-top: 12px;
}

.berat-display {
    position: absolute;
    top: 0;
    background-color: var(--primaryGreen);
    padding: 6px 12px;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    color: white;
    white-space: nowrap;
    transition: left 0.15s ease-in-out;
    border-radius: 4px;
}

.range-wrapper {
    position: relative;
    margin-top: 10px;
}

.berat-display-label {
    position: absolute;
    top: -24px;
    /* naik ke atas */
    transform: translateX(-50%);
    background-color: white;
    padding: 2px 6px;
    border: 1px solid #ccc;
    color: #006662;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 14px;
    transition: left 0.2s ease-in-out;
    pointer-events: none;
    border-radius: 4px;
}

/* Input Tanggal */
input[type="date"],
input[type="time"] {
    background-color: #98b0b0;
    color: white;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    border: none;
    padding: 8px;
    border-radius: 4px;
}

/* Waktu Penukaran */
.jam {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.jam button {
    flex: 1 1 30%;
    min-width: 100px;
    padding: 8px 16px;
    border: none;
    background-color: #98b0b0;
    color: white;
    font-family: "Poppins", sans-serif;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    border-radius: 4px;
    text-align: center;
}

.jam button.active {
    background-color: #006662 !important;
}

.jam button:not(.active):hover {
    background-color: #006662;
}

.btn-icon,
.jam button {
    transition: background-color 0.2s ease-in-out;
}

/* +Barang & Simpan */
.btn-icon {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background-color: #98b0b0;
    color: white;
    font-family: "Poppins", sans-serif;
    font-size: 16px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

.btn-icon img {
    width: 20px;
    height: 20px;
}

.btn-icon.active {
    background-color: #006662 !important;
}

.btn-icon:not(.active):hover {
    background-color: #006662;
}

.actions {
    display: flex;
    align-items: center;
    gap: 8px;
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
}

.btn.send {
    background-color: var(--primaryGreen);
    padding: 12px;
}

.btn.send img {
    height: 20px;
}

.btn.send:hover {
    background-color: var(--primaryGreen);
}
</style>
