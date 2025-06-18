<h1 align="center"><img src="public/images/logo_ecoinwhite.png" alt="Logo Ecoin" width="300"></h1>

## Daftar isi

- [Daftar isi](#daftar-isi)
- [Tentang Ecoin](#tentang-ecoin)
- [Fitur](#fitur)
- [Alat Pengembangan Sistem](#alat-pengembangan-sistem)
  - [🖥️ Frontend](#️-frontend)
  - [🛠️ Backend](#️-backend)
  - [🗄️ Database](#️-database)
  - [🧩 Lainnya](#-lainnya)
- [Struktur Proyek](#struktur-proyek)
- [Kontribusi](#kontribusi)
- [Kontributor](#kontributor)

## Tentang Ecoin

<p align="justify">
Ecoin merupakan aplikasi yang bertujuan sebagai wadah pertukaran sampah antara pengepul dan masyarakat. Dimana sampah tersebut akan ditukarkan menjadi koin dan koin dapat ditukarkan dengan berbagai pilihan kupon seperti saldo e-wallet, potongan pembelanjaan, dan lainnya. Aplikasi ini bertujuan untuk mengurangi dampak lingkungan dari sampah yang dihasilkan. Dengan adanya aplikasi ini sampah yang khususnya plastik akan jauh lebih berkurang penggunaannya karena akan diolah kembali.
</p>

## Fitur

Fitur dari Ecoin dari sisi User adalah sebagai berikut:

- Beranda
- Tukar Sampah
- Tukar Voucher
- Tukar Koin
- Aritkel
- Quiz
- Daftar Transaksi
- Voucher anda

Sedangan fitur Ecoin untuk admin adalah sebagai berikut:

- Manajemen User
- Manajemen Voucher
- Verifikasi Penukaran
- Buat Kuis

## Alat Pengembangan Sistem

### 🖥️ Frontend

![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D)

### 🛠️ Backend

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

### 🗄️ Database

![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)

### 🧩 Lainnya

![Figma](https://img.shields.io/badge/figma-%23F24E1E.svg?style=for-the-badge&logo=figma&logoColor=white)
![Vercel](https://img.shields.io/badge/vercel-%23000000.svg?style=for-the-badge&logo=vercel&logoColor=white)

## Struktur Proyek

```txt
 🌐Ecoin
 ┣ 📦app
 ┃ ┣ 📂Http
 ┃ ┃ ┣ 📂Controllers
 ┃ ┃ ┃ ┣ 📜AdminPageController.php
 ┃ ┃ ┃ ┣ 📜ArtikelController.php
 ┃ ┃ ┃ ┣ 📜AuthController.php
 ┃ ┃ ┃ ┣ 📜Controller.php
 ┃ ┃ ┃ ┣ 📜PageController.php
 ┃ ┃ ┃ ┣ 📜PenukaranKoinController.php
 ┃ ┃ ┃ ┣ 📜PenukaranSampahController.php
 ┃ ┃ ┃ ┣ 📜ProfileController.php
 ┃ ┃ ┃ ┗ 📜SampahController.php
 ┃ ┃ ┗ 📂Middleware
 ┃ ┃ ┃ ┣ 📜AdminMiddleware.php
 ┃ ┃ ┃ ┣ 📜CheckBanned.php
 ┃ ┃ ┃ ┗ 📜CorsMiddleware.php
 ┃ ┣ 📂Models
 ┃ ┃ ┣ 📜Artikel.php
 ┃ ┃ ┣ 📜Log_Transaksi.php
 ┃ ┃ ┣ 📜Penukaran_Koin.php
 ┃ ┃ ┣ 📜Penukaran_Sampah.php
 ┃ ┃ ┣ 📜Produk.php
 ┃ ┃ ┣ 📜Quiz.php
 ┃ ┃ ┣ 📜Sampah.php
 ┃ ┃ ┣ 📜User.php
 ┃ ┃ ┣ 📜UserQuizRewards.php
 ┃ ┃ ┣ 📜UserVoucher.php
 ┃ ┃ ┗ 📜Voucher.php
 ┃ ┗ 📂Providers
 ┃ ┃ ┗ 📜AppServiceProvider.php
 ┣📦bootstrap
 ┣📦config
 ┣📦database
 ┃ ┣ 📂factories
 ┃ ┃ ┗ 📜UserFactory.php
 ┃ ┣ 📂migrations
 ┃ ┃ ┣ 📜0001_01_01_000000_create_users_table.php
 ┃ ┃ ┣ 📜0001_01_01_000001_create_cache_table.php
 ┃ ┃ ┣ 📜0001_01_01_000002_create_jobs_table.php
 ┃ ┃ ┣ 📜2025_05_04_124103_create_personal_access_tokens_table.php
 ┃ ┃ ┣ 📜2025_05_17_132438_create_penukaran__sampahs_table.php
 ┃ ┃ ┣ 📜2025_05_17_132503_create_vouchers_table.php
 ┃ ┃ ┣ 📜2025_05_17_132822_create_penukaran__koins_table.php
 ┃ ┃ ┣ 📜2025_05_17_144357_create_log__transaksis_table.php
 ┃ ┃ ┣ 📜2025_06_02_034014_create_sampah_table.php
 ┃ ┃ ┣ 📜2025_06_02_162314_create_user_vouchers_table.php
 ┃ ┃ ┣ 📜2025_06_02_162534_create_artikel_table.php
 ┃ ┃ ┣ 📜2025_06_02_162913_create_quiz_table.php
 ┃ ┃ ┣ 📜2025_06_02_163027_create_produk_table.php
 ┃ ┃ ┗ 📜2025_06_06_094354_create_user_quiz_rewards_table.php
 ┃ ┣ 📂seeders
 ┃ ┃ ┣ 📜ArtikelSeeder.php
 ┃ ┃ ┣ 📜DatabaseSeeder.php
 ┃ ┃ ┣ 📜ProdukSeeder.php
 ┃ ┃ ┣ 📜SampahSeeder.php
 ┃ ┃ ┗ 📜VoucherSeeder.php
 ┃ ┗ 📜.gitignore
 ┣📦public
 ┃ ┣ 📂images
 ┃ ┃ ┣ 📜alfamart.png
 ┃ ┃ ┣ …
 ┃ ┣ 📜.htaccess
 ┃ ┣ 📜favicon.ico
 ┃ ┣ 📜hot
 ┃ ┣ 📜index.php
 ┃ ┗ 📜robots.txt
 ┣📦resources
 ┃ ┣ 📂css
 ┃ ┃ ┣ 📜app.css
 ┃ ┃ ┗ 📜style.css
 ┃ ┣ 📂js
 ┃ ┃ ┣ 📂components
 ┃ ┃ ┃ ┣ 📜FeatureItem.vue
 ┃ ┃ ┃ ┣ 📜Footer.vue
 ┃ ┃ ┃ ┣ 📜KonfirmasiPenukaran.vue
 ┃ ┃ ┃ ┣ 📜Navbar.vue
 ┃ ┃ ┃ ┣ 📜RedeemMoneyModal.vue
 ┃ ┃ ┃ ┣ 📜RedeemVoucherModal.vue
 ┃ ┃ ┃ ┣ 📜StepCard.vue
 ┃ ┃ ┃ ┗ 📜VoucherCard.vue
 ┃ ┃ ┣ 📂config
 ┃ ┃ ┃ ┗ 📜theme.js
 ┃ ┃ ┣ 📂interfaces
 ┃ ┃ ┣ 📂pages
 ┃ ┃ ┃ ┣ 📜Artikel.vue
 ┃ ┃ ┃ ┣ 📜Beranda.vue
 ┃ ┃ ┃ ┣ 📜DaftarTransaksi.vue
 ┃ ┃ ┃ ┣ 📜Jelajah.vue
 ┃ ┃ ┃ ┣ 📜Login.vue
 ┃ ┃ ┃ ┣ 📜ManajemenUser.vue
 ┃ ┃ ┃ ┣ 📜ManajemenVoucher.vue
 ┃ ┃ ┃ ┣ 📜PenukaranKoin.vue
 ┃ ┃ ┃ ┣ 📜penukaranstep1.vue
 ┃ ┃ ┃ ┣ 📜PenukaranStep2.vue
 ┃ ┃ ┃ ┣ 📜PenukaranStep3.vue
 ┃ ┃ ┃ ┣ 📜PenukaranStep3_2.vue
 ┃ ┃ ┃ ┣ 📜Profil.vue
 ┃ ┃ ┃ ┣ 📜Register.vue
 ┃ ┃ ┃ ┣ 📜Tentang.vue
 ┃ ┃ ┃ ┣ 📜VerifikasiPenukaran.vue
 ┃ ┃ ┃ ┗ 📜VoucherAnda.vue
 ┃ ┃ ┣ 📜app.js
 ┃ ┃ ┗ 📜bootstrap.js
 ┃ ┗ 📂views
 ┃ ┃ ┣ 📜artikel.blade.php
 ┃ ┃ ┣ 📜beranda.blade.php
 ┃ ┃ ┣ 📜daftartransaksi.blade.php
 ┃ ┃ ┣ 📜jelajah.blade.php
 ┃ ┃ ┣ 📜login.blade.php
 ┃ ┃ ┣ 📜manajemen_user.blade.php
 ┃ ┃ ┣ 📜manajemen_voucher.blade.php
 ┃ ┃ ┣ 📜master.blade.php
 ┃ ┃ ┣ 📜penukarankoin.blade.php
 ┃ ┃ ┣ 📜penukarans1.blade.php
 ┃ ┃ ┣ 📜penukarans2.blade.php
 ┃ ┃ ┣ 📜penukarans3.blade.php
 ┃ ┃ ┣ 📜penukarans3_2.blade.php
 ┃ ┃ ┣ 📜profil.blade.php
 ┃ ┃ ┣ 📜register.blade.php
 ┃ ┃ ┣ 📜tentang.blade.php
 ┃ ┃ ┣ 📜verifikasi_penukaran.blade.php
 ┃ ┃ ┣ 📜voucher_anda.blade.php
 ┃ ┃ ┗ 📜welcome.blade.php
 ┣📦routes
 ┃ ┣ 📜api.php
 ┃ ┣ 📜console.php
 ┃ ┗ 📜web.php
 ┣📦storage
 ┣📦tests
 ┣📜README.md
 ┣📜 artisan
 ┣📜 composer.json
 ┣📜 composer.lock
 ┣📜 package-lock.json
 ┣📜 package.json
 ┣📜 phpunit.xml
 ┣📜 vite.config.js
```

## Kontribusi

Anda dapat melakukan kontribusi dengan melakukan fork ataupun clone project ini ke device anda. Setelah itu lakukan beberapa hal berikut:

1. Lakukan instalasi modul dan dependensi Laravel serta Node.js

    ```sh
    composer install
    ```

    ```sh
    npm install
    ```

2. Buat file .env baru dan isi API_KEY

    ```.env
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY= ...
    APP_DEBUG=true
    APP_URL=http://localhost
    ```

3. Lakukan migrasi database

    ```sh
    php artisan migrate:fresh --seed
    ```

4. Jalankan proyeknya

    ```sh
    php artisan serve
    npm run dev
    ```

    atau gunakan

    ```sh
    php -S localhost:8000 -t public
    npm run dev
    ```

## Kontributor

<a href="https://github.com/TrashAlpha/Ecoin/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=TrashAlpha/Ecoin" alt="contrib.rocks image" />
</a>
