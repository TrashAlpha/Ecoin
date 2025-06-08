<script setup lang="ts">
import { ref, onMounted } from "vue";
import Footer from "../components/Footer.vue";
import Navbar from "../components/Navbar.vue";
import RedeemVoucherModal from "@/components/RedeemVoucherModal.vue";
import KonfirmasiPenukaranModal from "@/components/KonfirmasiPenukaran.vue";
import axios from "axios";

const vouchers = ref([])
const selectedVoucherId = ref(null)
const showModal = ref(false);
const selectedVoucher = ref(null);

const fetchVouchers = async () => {
  try {
    const res = await axios.get("http://localhost:8000/api/vouchers")
    console.log("Vouchers from API:", res.data)
    vouchers.value = res.data.vouchers // ✅ Perbaikan disini
  } catch (error) {
    console.error("Gagal mengambil data voucher:", error)
  }
}

const selectVoucher = (id) => {
  selectedVoucherId.value = id
}

const isSelected = (id) => {
  return selectedVoucherId.value === id
}

onMounted(() => {
  fetchUserData();
  fetchVouchers()
})

function redirectToStep2() {
    window.location.href = "/penukaran2";
}

const showConfirmationModal = ref(false);
const koinYangDidapat = ref<string | number>("");

function openModal(voucher: any) {
    selectedVoucher.value = voucher;
    showModal.value = true;
}

