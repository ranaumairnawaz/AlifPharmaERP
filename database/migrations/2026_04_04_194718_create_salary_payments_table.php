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
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('payment_month'); // e.g. 2024-03
            $table->decimal('base_salary', 15, 2);
            $table->integer('off_days')->default(0);
            $table->decimal('off_days_deduction', 15, 2)->default(0);
            $table->decimal('manual_adjustment', 15, 2)->default(0);
            $table->string('adjustment_note')->nullable();
            $table->decimal('net_salary', 15, 2);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_payments');
    }
};
