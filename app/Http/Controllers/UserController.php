<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the staff members.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        $roles = \App\Models\Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,slug',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Staff member onboarded successfully.');
    }

    /**
     * Show the form for editing the specified user's role.
     */
    public function edit(User $user)
    {
        $roles = \App\Models\Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user's role in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,slug',
        ]);

        // Prevent admin from demoting themselves if they are the only admin
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'You cannot demote yourself from Admin status.');
        }

        $user->update(['role' => $request->role]);

        return redirect()->route('users.index')->with('success', "User role updated to " . ucfirst($request->role));
    }

    /**
     * Remove the specified user from the system.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User access revoked successfully.');
    }
}
