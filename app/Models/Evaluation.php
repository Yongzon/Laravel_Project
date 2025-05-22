<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignTask_id',
        'evaluator_id',
        'evaluation_date',
        'work_quality_score',
        'productivity_score',
        'overall_score',
        'comments',
        'status_id',
    ];

    public function assignTask() {
        return $this->belongsTo(TaskAssignment::class);
    }

    public function evaluator() {
        return $this->belongsTo(Evaluator::class);
    }

    public function evaluationStatus() {
        return $this->belongsTo(EvaluationStatus::class); 
    }
}
