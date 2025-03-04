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
        Schema::create('project_project_checklist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'project_id');
            $table->unsignedBigInteger(column: 'project_checklist_id');
            $table->integer('orden')->unsigned();
            $table->boolean('completed')->default(value: false);

            $table->foreign(columns: 'project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('project_checklist_id')->references('id')->on('project_checklists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_project_checklist');
    }
};
