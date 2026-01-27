<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Show verification form
     */
    public function notice($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->isFullyVerified()) {
            return redirect()->route('dashboard')->with('info', 'Akun Anda sudah terverifikasi');
        }

        return view('auth.verify', compact('user'));
    }

    /**
     * Verify phone code
     */
    public function verifyPhone(Request $request, $userId)
    {
        $request->validate([
            'phone_code' => 'required|string|size:6',
        ]);

        $user = User::findOrFail($userId);

        if ($user->phone_verification_code !== $request->phone_code) {
            return back()->withErrors(['phone_code' => 'Kode verifikasi SMS salah']);
        }

        // Check expiration (15 menit)
        if ($user->phone_verification_sent_at->addMinutes(15)->isPast()) {
            return back()->withErrors(['phone_code' => 'Kode verifikasi sudah kadaluarsa. Silakan minta kode baru.']);
        }

        $user->update([
            'phone_verified' => true,
            'phone_verification_code' => null,
        ]);

        return back()->with('success', 'Nomor telepon berhasil diverifikasi!');
    }

    /**
     * Verify email code
     */
    public function verifyEmail($userId, $code)
    {
        $user = User::findOrFail($userId);

        if ($user->email_verification_code !== $code) {
            return redirect()->route('verification.notice', $userId)
                ->withErrors(['email' => 'Kode verifikasi email tidak valid']);
        }

        $user->update([
            'email_verified' => true,
            'email_verified_at' => now(),
            'email_verification_code' => null,
        ]);

        if ($user->isFullyVerified()) {
            auth()->login($user);
            return redirect()->route('dashboard')->with('success', 'Akun Anda telah terverifikasi! Selamat datang!');
        }

        return redirect()->route('verification.notice', $userId)
            ->with('success', 'Email berhasil diverifikasi! Silakan verifikasi nomor telepon Anda.');
    }

    /**
     * Resend phone verification
     */
    public function resendPhone($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->phone_verified) {
            return back()->with('info', 'Nomor telepon sudah terverifikasi');
        }

        $phoneCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'phone_verification_code' => $phoneCode,
            'phone_verification_sent_at' => now(),
        ]);

        // Kirim SMS (implementasi di Step 6)
        \Log::info("Kode verifikasi SMS untuk {$user->phone}: {$phoneCode}");

        return back()->with('success', 'Kode verifikasi SMS telah dikirim ulang');
    }

    /**
     * Resend email verification
     */
    public function resendEmail($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->email_verified) {
            return back()->with('info', 'Email sudah terverifikasi');
        }

        $emailCode = \Str::random(32);

        $user->update([
            'email_verification_code' => $emailCode,
            'email_verification_sent_at' => now(),
        ]);

        \Mail::send('emails.verify-email', ['user' => $user, 'code' => $emailCode], function ($message) use ($user) {
            $message->to($user->email)->subject('Verifikasi Email Anda - KADI');
        });

        return back()->with('success', 'Email verifikasi telah dikirim ulang');
    }
}