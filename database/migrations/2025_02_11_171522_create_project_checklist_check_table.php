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
        Schema::create('project_checklist_check', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_checklist_rel_id');
            $table->unsignedBigInteger('project_check_id');
            $table->boolean('checked')->default(false);

            $table->foreign('project_checklist_rel_id')->references('id')->on('project_checklist_rel')->constrained()->onDelete('cascade');
            $table->foreign('project_check_id')->references('id')->on('project_checks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_checklist_check');
    }
};
