<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::latest()->get();
        return view('groups.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|string', // Simple string for now, can be file upload later
            'website' => 'nullable|string|url|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country_of_origin' => 'nullable|string|max:100',
        ]);

        Group::create($validated);

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    public function edit(Group $group)
    {
        return view('groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'website' => 'nullable|string|url|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country_of_origin' => 'nullable|string|max:100',
        ]);

        $group->update($validated);

        return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }
}
