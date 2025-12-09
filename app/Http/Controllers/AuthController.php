<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            // возврат с ошибкой валидации — Inertia положит её в props.errors
            return back()->withErrors(['email' => 'Неверный email или пароль'])->withInput();
        }

        $request->session()->regenerate();

        // редирект на домашнюю — Inertia выполнит переход и подгрузит auth.user
        return redirect()->intended(route('home'));
    }

    public function register(SignupRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // API helper (уже был)
    public function user(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }
}
