<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'name',
        'price',
        'stock',
        'image',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Relasi ke Shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Scope: hanya produk yang tersedia & stok > 0
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stock', '>', 0);
    }
}
