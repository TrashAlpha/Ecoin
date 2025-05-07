<script setup>
import Navbar from '../components/Navbar.vue'
import Footer from '../components/Footer.vue'

</script>

<template>
    <div class="profil">
        <Navbar/>

        <section class="profil-isi">
            <div class="sisi-kiri">
                <h1>Pengguna</h1>
                <h3>pengguna@contoh.com</h3>
                <h3>tentang pengguna</h3>
                <button>tentang pengguna</button>
            </div>
            <div class="sisi-kanan">
                <h1>Profil</h1>
                <h3>Nama</h3>
                <input type="text" name="" id="">
                <h3>Email</h3>
                <input type="text" name="" id="">
                <h3>Email</h3>
                <input type="text" name="" id="">
                <h3>Email</h3>
                <input type="text" name="" id="">
                <h3>Email</h3>
                <input type="text" name="" id="">
            </div>
        </section>

    </div>
</template>

<style scoped>

.profil{
    font-family: var(--fontFamily);
    background-color: var(--backgroundWhite);
    color: var(--textBlack);
}

.profil-isi{
    height: 100%;
    background-color: aqua;
}

.sisi-kanan{
    background-color: var(--primaryGreen);

}

</style>
