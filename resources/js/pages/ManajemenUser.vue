<script setup>
import Navbar from '../components/Navbar.vue';

</script>

<template>
    <div class="manajemen-user">
        <Navbar/>

        <section class="hero">
            <h1 class="title">Manajemen User</h1>
        </section>

        <section class="content">
            <div class="card">
                <img src="/public/images/logo.png" alt="" width="100px">
                <h1>Nama Pengguna</h1>

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
    }

</style>
