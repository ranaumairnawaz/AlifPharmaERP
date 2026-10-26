<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_slips', function (Blueprint $table) {
            $table->id();
            $table->string('slip_number')->unique(); // AP000## format
            $table->foreignId('distributor_id')->constrained()->onDelete('cascade');
            $table->date('transaction_date');
            $table->text('notes')->nullable();
            $table->string('status')->default('completed'); // Default is completed for immediate stock action
            $table->timestamps();
        });

        Schema::create('inventory_slip_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_slip_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_cartons')->default(0);
            $table->integer('quantity_pieces')->default(0);
            $table->integer('total_pieces_deducted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_slip_items');
        Schema::dropIfExists('inventory_slips');
    }
};