async function handleConfirmKonfirmasi() {
    // 1. Ambil detail sampah dari localStorage
    const itemsString = localStorage.getItem("itemsToExchange");
    if (!itemsString) {
        alert(
            "Detail sampah tidak ditemukan. Harap ulangi dari langkah pertama."
        );
        showConfirmationModal.value = false;
        return;
    }

    let itemsFromStorage: Array<{
        berat: number;
        tanggal?: string; // YYYY-MM-DD
        waktu?: string; // HH:mm
        [key: string]: any;
    }>;
    try {
        itemsFromStorage = JSON.parse(itemsString);
        if (!Array.isArray(itemsFromStorage) || itemsFromStorage.length === 0) {
            alert(
                "Data item sampah tidak valid atau kosong. Harap ulangi dari langkah pertama."
            );
            showConfirmationModal.value = false;
            return;
        }
    } catch (error) {
        alert("Gagal memproses data item sampah. Format tidak valid.");
        console.error("Error parsing itemsToExchange:", error);
        showConfirmationModal.value = false;
        return;
    }

    // 2. Tentukan tanggal dan waktu penukaran paling jauh dari itemsFromStorage
    let latestDateTime: Date | null = null;
    let latestTanggalPenukaran: string | null = null;
    let latestWaktuPenukaran: string | null = null;

    for (const item of itemsFromStorage) {
        if (
            item.tanggal &&
            item.waktu &&
            typeof item.tanggal === "string" &&
            typeof item.waktu === "string" &&
            /^\d{4}-\d{2}-\d{2}$/.test(item.tanggal) && // Validasi format tanggal YYYY-MM-DD
            /^\d{2}:\d{2}$/.test(item.waktu) // Validasi format waktu HH:mm
        ) {
            try {
                // Gabungkan tanggal dan waktu. Tambahkan detik untuk parsing Date yang lebih robust.
                const currentItemDateTime = new Date(
                    `${item.tanggal}T${item.waktu}:00`
                );

                if (isNaN(currentItemDateTime.getTime())) {
                    // Cek apakah tanggal valid
                    console.warn(
                        `Format tanggal/waktu tidak valid pada item: ${item.nama_sampah} (${item.tanggal} ${item.waktu})`
                    );
                    continue; // Abaikan item ini
                }

                if (!latestDateTime || currentItemDateTime > latestDateTime) {
                    latestDateTime = currentItemDateTime;
                    latestTanggalPenukaran = item.tanggal;
                    latestWaktuPenukaran = item.waktu;
                }
            } catch (e) {
                console.warn(
                    `Error saat memproses tanggal/waktu untuk item '${item.nama_sampah}': `,
                    e
                );
            }
        } else {
            // Jika ingin mewajibkan setiap item punya tanggal/waktu, bisa tambahkan error di sini.
            // Untuk sekarang, kita hanya mencari yang "paling jauh" dari yang ada.
            console.warn(
                `Item '${item.nama_sampah}' tidak memiliki properti 'tanggal'/'waktu' yang valid atau formatnya salah.`
            );
        }
    }

    if (!latestTanggalPenukaran || !latestWaktuPenukaran) {
        alert(
            "Tanggal dan waktu penukaran tidak dapat ditentukan dari daftar item sampah. " +
                "Pastikan setidaknya satu item memiliki informasi tanggal (YYYY-MM-DD) dan waktu (HH:mm) yang valid."
        );
        showConfirmationModal.value = false;
        return;
    }

    // Mapping item sampah untuk payload, sama seperti sebelumnya
    const detail_sampah_payload = itemsFromStorage.map((item) => ({
        nama_sampah: item.nama_sampah,
        jumlah: item.berat,
    }));

    // 3. Ambil user_id dari localStorage (sama seperti sebelumnya)
    const userDataString = localStorage.getItem("user");
    if (!userDataString) {
        alert("Data pengguna tidak ditemukan. Harap login ulang.");
        showConfirmationModal.value = false;
        return;
    }
    let userId: number | string;
    try {
        const userData = JSON.parse(userDataString);
        if (!userData || typeof userData.id === "undefined") {
            alert(
                "User ID tidak ditemukan dalam data pengguna. Harap login ulang."
            );
            showConfirmationModal.value = false;
            return;
        }
        userId = userData.id;
    } catch (error) {
        alert("Gagal memproses data pengguna. Format tidak valid.");
        console.error("Error parsing userData:", error);
        showConfirmationModal.value = false;
        return;
    }

    // 4. Ambil detail lokasi dari localStorage (exchangeLocationDetails)
    // Tanggal & Waktu dari sini akan diabaikan karena sudah diambil dari itemsToExchange
    const exchangeLocationDetailsString = localStorage.getItem("location");
    if (!exchangeLocationDetailsString) {
        alert(
            "Detail lokasi penukaran tidak ditemukan (exchangeLocationDetails). Harap lengkapi Langkah 2."
        );
        showConfirmationModal.value = false;
        return;
    }
    let exchangeLocationDetailsParsed: string | any;
    try {
        exchangeLocationDetailsParsed = JSON.parse(
            exchangeLocationDetailsString
        );
        if (!exchangeLocationDetailsParsed) {
            alert(
                "Informasi 'lokasi_penukaran' wajib diisi pada detail lokasi (Langkah 2)."
            );
            showConfirmationModal.value = false;
            return;
        }
    } catch (error) {
        alert("Gagal memproses data detail lokasi. Format tidak valid.");
        console.error("Error parsing exchangeLocationDetails:", error);
        showConfirmationModal.value = false;
        return;
    }

    // 5. Siapkan bukti_transaksi (PLACEHOLDER - sama seperti sebelumnya)
    const bukti_transaksi_payload: string[] = [
        "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=",
    ];
    console.warn(
        "PERHATIAN: Menggunakan placeholder untuk 'bukti_transaksi'. Anda perlu mengimplementasikan fitur unggah gambar."
    );

    // 6. Buat payload akhir
    const payload = {
        user_id: userId,
        detail_sampah: detail_sampah_payload,
        tanggal_penukaran: latestTanggalPenukaran, // Dari itemsToExchange
        waktu_penukaran: latestWaktuPenukaran, // Dari itemsToExchange
        lokasi_penukaran: exchangeLocationDetailsParsed, // Dari exchangeLocationDetails
        alamat_detail: exchangeLocationDetailsParsed.alamat_detail || null,
        latitude: exchangeLocationDetailsParsed.latitude || null,
        longitude: exchangeLocationDetailsParsed.longitude || null,
        bukti_transaksi: bukti_transaksi_payload,
    };

    console.log("Payload yang akan dikirim:", payload);

    // 7. Kirim data ke backend (sama seperti sebelumnya)
    try {
        const response = await fetch(
            "http://localhost:8000/api/create-sampah",
            {
                // Ganti URL API jika perlu
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    // 'Authorization': `Bearer ${localStorage.getItem('authToken')}`, // Jika ada otentikasi
                },
                body: JSON.stringify(payload),
            }
        );

        const result = await response.json();

        if (response.ok && result.success) {
            alert(
                "Penukaran sampah berhasil diajukan! " + (result.message || "")
            );
            localStorage.removeItem("itemsToExchange");
            localStorage.removeItem("location"); // Hapus detail lokasi penukaran
            window.location.href = "/beranda";
            // localStorage.removeItem("exchangeLocationDetails"); // Pertimbangkan apakah ini perlu dihapus semua
            // window.location.href = "/status-penukaran";
        } else {
            let errorMessage = "Gagal mengajukan penukaran sampah.";
            if (result.message)
                errorMessage += `\nPesan Server: ${result.message}`;
            if (result.errors) {
                errorMessage += "\nDetail Kesalahan:\n";
                for (const key in result.errors) {
                    errorMessage += `- ${key}: ${result.errors[key].join(
                        ", "
                    )}\n`;
                }
            }
            alert(errorMessage);
            console.error("API Error Data:", result);
        }
    } catch (error) {
        console.error("Error submitting exchange to backend:", error);
        alert(
            "Terjadi kesalahan pada sisi klien saat mengirim data penukaran. Periksa konsol."
        );
    } finally {
        showConfirmationModal.value = false;
    }
}

