<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ACLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Define Modules & Actions
        $modules = [
            'products', 'batches', 'slips', 'invoices', 'distributors', 
            'roles', 'users', 'discards', 'settings', 'activities',
            'groups', 'brands', 'categories', 'units', 'reports', 'employees', 'salaries', 'damages'
        ];
        $actions = ['read', 'edit', 'delete'];

        // 2. Create Permissions
        $permissionIds = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permission = Permission::updateOrCreate(
                    ['slug' => "{$module}.{$action}"],
                    [
                        'name' => Str::title($action) . ' ' . Str::title($module),
                        'module' => $module,
                        'action' => $action,
                    ]
                );
                $permissionIds[$module][$action] = $permission->id;
            }
        }

        // 3. Create Roles & Assign Permissions
        
        // ADMIN: Full System Control
        $admin = Role::where('slug', 'admin')->orWhere('slug', 'administrator')->orWhere('name', 'Administrator')->first();
        if (!$admin) {
            $admin = Role::create([
                'slug' => 'admin', 
                'name' => 'Administrator', 
                'description' => 'Unrestricted access to all core and financial modules.'
            ]);
        } else {
            $admin->update([
                'slug' => 'admin', // Standardize to 'admin'
                'name' => 'Administrator',
                'description' => 'Unrestricted access to all core and financial modules.'
            ]);
        }
        $admin->permissions()->sync(Permission::pluck('id'));

        // ACCOUNTS MANAGER: Financial & Partner Expert
        $accounts = Role::updateOrCreate(
            ['slug' => 'accounts'],
            ['name' => 'Accounts Manager', 'description' => 'Authority over invoicing, partner records, and financial reporting.']
        );
        // Accounts can Read All, Edit Slips/Invoices/Distributors
        $accountsPerms = [
            'products.read', 'batches.read', 'slips.read', 'slips.edit', 
            'invoices.read', 'invoices.edit', 'invoices.delete',
            'distributors.read', 'distributors.edit', 'discards.read'
        ];
        $accounts->permissions()->sync(Permission::whereIn('slug', $accountsPerms)->pluck('id'));

        // LOGISTICS MANAGER: Operational Control
        $logistics = Role::updateOrCreate(
            ['slug' => 'manager'],
            ['name' => 'Logistics Manager', 'description' => 'Operations lead for stock, production batches, and dispatch manifests.']
        );
        $logisticsPerms = [
            'products.read', 'products.edit', 'batches.read', 'batches.edit', 'batches.delete',
            'slips.read', 'slips.edit', 'slips.delete', 'distributors.read', 'discards.read', 'discards.edit', 'discards.delete'
        ];
        $logistics->permissions()->sync(Permission::whereIn('slug', $logisticsPerms)->pluck('id'));

        // STAFF: Read-Only Visibility
        $staff = Role::updateOrCreate(
            ['slug' => 'staff'],
            ['name' => 'Field Staff', 'description' => 'Standard access for viewing inventory status and loading sheets.']
        );
        $staff->permissions()->sync(Permission::where('action', 'read')->pluck('id'));

        // 4. Update Existing Users (Migration Logic)
        $users = User::all();
        foreach ($users as $user) {
            // Map old role field to new role_id
            $roleSlug = $user->role ?: 'staff'; // default to staff
            if ($roleSlug === 'admin') $newRole = $admin;
            elseif ($roleSlug === 'manager') $newRole = $logistics;
            elseif ($roleSlug === 'accounts') $newRole = $accounts;
            else $newRole = $staff;

            $user->update(['role_id' => $newRole->id]);
        }
    }
}
