<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{
    public function loginAdmin()
    {
        return View::component('AdminLogin');
    }

    public function postLoginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'intended' =>"/"
            ]);
        }


        return response()->json([
            'email' => 'The provided credentials do not match our records.',

        ], 422);
    }

    public function dashboard()
    {
        return View::component('Dashboard');
    }
}
