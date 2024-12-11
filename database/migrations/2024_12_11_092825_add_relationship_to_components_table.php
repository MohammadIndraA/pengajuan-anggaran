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
        Schema::table('components', function (Blueprint $table) {
            $table->foreignId('kro_id')->constrained('kros');
            $table->foreignId('ro_id')->constrained('ros');
            $table->foreignId('program_id')->constrained('programs');
            $table->foreignId('activity_id')->constrained('activities');
            $table->foreignId('satker_id')->constrained('satkers');
            $table->foreignId('regency_budget_request_id')->nullable()->constrained('regency_budget_requests');
            $table->foreignId('division_budget_request_id')->nullable()->constrained('division_budget_requests');
            $table->foreignId('province_budget_request_id')->nullable()->constrained('province_budget_requests');
            $table->foreignId('departement_budget_request_id')->nullable()->constrained('departement_budget_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('components', function (Blueprint $table) {
            //
        });
    }
};
