<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->get();
        return view('units.index', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'is_decimal' => 'boolean',
        ]);

        Unit::create($validated);

        return redirect()->route('units.index');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'is_decimal' => 'boolean',
            'is_active' => 'required|boolean',
        ]);

        $unit->update($validated);

        return redirect()->route('units.index');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index');
    }
}
