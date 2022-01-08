<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Services\RoleService;
use Illuminate\Support\Facades\View;

class RoleController extends Controller
{
    private $viewDir;
    private $viewFiles;
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->viewDir = 'pages.roles';
        $this->viewFiles = [
            'index' => $this->viewDir . '.index',
            'add' => $this->viewDir . '.add',
            'edit' => $this->viewDir . '.edit',
        ];
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return View::component($this->viewFiles['index'], compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::where('parent_id', 0)
            ->select('id', 'name', 'display_name')
            ->with(['permissionsChildren' => function ($query) {
            }])
            ->get();
        // dd($permissions);
        return View::component($this->viewFiles['add'], compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $this->roleService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $role_permisstions = $role->permissions;
        $permissions = Permission::where('parent_id', 0)
            ->select('id', 'name', 'display_name')
            ->with(['permissionsChildren' => function ($query) {
            }])
            ->get();
        return View::component($this->viewFiles['edit'], compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleService->update($request, $role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
    }
}
