<script setup>
import { ref } from 'vue';
import Navbar from '../components/Navbar.vue';

const showPopup = ref(false)

function openDetail(){
    showPopup.value = true
}
</script>

<template>
    <div class="manajemen-user">
        <Navbar/>

        <section class="hero">
            <h1 class="title">Manajemen User</h1>
        </section>

        <section class="content">
            <div class="card">
                <div class="profil">
                    <div class="kiri">
                        <img src="/public/images/logo.png" alt="" width="100px">
                    </div>
                    <div class="kanan">
                        <h1>Username</h1>
                        <button class="btn-main" @click="openDetail">Detail</button>
                    </div>
                    <div v-if="showPopup" @click.self="showPopup = false" class="popup">
                        <div class="popup-card">
                            <div class="kiri-konten">
                                <div class="kiri">
                                    <img src="/public/images/logo.png" alt="" width="500px">
                                </div>
                                <div class="kanan">
                                    <h1>Username</h1>
                                    <h1>Email</h1>
                                    <h1>Status</h1>
                                    <h1>Saldo</h1>
                                    <h1>Facebook</h1>
                                    <h1>Twitter</h1>
                                </div>
                            </div>
                            <div class="kanan">
                                <h1>Transaksi Terkini</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-container">
                    <button class="btn-main">Aktif</button>
                    <button class="btn-delete">Delete</button>
                </div>
            </div>
        </section>
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

    /* Content */
    .content{
        padding: 40px 5%;
    }
    .card{
        background-color: var(--textField);
        padding: 20px;
        border-radius: 10px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .kiri-konten{
        display: flex;
        flex-direction: row;
    }

    /* Detail Popup */
    .popup{
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5); /* background gelap transparan */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .popup div {
        background-color: white;
        padding: 24px;
        border-radius: 8px;
        max-width: 100%;
        width: 90%;
    }
    .popup-card{
        background-color: var(--textField);
        padding: 20px;
        border-radius: 10px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    /* Profil */
    .profil{
        display: flex;
    }
    .profil h1{
        font-size: 20px;
        font-weight: 600;
    }

    /* btn-container */
    .btn-container{
        display: flex;
        flex-direction: row;
        margin-right: 28px;
    }

    /* Buttons */
    .btn-main{
        padding: 8px 20px;
        background-color: var(--primaryGreen);
        color: var(--backgroundWhite);
        border: 2px solid transparent;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-main:hover {
        border: 2px solid var(--primaryGreen);
        background-color: var(--accentGreen2);
        color: var(--primaryGreen);
        transition-duration: 0.3s;
    }
    .btn-delete{
        padding: 8px 20px;
        background-color: var(--accentRed);
        color: var(--backgroundWhite);
        border: 2px solid transparent;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-delete:hover{
        border: 2px solid var(--accentRed);
        background-color: var(--accentGreen2);
        color: var(--accentRed);
        transition-duration: 0.3s;
    }

</style>
