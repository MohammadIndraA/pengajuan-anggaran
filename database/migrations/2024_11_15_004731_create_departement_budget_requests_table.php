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
        Schema::create('departement_budget_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('budget');
            $table->string('deskription');
            $table->string('submission_name');
            $table->date('submission_date');
            $table->foreignId('funding_source_id')->constrained('funding_source');
            $table->foreignId('program_id')->constrained('programs');
            $table->text('evidence_file');
            $table->string('status')->default('pending');
            $table->integer('is_imported');
            $table->foreignId('regency_city_id')->constrained('regency_cities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departement_budget_requests');
    }
};
