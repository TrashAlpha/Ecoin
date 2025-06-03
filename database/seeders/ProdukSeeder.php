<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'nama_produk' => 'Tas Belanja Ramah Lingkungan',
                'deskripsi' => 'Tas belanja yang terbuat dari bahan daur ulang, tahan lama dan dapat digunakan berulang kali.',
                'harga' => 25000,
                'gambar_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400',
                'link_beli' => 'https://shopee.co.id/search?keyword=tas%20belanja%20ramah%20lingkungan',
                'status' => 'active'
            ],
            [
                'nama_produk' => 'Botol Minum Stainless Steel',
                'deskripsi' => 'Botol minum anti karat yang dapat mengurangi penggunaan botol plastik sekali pakai.',
                'harga' => 45000,
                'gambar_url' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400',
                'link_beli' => 'https://shopee.co.id/search?keyword=botol%20minum%20stainless%20steel',
                'status' => 'active'
            ],
            [
                'nama_produk' => 'Sedotan Bambu Set',
                'deskripsi' => 'Set sedotan bambu alami dengan sikat pembersih, alternatif ramah lingkungan untuk sedotan plastik.',
                'harga' => 15000,
                'gambar_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400',
                'link_beli' => 'https://shopee.co.id/search?keyword=sedotan%20bambu',
                'status' => 'active'
            ],
            [
                'nama_produk' => 'Sabun Cuci Piring Organik',
                'deskripsi' => 'Sabun cuci piring dari bahan organik yang aman untuk lingkungan dan tidak mencemari air.',
                'harga' => 18000,
                'gambar_url' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400',
                'link_beli' => 'https://tokopedia.com/search?st=product&q=sabun%20cuci%20piring%20organik',
                'status' => 'active'
            ],
            [
                'nama_produk' => 'Lampu LED Hemat Energi',
                'deskripsi' => 'Lampu LED dengan konsumsi energi rendah dan umur panjang, membantu mengurangi jejak karbon.',
                'harga' => 35000,
                'gambar_url' => 'https://images.unsplash.com/photo-1524484485831-a92ffc0de03f?w=400',
                'link_beli' => 'https://tokopedia.com/search?st=product&q=lampu%20led%20hemat%20energi',
                'status' => 'active'
            ],
            [
                'nama_produk' => 'Pupuk Kompos Organik',
                'deskripsi' => 'Pupuk kompos dari bahan organik untuk tanaman, membantu mengurangi limbah organik rumah tangga.',
                'harga' => 20000,
                'gambar_url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400',
                'link_beli' => 'https://shopee.co.id/search?keyword=pupuk%20kompos%20organik',
                'status' => 'active'
            ]
        ];

        foreach ($products as $product) {
            Produk::create($product);
        }
    }
} 