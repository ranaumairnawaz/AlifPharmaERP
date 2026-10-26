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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2);
            $table->string('category')->default('General');
            $table->string('ref_type')->nullable(); // e.g., 'MaterialEntry'
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->text('description')->nullable();
            $table->date('expense_date');
            $table->string('status')->default('paid'); // paid, pending
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
