<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('gerenciar_roles');
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('gerenciar_roles');
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('gerenciar_roles');

        $validated = $request->validate([
            'name'        => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Papel criado com sucesso!');
    }

    public function edit(Role $role)
    {
        $this->authorize('gerenciar_roles');
        $permissions    = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('gerenciar_roles');

        $validated = $request->validate([
            'name'        => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Papel atualizado com sucesso!');
    }

    public function destroy(Role $role)
    {
        $this->authorize('gerenciar_roles');

        if ($role->name === 'admin') {
            return back()->with('error', 'O papel Admin não pode ser excluído!');
        }

        $role->delete();
        return back()->with('success', 'Papel excluído com sucesso!');
    }
}