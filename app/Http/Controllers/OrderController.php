<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Shop;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman konfirmasi order (order-confirm.blade.php)
     */
    public function show(Request $request)
    {
        // Ambil data dari session cart
        $cart = session()->get('cart', []);

        // Kalo cart kosong, redirect balik ke menu
        if (empty($cart)) {
            return redirect()->route('customer.menu')->with('error', 'Keranjang lu kosong bro!');
        }

        // Hitung total & gabung nama menu
        $total = array_sum(array_column($cart, 'price'));
        $menuNames = array_column($cart, 'name');
        $shop_id = $cart[0]['shop_id'] ?? 1; // Ambil shop_id dari item pertama

        $shop = Shop::findOrFail($shop_id);

        return view('order-confirm', [
            'cart' => $cart,
            'nama_makanan' => implode(', ', $menuNames),
            'harga' => $total,
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
            'notes' => $validated['notes'] ?? null,
        ]);

        // Update balance toko
        $shop = Shop::find($validated['shop_id']);
        $shop->increment('balance', $validated['total']);

        // PENTING: Hapus cart setelah order berhasil
        session()->forget('cart');

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
