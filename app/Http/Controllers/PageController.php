<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        return Inertia::render('Home', [
            'auth' => [
                'user' => Auth::check() ? [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ] : null,
            ],
        ]);
    }

    public function login()
    {
        // Если уже авторизован, можно сразу редиректить на главную
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return Inertia::render('Auth/Login', [
            'auth' => ['user' => null],
        ]);
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return Inertia::render('Auth/Register', [
            'auth' => ['user' => null],
        ]);
    }

    public function userProfile()
    {
        return Inertia::render('User/Profile', [
            'auth' => [
                'user' => Auth::check() ? [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ] : null,
            ],
        ]);
    }
}
