<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | Ecoin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    @include('partials.header') <!-- jika header.blade.php sudah ada -->

    <main class="main-content">
        <h1>Selamat Datang di ECOIN</h1>
        <p>Mari jadikan sampah sebagai kebaikan yang bernilai.</p>
    </main>

    @include('partials.footer')

</body>
</html>
