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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('province_id')->constrained('provinces', 'id')->after('region')->nullable();
            $table->foreignId('regency_city_id')->nullable()->constrained('regency_cities', 'id')->after('province_id');
            $table->foreignId('departement_id')->nullable()->constrained('departements', 'id')->after('regency_city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['regency_city_id']);
            $table->dropForeign(['departement_id']);
        });
    }
};
