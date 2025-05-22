<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
        'description',
        'employee_id',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class); 
    }
}
