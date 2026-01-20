<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Shop;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Admin KADI
        if ($user->role === 'admin_web') {
            $shops = Shop::withCount('transactions')
                ->withSum('transactions', 'total')
                ->get();

            $transactions = Transaction::with('shop')
                ->latest()
                ->paginate(20);

            return view('admin.kadi.dashboard', compact('shops', 'transactions'));
        }

        // Admin Kantin
        if ($user->role === 'admin_kantin') {
            $shop = Shop::find($user->shop_id);

            if (!$shop) {
                abort(404, 'Toko tidak ditemukan');
            }

            $transactions = Transaction::where('shop_id', $user->shop_id)
                ->latest()
                ->paginate(20);

            return view('admin.shop.dashboard', compact('shop', 'transactions'));
        }

        // Customer - redirect ke menu
        if ($user->role === 'customer') {
            return redirect()->route('customer.menu');
        }

        // Default fallback
        return redirect('/')->with('error', 'Role tidak dikenali');
    }
}
