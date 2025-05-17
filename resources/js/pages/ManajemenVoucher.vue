<script setup>
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';
import { ref } from 'vue';

const popupAdd = ref(false);
const popupUpdate = ref(false);

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
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data statis -->
                    <tr>
                        <td><img src="/public/images/logo.png" alt="Logo Voucher" width="100px"></td>
                        <td>Voucher satu</td>
                        <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</td>
                        <td>Rp. 350.000</td>
                        <td><span class="status status-active">Aktif</span></td>
                        <td>
                            <button class="btn btn-update" @click="updateVoucher()">Update</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                    <!-- Tambah sesuai kebutuhan -->
                </tbody>
            </table>
        </section>

        <div v-if="popupAdd" class="overlay">
            <div class="popup-form">
                <h1>Tambah Voucher</h1>
                <form action="">
                    <label for="gambar">Gambar</label><br>
                    <input type="text" placeholder="Link Gambar"><br>
                    <label for="judul">Judul</label><br>
                    <input type="text" placeholder="Judul"><br>
                    <label for="deskripsi">Deskripsi</label><br>
                    <input type="text" placeholder="Deskripsi"><br>
                    <label for="harga">Harga</label><br>
                    <input type="text" placeholder="Harga"><br>
                    <label for="status">Status</label><br>
                    <select id="status" name="status">
                        <option value="aktif">Aktif</option>
                        <option value="expired">Kadaluarsa</option>
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
                    <label for="gambar">Gambar</label><br>
                    <input type="text" placeholder="Link Gambar"><br>
                    <label for="judul">Judul</label><br>
                    <input type="text" placeholder="Judul"><br>
                    <label for="deskripsi">Deskripsi</label><br>
                    <input type="text" placeholder="Deskripsi"><br>
                    <label for="harga">Harga</label><br>
                    <input type="text" placeholder="Harga"><br>
                    <label for="status">Status</label><br>
                    <select id="status" name="status">
                        <option value="aktif">Aktif</option>
                        <option value="expired">Kadaluarsa</option>
                    </select><br>
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
.status-active {
    background-color: green;
    color: white;
}
.status-expired {
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
