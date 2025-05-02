<script setup lang="ts">
import Footer from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';

</script>

<template>
    <div class="beranda">
        <Navbar/>
        <section>
            <div class="relative w-full">
                <div class="flex items-center justify-center">
                    <img src="/public/images/hero.png" alt="Anak menukar sampah" class="object-cover" />
                </div>
                <div class="absolute top-1/4 left-6 max-w-xs bg-emerald-900 p-6 text-white shadow-lg md:left-16 md:p-8">
                    <h2 class="mb-2 text-2xl font-bold">Ayo Tukarkan Sampahmu</h2>
                    <p class="text-base">Jadikan lingkungan lebih bersih dengan cara menukar sampah kembali</p>
                </div>
            </div>
            <div class="mt-24 px-10">
                <div class="mb-16 flex items-center gap-4">
                    <hr class="h-1 w-24 bg-[#006662]" />
                    <h1 class="text-3xl font-semibold text-[#006662]">
                        Fitur Unggulan Yang<br />
                        Tawarkan
                    </h1>
                </div>
                <div class="flex flex-wrap justify-between">
                    <FeatureItem :icon="'/images/phone.png'" title="Mudah Cepat" description="Proses penukaran yang mudah dipelajari dan dipahami" />
                    <FeatureItem
                        :icon="'/images/calculator.png'"
                        title="Atur Jadwal"
                        description="Penukaran dapat disesuaikan berdasarkan tanggal dan waktu"
                    />
                    <FeatureItem :icon="'/images/paper.png'" title="Mudah Cepat" description="Banyak informasi mengenai sampah dan manfaatnya" />
                </div>
            </div>
            <div class="flex items-center gap-10 px-10 pt-24">
                <img src="/public/images/image.png" alt="" />
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <h1 class="text-3xl font-semibold text-[#006662]">Tentang Kami<br />ECOIN Merupakan</h1>
                        <hr class="h-1 w-24 bg-[#006662]" />
                    </div>
                    <p>
                        Ecoin merupakan aplikasi yang bertujuan sebagai wadah pertukaran sampah antara pengepul dan masyrakat. Dimana sampah tersebut akan
                        ditukarkan menjadi koin dan koin dapat ditukarkan dengan berbagai pilihan kupon seperti saldo e-wallet, potongan pembelanjaan, dan
                        lainnya. Aplikasi ini bertujuan untuk mengurangi dampak lingkungan dari sampah yang dihasilkan. Dengan adanya aplikasi ini sampah
                        yang khusunya plastik akan jauh lebih berkurang penggunaannya karena akan diolah Kembali
                    </p>
                    <img src="/public/images/app.png" alt="" class="size-fit" />
                </div>
            </div>
            <div class="flex flex-col items-center justify-center gap-4 pt-24">
                <h1 class="text-center text-3xl font-semibold text-[#006662]">Cara Menukarkan<br />untuk mendapatkan poin</h1>
                <div class="flex flex-col justify-between gap-8 p-4 md:flex-row">
                    <StepCard
                        :step="1"
                        title="Buat Akun"
                        description="Langkah Pertama, buat akun untuk bisa login dan bertransaksi"
                        linkText="Registrasi Akun"
                        linkHref="#"
                    />
                    <StepCard
                        :step="2"
                        title="Tukar Sampah"
                        description="Langkah Kedua, pilih sampah dan tukarkan sesuai langkah-langkah"
                        linkText="Penukaran Sampah"
                        linkHref="#"
                    />
                    <StepCard
                        :step="3"
                        title="Tukar koin"
                        description="Langkah Ketiga, dapatkan koin lalu tukar koin dengan kupon"
                        linkText="Dapatkan Kupon"
                        linkHref="#"
                    />
                </div>
            </div>
            <div class="flex flex-col items-center justify-center pt-9">
                <iframe
                    width="560"
                    height="315"
                    src="https://www.youtube.com/embed/pnuiEGuThsI"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                >
                </iframe>
                <div class="h-6 w-96 bg-teal-800"></div>
            </div>
            <div class="mb-16 flex items-center gap-4">
                <hr class="h-1 w-24 bg-[#006662]" />
                <h1 class="text-3xl font-semibold text-[#006662]">
                    Fitur Unggulan Yang di<br />
                    Tawarkan
                </h1>
            </div>
        </section>
        <Footer/>
    </div>
</template>
