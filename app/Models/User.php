<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'shop_id',
        'phone_verified',
        'email_verified',
        'phone_verification_code',
        'email_verification_code',
        'phone_verification_sent_at',
        'email_verification_sent_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'phone_verification_code',
        'email_verification_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified' => 'boolean',
        'email_verified' => 'boolean',
        'phone_verification_sent_at' => 'datetime',
        'email_verification_sent_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user has verified both phone and email
     */
    public function isFullyVerified(): bool
    {
        return $this->phone_verified && $this->email_verified;
    }
}