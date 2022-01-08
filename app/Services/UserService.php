<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\TransactionFunction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    use TransactionFunction;
    public function store(Request $request)
    {
        $store = function () use ($request) {
            $roles =  $request->user_roles;
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->roles()->attach(explode(",", $roles));
        };
        $this->transactionExecWihReq($store);
    }
    public function update(Request $request, User $user)
    {
        $store = function () use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->roles()->sync($request->user_roles);
        };
        $this->transactionExecWihReq($store);
    }
}
