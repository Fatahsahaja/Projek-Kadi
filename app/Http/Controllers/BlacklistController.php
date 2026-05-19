<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    // List semua customer + status blacklist
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->latest();

        if ($request->filter === 'blacklisted') {
            $query->where('is_blacklisted', true);
        } elseif ($request->filter === 'active') {
            $query->where('is_blacklisted', false);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('phone', 'like', '%'.$request->search.'%');
            });
        }

        $customers       = $query->withCount('transactions')->paginate(15);
        $blacklistCount  = User::where('role', 'customer')->where('is_blacklisted', true)->count();
        $activeCount     = User::where('role', 'customer')->where('is_blacklisted', false)->count();

        return view('admin.kadi.blacklist', compact('customers', 'blacklistCount', 'activeCount'));
    }

    // Blacklist customer
    public function blacklist(Request $request, User $user)
    {
        if ($user->role !== 'customer') {
            abort(403);
        }

        $request->validate([
            'reason' => 'required|string|max:255',
        ], [
            'reason.required' => 'Alasan blacklist wajib diisi.',
        ]);

        $user->update([
            'is_blacklisted'   => true,
            'blacklist_reason' => $request->reason,
            'blacklisted_at'   => now(),
        ]);

        return redirect()->back()->with('swal', [
            'type'  => 'warning',
            'title' => 'Customer Di-blacklist',
            'text'  => $user->name . ' (' . $user->phone . ') berhasil dimasukkan ke daftar blacklist.',
        ]);
    }

    // Hapus dari blacklist
    public function unblacklist(User $user)
    {
        if ($user->role !== 'customer') {
            abort(403);
        }

        $user->update([
            'is_blacklisted'   => false,
            'blacklist_reason' => null,
            'blacklisted_at'   => null,
        ]);

        return redirect()->back()->with('swal', [
            'type'  => 'success',
            'title' => 'Blacklist Dicabut',
            'text'  => $user->name . ' sudah bisa menggunakan aplikasi kembali.',
        ]);
    }
}
