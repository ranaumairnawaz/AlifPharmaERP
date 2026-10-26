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
        Schema::table('distributors', function (Blueprint $table) {
            $table->string('company_name')->after('id')->nullable();
            $table->string('contact_name')->after('company_name')->nullable();
            $table->string('street_address')->after('phone')->nullable();
            $table->string('city')->after('street_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributors', function (Blueprint $table) {
            //
        });
    }
};
