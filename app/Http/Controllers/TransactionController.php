<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
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
                ->with('swal', ['type' => 'error', 'title' => 'Token Invalid', 'text' => 'Transaksi tidak ditemukan.']);
        }

        // Customer → lihat status saja
        if (auth()->user()->role === 'customer') {
            return view('transactions.status', compact('transaction'));
        }

        // Kalau sudah SELESAI/DIBATALKAN → redirect ke detail
        if (in_array($transaction->status, ['SELESAI', 'DIBATALKAN'])) {
            return redirect()->route('transactions.show', $transaction->id)
                ->with('swal', ['type' => 'info', 'title' => 'Info', 'text' => 'Transaksi ini sudah ' . $transaction->status]);
        }

        // Admin kantin → cek warung
        if (auth()->user()->role === 'admin_kantin' &&
            $transaction->shop_id !== auth()->user()->shop_id) {
            return redirect()->route('dashboard')
                ->with('swal', ['type' => 'error', 'title' => 'Akses Ditolak', 'text' => 'Bukan transaksi warung kamu!']);
        }

        return view('transactions.confirm', compact('transaction'));
    }

    // ─────────────────────────────────────────────
    // PROSES KONFIRMASI STEP 1: PENDING → SIAP
    // Admin kantin scan QR → pesanan disiapkan
    // Stok berkurang, tapi saldo BELUM dipotong
    // ─────────────────────────────────────────────
    public function processConfirm(Transaction $transaction)
    {
        // Jika masih PENDING → ubah ke SIAP (pesanan sedang disiapkan)
        if ($transaction->status === 'PENDING') {
            try {
                DB::transaction(function () use ($transaction) {
                    $items = is_array($transaction->items)
                        ? $transaction->items
                        : json_decode($transaction->items, true);

                    // Kurangi stok saat pesanan mulai disiapkan
                    foreach ($items as $item) {
                        if (isset($item['product_id'])) {
                            Product::where('id', $item['product_id'])
                                ->decrement('stock', $item['quantity'] ?? 1);
                        }
                    }

                    $transaction->update([
                        'status' => 'SIAP',
                    ]);
                });

                return redirect()->route('dashboard')->with('swal', [
                    'type'  => 'success',
                    'title' => 'Pesanan Disiapkan! ',
                    'text'  => 'Pesanan #' . $transaction->id . ' atas nama ' . $transaction->cashier_name . ' sedang disiapkan. Tunggu siswa mengambil.',
                ]);
            } catch (\Exception $e) {
                return redirect()->route('dashboard')->with('swal', [
                    'type'  => 'error',
                    'title' => 'Gagal',
                    'text'  => 'Terjadi kesalahan sistem.',
                ]);
            }
        }

        // Jika sudah SIAP → ubah ke SELESAI (siswa sudah ambil, saldo dipotong)
        if ($transaction->status === 'SIAP') {
            try {
                DB::transaction(function () use ($transaction) {
                    // Potong saldo customer (jika bayar saldo)
                    if ($transaction->payment_method === 'saldo' && $transaction->user_id) {
                        $transaction->user->decrement('balance', $transaction->total);
                    }

                    // Tambah balance warung
                    $transaction->shop->increment('balance', $transaction->total);

                    $transaction->update([
                        'status'       => 'SELESAI',
                        'confirmed_at' => now(),
                    ]);
                });

                return redirect()->route('dashboard')->with('swal', [
                    'type'  => 'success',
                    'title' => 'Transaksi Selesai! ',
                    'text'  => 'Pesanan #' . $transaction->id . ' atas nama ' . $transaction->cashier_name . ' sudah diserahkan.',
                ]);
            } catch (\Exception $e) {
                return redirect()->route('dashboard')->with('swal', [
                    'type'  => 'error',
                    'title' => 'Gagal',
                    'text'  => 'Terjadi kesalahan sistem.',
                ]);
            }
        }

        // Status lain (sudah SELESAI/DIBATALKAN)
        return redirect()->route('transactions.show', $transaction->id)
            ->with('swal', ['type' => 'info', 'title' => 'Info', 'text' => 'Transaksi ini sudah ' . $transaction->status]);
    }

    // ─────────────────────────────────────────────
    // SHOW DETAIL TRANSAKSI
    // ─────────────────────────────────────────────
    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    // ─────────────────────────────────────────────
    // UPDATE STATUS MANUAL (admin web)
    // ─────────────────────────────────────────────
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:PENDING,SIAP,SELESAI,DIBATALKAN',
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

        if ($user->role === 'customer' && $transaction->user_id !== $user->id) {
            abort(403, 'Bukan pesanan Anda.');
        }

        if ($user->role === 'admin_kantin' && $transaction->shop_id !== $user->shop_id) {
            abort(403, 'Bukan transaksi warung Anda.');
        }

        // Hanya PENDING yang bisa dibatalkan (SIAP sudah mulai disiapkan)
        if ($transaction->status !== 'PENDING') {
            return redirect()->back()->with('swal', [
                'type'  => 'error',
                'title' => 'Tidak Bisa Dibatalkan!',
                'text'  => 'Pesanan dengan status ' . $transaction->status . ' tidak bisa dibatalkan.',
            ]);
        }

        DB::transaction(function () use ($transaction) {
            $transaction->update(['status' => 'DIBATALKAN']);
        });

        return redirect()->back()->with('swal', [
            'type'  => 'info',
            'title' => 'Pesanan Dibatalkan',
            'text'  => 'Pesanan #' . $transaction->id . ' berhasil dibatalkan.',
        ]);
    }
}
