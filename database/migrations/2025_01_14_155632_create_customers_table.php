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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string(column: 'name',length: '20');
            $table->string(column: 'last_name',length: '30');
            $table->string(column: 'phone',length: '15')->unique();
            $table->string(column: 'email',length: '50')->unique();
            $table->boolean(column: 'status')->default(true);
            $table->string('slug')->unique()->nullable();


            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            // $table->softDeletes(); // Adds 'deleted_at' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
