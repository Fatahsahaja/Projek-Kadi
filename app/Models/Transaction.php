<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'user_id',
        'cashier_name',
        'items',
        'phone',
        'total',
        'status',
        'notes',
        'confirmation_token',
        'confirmed_at',
        'payment_method',
    ];

    protected $casts = [
        'items' => 'array',      // otomatis decode JSON jadi array
        'confirmed_at' => 'datetime',
        'total' => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
