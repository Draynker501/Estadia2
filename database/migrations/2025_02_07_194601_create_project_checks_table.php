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
        Schema::create('project_checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'project_checklist_id');
            $table->string('name', 150);
            $table->boolean('required')->default(false);

            $table->foreign('project_checklist_id')->references('id')->on('project_checklists');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_checks');
    }
};
