<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use Illuminate\Support\Facades\DB; 

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // DOKUMENTASI: Diubah dari 'buku' menjadi 'bukus'
        // agar sesuai dengan nama tabel di file migrasi Anda.
        DB::table('bukus')->truncate();

        // Loop Anda untuk membuat 20 buku palsu (ini sudah benar)
        for ($i = 0; $i < 20; $i++) {
            Buku::create([
                'title' => fake()->sentence(3),
                'writer' => fake()->name(),
                'price' => fake()->numberBetween(10000, 50000),
                'published_date' => fake()->date(),
            ]);
        }
    }
}