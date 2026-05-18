<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $shopA = Shop::where('name', 'Kantin A - Nasi Goreng')->first();
        $shopB = Shop::where('name', 'Kantin B - Mie Ayam')->first();
        $shopC = Shop::where('name', 'Kantin C - Bakso')->first();

        $products = [
            // Kantin A
            [
                'shop_id'      => $shopA->id,
                'name'         => 'Es TeaJus',
                'price'        => 3000,
                'stock'        => 50,
                'image'        => 'products/Teajus.jpg',
                'is_available' => true,
            ],
            [
                'shop_id'      => $shopA->id,
                'name'         => 'Gorengan',
                'price'        => 1000,
                'stock'        => 100,
                'image'        => 'products/Gorengan.png',
                'is_available' => true,
            ],
            [
                'shop_id'      => $shopA->id,
                'name'         => 'Ayam Goyeng',
                'price'        => 8000,
                'stock'        => 30,
                'image'        => 'products/AyamGoyeng.png',
                'is_available' => true,
            ],

            // Kantin B
            [
                'shop_id'      => $shopB->id,
                'name'         => 'Mie Ayam',
                'price'        => 8000,
                'stock'        => 30,
                'image'        => 'products/default.png',
                'is_available' => true,
            ],
            [
                'shop_id'      => $shopB->id,
                'name'         => 'Mie Goreng',
                'price'        => 7000,
                'stock'        => 25,
                'image'        => 'products/default.png',
                'is_available' => true,
            ],

            // Kantin C
            [
                'shop_id'      => $shopC->id,
                'name'         => 'Bakso',
                'price'        => 10000,
                'stock'        => 40,
                'image'        => 'products/default.png',
                'is_available' => true,
            ],
            [
                'shop_id'      => $shopC->id,
                'name'         => 'Bakso Urat',
                'price'        => 12000,
                'stock'        => 20,
                'image'        => 'products/default.png',
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
