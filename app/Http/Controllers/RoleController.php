<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;  
use Inertia\Inertia;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','show']]);
    //     $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $roles = Role::with('permissions')->get();

        return Inertia::render('roles/RoleIndex', [
            'roles' => $roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'permissions' => $role->permissions->pluck('name'),
                ];
            }),
        ]);
    }

    public function create()
    {
        $permissions = Permission::pluck('name');
        return Inertia::render('roles/CreateRole', [
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name'),
            ],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ], [
            'permissions.required' => 'Please select at least one permission.',
            'permissions.min' => 'Please select at least one permission.',
            'permissions.*.exists' => 'One or more selected permissions is invalid.',
        ]);
    
        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);
    
        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function show(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return Inertia::render('roles/ShowRole', [
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name'),
            ],
        ]);
    }

    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $allPermissions = Permission::pluck('name');
        $assigned = $role->permissions->pluck('name');

        return Inertia::render('roles/EditRole', [
            'role' => $role,
            'permissions' => $allPermissions,
            'assigned' => $assigned,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required','string','max:255', Rule::unique('roles','name')->ignore($role->id)],
            'permissions' => ['required','array','min:1'],
            'permissions.*' => ['string','exists:permissions,name'],
        ], [
            'permissions.required' => 'Select at least one permission.',
            'permissions.min' => 'Select at least one permission.',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}