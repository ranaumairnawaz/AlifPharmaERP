<?php

namespace App\Http\Controllers;

use App\Models\ProjectManager;
use Illuminate\Http\Request;

class ProjectManagerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:project_managers,name',
        ]);

        $pm = ProjectManager::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'pm' => $pm,
            'message' => 'Personnel added successfully to registry.'
        ]);
    }

    public function destroy(ProjectManager $pm)
    {
        // Prevent deletion if already referenced in invoices? 
        // For now, let's just delete to satisfy user request "allow me to delete".
        $pm->delete();

        return response()->json([
            'success' => true,
            'message' => 'Personnel removed from registry.'
        ]);
    }
}
