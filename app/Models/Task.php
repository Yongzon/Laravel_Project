<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'description',
        'due_date',
        'employee_id',
        'status_id',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function taskStatus() {
        return $this->belongsTo(TaskStatus::class);
    }
}
