<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', [
                'invoice_payment', // Auto-created when invoice paid
                'advance_payment',
                'loan_received',
                'other',
            ])->default('other');
            $table->decimal('amount', 15, 2);
            $table->string('ref_type')->nullable(); // 'Invoice'
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->text('description')->nullable();
            $table->date('income_date');
            $table->enum('status', ['received', 'pending'])->default('received');
            $table->timestamps();
        });

        // Add payment_method to expenses if not already present
        if (Schema::hasTable('expenses') && !Schema::hasColumn('expenses', 'payment_method')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->enum('payment_method', ['cash', 'bank', 'credit', 'other'])->default('cash')->after('status');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
        if (Schema::hasColumn('expenses', 'payment_method')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }
};
