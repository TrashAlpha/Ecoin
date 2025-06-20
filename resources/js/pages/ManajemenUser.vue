<script setup>
import { onMounted, ref } from 'vue';
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';

const updateUserPopup = ref(false)
const users = ref([])
const selectedUser = ref(null)

function updateUser(user){
    selectedUser.value = { ...user } // clone data user
    updateUserPopup.value = true
}

function close(){
    updateUserPopup.value = false
}

function fetchUsers(){
    fetch("https://ecoin-hosted.vercel.app/api/admin/users")
    .then((res) => res.json())
    .then((data) => {
        users.value = data.data; // <- Ambil dari properti "data"
    })
    .catch((err) => {
        console.error("Gagal ambil data user: ", err);
    })
}

function submitUpdateUser() {
    const konfirmasi = window.confirm("Apakah Anda yakin ingin mengupdate data user?");
    if (!konfirmasi) return;

    const id = selectedUser.value.id;

    // Update status
    fetch(`https://ecoin-hosted.vercel.app/api/admin/users/${id}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ status: selectedUser.value.status })
    })
    .then(res => res.json())
    .then(data => {
        console.log('Status updated', data);
        fetchUsers();
    });

    // Update koin
    fetch(`https://ecoin-hosted.vercel.app/api/admin/users/${id}/coins`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ saldo_koin: selectedUser.value.saldo_koin })
    })
    .then(res => res.json())
    .then(data => {
        console.log('Saldo updated', data);
        fetchUsers();
        close();
    })
    .catch(err => {
        console.error("Gagal update user: ", err);
    });
}

// Search and filter function
const searchQuery = ref('');
const selectedStatus = ref('');

import { computed } from 'vue';

const filteredUsers = computed(() => {
    return users.value
        .filter(user => {
            const matchesSearch = user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                                  user.email.toLowerCase().includes(searchQuery.value.toLowerCase());
            const matchesStatus = selectedStatus.value === '' || user.status === selectedStatus.value;
            return matchesSearch && matchesStatus;
        })
        
        .sort((a, b) => a.name.localeCompare(b.name));
});



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
            <input type="text" placeholder="Cari pengguna" class="search-input" v-model="searchQuery">
            <select class="filter-select" v-model="selectedStatus">
                <option value="">Semua status</option>
                <option value="active">Aktif</option>
                <option value="banned">Banned</option>
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
                    <tr v-for="user in filteredUsers" :key="user.id">
                        <td><img :src="user?.photo_profile_url || '/images/user-icon.png'" alt="Logo Voucher" style="max-width: 60px; max-height: 60px; object-fit: cover;"></td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.saldo_koin}}</td>
                        <td>{{user.akun_facebook}}</td>
                        <td>{{user.akun_twitter}}</td>
                        <td><span :class="`status status-${user.status}`">{{user.status}}</span></td>
                        <td>
                            <!-- TODO Update dan delete belum bisa -->
                            <button class="btn btn-update" @click="updateUser(user)">Update</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- TODO Popup masih belum benar -->
        <div v-if="updateUserPopup" class="overlay">
            <div class="popup-form">
                <h1>Edit User {{ selectedUser.name }}</h1>
                <form action="">
                    <label for="saldo">Saldo</label><br>
                    <input type="number" v-model="selectedUser.saldo_koin"><br>

                    <select v-model="selectedUser.status">
                        <option value="active">Aktif</option>
                        <option value="banned">Banned</option>
                    </select>
                    <button type="button" class="btn btn-update" @click="submitUpdateUser">Submit</button>
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
.status-banned {
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
