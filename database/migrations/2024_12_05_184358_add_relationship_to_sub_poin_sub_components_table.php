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
        Schema::table('sub_poin_sub_components', function (Blueprint $table) {
            $table->foreignId('point_sub_component_id')->constrained('point_sub_components');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_poin_sub_components', function (Blueprint $table) {
            //
        });
    }
};
