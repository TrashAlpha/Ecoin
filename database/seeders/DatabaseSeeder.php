<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Create Admin User
        User::create([
            'name' => 'Admin Ecoin',
            'email' => 'admin@ecoin.com',
            'password' => Hash::make('admin123'),
            'saldo_koin' => 0,
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create Regular User for testing
        User::create([
            'name' => 'User Test',
            'email' => 'user@ecoin.com',
            'password' => Hash::make('user123'),
            'saldo_koin' => 100,
            'role' => 'user',
            'status' => 'active',
        ]);

        // Seed Users Table
        for ($x = 1; $x <= 8; $x++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'saldo_koin' => $faker->numberBetween(0, 5000),
                'role' => 'user',
                'status' => 'active',
            ]);
        }

        // Seed Vouchers Table
        for ($x = 1; $x <= 10; $x++) {
            DB::table('vouchers')->insert([
                'nama_voucher' => 'Voucher ' . $x,
                'deskripsi' => $faker->sentence(),
                'nilai_koin' => $faker->numberBetween(10, 500),
                'image_url' => 'https://via.placeholder.com/300x200?text=Voucher+' . $x,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Call other seeders
        $this->call([
            SampahSeeder::class,
        ]);
    }
} 