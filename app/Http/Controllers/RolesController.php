<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('permissions', 'users')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('module');
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Custom role defined and permissions synchronized.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('module');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array'
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Role profile and access matrix updated.');
    }

    public function destroy(Role $role)
    {
        if ($role->slug === 'admin') {
            return back()->with('error', 'The Administrator role is immutable.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'Cannot delete a role with active users assigned.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role purged from security records.');
    }
}
