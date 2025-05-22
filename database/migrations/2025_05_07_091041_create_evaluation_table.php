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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignTask_id')->constrained('task_assignments')->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('evaluators')->onDelete('cascade');
            $table->date('evaluation_date');
            $table->string('work_quality_score');
            $table->string('productivity_score');
            $table->string('overall_score');
            $table->string('comments');
            $table->foreignId('status_id')->constrained('evaluation_statuses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
