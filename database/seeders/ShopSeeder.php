<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    public function run()
    {
        $shops = [
            ['name' => 'Kantin A - Nasi Goreng', 'balance' => 0],
            ['name' => 'Kantin B - Mie Ayam', 'balance' => 0],
            ['name' => 'Kantin C - Bakso', 'balance' => 0],
        ];

        foreach ($shops as $shop) {
            Shop::create($shop);
        }
    }
}
