<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Tampilkan halaman detail warung dengan daftar menu
     */
    public function detail($shop_id)
    {
        // Cari data warung berdasarkan ID
        $shop = Shop::findOrFail($shop_id);

        // Untuk sementara, kirim data shop ke view
        // Nanti bisa ditambah query menu dari database
        return view('shop-detail', compact('shop'));
    }
}
