<?php

namespace App\Services;

use App\Traits\TransactionFunction;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleService
{
    use TransactionFunction;
    public function store(Request $request)
    {
        $store = function () use ($request) {
            $role = Role::create([
                'name' => $request->role_name,
                'display_name' => $request->display_name,
            ]);
            $role->permissions()->attach(explode(",", $request->permissions));
        };
        $this->transactionExecWihReq($store);
    }
    public function update(Request $request, Role $role)
    {
        $store = function () use ($request, $role) {
            $role->update([
                'name' => $request->role_name,
                'display_name' => $request->display_name,
            ]);
            $role->permissions()->sync($request->permissions);
        };
        $this->transactionExecWihReq($store);
    }

    public function update2(Request $request, Role $role)
    {
        $store = function () use ($request, $role) {
            $role->update([
                'name' => $request->role_name,
                'display_name' => $request->display_name,
            ]);
            $role->permissions()->sync($request->permissions);
        };
        return $store;
    }
}
