<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            'shop_id'        => 'required|exists:shops,id',
            'items'          => 'required|string',
            'total'          => 'required|numeric',
            'notes'          => 'nullable|string',
            'payment_method' => 'required|in:saldo,qr',
        ]);

        $user  = auth()->user();
        $total = (float) $validated['total'];

        // Cek blacklist
        if ($user->is_blacklisted) {
            return redirect()->back()->with('error',
                'Akun kamu telah diblokir dari sistem. Hubungi admin KADI untuk informasi lebih lanjut.'
            );
        }

        // Cek saldo sebelum masuk DB transaction
        if ($validated['payment_method'] === 'saldo') {
            if ($user->balance < $total) {
                return redirect()->back()
                    ->with('error', 'Saldo kamu tidak cukup! Saldo saat ini: Rp ' . number_format($user->balance, 0, ',', '.') . '. Silakan isi saldo terlebih dahulu.');
            }
        }

        $token       = Str::uuid();
        $transaction = null;

        DB::transaction(function () use ($validated, $user, $total, $token, &$transaction) {
            $isSaldo      = $validated['payment_method'] === 'saldo';
            $status       = $isSaldo ? 'SUKSES' : 'PENDING';
            $confirmedAt  = $isSaldo ? now() : null;

            $transaction = Transaction::create([
                'shop_id'            => $validated['shop_id'],
                'user_id'            => $user->id,
                'cashier_name'       => $user->name,
                'items'              => $validated['items'],
                'phone'              => $user->phone,
                'total'              => $total,
                'status'             => $status,
                'notes'              => $validated['notes'] ?? null,
                'confirmation_token' => $token,
                'confirmed_at'       => $confirmedAt,
                'payment_method'     => $validated['payment_method'],
            ]);

            // Bayar saldo: potong saldo customer + tambah balance warung
            if ($isSaldo) {
                $user->decrement('balance', $total);
                $transaction->shop->increment('balance', $total);
            }
        });

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
