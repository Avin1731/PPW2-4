<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- DOKUMENTASI: Kita import 'Hash' untuk enkripsi password

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // DOKUMENTASI: Buat 1 user Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // passwordnya adalah 'password'
            'role' => 'admin', // <-- PENTING: set rolenya 'admin'
        ]);
        
        // DOKUMENTASI: Buat 1 user biasa untuk tes
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'), // passwordnya adalah 'password'
            'role' => 'user', // <-- PENTING: set rolenya 'user'
        ]);

        // DOKUMENTASI: Panggil 'BukuSeeder' yang sudah kita edit tadi
        // Ini akan menjalankan file 'BukuSeeder.php'
        $this->call(BukuSeeder::class);

        // DOKUMENTASI: Kode bawaan Anda yang lama tidak kita pakai lagi
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}