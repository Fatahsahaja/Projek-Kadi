<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\NisTemplate;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name'     => ['required', 'string', 'max:255'],
        'nis'      => ['nullable', 'string', 'exists:nis_templates,nis'], // ← cek ke tabel template
        'phone'    => ['required', 'string', 'max:20'], // tambah ini
        'email'    => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

     $nisData = null;
    if ($request->nis) {
        $nisData = NisTemplate::where('nis', $request->nis)->first();
    }

    $user = User::create([
        'name'     => $request->name,
        'nis'      => $request->nis ?? null,
        'kelas'    => $nisData?->kelas ?? null,
        'jurusan'  => $nisData?->jurusan ?? null,
        'phone'    => $request->phone,
        'email'    => $request->phone . '@kadi.local',
        'password' => Hash::make($request->password),
        'role'     => 'customer',
    ]);

    event(new Registered($user));

    Auth::login($user);
    return redirect(route('dashboard', absolute: false));
}
}
