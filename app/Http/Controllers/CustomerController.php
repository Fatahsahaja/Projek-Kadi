<?php

namespace App\Http\Controllers;

use App\Models\Shop;

class CustomerController extends Controller
{
    public function menu()
    {
        $shops = Shop::all();

        return view('customer.menu', compact('shops'));
    }

    public function order()
    {
        // Logic untuk order nanti
        return back()->with('success', 'Order berhasil!');
    }
}
