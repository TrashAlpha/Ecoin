<script setup>
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';

const popupAdd = ref(false);
const popupUpdate = ref(false);
const vouchers = ref([]);
const selectedVoucher = ref(null);
const newVoucher = ref({
  nama_voucher: '',
  deskripsi: '',
  nilai_koin: '',
  image_url: '',
  status: 'aktif'
});

// Cloudinary upload
const selectedPhoto = ref(null);
const previewPhoto = ref(null);
const selectedPhotoUpdate = ref(null);
const previewPhotoUpdate = ref(null);

function handlePhotoUpload(event) {
    const file = event.target.files[0];
    if (file) {
        selectedPhoto.value = file;
        previewPhoto.value = URL.createObjectURL(file);
    }
}

function handlePhotoUploadUpdate(event) {
    const file = event.target.files[0];
    if (file) {
        selectedPhotoUpdate.value = file;
        previewPhotoUpdate.value = URL.createObjectURL(file);
    }
}

async function uploadToCloudinary(file) {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('upload_preset', 'EcoinUp');
    formData.append('cloud_name', 'dk2wbhh4d');

    const response = await axios.post('https://api.cloudinary.com/v1_1/dk2wbhh4d/image/upload', formData);
    return response.data.secure_url;
}

function addVoucher(){
    popupAdd.value = true;
}

function updateVoucher(){
    popupUpdate.value = true;
}

function close(){
    if (popupAdd.value == true) {
        popupAdd.value = false;
        // Reset photo selection when closing
        selectedPhoto.value = null;
        previewPhoto.value = null;
    } else {
        popupUpdate.value = false;
        // Reset photo selection when closing
        selectedPhotoUpdate.value = null;
        previewPhotoUpdate.value = null;
    }
}

function fetchVouchers(){
    fetch("https://ecoin-hosted.vercel.app/api/admin/vouchers")
        .then((res) => res.json())
        .then((data) => {
          vouchers.value = data.data;
        })
        .catch((err) => {
          console.error("Gagal ambil data voucher:", err);
        });
}

function deleteVoucherFromServer(id) {
    if (!confirm("Apakah kamu yakin ingin menghapus voucher ini?")) return;

    fetch(`https://ecoin-hosted.vercel.app/api/admin/vouchers/${id}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                alert("Voucher berhasil dihapus");
                fetchVouchers();
            } else {
                alert("Gagal menghapus voucher");
            }
        })
        .catch((err) => {
            console.error("Error saat menghapus:", err);
        });
}

function openUpdatePopup(voucher) {
    selectedVoucher.value = { ...voucher };
    popupUpdate.value = true;
}

async function updateVoucherOnServer() {
    if (!selectedVoucher.value) return;

    try {
        let imageUrl = selectedVoucher.value.image_url;

        // Upload new photo if selected
        if (selectedPhotoUpdate.value) {
            imageUrl = await uploadToCloudinary(selectedPhotoUpdate.value);
            selectedVoucher.value.image_url = imageUrl;
        }

        const response = await fetch(`https://ecoin-hosted.vercel.app/api/admin/vouchers/${selectedVoucher.value.id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(selectedVoucher.value),
        });

        const data = await response.json();

        if (data.success) {
            alert("Voucher berhasil diperbarui");
            popupUpdate.value = false;
            fetchVouchers();
            // Reset photo selection
            selectedPhotoUpdate.value = null;
            previewPhotoUpdate.value = null;
        } else {
            alert("Gagal update voucher");
        }
    } catch (err) {
        console.error("Update error:", err);
        alert("Terjadi kesalahan saat memperbarui voucher");
    }
}

