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
        Schema::table('products', function (Blueprint $table) {
            // Rename old link to brands (now groups)
            $table->renameColumn('brand_id', 'group_id');
            // Add new link to brands (child of groups)
            $table->foreignId('brand_id')->nullable()->after('description')->constrained('brands')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('brand_id');
            $table->renameColumn('group_id', 'brand_id');
        });
    }
};
