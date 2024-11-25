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
        Schema::create('division_imports', function (Blueprint $table) {
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
            $table->foreignId('division_budget_request_id')->constrained('division_budget_requests');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('division_imports');
    }
};
