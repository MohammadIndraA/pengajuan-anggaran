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
        Schema::create('departement_imports', function (Blueprint $table) {
            $table->id();
            $table->integer('no');
            $table->string('program');
            $table->string('activity');
            $table->string('kro');
            $table->string('ro');
            $table->string('unit');
            $table->string('component');
            $table->integer('qty');
            $table->integer('subtotal');
            $table->integer('total');
            $table->foreignId('departement_budget_request_id')->constrained('departement_budget_requests', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departement_imports');
    }
};
