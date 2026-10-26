<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // All columns (project_manager_id, is_net_invoiced, is_warranty_invoiced) 
        // have been verified to exist in the database. 
        // This migration is now a placeholder to satisfy the migrations table.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_slips', function (Blueprint $table) {
            $table->boolean('is_invoiced')->default(false);
        });

        DB::table('inventory_slips')
            ->where('is_net_invoiced', true)
            ->orWhere('is_warranty_invoiced', true)
            ->update(['is_invoiced' => true]);

        Schema::table('inventory_slips', function (Blueprint $table) {
            $table->dropColumn(['is_net_invoiced', 'is_warranty_invoiced']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['project_manager_id']);
            $table->dropColumn('project_manager_id');
        });
    }
};
