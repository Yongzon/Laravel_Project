<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\EvaluationStatus;

class EvaluationStatusController extends Controller
{
    public function getEvaluationStatuses()
    {
        $statuses = EvaluationStatus::all();
        return response()->json(['evaluation_statuses' => $statuses]);
    }

    public function addEvaluationStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $status = EvaluationStatus::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Evaluation status created successfully!',
            'evaluation_status' => $status
        ], 201);
    }

    public function editEvaluationStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $status = EvaluationStatus::find($id);

        if (!$status) {
            return response()->json(['message' => 'Evaluation status not found'], 404);
        }

        $status->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Evaluation status updated successfully!',
            'evaluation_status' => $status
        ]);
    }

    public function deleteEvaluationStatus($id)
    {
        $status = EvaluationStatus::find($id);

        if (!$status) {
            return response()->json(['message' => 'Evaluation status not found'], 404);
        }

        if ($status->evaluations()->exists()) {
            return response()->json([
                'message' => 'Cannot delete evaluation status as it is being used in evaluations'], 400);
        }

        $status->delete();

        return response()->json([
            'message' => 'Evaluation status deleted successfully!'
        ]);
    }
}