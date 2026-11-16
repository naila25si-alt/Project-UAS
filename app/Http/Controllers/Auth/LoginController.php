<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Bisa login pakai NIM atau email
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        if (Auth::attempt([$field => $request->login, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors(['login' => 'NIM/Email atau password salah.'])
            ->onlyInput('login');
    }
}
