<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function detail($shop_id)
    {
        $shop = Shop::findOrFail($shop_id);

        // Ambil produk yang tersedia & stok > 0, 9 per halaman
        $products = $shop->products()
            ->available()
            ->paginate(9);

        return view('shop-detail', compact('shop', 'products'));
    }
}
