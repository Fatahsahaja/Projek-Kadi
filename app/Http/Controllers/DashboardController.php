<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'admin_web') {
            return redirect()->route('admin.kadi.dashboard');
        }

        if ($user->role === 'admin_kantin') {
            $shop = Shop::find($user->shop_id);
            if (!$shop) abort(404, 'Toko tidak ditemukan');

            $dari  = $request->input('dari',  now()->startOfMonth()->format('Y-m-d'));
            $sampai = $request->input('sampai', now()->format('Y-m-d'));

            $transactions = Transaction::where('shop_id', $user->shop_id)
                ->whereDate('created_at', '>=', $dari)
                ->whereDate('created_at', '<=', $sampai)
                ->latest()
                ->paginate(20)
                ->withQueryString();

            // Kalau AJAX request (polling), return JSON
            if ($request->ajax()) {
                return response()->json([
                    'html' => view(
                        'admin.shop.partials.transaction-table',
                        compact('transactions')
                    )->render(),
                    'pending_count' => Transaction::where('shop_id', $user->shop_id)
                        ->where('status', 'PENDING')->count(),
                ]);
            }

            $products = Product::where('shop_id', $shop->id)->latest()->get();

            return view('admin.shop.dashboard', compact('shop', 'transactions', 'dari', 'sampai', 'products'));
        }

        if ($user->role === 'customer') {
            return redirect()->route('customer.menu');
        }

        return redirect('/')->with('error', 'Role tidak dikenali');
    }
}
