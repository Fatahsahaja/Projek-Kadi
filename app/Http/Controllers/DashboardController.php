<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Shop;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Admin KADI - Lihat semua toko
        if ($user->role === 'admin_web') {
            $shops = Shop::withCount('transactions')
                ->withSum('transactions', 'total')
                ->get(); // ✅ Ambil SEMUA toko
                
            $transactions = Transaction::with('shop')
                ->latest()
                ->paginate(20); // ✅ Ambil SEMUA transaksi
                
            return view('admin.kadi.dashboard', compact('shops', 'transactions'));
        }
        
        // Admin Kantin - Hanya lihat toko sendiri
        if ($user->role === 'admin_kantin') {
            $shop = Shop::find($user->shop_id); // ✅ Hanya toko sendiri
            
            if (!$shop) {
                abort(404, 'Toko tidak ditemukan');
            }
            
            $transactions = Transaction::where('shop_id', $user->shop_id) // ✅ FILTER di sini!
                ->latest()
                ->paginate(20); // ✅ Hanya transaksi toko sendiri
                
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