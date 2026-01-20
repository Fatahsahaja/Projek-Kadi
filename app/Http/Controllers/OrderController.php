<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Shop;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman konfirmasi order
     */
    public function show(Request $request)
    {
        // Validasi parameter dari URL
        $validated = $request->validate([
            'menu' => 'required|string',
            'harga' => 'required|numeric',
            'shop_id' => 'required|exists:shops,id',
        ]);

        $shop = Shop::find($validated['shop_id']);

        return view('order', [
            'nama_makanan' => $validated['menu'],
            'harga' => $validated['harga'],
            'shop' => $shop,
        ]);
    }

    /**
     * Proses order & simpan ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'items' => 'required|string',
            'total' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        // Simpan transaksi
        $transaction = Transaction::create([
            'shop_id' => $validated['shop_id'],
            'user_id' => auth()->id(),
            'cashier_name' => auth()->user()->name,
            'items' => $validated['items'],
            'phone' => auth()->user()->phone,
            'total' => $validated['total'],
            'status' => 'PENDING',
        ]);

        // Update balance toko (opsional)
        $shop = Shop::find($validated['shop_id']);
        $shop->increment('balance', $validated['total']);

        return redirect()->route('order.success')->with('order_id', $transaction->id);
    }

    /**
     * Tampilkan halaman sukses
     */
    public function success()
    {
        $order_id = session('order_id');

        return view('order-success', compact('order_id'));
    }
}
