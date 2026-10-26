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
        Schema::table('material_entries', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->after('notes');
            $table->decimal('paid_amount', 15, 2)->default(0)->after('payment_status');
        });

        // Clean up legacy instant-expenses to prevent double accounting
        \App\Models\Expense::where('category', 'Material Procurement')
            ->where('status', 'pending')
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_entries', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'paid_amount']);
        });
    }
};
