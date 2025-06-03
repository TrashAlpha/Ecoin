<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sampah;

class SampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampahData = [
            // Organik
            [
                'nama_sampah' => 'Sisa Makanan',
                'tipe_sampah' => 'organik',
                'nilai_koin_per_kg' => 2,
                'deskripsi' => 'Sisa makanan yang dapat dikompos',
                'status' => 'active'
            ],
            [
                'nama_sampah' => 'Daun Kering',
                'tipe_sampah' => 'organik',
                'nilai_koin_per_kg' => 1,
                'deskripsi' => 'Daun-daun kering yang gugur',
                'status' => 'active'
            ],
            [
                'nama_sampah' => 'Kulit Buah',
                'tipe_sampah' => 'organik',
                'nilai_koin_per_kg' => 2,
                'deskripsi' => 'Kulit buah-buahan',
                'status' => 'active'
            ],

            // Anorganik
            [
                'nama_sampah' => 'Botol Plastik',
                'tipe_sampah' => 'anorganik',
                'nilai_koin_per_kg' => 5,
                'deskripsi' => 'Botol plastik bekas minuman',
                'status' => 'active'
            ],
            [
                'nama_sampah' => 'Kertas',
                'tipe_sampah' => 'anorganik',
                'nilai_koin_per_kg' => 3,
                'deskripsi' => 'Kertas bekas yang masih bisa didaur ulang',
                'status' => 'active'
            ],
            [
                'nama_sampah' => 'Baju',
                'tipe_sampah' => 'anorganik',
                'nilai_koin_per_kg' => 6,
                'deskripsi' => 'Baju bekas',
                'status' => 'active'
            ],

            // Medis
            [
                'nama_sampah' => 'Masker Medis',
                'tipe_sampah' => 'medis',
                'nilai_koin_per_kg' => 10,
                'deskripsi' => 'Masker medis bekas pakai',
                'status' => 'active'
            ],
            [
                'nama_sampah' => 'Sarung Tangan Medis',
                'tipe_sampah' => 'medis',
                'nilai_koin_per_kg' => 12,
                'deskripsi' => 'Sarung tangan medis sekali pakai',
                'status' => 'active'
            ],
            [
                'nama_sampah' => 'Jarum Suntik',
                'tipe_sampah' => 'medis',
                'nilai_koin_per_kg' => 15,
                'deskripsi' => 'Jarum suntik bekas (harus dalam safety box)',
                'status' => 'active'
            ],
        ];

        foreach ($sampahData as $data) {
            Sampah::create($data);
        }
    }
} 