<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\EvaluationStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluation_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $evaluationStatuses = [
            ['name' => 'Pending'],
            ['name' => 'Active'],
            ['name' => 'Completed'],
        ];

        foreach($evaluationStatuses as $evaluationStatus) {
            EvaluationStatus::create($evaluationStatus);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_statuses');
    }
};
