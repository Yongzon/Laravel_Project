<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'department_id',
        'evaluator_id',
    ];

    public function evaluation() {
        return $this->belongsTo(Evaluation::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function evaluator() {
        return $this->belongsTo(Evaluator::class); 
    }
}
