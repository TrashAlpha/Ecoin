<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Seed Users Table
        for ($x = 1; $x <= 10; $x++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'saldo_koin' => $faker->numberBetween(0, 5000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed Vouchers Table
        for ($x = 1; $x <= 10; $x++) {
            DB::table('vouchers')->insert([
                'nama_voucher' => 'Voucher ' . $x,
                'deskripsi' => $faker->sentence(),
                'nilai_koin' => $faker->numberBetween(100, 1000),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
