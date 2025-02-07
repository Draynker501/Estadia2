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
        Schema::create('project_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'project_id');
            $table->unsignedBigInteger(column: 'checklist_id');
            $table->integer('orden');

            $table->foreign(columns: 'project_id')->references('id')->on('projects');
            $table->foreign('checklist_id')->references('id')->on('checklists');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_checklists');
    }
};
