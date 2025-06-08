<p align="center"><img src="public/images/logo_ecoinwhite.png" alt="Logo Ecoin" width="300"></p>

## Tentang Ecoin

Ecoin merupakan aplikasi yang bertujuan sebagai wadah pertukaran sampah antara pengepul dan masyarakat. Dimana sampah tersebut akan ditukarkan menjadi koin dan koin dapat ditukarkan dengan berbagai pilihan kupon seperti saldo e-wallet, potongan pembelanjaan, dan lainnya. Aplikasi ini bertujuan untuk mengurangi dampak lingkungan dari sampah yang dihasilkan. Dengan adanya aplikasi ini sampah yang khususnya plastik akan jauh lebih berkurang penggunaannya karena akan diolah kembali.

## Fitur

Fitur dari Ecoin dari sisi User adalah sebagai berikut:

* Beranda
* Tukar sampah
* Tukar voucher
* tukar koin
* aritkel
* quiz
* daftar transaksi
* voucher anda

Sedangan fitur Ecoin untuk admin adalah sebagai berikut:

* Manajemen User
* Manajemen Voucher
* Verifikasi Penukaran
* Buat Kuis

## Alat Pengembangan Sistem

<a href="https://vuejs.org/">
    <img src="https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D">
</a>
<a href="https://laravel.com/">
    <img src="https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white">
</a>
<a href="https://www.mysql.com/">
    <img src="https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white">
</a>
<a href="https://www.figma.com/">
    <img src="https://img.shields.io/badge/figma-%23F24E1E.svg?style=for-the-badge&logo=figma&logoColor=white">
</a>

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