async function submitNewVoucher() {
  // Validasi dasar
  if (!newVoucher.value.nama_voucher || !newVoucher.value.deskripsi || !newVoucher.value.nilai_koin) {
    alert("Mohon isi semua field wajib");
    return;
  }

  try {
    let imageUrl = newVoucher.value.image_url;

    // Upload photo if selected
    if (selectedPhoto.value) {
        imageUrl = await uploadToCloudinary(selectedPhoto.value);
    }

    const response = await fetch("https://ecoin-hosted.vercel.app/api/admin/vouchers", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        ...newVoucher.value,
        image_url: imageUrl,
        nilai_koin: parseInt(newVoucher.value.nilai_koin)
      })
    });

    const data = await response.json();

    if (data.success) {
      alert("Voucher berhasil ditambahkan");
      popupAdd.value = false;
      fetchVouchers();
      // Reset form
      newVoucher.value = {
        nama_voucher: '',
        deskripsi: '',
        nilai_koin: '',
        image_url: '',
        status: 'aktif'
      };
      // Reset photo selection
      selectedPhoto.value = null;
      previewPhoto.value = null;
    } else {
      console.error("Gagal tambah:", data);
      alert("Gagal menambahkan voucher");
    }
  } catch (err) {
    console.error("Error:", err);
    alert("Terjadi kesalahan saat menambahkan voucher");
  }
}

// Search and filter function
const searchKeyword = ref('');
const selectedStatus = ref('');

import { computed } from 'vue';

const filteredVouchers = computed(() => {
  return vouchers.value.filter(voucher => {
    const matchKeyword = voucher.nama_voucher.toLowerCase().includes(searchKeyword.value.toLowerCase());
    const matchStatus = selectedStatus.value === '' || voucher.status === selectedStatus.value;
    return matchKeyword && matchStatus;
  });
});

onMounted(() => {
    fetchVouchers();
})
</script>

<template>
    <div class="manajemen-voucher">
        <Navbar/>

        <section class="hero">
            <h1 class="title">Manajemen Voucher</h1>
        </section>

        <section class="filter-section">
            <input type="text" placeholder="Cari voucher" class="search-input" v-model="searchKeyword">
            <select class="filter-select" v-model="selectedStatus">
                <option value="">Semua status</option>
                <option value="aktif">Aktif</option>
                <option value="kadaluarsa">Kadaluarsa</option>
            </select>
            <button class="btn btn-add" @click="addVoucher()">Tambah Voucher</button>
        </section>

        <section class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Nilai Koin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="voucher in filteredVouchers" :key="voucher.id">
                        <td>
                            <img
                                :src="voucher.image_url || '/images/logo.png'"
                                alt="Gambar Voucher"
                                style="max-width: 60px; max-height: 60px; object-fit: cover;"
                            >
                        </td>
                        <td>{{ voucher.nama_voucher }}</td>
                        <td>{{ voucher.deskripsi }}</td>
                        <td>{{ voucher.nilai_koin }}</td>
                        <td><span :class="`status status-${voucher.status}`">{{ voucher.status }}</span></td>
                        <td>
                            <button class="btn btn-update" @click="openUpdatePopup(voucher)">Update</button>
                            <button class="btn btn-delete" @click="deleteVoucherFromServer(voucher.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Popup Tambah Voucher -->
        <div v-if="popupAdd" class="overlay">
            <div class="popup-form">
                <h1>Tambah Voucher</h1>
                <form @submit.prevent="submitNewVoucher">
                    <!-- Preview Gambar -->
                    <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                        <img
                            :src="previewPhoto || '/images/logo.png'"
                            alt="Preview Gambar"
                            style="width: 150px; height: 150px; object-fit: cover; border-radius: 4px;"
                        />
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <input
                            type="file"
                            id="photo"
                            accept="image/*"
                            @change="handlePhotoUpload"
                            style="display: none;"
                        />
                        <label for="photo" style="cursor: pointer; background: var(--primaryGreen); color: white; padding: 8px 16px; border-radius: 4px; display: flex; justify-content: center; align-items: center;">
                            Pilih Gambar
                        </label>
                    </div>

                    <label for="judul">Judul</label>
                    <input type="text" placeholder="Judul" v-model="newVoucher.nama_voucher" required><br>

                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" placeholder="Deskripsi" v-model="newVoucher.deskripsi" required><br>

                    <label for="nilai_koin">Nilai Koin</label>
                    <input type="number" placeholder="Nilai Koin" v-model="newVoucher.nilai_koin" required><br>

                    <label for="status">Status</label>
                    <select v-model="newVoucher.status" required>
                        <option value="aktif">Aktif</option>
                        <option value="kadaluarsa">Kadaluarsa</option>
                    </select><br>

                    <button type="submit" class="btn btn-update">Submit</button>
                    <button type="button" class="btn btn-back" @click="close">Kembali</button>
                </form>
            </div>
        </div>

        <!-- Popup Update Voucher -->
        <div v-if="popupUpdate" class="overlay">
            <div class="popup-form">
                <h1>Ubah Voucher</h1>
                <form @submit.prevent="updateVoucherOnServer">
                    <!-- Preview Gambar -->
                    <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                        <img
                            :src="previewPhotoUpdate || selectedVoucher?.image_url || '/images/logo.png'"
                            alt="Preview Gambar"
                            style="width: 150px; height: 150px; object-fit: cover; border-radius: 4px;"
                        />
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <input
                            type="file"
                            id="photoUpdate"
                            accept="image/*"
                            @change="handlePhotoUploadUpdate"
                            style="display: none;"
                        />
                        <label for="photoUpdate" style="cursor: pointer; background: var(--primaryGreen); color: white; padding: 8px 16px; border-radius: 4px; display: flex; justify-content: center; align-items: center;">
                            Pilih Gambar
                        </label>
                    </div>

                    <label for="judul">Judul</label>
                    <input type="text" id="judul" placeholder="Judul" v-model="selectedVoucher.nama_voucher" required><br><br>

                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" id="deskripsi" placeholder="Deskripsi" v-model="selectedVoucher.deskripsi" required><br><br>

                    <label for="nilai_koin">Nilai Koin</label>
                    <input type="number" id="nilai_koin" placeholder="Nilai Koin" v-model="selectedVoucher.nilai_koin" required><br><br>

                    <label for="status">Status</label>
                    <select id="status" v-model="selectedVoucher.status" required>
                        <option value="aktif">Aktif</option>
                        <option value="kadaluarsa">Kadaluarsa</option>
                    </select><br><br>

                    <button type="submit" class="btn btn-update">Ubah</button>
                    <button type="button" class="btn btn-back" @click="close">Kembali</button>
                </form>
            </div>
        </div>

        <Footer/>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap');