async function fetchAndCalculateCoins() {
    const localStorageKey = "itemsToExchange";
    const itemsString = localStorage.getItem(localStorageKey);

    const koinDidapatInput = document.getElementById(
        "koin_yang_ditukar"
    ) as HTMLInputElement;
    const koinYangDidapatRef = koinYangDidapat;

    if (!itemsString) {
        console.warn(`'${localStorageKey}' not found in localStorage.`);
        if (koinDidapatInput)
            koinDidapatInput.value = "Data item tidak ditemukan";
        koinYangDidapatRef.value = "Data item tidak ditemukan";
        return;
    }

    try {
        const itemsFromStorage: Array<{
            nama_sampah: string;
            berat: number;
            [key: string]: any;
        }> = JSON.parse(itemsString);

        if (!Array.isArray(itemsFromStorage) || itemsFromStorage.length === 0) {
            console.warn(
                `Data in '${localStorageKey}' is not a valid array or is empty.`
            );
            if (koinDidapatInput)
                koinDidapatInput.value = "Data item tidak valid";
            koinYangDidapatRef.value = "Data item tidak valid";
            return;
        }

        const detail_sampah_payload = itemsFromStorage.map((item) => ({
            nama_sampah: item.nama_sampah,
            jumlah: item.berat,
        }));

        const apiUrl = "http://localhost:8000/api/calculate";
        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({ detail_sampah: detail_sampah_payload }),
        });

        console.log(detail_sampah_payload);
        const result = await response.json();

        if (
            response.ok &&
            result.success &&
            result.data &&
            typeof result.data.total_koin !== "undefined"
        ) {
            if (koinDidapatInput)
                koinDidapatInput.value = result.data.total_koin.toString();
            koinYangDidapatRef.value = result.data.total_koin;
        } else {
            const errorMessage =
                result.message || `Gagal menghitung (HTTP ${response.status})`;
            console.error(
                "Failed to calculate coins:",
                errorMessage,
                result.errors || ""
            );
            if (koinDidapatInput) koinDidapatInput.value = errorMessage;
            koinYangDidapatRef.value = errorMessage;
            if (result.errors) {
                console.log("Validation errors:", result.errors);
            }
        }
    } catch (error) {
        console.error("Error fetching or processing coin calculation:", error);
        const clientErrorMessage = "Terjadi kesalahan pada klien";
        if (koinDidapatInput) koinDidapatInput.value = clientErrorMessage;
        koinYangDidapatRef.value = clientErrorMessage;
    }
}

