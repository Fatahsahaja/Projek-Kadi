<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin Web (Super Admin KADI) - Bisa lihat SEMUA
        User::create([
            'name' => 'Admin KADI',
            'email' => 'adminweb@kadi.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'admin_web',
            'shop_id' => null, // NULL karena dia super admin
        ]);

        // Admin Kantin A
        User::create([
            'name' => 'Admin Kantin A',
            'email' => 'kantina@kadi.com',
            'phone' => '081234567891',
            'password' => Hash::make('password'),
            'role' => 'admin_kantin',
            'shop_id' => 1, // ID shop Kantin A
        ]);

        // Admin Kantin B
        User::create([
            'name' => 'Admin Kantin B',
            'email' => 'kantinb@kadi.com',
            'phone' => '081234567892',
            'password' => Hash::make('password'),
            'role' => 'admin_kantin',
            'shop_id' => 2, // ID shop Kantin B
        ]);

        // Admin Kantin C
        User::create([
            'name' => 'Admin Kantin C',
            'email' => 'kantinc@kadi.com',
            'phone' => '081234567893',
            'password' => Hash::make('password'),
            'role' => 'admin_kantin',
            'shop_id' => 3, // ID shop Kantin C
        ]);

        // Customer Test
        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@kadi.com',
            'phone' => '081234567899',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'shop_id' => null, // Customer ga punya shop
        ]);
    }
}
