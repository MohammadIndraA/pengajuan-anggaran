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
        Schema::create('sub_components', function (Blueprint $table) {
            $table->id();
            $table->string('sub_component_code');
            $table->string('sub_component_name');
            $table->string('total');
            $table->string('validasi_total');
            $table->foreignId('component_id')->constrained('components');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_components');
    }
};
