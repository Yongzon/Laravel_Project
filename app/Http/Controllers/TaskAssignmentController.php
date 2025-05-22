<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\TaskAssignment;
use App\Models\Task;
use App\Models\Employee;

class TaskAssignmentController extends Controller
{
    public function getTaskAssignments()
    {
        $assignments = TaskAssignment::with(['task', 'employee'])->get();
        return response()->json(['assignments' => $assignments]);
    }

    public function addTaskAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => ['required', 'exists:tasks,id'],
            'employee_id' => ['required', 'exists:employees,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $existingAssignment = TaskAssignment::where('task_id', $request->task_id)
            ->where('employee_id', $request->employee_id)
            ->first();

        if ($existingAssignment) {
            return response()->json(['message' => 'This task is already assigned to this employee'], 400);
        }

        $assignment = TaskAssignment::create([
            'task_id' => $request->task_id,
            'employee_id' => $request->employee_id,
        ]);

        return response()->json([
            'message' => 'Task assignment created successfully!',
            'assignment' => $assignment->load(['task', 'employee'])
        ]);
    }

    public function editTaskAssignment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => ['required', 'exists:tasks,id'],
            'employee_id' => ['required', 'exists:employees,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $assignment = TaskAssignment::find($id);

        if (!$assignment) {
            return response()->json(['message' => 'Task assignment not found'], 404);
        }

        $existingAssignment = TaskAssignment::where('task_id', $request->task_id)
            ->where('employee_id', $request->employee_id)
            ->where('id', '!=', $id)
            ->first();

        if ($existingAssignment) {
            return response()->json(['message' => 'This task is already assigned to this employee'], 400);
        }

        $assignment->update([
            'task_id' => $request->task_id,
            'employee_id' => $request->employee_id,
        ]);

        return response()->json([
            'message' => 'Task assignment updated successfully!',
            'assignment' => $assignment->fresh(['task', 'employee'])
        ]);
    }

    public function deleteTaskAssignment($id)
    {
        $assignment = TaskAssignment::find($id);

        if (!$assignment) {
            return response()->json(['message' => 'Task assignment not found'], 404);
        }

        $assignment->delete();

        return response()->json(['message' => 'Task assignment deleted successfully!']);
    }
}