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
        Schema::create('sub_wilayahs', function (Blueprint $table) {
            $table->id();
            $table->string('sub_wilayah_name');
            $table->integer('qty')->nullable();
            $table->string('satuan')->nullable();
            $table->bigInteger('sub_total');
            $table->string('validasi_isi')->nullable();
            $table->bigInteger('verifikasi');
            $table->string('validasi_total')->nullable();
            $table->bigInteger('total');
            $table->foreignId('wilayah_id')->constrained('wilayahs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_wilayahs');
    }
};
