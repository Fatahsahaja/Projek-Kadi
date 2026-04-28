<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Transaction;
class CustomerController extends Controller

{
    public function menu()
    {
        $shops = Shop::with(['products' => function($q) {
            $q->where('is_available', true)->where('stock', '>', 0)->limit(3);
        }])->get();

        return view('customer.menu', compact('shops'));
    }

    public function riwayat()
{
    $transactions = Transaction::where('user_id', auth()->id())
        ->with('shop')
        ->latest()
        ->paginate(10);

    return view('customer.riwayat', compact('transactions'));
}
}
