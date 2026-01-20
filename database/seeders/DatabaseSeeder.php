<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ShopSeeder::class,    // HARUS PERTAMA!
            UserSeeder::class,     // Kedua (karena butuh shop_id)
        ]);
    }
}
