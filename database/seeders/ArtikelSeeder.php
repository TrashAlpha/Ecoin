<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\Quiz;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artikelData = [
            [
                'judul' => 'Pentingnya Memilah Sampah untuk Lingkungan',
                'konten' => 'Memilah sampah merupakan langkah awal yang sangat penting dalam pengelolaan limbah. Dengan memilah sampah organik dan anorganik, kita dapat membantu proses daur ulang dan mengurangi pencemaran lingkungan. Sampah organik dapat diolah menjadi kompos yang berguna untuk tanaman, sedangkan sampah anorganik seperti plastik dan kertas dapat didaur ulang menjadi produk baru.',
                'gambar_url' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800',
                'kategori' => 'Lingkungan',
                'views' => 150,
                'reward_koin' => 10,
                'status' => 'active'
            ],
            [
                'judul' => 'Cara Mengurangi Penggunaan Plastik Sekali Pakai',
                'konten' => 'Plastik sekali pakai menjadi salah satu penyumbang terbesar pencemaran lingkungan. Kita dapat mengurangi penggunaannya dengan membawa tas belanja sendiri, menggunakan botol minum yang dapat digunakan berulang, dan memilih produk dengan kemasan yang ramah lingkungan. Setiap langkah kecil yang kita lakukan akan memberikan dampak besar bagi kelestarian bumi.',
                'gambar_url' => 'https://images.unsplash.com/photo-1571727153934-b9e0059b7ab2?w=800',
                'kategori' => 'Gaya Hidup',
                'views' => 200,
                'reward_koin' => 10,
                'status' => 'active'
            ],
            [
                'judul' => 'Manfaat Kompos untuk Tanaman dan Lingkungan',
                'konten' => 'Kompos adalah hasil penguraian bahan organik yang sangat bermanfaat untuk tanaman. Selain menyuburkan tanah, kompos juga membantu mengurangi volume sampah organik yang berakhir di tempat pembuangan akhir. Proses pembuatan kompos sangat mudah dan dapat dilakukan di rumah dengan memanfaatkan sisa-sisa makanan dan dedaunan.',
                'gambar_url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800',
                'kategori' => 'Pertanian',
                'views' => 120,
                'reward_koin' => 10,
                'status' => 'active'
            ]
        ];

        foreach ($artikelData as $data) {
            $artikel = Artikel::create($data);

            // Create quiz for each article
            $this->createQuizForArtikel($artikel);
        }
    }

    private function createQuizForArtikel($artikel)
    {
        $quizData = [];

        if ($artikel->judul == 'Pentingnya Memilah Sampah untuk Lingkungan') {
            $quizData = [
                [
                    'artikel_id' => $artikel->id,
                    'pertanyaan' => 'Apa manfaat utama dari memilah sampah?',
                    'pilihan_jawaban' => [
                        'A' => 'Menghemat waktu',
                        'B' => 'Membantu proses daur ulang dan mengurangi pencemaran',
                        'C' => 'Mengurangi biaya',
                        'D' => 'Mempercantik lingkungan'
                    ],
                    'jawaban_benar' => 'B',
                    'urutan' => 1
                ],
                [
                    'artikel_id' => $artikel->id,
                    'pertanyaan' => 'Sampah organik dapat diolah menjadi?',
                    'pilihan_jawaban' => [
                        'A' => 'Plastik',
                        'B' => 'Kertas',
                        'C' => 'Kompos',
                        'D' => 'Kaca'
                    ],
                    'jawaban_benar' => 'C',
                    'urutan' => 2
                ],
                [
                    'artikel_id' => $artikel->id,
                    'pertanyaan' => 'Contoh sampah anorganik adalah?',
                    'pilihan_jawaban' => [
                        'A' => 'Sisa makanan',
                        'B' => 'Daun kering',
                        'C' => 'Plastik dan kertas',
                        'D' => 'Kulit buah'
                    ],
                    'jawaban_benar' => 'C',
                    'urutan' => 3
                ]
            ];
        } elseif ($artikel->judul == 'Cara Mengurangi Penggunaan Plastik Sekali Pakai') {
            $quizData = [
                [
                    'artikel_id' => $artikel->id,
                    'pertanyaan' => 'Salah satu cara mengurangi plastik sekali pakai adalah?',
                    'pilihan_jawaban' => [
                        'A' => 'Membeli lebih banyak plastik',
                        'B' => 'Membawa tas belanja sendiri',
                        'C' => 'Menggunakan plastik berkualitas tinggi',
                        'D' => 'Membakar plastik'
                    ],
                    'jawaban_benar' => 'B',
                    'urutan' => 1
                ],
                [
                    'artikel_id' => $artikel->id,
                    'pertanyaan' => 'Mengapa plastik sekali pakai berbahaya bagi lingkungan?',
                    'pilihan_jawaban' => [
                        'A' => 'Karena mahal',
                        'B' => 'Karena mudah rusak',
                        'C' => 'Karena menjadi penyumbang pencemaran lingkungan',
                        'D' => 'Karena tidak praktis'
                    ],
                    'jawaban_benar' => 'C',
                    'urutan' => 2
                ],
                [
                    'artikel_id' => $artikel->id,
                    'pertanyaan' => 'Alternatif pengganti botol plastik sekali pakai adalah?',
                    'pilihan_jawaban' => [
                        'A' => 'Botol kaca sekali pakai',
                        'B' => 'Botol minum yang dapat digunakan berulang',
                        'C' => 'Botol kertas',
                        'D' => 'Tidak minum sama sekali'
                    ],
                    'jawaban_benar' => 'B',
                    'urutan' => 3
                ]
            ];
        } else {
            $quizData = [
                [
                    'artikel_id' => $artikel->id,
                    'pertanyaan' => 'Apa itu kompos?',
                    'pilihan_jawaban' => [
                        'A' => 'Sampah plastik',
                        'B' => 'Hasil penguraian bahan organik',
                        'C' => 'Pupuk kimia',
                        'D' => 'Pestisida alami'
                    ],
                    'jawaban_benar' => 'B',
                    'urutan' => 1
                ],
                [
                    'artikel_id' => $artikel->id,
                    'pertanyaan' => 'Manfaat kompos untuk tanaman adalah?',
                    'pilihan_jawaban' => [
                        'A' => 'Membuat tanaman layu',
                        'B' => 'Menyuburkan tanah',
                        'C' => 'Membunuh tanaman',
                        'D' => 'Tidak ada manfaat'
                    ],
                    'jawaban_benar' => 'B',
                    'urutan' => 2
                ],
                [
                    'artikel_id' => $artikel->id,
                    'pertanyaan' => 'Bahan apa yang bisa dijadikan kompos?',
                    'pilihan_jawaban' => [
                        'A' => 'Plastik',
                        'B' => 'Kaca',
                        'C' => 'Sisa makanan dan dedaunan',
                        'D' => 'Logam'
                    ],
                    'jawaban_benar' => 'C',
                    'urutan' => 3
                ]
            ];
        }

        foreach ($quizData as $quiz) {
            Quiz::create($quiz);
        }
    }
}
