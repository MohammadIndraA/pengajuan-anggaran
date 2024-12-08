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
        Schema::create('sub_poin_sub_kppns', function (Blueprint $table) {
            $table->id();
            $table->string('sub_poin_sub_kppn_name');
            $table->string('subtotal');
            $table->string('satuan')->nullable();
            $table->string('budget');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_poin_sub_kppns');
    }
};
