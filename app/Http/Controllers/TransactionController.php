<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Method untuk mengubah status pesanan
    public function updateStatus(Request $request, Transaction $transaction)
    {
        // ✅ Menggunakan Policy - lebih bersih
        $this->authorize('update', $transaction);

        $request->validate([
            'status' => 'required|in:pending,processing,ready,completed,cancelled'
        ]);

        $transaction->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diubah');
    }

    // Method untuk melihat detail pesanan
    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return view('transactions.show', compact('transaction'));
    }

    // Method untuk cancel pesanan
    public function cancel(Transaction $transaction)
    {
        $this->authorize('cancel', $transaction);

        // Cek apakah pesanan masih bisa di-cancel
        if (!in_array($transaction->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan');
        }

        $transaction->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan');
    }
}
