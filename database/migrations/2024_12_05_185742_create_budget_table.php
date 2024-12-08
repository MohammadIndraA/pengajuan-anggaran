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
        Schema::create('budget', function (Blueprint $table) {
            $table->id();
            $table->string('budget');
            $table->foreignId('kro_id')->nullable()->constrained('kros');
            $table->foreignId('ro_id')->nullable()->constrained('ros');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('activity_id')->nullable()->constrained('activities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget');
    }
};
