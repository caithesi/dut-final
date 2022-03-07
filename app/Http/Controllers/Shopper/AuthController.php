<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function signUp()
    {
        if (Auth::check()) {
            return redirect()->route('shopper-home');
        }
        return View::shopper('shopper.auth.sign-up');
    }

    public function postSignUp(SignupRequest $req)
    {
        if (Auth::check()) {
            return redirect()->route('shopper-home');
        }
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
            ]);
            $role = [2];
            $user->roles()->attach($role);
            DB::commit();
            return response()->json([
                'msg' => [
                    "Welcome to our shop"
                ],
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
        }
    }
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('shopper-home');
        }
        return View::shopper('shopper.auth.login');
    }

    public function postLogin(Request $request)
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
}
