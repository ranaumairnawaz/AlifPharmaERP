<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Seed accounts permissions: accounts.read, accounts.edit, accounts.delete
        $permissions = [
            ['name' => 'View Accounts Ledger',      'slug' => 'accounts.read',   'module' => 'accounts', 'action' => 'read'],
            ['name' => 'Create/Edit Transactions',   'slug' => 'accounts.edit',   'module' => 'accounts', 'action' => 'edit'],
            ['name' => 'Delete Transactions',        'slug' => 'accounts.delete', 'module' => 'accounts', 'action' => 'delete'],
        ];

        foreach ($permissions as $perm) {
            DB::table('permissions')->updateOrInsert(
                ['slug' => $perm['slug']],
                array_merge($perm, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // Auto-grant accounts permissions to the admin role (slug: 'admin')
        $adminRole = DB::table('roles')->where('slug', 'admin')->first();
        if ($adminRole) {
            $permIds = DB::table('permissions')
                ->whereIn('slug', ['accounts.read', 'accounts.edit', 'accounts.delete'])
                ->pluck('id');

            foreach ($permIds as $permId) {
                DB::table('permission_role')->updateOrInsert(
                    ['permission_id' => $permId, 'role_id' => $adminRole->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }

    public function down(): void
    {
        DB::table('permissions')->whereIn('slug', [
            'accounts.read', 'accounts.edit', 'accounts.delete'
        ])->delete();
    }
};
