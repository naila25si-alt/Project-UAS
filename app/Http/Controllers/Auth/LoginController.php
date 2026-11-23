<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): RedirectResponse|View
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:admin,mahasiswa'],
        ]);

        // Admin masuk dengan email, mahasiswa bisa memakai NIM atau email.
        $field = $request->role === 'admin'
            ? 'email'
            : (filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim');

        if (Auth::attempt([
            $field => $request->login,
            'password' => $request->password,
            'role' => $request->role,
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors(['login' => 'Email/NIM atau password tidak cocok dengan jenis akun yang dipilih.'])
            ->onlyInput('login', 'role');
    }
}
