<?php

namespace App\Http\Controllers;

use App\Models\TopupRequest;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    // Halaman top up
    public function index()
    {
        $user = auth()->user();
        return view('customer.topup', compact('user'));
    }

    // Simpan request top up dari customer
    public function store(Request $request)
    {
        $request->validate([
            'amount'  => ['required', 'integer', 'min:10000', 'max:1000000'],
            'metode'  => ['required', 'in:qris,dana,gopay,cash'],
        ]);

        TopupRequest::create([
            'user_id' => auth()->id(),
            'amount'  => $request->amount,
            'metode'  => $request->metode,
            'status'  => 'PENDING',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan top up berhasil dikirim!',
        ]);
    }

    // Admin approve top up
    public function approve(TopupRequest $topupRequest)
    {
        if ($topupRequest->status !== 'PENDING') {
            return redirect()->back()->with('swal', [
                'type'  => 'error',
                'title' => 'Gagal!',
                'text'  => 'Request ini sudah diproses.',
            ]);
        }

        // Tambah balance user
        $topupRequest->user->increment('balance', $topupRequest->amount);

        // Update status
        $topupRequest->update([
            'status'      => 'APPROVED',
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('swal', [
            'type'  => 'success',
            'title' => 'Berhasil!',
            'text'  => 'Saldo ' . $topupRequest->user->name . ' berhasil ditambahkan.',
        ]);
    }

    // Admin reject top up
    public function reject(TopupRequest $topupRequest)
    {
        $topupRequest->update(['status' => 'REJECTED']);

        return redirect()->back()->with('swal', [
            'type'  => 'info',
            'title' => 'Ditolak',
            'text'  => 'Request top up berhasil ditolak.',
        ]);
    }
}
