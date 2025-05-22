<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluator;
use Illuminate\Support\Facades\Validator;

class EvaluatorController extends Controller
{
    public function getEvaluators()
    {
        $evaluators = Evaluator::with('user', 'role', 'userStatus')->get();
        return response()->json(['evaluators' => $evaluators]);
    }

    public function addEvaluator(Request $request)
    {
        $evaluators = $request->all();

        if (isset($evaluators[0])) {
            $createdEvaluators = [];

            foreach ($evaluators as $evaluatorData) {
                $validator = Validator::make($evaluatorData, [
                    'role_id' => ['required', 'exists:roles,id'],
                    'status_id' => ['required', 'exists:user_statuses,id'],
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $evaluator = Evaluator::create([
                    'user_id' => $evaluatorData['user_id'],
                    'role_id' => $evaluatorData['role_id'],
                    'status_id' => $evaluatorData['status_id'],
                ]);

                $createdEvaluators[] = $evaluator;
            }

            return response()->json([
                'message' => 'Evaluators successfully added!',
                'evaluators' => $createdEvaluators
            ]);
        } else {
            $request->validate([
                'user_id' => ['required', 'exists:users,id'],
                'role_id' => ['required', 'exists:roles,id'],
                'status_id' => ['required', 'exists:user_statuses,id'],
            ]);

            $evaluator = Evaluator::create([
                'user_id' => $request->user_id,
                'role_id' => $request->role_id,
                'status_id' => $request->status_id,
            ]);

            return response()->json([
                'message' => 'Evaluator added successfully!',
                'evaluator' => $evaluator
            ]);
        }
    }

    public function updateEvaluator(Request $request, $id)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $evaluator = Evaluator::find($id);

        if (!$evaluator) {
            return response()->json(['message' => 'Evaluator not found.'], 404);
        }

        $evaluator->update([
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Evaluator updated successfully!',
            'evaluator' => $evaluator
        ]);
    }

    public function editEvaluator(Request $request, $id)
    {
        $request->validate([
            'role_id' => ['nullable', 'exists:roles,id'],
            'status_id' => ['nullable', 'exists:user_statuses,id'],
        ]);

        $evaluator = Evaluator::find($id);

        if (!$evaluator) {
            return response()->json(['message' => 'Evaluator not found.'], 404);
        }

        $evaluator->update([
            'role_id' => $request->role_id,
            'status_id' => $request->status_id,
        ]);

        return response()->json([
            'message' => 'Evaluator successfully edited!',
            'evaluator' => $evaluator
        ]);
    }

    public function deleteEvaluator($id)
    {
        $evaluator = Evaluator::find($id);

        if (!$evaluator) {
            return response()->json(['message' => 'Evaluator not found.'], 404);
        }

        $evaluator->delete();

        return response()->json(['message' => 'Evaluator successfully deleted!']);
    }
}