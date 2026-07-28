<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index ()
    {
        return view('login');
    }

    public function auth (LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {

            $request->session()->regenerate();

            return redirect()->route('dashboard')->with('success', 'Selamat Datang' . Auth::user()->name);
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ]);
    }
}
