<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'customer_id');
            $table->string('name', '150');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('slug')->unique()->nullable();


            $table->foreign('customer_id')->references('id')->on('customers');

            // Agregar índice único sobre customer_id y name
            $table->unique(['customer_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
