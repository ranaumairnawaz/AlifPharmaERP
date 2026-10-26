<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'backup_path' => Setting::get('backup_path'),
            'cloud_backup_enabled' => Setting::get('cloud_backup_enabled', '0'),
            'google_drive_client_id' => Setting::get('google_drive_client_id'),
            'google_drive_client_secret' => Setting::get('google_drive_client_secret'),
            'google_drive_refresh_token' => Setting::get('google_drive_refresh_token'),
            'google_drive_folder_id' => Setting::get('google_drive_folder_id'),
            // Branding Hub
            'company_name' => Setting::get('company_name', 'Alif Pharma'),
            'brand_color' => Setting::get('brand_color', '#0d9488'),
            'pdf_override_colors' => Setting::get('pdf_override_colors', 'false'),
            'company_logo' => Setting::get('company_logo', '/alif-logo.png'),
        ];
        return view('settings.index', $settings);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'backup_path' => 'nullable|string',
            'cloud_backup_enabled' => 'nullable|in:0,1',
            'google_drive_client_id' => 'required_if:cloud_backup_enabled,1|nullable|string',
            'google_drive_client_secret' => 'required_if:cloud_backup_enabled,1|nullable|string',
            'google_drive_refresh_token' => 'required_if:cloud_backup_enabled,1|nullable|string',
            'google_drive_folder_id' => 'nullable|string',
            // Branding Validations
            'company_name' => 'nullable|string|max:255',
            'brand_color' => 'nullable|string|size:7', // Hex format #FFFFFF
            'pdf_override_colors' => 'nullable|in:true,false',
            'company_logo_file' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        // Process Logo Upload
        if ($request->hasFile('company_logo_file')) {
            $path = $request->file('company_logo_file')->store('branding', 'public');
            Setting::set('company_logo', '/storage/' . $path);
        }

        foreach ($data as $key => $value) {
            // Filter out file inputs and internal logic
            if (str_contains($key, 'company_logo_file')) continue;
            
            Setting::set($key, $value ?? ($key === 'cloud_backup_enabled' ? '0' : null));
        }

        // Special case for checkbox if not present
        if (!$request->has('cloud_backup_enabled')) {
            Setting::set('cloud_backup_enabled', '0');
        }

        return back()->with('success', 'Global Identity and Infrastructure settings synchronized successfully.');
    }
}
