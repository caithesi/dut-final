<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function loginAdmin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return View::component('pages.admin.login');
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
                'intended' => "/"
            ]);
        }


        return response()->json([
            'errors' => [
                'email' => 'The provided credentials do not match our records.',
            ],
        ], 422);
    }

    public function dashboard()
    {
        return View::component('pages.dashboard');
    }
}
