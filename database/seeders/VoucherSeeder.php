<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voucherData = [
            [
                'nama_voucher' => 'Voucher Belanja Rp10.000 - Alfamart',
                'nilai_koin' => 10,
                'deskripsi' => 'Tukarkan koin Anda dengan voucher belanja senilai Rp10.000 di gerai Alfamart.',
                'status' => 'aktif',
            ],
            [
                'nama_voucher' => 'Diskon 50% - GrabFood',
                'nilai_koin' => 120,
                'deskripsi' => 'Nikmati diskon 50% untuk pemesanan makanan melalui GrabFood.',
                'status' => 'aktif',
            ],
            [
                'nama_voucher' => 'Voucher Pulsa Rp50.000',
                'nilai_koin' => 40,
                'deskripsi' => 'Tukarkan koin untuk mendapatkan pulsa prabayar senilai Rp5.000.',
                'status' => 'aktif',
            ],
            [
                'nama_voucher' => 'Voucher OVO Rp15.000',
                'nilai_koin' => 14,
                'deskripsi' => 'Dapatkan saldo OVO senilai Rp15.000 untuk transaksi digital Anda.',
                'status' => 'aktif',
            ],
            [
                'nama_voucher' => 'Gratis Ongkir - Tokopedia',
                'nilai_koin' => 15,
                'deskripsi' => 'Voucher bebas ongkir untuk belanja di Tokopedia hingga Rp20.000.',
                'status' => 'aktif',
            ],
            [
                'nama_voucher' => 'Voucher Kopi Gratis - Kopi Kenangan',
                'nilai_koin' => 11,
                'deskripsi' => 'Dapatkan 1 kopi gratis ukuran reguler di gerai Kopi Kenangan.',
                'status' => 'aktif',
            ],
            [
                'nama_voucher' => 'Diskon Rp25.000 - Gojek',
                'nilai_koin' => 20,
                'deskripsi' => 'Potongan langsung Rp25.000 untuk layanan GoRide atau GoCar.',
                'status' => 'aktif',
            ],
            [
                'nama_voucher' => 'Voucher Air Mineral 1 Galon - Indomaret',
                'nilai_koin' => 7,
                'deskripsi' => 'Tukarkan koin Anda untuk mendapatkan 1 galon air mineral di Indomaret.',
                'status' => 'aktif',
            ],
            [
                'nama_voucher' => 'Donasi Pohon - LindungiHutan',
                'nilai_koin' => 6,
                'deskripsi' => 'Sumbangkan koin untuk penanaman 1 pohon melalui program LindungiHutan.',
                'status' => 'aktif',
            ],
            [
                'nama_voucher' => 'Voucher Belanja Rp100.000 - ECO Market',
                'nilai_koin' => 95,
                'deskripsi' => 'Gunakan voucher ini untuk berbelanja produk ramah lingkungan di ECO Market.',
                'status' => 'aktif',
            ],
        ];

        foreach ($voucherData as $data) {
            Voucher::create($data);
        }
    }
}
