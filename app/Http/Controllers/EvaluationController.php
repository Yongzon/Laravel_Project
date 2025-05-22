<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\TaskAssignment;
use App\Models\Evaluator;
use App\Models\EvaluationStatus;

class EvaluationController extends Controller
{
    public function getEvaluations()
    {
        $evaluations = Evaluation::with(['assignTask', 'evaluator', 'evaluationStatus'])->get();
        return response()->json(['evaluations' => $evaluations]);
    }

    public function addEvaluation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assignTask_id' => ['required', 'exists:task_assignments,id'],
            'evaluator_id' => ['required', 'exists:evaluators,id'],
            'evaluation_date' => ['required', 'date'],
            'work_quality_score' => ['required', 'string'],
            'productivity_score' => ['required', 'string'],
            'overall_score' => ['required', 'string'],
            'comments' => ['required', 'string', 'max:255'],
            'status_id' => ['required', 'exists:evaluation_statuses,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $evaluation = Evaluation::create([
            'assignTask_id' => $request->assignTask_id,
            'evaluator_id' => $request->evaluator_id,
            'evaluation_date' => $request->evaluation_date,
            'work_quality_score' => $request->work_quality_score,
            'productivity_score' => $request->productivity_score,
            'overall_score' => $request->overall_score,
            'comments' => $request->comments,
            'status_id' => $request->status_id,
        ]);

        return response()->json([
            'message' => 'Evaluation created successfully!',
            'evaluation' => $evaluation->load(['assignTask', 'evaluator', 'evaluationStatus'])
        ]);
    }

    public function editEvaluation(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'assignTask_id' => ['required', 'exists:task_assignments,id'],
            'evaluator_id' => ['required', 'exists:evaluators,id'],
            'evaluation_date' => ['required', 'date'],
            'work_quality_score' => ['required', 'string'],
            'productivity_score' => ['required', 'string'],
            'overall_score' => ['required', 'string'],
            'comments' => ['required', 'string', 'max:255'],
            'status_id' => ['required', 'exists:evaluation_statuses,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $evaluation = Evaluation::find($id);

        if (!$evaluation) {
            return response()->json(['message' => 'Evaluation not found'], 404);
        }

        $evaluation->update([
            'assignTask_id' => $request->assignTask_id,
            'evaluator_id' => $request->evaluator_id,
            'evaluation_date' => $request->evaluation_date,
            'work_quality_score' => $request->work_quality_score,
            'productivity_score' => $request->productivity_score,
            'overall_score' => $request->overall_score,
            'comments' => $request->comments,
            'status_id' => $request->status_id,
        ]);

        return response()->json([
            'message' => 'Evaluation updated successfully!',
            'evaluation' => $evaluation->fresh(['assignTask', 'evaluator', 'evaluationStatus'])
        ]);
    }

    public function deleteEvaluation($id)
    {
        $evaluation = Evaluation::find($id);

        if (!$evaluation) {
            return response()->json(['message' => 'Evaluation not found'], 404);
        }

        $evaluation->delete();

        return response()->json(['message' => 'Evaluation deleted successfully!']);
    }
}