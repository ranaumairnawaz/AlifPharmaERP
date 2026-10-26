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
        Schema::create('damage_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('product_batches')->onDelete('cascade');
            $table->decimal('quantity', 10, 3);
            $table->string('reason')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('damage_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('damage_report_id')->constrained('damage_reports')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // The packaging material
            $table->decimal('quantity_returned', 10, 3);
            $table->decimal('unit_cost', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_return_items');
        Schema::dropIfExists('damage_reports');
    }
};
