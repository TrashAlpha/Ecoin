<script setup>
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';
import { onMounted, ref } from 'vue';

const popupAdd = ref(false);
const popupUpdate = ref(false);
const vouchers = ref([]);
const selectedVoucher = ref(null); // voucher yang sedang diedit
const newVoucher = ref({
  nama_voucher: '',
  deskripsi: '',
  nilai_koin: '',
  image_url: '',
  status: 'aktif'
});

function addVoucher(){
    popupAdd.value = true;
}

function updateVoucher(){
    popupUpdate.value = true;
}

function close(){
    if (popupAdd.value == true) {
        popupAdd.value = false;
    } else {
        popupUpdate.value = false;
    }
}

function fetchVouchers(){
    fetch("http://localhost:8000/api/admin/vouchers")
        .then((res) => res.json())
        .then((data) => {
          vouchers.value = data.data; // Ambil dari properti "data"
        })
        .catch((err) => {
          console.error("Gagal ambil data voucher:", err);
        });
}

function deleteVoucherFromServer(id) {
    if (!confirm("Apakah kamu yakin ingin menghapus voucher ini?")) return;

    fetch(`http://localhost:8000/api/admin/vouchers/${id}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                alert("Voucher berhasil dihapus");
                fetchVouchers(); // refresh daftar
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

function updateVoucherOnServer() {
    if (!selectedVoucher.value) return;

    fetch(`http://localhost:8000/api/admin/vouchers/${selectedVoucher.value.id}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(selectedVoucher.value),
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                alert("Voucher berhasil diperbarui");
                popupUpdate.value = false;
                fetchVouchers();
            } else {
                alert("Gagal update voucher");
            }
        })
        .catch((err) => {
            console.error("Update error:", err);
        });
}

function submitNewVoucher() {
  // Validasi dasar
  if (!newVoucher.value.nama_voucher || !newVoucher.value.deskripsi || !newVoucher.value.nilai_koin) {
    alert("Mohon isi semua field wajib");
    return;
  }

  fetch("http://localhost:8000/api/admin/vouchers", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      ...newVoucher.value,
      nilai_koin: parseInt(newVoucher.value.nilai_koin)
    })
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("Voucher berhasil ditambahkan");
        popupAdd.value = false;
        fetchVouchers();
        newVoucher.value = {
          nama_voucher: '',
          deskripsi: '',
          nilai_koin: '',
          image_url: '',
          status: 'aktif'
        };
      } else {
        console.error("Gagal tambah:", data);
        alert("Gagal menambahkan voucher");
      }
    })
    .catch((err) => {
      console.error("Error:", err);
      alert("Terjadi kesalahan saat menambahkan voucher");
    });
}

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
            <input type="text" placeholder="Cari voucher" class="search-input">
            <select name="" id="" class="filter-select">
                <option value="">Semua status</option>
                <option value="active">Aktif</option>
                <option value="expired">Kadaluarsa</option>
            </select>
            <button class="btn btn-add" @click="addVoucher()">Tambah Voucher</button>
            <!-- TODO Popup tambah voucher, isinya form -->
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
                    <tr v-for="voucher in vouchers" :key="voucher.id">
                        <td><img src="/public/images/logo.png" alt="Logo Voucher" width="100px"></td>
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

        <div v-if="popupAdd" class="overlay">
            <div class="popup-form">
                <h1>Tambah Voucher</h1>
                <form @submit.prevent="submitNewVoucher">
                    <label for="gambar">Gambar</label><br>
                    <input type="text" placeholder="Link Gambar" v-model="newVoucher.image_url"><br>
                    <label for="judul">Judul</label><br>
                    <input type="text" placeholder="Judul" v-model="newVoucher.nama_voucher"><br>
                    <label for="deskripsi">Deskripsi</label><br>
                    <input type="text" placeholder="Deskripsi" v-model="newVoucher.deskripsi"><br>
                    <label for="nilai_koin">Nilai Koin</label><br>
                    <input type="text" placeholder="Nilai Koin" v-model="newVoucher.nilai_koin"><br>
                    <label for="status">Status</label><br>
                    <select v-model="newVoucher.status">
                        <option value="aktif">Aktif</option>
                        <option value="kadaluarsa">Kadaluarsa</option>
                    </select><br>
                    <button type="submit" class="btn btn-update">Submit</button>
                    <button type="button" class="btn btn-back" @click="close">Kembali</button>
                </form>
            </div>
        </div>

        <div v-if="popupUpdate" class="overlay">
            <div class="popup-form">
                <h1>Ubah Voucher</h1>
                <form action="">
                    <label for="judul">Judul</label><br>
                    <input type="text" id="judul" placeholder="Judul" v-model="selectedVoucher.nama_voucher"><br><br>

                    <label for="deskripsi">Deskripsi</label><br>
                    <input type="text" id="deskripsi" placeholder="Deskripsi" v-model="selectedVoucher.deskripsi"><br><br>

                    <label for="nilai_koin">Nilai Koin</label><br>
                    <input type="text" id="nilai_koin" placeholder="Nilai Koin" v-model="selectedVoucher.nilai_koin"><br><br>

                    <label for="image_url">Link Gambar</label><br>
                    <input type="text" id="image_url" placeholder="Link Gambar" v-model="selectedVoucher.image_url"><br><br>

                    <label for="status">Status</label><br>
                    <select id="status" v-model="selectedVoucher.status">
                        <option value="aktif">Aktif</option>
                        <option value="kadaluarsa">Kadaluarsa</option>
                    </select><br><br>

                    <button type="button" class="btn btn-update" @click="updateVoucherOnServer">Ubah</button>
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
