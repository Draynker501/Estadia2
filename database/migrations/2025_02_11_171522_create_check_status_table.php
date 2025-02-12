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
        Schema::create('check_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_checklist_id');
            $table->unsignedBigInteger('check_id');
            $table->boolean('checked')->default(false);

            $table->foreign('project_checklist_id')->references('id')->on('project_checklists');
            $table->foreign('check_id')->references('id')->on('checks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_status');
    }
};
