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
        Schema::create('province_budget_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('budget');
            $table->string('deskription');
            $table->string('submission_name');
            $table->date('submission_date');
            $table->foreignId('funding_source_id')->nullable()->constrained('funding_source');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->text('evidence_file');
            $table->string('status')->default('pending');
            $table->integer('is_imported');
            $table->foreignId('province_id')->constrained('provinces');
            $table->foreignId('proposal_file_id')->nullable()->constrained('proposal_files');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('province_budget_requests');
    }
};
