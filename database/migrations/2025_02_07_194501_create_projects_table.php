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
            $table->unsignedBigInteger(column: 'client_id');
            $table->string('name', '150')->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->string('slug')->unique()->nullable();


            $table->foreign('client_id')->references('id')->on('clients');

            // Agregar índice único sobre customer_id y name
            $table->unique(['client_id', 'name']);
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
