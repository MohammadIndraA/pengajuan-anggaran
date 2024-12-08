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
        Schema::table('kppns', function (Blueprint $table) {
            $table->foreignId('sub_poin_sub_component_id')->constrained('sub_poin_sub_components');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kppns', function (Blueprint $table) {
            //
        });
    }
};
