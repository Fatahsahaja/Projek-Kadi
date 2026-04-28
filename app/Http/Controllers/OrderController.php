<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function show(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.menu')->with('error', 'Keranjang kamu kosong!');
        }

        // Hitung total dari subtotal tiap item
        $total = array_sum(array_column($cart, 'subtotal'));
        $shop_id = $cart[0]['shop_id'];
        $shop = Shop::findOrFail($shop_id);

        return view('order-confirm', compact('cart', 'total', 'shop'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'items'   => 'required|string',
            'total'   => 'required|numeric',
            'notes'   => 'nullable|string',
        ]);

        // Generate token unik untuk QR
        $token = Str::uuid();

        $transaction = Transaction::create([
            'shop_id'            => $validated['shop_id'],
            'user_id'            => auth()->id(),
            'cashier_name'       => auth()->user()->name,
            'items'              => $validated['items'],
            'phone'              => auth()->user()->phone,
            'total'              => $validated['total'],
            'status'             => 'PENDING',
            'notes'              => $validated['notes'] ?? null,
            'confirmation_token' => $token,
            // ✅ Balance TIDAK diupdate di sini
            // ✅ Balance diupdate saat admin konfirmasi QR
        ]);

        // Hapus cart setelah order
        session()->forget('cart');

        return redirect()->route('order.success')->with('order_id', $transaction->id);
    }

    // Tambahkan method ini di OrderController
    public function checkStatus(Transaction $transaction)
    {
        // Pastikan hanya pemilik pesanan yang bisa cek
        if ($transaction->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status'       => $transaction->status,
            'confirmed_at' => $transaction->confirmed_at,
        ]);
    }

    public function success()
    {
        $order_id = session('order_id');

        if (!$order_id) {
            return redirect()->route('customer.menu');
        }

        $transaction = Transaction::with('shop')->findOrFail($order_id);

        $qrUrl = route('transactions.confirmByQR', [
            'token' => $transaction->confirmation_token
        ]);

        return view('order-success', compact('transaction', 'qrUrl'));
    }
}
