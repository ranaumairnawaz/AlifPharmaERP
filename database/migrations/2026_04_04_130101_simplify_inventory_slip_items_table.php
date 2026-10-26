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
        Schema::table('inventory_slip_items', function (Blueprint $table) {
            $table->integer('quantity')->default(0)->after('product_id');
            $table->integer('quantity_cartons')->nullable()->change();
            $table->integer('quantity_pieces')->nullable()->change();
            $table->integer('total_pieces_deducted')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_slip_items', function (Blueprint $table) {
            //
        });
    }
};
