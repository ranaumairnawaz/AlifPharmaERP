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
            $table->date('expiry_date')->nullable()->after('sale_price');
            
            // Performance Indexes for high-speed catalog filtering
            $table->index('brand_id');
            $table->index('category_id');
            $table->index('material_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['brand_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['material_type']);
            $table->dropColumn('expiry_date');
        });
    }
};