onMounted(() => {
    const userDataString = localStorage.getItem("user");
    if (userDataString) {
        try {
            const userData = JSON.parse(userDataString);
            if (userData && typeof userData.saldo_koin !== "undefined") {
                const saldoKoinInput = document.getElementById(
                    "saldo_koin"
                ) as HTMLInputElement;
                if (saldoKoinInput) {
                    saldoKoinInput.value = userData.saldo_koin;
                }
            } else {
                console.warn(
                    "saldo_koin not found in userData from localStorage."
                );
            }
        } catch (error) {
            console.error("Failed to parse userData from localStorage:", error);
        }
    } else {
        console.warn("userData not found in localStorage.");
    }
    fetchAndCalculateCoins();
});

// Tukar Voucher logic
const isLoading = ref(true);
const errorMessage = ref('');

const exchangeVoucher = (voucher) => {
  selectedVoucher.value = voucher;
  showModal.value = true;
};

const confirmExchange = async (voucherId) => {
    try {
        const response = await axios.post(
            '/api/confirm-exchange',
            { voucher_id: voucherId },
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type': 'application/json',
                },
            }
        );

        if (response.data.success) {
            alert('Penukaran berhasil!');
            // Update saldo di localStorage
            await fetchUserData(); // fetch ulang data user
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            alert(response.data.message || 'Penukaran gagal.');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    } catch (error) {
        console.error('Gagal konfirmasi penukaran:', error);
        alert('Terjadi kesalahan saat konfirmasi penukaran.');
    }
};

const user = ref({});
const fetchUserData = async () => {
  try {
    const res = await axios.get('/api/get-user', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
    user.value = res.data.data;
    console.log('User data:', user.value);
  } catch (error) {
    console.error('Gagal fetch user:', error);
  }
};

const handleCancel = () => {
  showModal.value = false;
  selectedVoucher.value = null;
};

const handleConfirm = async () => {
  if (!selectedVoucher.value) return;

  try {
    const response = await axios.post(
      '/api/confirm-exchange',
      { voucher_id: selectedVoucher.value.id },
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': 'application/json',
        },
      }
    );

    if (response.data.success) {
      alert('Penukaran berhasil!');
      await fetchUserData();
    } else {
      alert(response.data.message || 'Penukaran gagal.');
    }
  } catch (error) {
    console.error('Gagal konfirmasi penukaran:', error);
    alert('Terjadi kesalahan saat konfirmasi penukaran.');
  }

  // Tutup modal
  showModal.value = false;
  selectedVoucher.value = null;
};
</script>

<template>
    <div class="penukaran-step-3-2">
        <Navbar />

        <section class="hero">
            <img
                src="/public/images/heroPenukaran.png"
                alt="Penukaran Sampah"
                class="hero-image"
            />
            <div class="kategori-tabs">
                <div class="tab">
                    <img src="/public/images/ic_plastic.png" alt="" /> Non
                    Organik
                </div>
                <div class="tab">
                    <img src="/public/images/ic_leaf.png" alt="" /> Organik
                </div>
                <div class="tab">
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
                <div class="step active"><span>2</span> Lokasi Penukaran</div>
                <div class="step active">
                    <span>3</span> Konfirmasi Penukaran
                </div>
            </div>
        </section>

        <section class="konten">
            <div class="form">
                <form action="">
                    <label for="saldo-koin">Saldo Koin</label><br />
                    <input type="text" name="" id="saldo_koin" readonly />
                    <br />
                    <label for="koin-yang-didapat">Koin yang Didapat</label
                    ><br />
                    <input
                        type="text"
                        name=""
                        id="koin_yang_ditukar"
                        readonly
                    />
                    <br />

                    <button type="button" @click="redirectToStep2">
                        Kembali
                    </button>
                    <button type="button" @click="showConfirmationModal = true">
                        Tukarkan
                    </button>
                </form>
            </div>
            <div class="opsi-transfer">
            <div class="opsi-grid">
                <div
                class="voucher-card"
                v-for="voucher in vouchers.slice(0, 8)"
                :key="voucher.id"
                @click="exchangeVoucher(voucher)"
                >
                <img :src="voucher.image_url || '/images/logo.png'" alt="voucher image" />

                <div class="info">
                    <div class="voucher-name">{{ voucher.nilai_koin }} poin</div>
                    <div class="total-judul">{{ voucher.deskripsi }}</div>
                    <div class="total-nominal">{{ voucher.nama_voucher }}</div>

                </div>
                </div>
            </div>

            <a href="/penukaran3_2" style="color: blue;">Atau tukar ke rupiah</a>
        </div>
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

        <RedeemVoucherModal
        v-if="showModal"
        :visible="showModal"
        :coins="selectedVoucher?.nilai_koin"
        :voucherName="selectedVoucher?.nama_voucher"
        :icon="'/images/mdi_voucher.png'"
        @cancel="handleCancel"
        @confirm="handleConfirm"
        />

        <KonfirmasiPenukaranModal
            v-if="showConfirmationModal"
            :visible="showConfirmationModal"
            :icon="'/images/VerificationIcon.png'"
            @confirm="handleConfirmKonfirmasi"
        />

        <Footer />
    </div>