.manajemen-voucher {
    font-family: 'Poppins', sans-serif;
    background-color: var(--backgroundWhite);
    color: var(--textBlack);
}
.hero {
    background-color: var(--primaryGreen);
    height: 200px;
    display: flex;
    text-align: center;
    justify-content: center;
    align-items: center;
}
.title {
    color: var(--backgroundWhite);
    font-weight: bold;
    font-size: 32px;
}

.filter-section {
    display: flex;
    justify-content: space-between;
    margin-top: 16px;
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
    background-color: var(--backgroundWhite);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}
th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
th {
    background-color: var(--primaryGreen);
    color: var(--backgroundWhite);
    font-weight: 600;
}

.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 12px;
}
.status-aktif {
    background-color: green;
    color: white;
}
.status-kadaluarsa {
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
.btn-update {
    background-color: #27ae60;
    color: white;
}
.btn-delete {
    background-color: #c0392b;
    color: white;
}
.btn-add {
    background-color: var(--color-blue-500);
    color: white;
}
.btn-back {
    background-color: grey;
    color: white;
}


/* Popup Tambah Voucher */
.overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
}
.popup-form {
  background: white;
  padding: 20px;
  border-radius: 8px;
  min-width: 300px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.3);
  max-height: 600px;
  overflow-y: auto;
}
.popup-form input,
.popup-form select {
  width: 100%;
  padding: 6px 10px;
  margin: 5px 0 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.popup-form h1 {
    margin-bottom: 40px;
    font-size: larger;
    font-weight: 700;
}
</style>
