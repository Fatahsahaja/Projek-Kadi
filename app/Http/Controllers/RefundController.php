<?php

namespace App\Http\Controllers;

use App\Models\RefundRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
    // ─────────────────────────────────────────────
    // CUSTOMER: buat request refund
    // ─────────────────────────────────────────────
    public function store(Request $request)
    {
        $user = auth()->user();

        // Cek saldo cukup
        $validated = $request->validate([
            'amount'         => 'required|numeric|min:10000',
            'ewallet_type'   => 'required|in:GoPay,DANA,OVO,ShopeePay',
            'ewallet_number' => 'required|string|min:10|max:20',
        ], [
            'amount.min' => 'Minimal refund Rp 10.000.',
        ]);

        if ($user->balance < $validated['amount']) {
            return redirect()->back()->with('error',
                'Saldo tidak cukup untuk direfund. Saldo kamu: Rp ' .
                number_format($user->balance, 0, ',', '.')
            );
        }

        // Cek tidak ada request PENDING sebelumnya
        $pending = RefundRequest::where('user_id', $user->id)
            ->where('status', 'PENDING')
            ->exists();

        if ($pending) {
            return redirect()->back()->with('error',
                'Kamu masih punya permintaan refund yang sedang diproses. Tunggu hingga selesai.'
            );
        }

        DB::transaction(function () use ($validated, $user) {
            // Freeze saldo — potong dulu saat request
            $user->decrement('balance', $validated['amount']);

            RefundRequest::create([
                'user_id'        => $user->id,
                'amount'         => $validated['amount'],
                'ewallet_type'   => $validated['ewallet_type'],
                'ewallet_number' => $validated['ewallet_number'],
                'status'         => 'PENDING',
            ]);
        });

        return redirect()->route('customer.profil', ['#dompet'])->with('swal', [
            'type'  => 'success',
            'title' => 'Permintaan Refund Dikirim!',
            'text'  => 'Saldo sementara dibekukan. Admin akan memproses refund ke ' .
                       $validated['ewallet_type'] . ' ' . $validated['ewallet_number'] . '.',
        ]);
    }

    // ─────────────────────────────────────────────
    // ADMIN: approve refund
    // ─────────────────────────────────────────────
    public function approve(RefundRequest $refundRequest)
    {
        if ($refundRequest->status !== 'PENDING') {
            return redirect()->back()->with('swal', [
                'type'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Request ini sudah diproses sebelumnya.',
            ]);
        }

        // Saldo sudah dipotong saat request → tinggal update status
        $refundRequest->update([
            'status'      => 'APPROVED',
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('swal', [
            'type'  => 'success',
            'title' => 'Refund Disetujui!',
            'text'  => 'Refund Rp ' . number_format($refundRequest->amount, 0, ',', '.') .
                       ' ke ' . $refundRequest->ewallet_type . ' ' . $refundRequest->ewallet_number .
                       ' atas nama ' . $refundRequest->user->name . ' telah disetujui.',
        ]);
    }

    // ─────────────────────────────────────────────
    // ADMIN: reject refund → kembalikan saldo
    // ─────────────────────────────────────────────
    public function reject(Request $request, RefundRequest $refundRequest)
    {
        if ($refundRequest->status !== 'PENDING') {
            return redirect()->back()->with('swal', [
                'type'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Request ini sudah diproses sebelumnya.',
            ]);
        }

        $request->validate([
            'notes' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $refundRequest) {
            // Kembalikan saldo ke customer
            $refundRequest->user->increment('balance', $refundRequest->amount);

            $refundRequest->update([
                'status' => 'REJECTED',
                'notes'  => $request->notes ?? 'Ditolak oleh admin.',
            ]);
        });

        return redirect()->back()->with('swal', [
            'type'  => 'info',
            'title' => 'Refund Ditolak',
            'text'  => 'Saldo Rp ' . number_format($refundRequest->amount, 0, ',', '.') .
                       ' dikembalikan ke akun ' . $refundRequest->user->name . '.',
        ]);
    }

    // ─────────────────────────────────────────────
    // ADMIN: list semua refund requests
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = RefundRequest::with('user')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $refunds       = $query->paginate(15);
        $pendingCount  = RefundRequest::where('status', 'PENDING')->count();
        $approvedCount = RefundRequest::where('status', 'APPROVED')->count();
        $rejectedCount = RefundRequest::where('status', 'REJECTED')->count();
        $totalRefunded = RefundRequest::where('status', 'APPROVED')->sum('amount');

        return view('admin.kadi.refund', compact(
            'refunds', 'pendingCount', 'approvedCount', 'rejectedCount', 'totalRefunded'
        ));
    }
}
