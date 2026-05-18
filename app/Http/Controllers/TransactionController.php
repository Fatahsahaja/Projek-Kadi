<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // ─────────────────────────────────────────────
    // KONFIRMASI VIA QR
    // ─────────────────────────────────────────────
    public function confirmByQR(string $token)
{
    $transaction = Transaction::where('confirmation_token', $token)
        ->with('shop')
        ->first();

    if (!$transaction) {
        return redirect()->route('dashboard')
            ->with('swal', ['type'=>'error','title'=>'Token Invalid','text'=>'Transaksi tidak ditemukan.']);
    }

    // Customer → lihat status saja
    if (auth()->user()->role === 'customer') {
        return view('transactions.status', compact('transaction'));
    }

    // Kalau sudah SUKSES/SELESAI → redirect ke detail saja
    if ($transaction->status !== 'PENDING') {
        return redirect()->route('transactions.show', $transaction->id)
            ->with('swal', ['type'=>'info','title'=>'Info','text'=>'Transaksi ini sudah '.$transaction->status]);
    }

    // Admin kantin → cek warung
    if (auth()->user()->role === 'admin_kantin' &&
        $transaction->shop_id !== auth()->user()->shop_id) {
        return redirect()->route('dashboard')
            ->with('swal', ['type'=>'error','title'=>'Akses Ditolak','text'=>'Bukan transaksi warung kamu!']);
    }

    return view('transactions.confirm', compact('transaction'));
}

    // ─────────────────────────────────────────────
    // PROSES KONFIRMASI (dipanggil dari form di confirm.blade.php)
    // ─────────────────────────────────────────────
    public function processConfirm(Transaction $transaction)
    {
        try {
            DB::transaction(function () use ($transaction) {
                $items = is_array($transaction->items)
                    ? $transaction->items
                    : json_decode($transaction->items, true);

                foreach ($items as $item) {
                    if (isset($item['product_id'])) {
                        Product::where('id', $item['product_id'])
                            ->decrement('stock', $item['quantity'] ?? 1);
                    }
                }

                $transaction->shop->increment('balance', $transaction->total);

                $transaction->update([
                    'status'       => 'SUKSES',
                    'confirmed_at' => now(),
                ]);
            });

            return redirect()->route('dashboard')->with('swal', [
                'type'  => 'success',
                'title' => 'Pesanan Dikonfirmasi! 🎉',
                'text'  => 'Pesanan atas nama ' . $transaction->cashier_name . ' berhasil dikonfirmasi!',
            ]);

        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('swal', [
                'type'  => 'error',
                'title' => 'Gagal Konfirmasi',
                'text'  => 'Terjadi kesalahan sistem. Silakan coba lagi.',
            ]);
        }
    }

    // ─────────────────────────────────────────────
    // SHOW DETAIL TRANSAKSI
    // ─────────────────────────────────────────────
    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    // ─────────────────────────────────────────────
    // UPDATE STATUS MANUAL
    // ─────────────────────────────────────────────
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:PENDING,SUKSES,SELESAI',
        ]);

        $transaction->update(['status' => $request->status]);

        return redirect()->back()->with('swal', [
            'type'  => 'success',
            'title' => 'Status Diperbarui!',
            'text'  => 'Status pesanan berhasil diubah ke ' . $request->status,
        ]);
    }

    // ─────────────────────────────────────────────
    // CEK NOTIFIKASI PENDING
    // ─────────────────────────────────────────────
    public function checkNotifications()
    {
        $pendingCount = Transaction::where('shop_id', auth()->user()->shop_id)
            ->where('status', 'PENDING')
            ->count();

        $latestPending = Transaction::where('shop_id', auth()->user()->shop_id)
            ->where('status', 'PENDING')
            ->latest()
            ->first();

        return response()->json([
            'pending_count' => $pendingCount,
            'latest'        => $latestPending ? [
                'id'           => $latestPending->id,
                'cashier_name' => $latestPending->cashier_name,
                'total'        => number_format($latestPending->total, 0, ',', '.'),
                'created_at'   => $latestPending->created_at->diffForHumans(),
            ] : null,
        ]);
    }

    // ─────────────────────────────────────────────
    // CANCEL PESANAN
    // ─────────────────────────────────────────────
    public function cancel(Transaction $transaction)
    {
        $user = auth()->user();

        // Validasi akses: customer hanya bisa cancel miliknya,
        // admin kantin hanya bisa cancel transaksi di warungnya sendiri
        if ($user->role === 'customer' && $transaction->user_id !== $user->id) {
            abort(403, 'Bukan pesanan Anda.');
        }

        if ($user->role === 'admin_kantin' && $transaction->shop_id !== $user->shop_id) {
            abort(403, 'Bukan transaksi warung Anda.');
        }

        // Hanya PENDING atau SUKSES (bayar saldo) yang bisa dibatalkan
        if (!in_array($transaction->status, ['PENDING', 'SUKSES'])) {
            return redirect()->back()->with('swal', [
                'type'  => 'error',
                'title' => 'Tidak Bisa Dibatalkan!',
                'text'  => 'Pesanan sudah selesai atau sudah dibatalkan.',
            ]);
        }

        // Kalau bayar saldo & status SUKSES → refund saldo ke customer
        DB::transaction(function () use ($transaction) {
            if ($transaction->payment_method === 'saldo' && $transaction->status === 'SUKSES') {
                $transaction->user->increment('balance', $transaction->total);
                $transaction->shop->decrement('balance', $transaction->total);
            }
            $transaction->update(['status' => 'DIBATALKAN']);
        });

        $pesanRefund = ($transaction->payment_method === 'saldo' && $transaction->status === 'SUKSES')
            ? ' Saldo Rp ' . number_format($transaction->total, 0, ',', '.') . ' telah dikembalikan ke customer.'
            : '';

        return redirect()->back()->with('swal', [
            'type'  => 'info',
            'title' => 'Pesanan Dibatalkan',
            'text'  => 'Pesanan berhasil dibatalkan.' . $pesanRefund,
        ]);
    }
}