</template>

<style scoped>
.penukaran-step-3-2 {
    font-family: var(--fontFamily);
    background-color: var(--backgroundWhite);
    color: var(--textBlack);
}

.hero {
    position: relative;
    display: flex;
    justify-content: center;
}

.hero-image {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
    /* padding:0 32px; */
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
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 2;
}
.tab {
    width: 150px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    margin: 0 5px;
    color: var(--backgroundWhite);
    font-weight: var(--fontWeightBold);
    cursor: pointer;
    border-radius: 5px;
    text-align: center;
}
.tab img {
    height: 20px;
    margin: 0 0 6px 0;
}
.tab:hover {
    background-color: var(--accentGreen1);
    color: var(--textBlack);
}

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
    border-radius: 2px;
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

.langganan {
    text-align: center;
    padding: 80px 20px 100px;
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
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
.btn.send {
    background-color: var(--primaryGreen);
    padding: 12px;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}
.btn.send img {
    height: 20px;
}

.btn.send:hover {
    background-color: var(--primaryGreen);
}

.konten {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
    margin-top: 30px;
    padding: 60px 32px;
    flex-wrap: nowrap;
}

@media (max-width: 768px) {
    .konten {
        flex-direction: column;
        align-items: stretch;
        flex-wrap: wrap;
    }
}

.konten label {
    color: var(--primaryGreen);
    font-size: 24px;
    font-weight: bold;
}

.form input {
    background-color: var(--accentGreen1);
    padding: 12px;
    margin-top: 20px;
    margin-bottom: 20px;
    width: 500px;
    border-radius: 4px;
}

.form button {
    background-color: var(--accentGreen1);
    margin-right: 10px;
    padding: 10px;
    width: 150px;
    color: var(--textField);
    font-size: 20px;
    font-weight: bold;
    border-radius: 4px;
}

.form button:hover {
    background-color: var(--primaryGreen);
}

.opsi-transfer {
    flex: 1;
    min-width: 400px;
    max-width: 800px;
    margin-left: 200px;
}

.opsi-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-top: 16px;
}

.voucher-card {
    background-color: var(--accentGreen1);
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 12px 16px;
    gap: 12px;
    border-radius: 4px;
    cursor: pointer;
}

.voucher-card img {
    width: 75px;
    height: auto;
    object-fit: contain;
    border-radius: 4px;
}

.voucher-card .info {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.voucher-name {
    background-color: var(--primaryGreen);
    padding: 2px 8px;
    color: var(--textField);
    font-size: 14px;
    font-weight: bold;
    border-radius: 4px;

    display: inline-block;       /* Agar background menyesuaikan isi */
    max-width: 100px;            /* Batasi panjang maksimum */
    white-space: nowrap;         /* Hindari pemisahan baris */
    overflow: hidden;            /* Sembunyikan teks yang kepanjangan */
    text-overflow: ellipsis;     /* Tambahkan '...' jika teks terlalu panjang */
}

.total-judul {
    margin-top: 4px;
    font-size: 16px;
    font-weight: bold;
    color: var(--textBlack);
}

.total-nominal {
    color: var(--textGrey);
    font-size: 14px;
}

/* Media query untuk layar kecil */
@media (max-width: 500px) {
    .opsi-transfer {
        min-width: 100%;
        margin-left: 0;
        margin-right: 0;
    }

    .voucher-card {
        flex-direction: column;
        align-items: flex-start;
    }

    .voucher-card img {
        width: 100%;
        max-width: 100px;
    }
}

</style>
