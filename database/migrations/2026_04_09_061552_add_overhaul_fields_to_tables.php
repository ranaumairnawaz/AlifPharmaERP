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
        // 1. Material Entries Table (for Raw & Packaging multi-product inward)
        Schema::create('material_entries', function (Blueprint $table) {
            $table->id();
            $table->string('slip_number')->unique();
            $table->string('source');
            $table->date('transaction_date');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Stock Movements Update
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->foreignId('material_entry_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('price_per_unit', 15, 2)->nullable();
        });

        // 3. Invoice Items Update
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->foreignId('product_batch_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discount_value', 15, 2)->default(0);
            $table->decimal('gross_amount', 15, 2)->default(0);
        });

        // 4. Inventory Slip Items Update
        Schema::table('inventory_slip_items', function (Blueprint $table) {
            $table->integer('number_of_cartons')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_slip_items', function (Blueprint $table) {
            $table->dropColumn('number_of_cartons');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_batch_id');
            $table->dropColumn(['discount_percentage', 'discount_value', 'gross_amount']);
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('material_entry_id');
            $table->dropColumn('price_per_unit');
        });

        Schema::dropIfExists('material_entries');
    }
};
