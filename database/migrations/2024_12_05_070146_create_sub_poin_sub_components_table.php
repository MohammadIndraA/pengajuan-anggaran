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
        Schema::create('sub_poin_sub_components', function (Blueprint $table) {
            $table->id();
            $table->string('sub_poin_sub_component_code');
            $table->string('sub_poin_sub_component_name');
            $table->string('budget');
            $table->string('komponen_utama')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_poin_sub_components');
    }
};