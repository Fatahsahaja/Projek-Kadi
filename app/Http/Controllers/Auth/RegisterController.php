<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\ValidIndonesianPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'unique:users', new ValidIndonesianPhone],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Generate kode verifikasi
        $phoneCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $emailCode = Str::random(32);

        // Normalize nomor telepon
        $phone = $this->normalizePhoneNumber($validated['phone']);

        // Buat user
        $user = User::create([
            'name' => $validated['name'],
            'phone' => $phone,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer', // Default role
            'phone_verification_code' => $phoneCode,
            'email_verification_code' => $emailCode,
            'phone_verification_sent_at' => now(),
            'email_verification_sent_at' => now(),
        ]);

        // Kirim kode verifikasi SMS (implementasi di Step 5)
        $this->sendPhoneVerification($user, $phoneCode);

        // Kirim kode verifikasi Email
        $this->sendEmailVerification($user, $emailCode);

        return redirect()->route('verification.notice', $user->id)
            ->with('success', 'Akun berhasil dibuat! Silakan cek SMS dan Email Anda untuk kode verifikasi.');
    }

    /**
     * Normalize phone number to Indonesian format
     */
    private function normalizePhoneNumber($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Convert ke format 62xxx
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Send phone verification SMS
     */
    private function sendPhoneVerification($user, $code)
    {
        // TODO: Implementasi kirim SMS (Step 5)
        // Sementara log dulu
        \Log::info("Kode verifikasi SMS untuk {$user->phone}: {$code}");
    }

    /**
     * Send email verification
     */
    private function sendEmailVerification($user, $code)
    {
        Mail::send('emails.verify-email', ['user' => $user, 'code' => $code], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Verifikasi Email Anda - KADI');
        });
    }
}