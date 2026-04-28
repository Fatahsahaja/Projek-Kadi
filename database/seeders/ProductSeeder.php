<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Shop ID 1 — Kantin A (Nasi Goreng)
            [
                'shop_id'      => 1,
                'name'         => 'Es TeaJus',
                'price'        => 3000,
                'stock'        => 50,
                'image'        => '/images/Teajus.jpg',
                'is_available' => true,
            ],
            [
                'shop_id'      => 1,
                'name'         => 'Gorengan',
                'price'        => 1000,
                'stock'        => 100,
                'image'        => '/images/Gorengan.png',
                'is_available' => true,
            ],
            [
                'shop_id'      => 1,
                'name'         => 'Ayam Goyeng',
                'price'        => 8000,
                'stock'        => 30,
                'image'        => '/images/AyamGoyeng.png',
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
