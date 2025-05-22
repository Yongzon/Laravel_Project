<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function getDepartments()
    {
        $departments = Department::with('employee')->get();
        return response()->json(['departments'  => $departments]);
    }

    public function addDepartment(Request $request)
    {
        $validatedData = $request->validate([
            'department_name' => 'required|string|max:255',
            'description' => 'required|string',
            'employee_id' => 'required|exists:employees,id'
        ]);

        $department = Department::create($validatedData);
        
        return response()->json([
            'message' => 'Department created successfully',
            'department' => $department
        ], 201);
    }

    public function editDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validatedData = $request->validate([
            'department_name' => 'required|string|max:255',
            'description' => 'required|string',
            'employee_id' => 'required|exists:employees,id'
        ]);

        $department->update($validatedData);
        
        return response()->json([
            'message' => 'Department updated successfully',
            'department' => $department
        ]);
    }

    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        
        return response()->json([
            'message' => 'Department deleted successfully'
        ]);
    }
}