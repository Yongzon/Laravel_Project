<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;
use App\Models\UserStatus;
use Illuminate\Support\Facades\Validator; 

class EmployeeController extends Controller
{
    public function getEmployees(){ 
        $employees = Employee::with('user', 'role', 'userStatus')->get();

        return response()->json(['employees' => $employees]); 
    }

    public function addEmployee(Request $request){
        $employees = $request->all();

        if(isset($employees[0])){
            $createdEmployees = [];

            foreach($employees as $employeeData){
                $validator = Validator::make($employeeData,[
                    'role_id' => ['required', 'exists:roles,id'], 
                    'status_id' => ['required', 'exists:user_statuses,id'],
                ]);

                if($validator->fails()){
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $employee = Employee::create([
                    'user_id' => $employeeData['user_id'], 
                    'role_id' => $employeeData['role_id'], 
                    'status_id' => $employeeData['status_id'],
                ]);

                $createdEmployees[] = $employee;
            }

            return response()->json(['message' => 'Employee Successfully Added!', 'employees' => $createdEmployees]);
        } else {
            $request->validate([
                'user_id' => ['required', 'exists:users,id'],
                'role_id' => ['required', 'exists:roles,id'],
                'status_id' => ['required', 'exists:user_statuses,id'], 
            ]);

            $employee = Employee::create([
                'user_id' => $request->user_id, 
                'role_id' => $request->role_id,
                'status_id' => $request->status_id,
            ]);
            return response()->json(['message' => 'Employee added successfully!', 'employee' => $employee]); 
        }
    }


    public function updateEmployee(Request $request, $id) {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $employee = Employee::find($id);

        if(!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $employee->update([
            'user_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Employee Updated successfully!', 'employee' => $employee]); 
    }

    public function editEmployee(Request $request, $id) {
        $request->validate([
            'role_id' => ['nullable', 'exists:roles,id'],
            'status_id' => ['nullable', 'exists:user_statuses,id'],
        ]);

        $employee = Employee::find($id);

        if(!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $employee->update([
            'role_id' => $request->role_id,
            'status_id' => $request->status_id,
        ]);

        return response()->json(['message' => 'Employee successfully edited!', 'employee' => $employee]);
    }

    public function deleteEmployee($id) {
        $employee = Employee::find($id); 

        if(!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee successfully deleted!']);
    }
}