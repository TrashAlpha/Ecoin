<script setup>
import { onMounted, ref } from 'vue';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

const updateUserPopup = ref(false)
const users = ref([])

function updateUser(){
    updateUserPopup.value = true
}

function close(){
    updateUserPopup.value = false
}

function fetchUsers(){
    fetch("http://localhost:8000/api/users")
    .then((res) => res.json())
    .then((data) => {
        users.value = data;
    })
    .catch((err) => {
        console.error("Gagal ambil data user: ", err);
    })
}

onMounted(() => {
    fetchUsers();
})
</script>

<template>
    <div class="manajemen-user">
        <Navbar/>

        <section class="hero">
            <h1 class="title">Manajemen User</h1>
        </section>

        <section class="filter-section">
            <input type="text" placeholder="Cari pengguna" class="search-input">
            <select name="" id="" class="filter-select">
                <option value="">Semua status</option>
                <option value="active">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </section>

        <section class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Saldo</th>
                        <th>Facebook</th>
                        <th>Twitter</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td><img src="/public/images/logo.png" alt="Logo Voucher" width="100px"></td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.saldo_koin}}</td>
                        <td>{{user.akun_facebook}}</td>
                        <td>{{user.akun_twitter}}</td>
                        <td><span :class="`status status-${user.status}`">{{user.status}}</span></td>
                        <td>
                            <!-- TODO Update dan delete belum bisa -->
                            <button class="btn btn-update" @click="updateUser">Update</button>
                            <button class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- TODO Popup masih belum benar -->
        <div v-if="updateUserPopup" class="overlay">
            <div class="popup-form">
                <h1>Edit User</h1>
                <form action="">
                    <label for="gambar">Gambar</label><br>
                    <input type="text" placeholder="Link Gambar" disabled><br>
                    <label for="username">Username</label><br>
                    <input type="text" placeholder="username" disabled><br>
                    <label for="email">Email</label><br>
                    <input type="text" placeholder="email" disabled><br>
                    <label for="saldo">Saldo</label><br>
                    <input type="text" placeholder="saldo" disabled><br>
                    <label for="facebook">Facebook</label><br>
                    <input type="text" placeholder="facebook" disabled><br>
                    <label for="twitter">Twitter</label><br>
                    <input type="text" placeholder="twitter" disabled><br>
                    <label for="status">Status</label><br>
                    <select id="status" name="status">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select><br>
                    <button type="submit" class="btn btn-update">Submit</button>
                    <button type="button" class="btn btn-back" @click="close">Kembali</button>
                </form>
            </div>
        </div>

        <Footer/>
    </div>
</template>

<style scoped>

.manajemen-user{
    font-family: var(--fontFamily);
    background-color: var(--backgroundWhite);
    color: var(--textBlack);
}
.hero{
    background-color: var(--primaryGreen);
    height: 200px;
    display: flex;
    text-align: center;
    justify-content: center;
    align-items: center;
}
.title{
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
