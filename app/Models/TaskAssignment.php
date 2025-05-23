<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'employee_id',
    ];

    public function task() {
        return $this->belongsTo(Task::class);
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
