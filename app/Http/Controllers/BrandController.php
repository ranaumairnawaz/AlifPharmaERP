<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Group;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('group')->latest()->get();
        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        $groups = Group::orderBy('name')->get();
        return view('brands.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group_id' => 'required|exists:groups,id',
        ]);

        Brand::create($validated);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        $groups = Group::orderBy('name')->get();
        return view('brands.edit', compact('brand', 'groups'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group_id' => 'required|exists:groups,id',
        ]);

        $brand->update($validated);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}
