<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EvaluatorController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\EvaluationStatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::put('/reset-password/{id}', [AuthenticationController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function(){
    // Authentcation
    
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // Employee
    Route::get('/get-employees', [EmployeeController::class, 'getEmployees']);
    Route::post('/add-employee', [EmployeeController::class, 'addEmployee']);
    Route::put('/edit-employee/{id}', [EmployeeController::class, 'editEmployee']);
    Route::delete('/delete-employee/{id}', [EmployeeController::class, 'deleteEmployee']);

    // Department
    Route::get('/get-departments', [DepartmentController::class, 'getDepartments']);
    Route::post('/add-department', [DepartmentController::class, 'addDepartment']);
    Route::put('/edit-department/{id}', [DepartmentController::class, 'editDepartment']);
    Route::delete('/delete-department/{id}', [DepartmentController::class, 'deleteDepartment']);

    // Evaluation Report
    Route::get('/get-evaluation-reports', [EvaluationReportController::class, 'getEvaluationReports']);
    Route::post('/add-evaluation-report', [EvaluationReportController::class, 'addEvaluationReport']);
    Route::put('/edit-evaluation-report/{id}', [EvaluationReportController::class, 'editEvaluationReport']);
    Route::delete('/delete-evaluation-report/{id}', [EvaluationReportController::class, 'deleteEvaluationReport']);

    // Evaluator
    Route::get('/get-evaluators', [EvaluatorController::class, 'getEvaluators']);
    Route::post('/add-evaluator', [EvaluatorController::class, 'addEvaluator']);
    Route::put('/edit-evaluator/{id}', [EvaluatorController::class, 'editEvaluator']);
    Route::delete('/delete-evaluator/{id}', [EvaluatorController::class, 'deleteEvaluator']);

    // Evaluation
    Route::get('/get-evaluations', [EvaluationController::class, 'getEvaluations']);
    Route::post('/add-evaluation', [EvaluationController::class, 'addEvaluation']);
    Route::put('/edit-evaluation/{id}', [EvaluationController::class, 'editEvaluation']);
    Route::delete('/delete-evaluation/{id}', [EvaluationController::class, 'deleteEvaluation']);

    // Evaluation Status
    Route::get('/get-evaluation-statuses', [EvaluationStatusController::class, 'getEvaluationStatuses']);
    Route::post('/add-evaluation-status', [EvaluationStatusController::class, 'addEvaluationStatus']);
    Route::put('/edit-evaluation-status/{id}', [EvaluationStatusController::class, 'editEvaluationStatus']);
    Route::delete('/delete-evaluation-status/{id}', [EvaluationStatusController::class, 'deleteEvaluationStatus']);

    // User
    Route::get('/get-users', [UserController::class, 'getUsers']);
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);

     // Task
     Route::get('/get-tasks', [TaskController::class, 'getTasks']);
     Route::post('/add-task', [TaskController::class, 'addTask']);
     Route::put('/edit-task/{id}', [TaskController::class, 'editTask']);
     Route::delete('/delete-task/{id}', [TaskController::class, 'deleteTask']);
     Route::put('/assign-task/{id}', [TaskController::class, 'assignTask']);
     Route::put('/replace-task/{id}', [TaskController::class, 'replaceTask']);
     Route::put('/remove-task/{id}', [TaskController::class, 'removeTask']);
     Route::put('/complete-task/{id}', [TaskController::class, 'completeTask']);

      // Task Assignment
    Route::get('/get-taskassignments', [TaskAssignmentController::class, 'getTaskAssignments']);
    Route::post('/add-taskassignment', [TaskAssignmentController::class, 'addTaskAssignment']);
    Route::put('/edit-taskassignment/{id}', [TaskAssignmentController::class, 'editTaskAssignment']);
    Route::delete('/delete-taskassignment/{id}', [TaskAssignmentController::class, 'deleteTaskAssignment']);

     // Role
    Route::get('/get-roles', [RoleController::class, 'getRoles']);
    Route::post('/add-role', [RoleController::class, 'addRole']);
    Route::put('/edit-role/{id}', [RoleController::class, 'editRole']);
    Route::delete('/delete-role/{id}', [RoleController::class, 'deleteRole']);

    // User Status
    Route::get('/get-user-statuses', [UserStatusController::class, 'getUserStatuses']);
    Route::post('/add-user-status', [UserStatusController::class, 'addUserStatus']);
    Route::put('/edit-user-status/{id}', [UserStatusController::class, 'editUserStatus']);
    Route::delete('/delete-user-status/{id}', [UserStatusController::class, 'deleteUserStatus']);

    // Task Status
    Route::get('/get-task-statuses', [TaskStatusController::class, 'getTaskStatuses']);
    Route::post('/add-task-status', [TaskStatusController::class, 'addTaskStatus']);
    Route::put('/edit-task-status/{id}', [TaskStatusController::class, 'editTaskStatus']);
    Route::delete('/delete-task-status/{id}', [TaskStatusController::class, 'deleteTaskStatus']);
});
