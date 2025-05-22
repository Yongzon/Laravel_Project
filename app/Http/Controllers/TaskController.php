<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;
use App\Models\TaskStatus;

class TaskController extends Controller
{
    public function getTasks()
    {
        $tasks = Task::with(['employee', 'taskStatus'])->get();
        return response()->json(['tasks' => $tasks]);
    }

    public function addTask(Request $request)
    {
        $id = Auth::id();
        $tasks = $request->all();

        if (isset($tasks[0])) {
            $createdTasks = [];

            foreach ($tasks as $taskData) {
                $validator = Validator::make($taskData, [
                    'task_name' => ['required', 'string', 'max:255'],
                    'description' => ['required', 'string', 'max:255'],
                    'due_date' => ['required', 'date'],
                    'employee_id' => ['exists:employees,id'],
                    'status_id' => ['required', 'exists:task_statuses,id'],
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $task = Task::create([
                    'task_name' => $taskData['task_name'],
                    'description' => $taskData['description'],
                    'due_date' => $taskData['due_date'],
                    'employee_id' => $taskData['employee_id'] ?? null,
                    'status_id' => $taskData['status_id'],
                ]);

                $createdTasks[] = $task;
            }

            return response()->json(['message' => 'Tasks Created Successfully!', 'tasks' => $createdTasks]);
        } else {
            $request->validate([
                'task_name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
                'due_date' => ['required', 'date'],
                'employee_id' => ['exists:employees,id'],
                'status_id' => ['required', 'exists:task_statuses,id'],
            ]);

            $task = Task::create([
                'task_name' => $request->task_name,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'employee_id' => $request->employee_id ?? null,
                'status_id' => $request->status_id,
            ]);

            return response()->json(['message' => 'Task added successfully!', 'task' => $task]);
        }
    }

    public function assignTask(Request $request, $id)
    {
        $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
        ]);

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update([
            'employee_id' => $request->employee_id,
        ]);

        return response()->json(['message' => 'Task assigned successfully!', 'task' => $task]);
    }

    public function replaceTask(Request $request, $id)
    {
        $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
        ]);

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update([
            'employee_id' => $request->employee_id,
        ]);

        return response()->json(['message' => 'Task replaced successfully!', 'task' => $task]);
    }

    public function removeTask($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update([
            'employee_id' => null,
        ]);

        return response()->json(['message' => 'Task removed successfully!', 'task' => $task]);
    }

    public function editTask(Request $request, $id)
    {
        $request->validate([
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'due_date' => ['required', 'date'],
            'employee_id' => ['nullable', 'exists:employees,id'],
            'status_id' => ['required', 'exists:task_statuses,id'],
        ]);

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'employee_id' => $request->employee_id,
            'status_id' => $request->status_id,
        ]);

        return response()->json(['message' => 'Task updated successfully!', 'task' => $task]);
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully!']);
    }

    public function completeTask($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        
        $task->update([
            'status_id' => 3,
        ]);

        return response()->json(['message' => 'Task completed!', 'task' => $task]);
    }
}