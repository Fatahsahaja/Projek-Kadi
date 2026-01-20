<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;

class TransactionPolicy
{
    // Policy untuk update status
    public function update(User $user, Transaction $transaction)
    {
        // Admin KADI bisa update semua
        if ($user->role === 'admin_web') {
            return true;
        }

        // Admin Kantin hanya bisa update pesanan toko sendiri
        if ($user->role === 'admin_kantin') {
            return $transaction->shop_id === $user->shop_id;
        }

        return false;
    }

    // Policy untuk view detail
    public function view(User $user, Transaction $transaction)
    {
        if ($user->role === 'admin_web') {
            return true;
        }

        if ($user->role === 'admin_kantin') {
            return $transaction->shop_id === $user->shop_id;
        }

        if ($user->role === 'customer') {
            return $transaction->user_id === $user->id;
        }

        return false;
    }

    // Policy untuk cancel pesanan
    public function cancel(User $user, Transaction $transaction)
    {
        // Admin Kantin hanya bisa cancel pesanan toko sendiri
        if ($user->role === 'admin_kantin') {
            return $transaction->shop_id === $user->shop_id;
        }

        // Customer hanya bisa cancel pesanan sendiri
        if ($user->role === 'customer') {
            return $transaction->user_id === $user->id;
        }

        return false;
    }
}
