<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
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