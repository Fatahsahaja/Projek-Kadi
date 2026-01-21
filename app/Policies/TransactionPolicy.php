<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;

class TransactionPolicy
{
    /**
     * Determine if user can update transaction
     */
    public function update(User $user, Transaction $transaction): bool
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
    
    /**
     * Determine if user can view transaction
     */
    public function view(User $user, Transaction $transaction): bool
    {
        // Admin KADI bisa lihat semua
        if ($user->role === 'admin_web') {
            return true;
        }
        
        // Admin Kantin hanya bisa lihat pesanan toko sendiri
        if ($user->role === 'admin_kantin') {
            return $transaction->shop_id === $user->shop_id;
        }
        
        // Customer hanya bisa lihat pesanan sendiri
        if ($user->role === 'customer') {
            return $transaction->user_id === $user->id;
        }
        
        return false;
    }
    
    /**
     * Determine if user can cancel transaction
     */
    public function cancel(User $user, Transaction $transaction): bool
    {
        // Admin KADI bisa cancel semua
        if ($user->role === 'admin_web') {
            return true;
        }
        
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