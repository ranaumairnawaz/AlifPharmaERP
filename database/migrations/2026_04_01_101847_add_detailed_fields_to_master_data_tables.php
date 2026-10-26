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
        Schema::table('brands', function (Blueprint $table) {
            $table->string('website')->nullable()->after('description');
            $table->string('contact_person')->nullable()->after('website');
            $table->string('phone')->nullable()->after('contact_person');
            $table->string('country_of_origin')->nullable()->after('phone');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('description');
        });

        Schema::table('units', function (Blueprint $table) {
            $table->text('description')->nullable()->after('short_name');
            $table->boolean('is_active')->default(true)->after('is_decimal');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['website', 'contact_person', 'phone', 'country_of_origin']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn(['description', 'is_active']);
        });
    }
};
