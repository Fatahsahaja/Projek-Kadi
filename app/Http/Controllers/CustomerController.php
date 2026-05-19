<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Transaction;

class CustomerController extends Controller
{
    public function menu()
    {
        $shops = Shop::with(['products' => function ($q) {
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

    public function profil()
    {
        $user = auth()->user();

        // Ambil data NIS template kalau ada
        $nisData = $user->nis
            ? \App\Models\NisTemplate::where('nis', $user->nis)->first()
            : null;

        // FIX: Total pengeluaran hitung transaksi SELESAI saja
        // (SELESAI = siswa sudah ambil & saldo sudah terpotong)
        $totalPengeluaran = Transaction::where('user_id', $user->id)
            ->where('status', 'SELESAI')
            ->sum('total');

        // Riwayat transaksi
        $transactions = Transaction::where('user_id', $user->id)
            ->with('shop')
            ->latest()
            ->paginate(8);

        // Warung favorit (paling sering dipesan, status SELESAI)
        $warungFavorit = Transaction::where('user_id', $user->id)
            ->where('status', 'SELESAI')
            ->select('shop_id', \DB::raw('COUNT(*) as total'))
            ->groupBy('shop_id')
            ->orderByDesc('total')
            ->with('shop')
            ->first();

        return view('customer.profil', compact(
            'user',
            'nisData',
            'totalPengeluaran',
            'transactions',
            'warungFavorit'
        ));
    }
}
