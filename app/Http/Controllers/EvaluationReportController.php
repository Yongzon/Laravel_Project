<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EvaluationReport;
use App\Models\Evaluation;
use App\Models\Department;
use App\Models\Evaluator;
use Illuminate\Http\Request;

class EvaluationReportController extends Controller
{
    public function getEvaluationReports()
    {
        $reports = EvaluationReport::with(['evaluation', 'department', 'evaluator'])->get();
         return response()->json(['evaluation_reports'  => $reports]);
    }

    public function addEvaluationReport(Request $request)
    {
        $validatedData = $request->validate([
            'evaluation_id' => 'required|exists:evaluations,id',
            'department_id' => 'required|exists:departments,id',
            'evaluator_id' => 'required|exists:evaluators,id'
        ]);

        $report = EvaluationReport::create($validatedData);
        
        return response()->json([
            'message' => 'Evaluation report created successfully',
            'report' => $report->load(['evaluation', 'department', 'evaluator'])
        ], 201);
    }

    public function editEvaluationReport(Request $request, $id)
    {
        $report = EvaluationReport::findOrFail($id);

        $validatedData = $request->validate([
            'evaluation_id' => 'required|exists:evaluations,id',
            'department_id' => 'required|exists:departments,id',
            'evaluator_id' => 'required|exists:evaluators,id'
        ]);

        $report->update($validatedData);
        
        return response()->json([
            'message' => 'Evaluation report updated successfully',
            'report' => $report->fresh(['evaluation', 'department', 'evaluator'])
        ]);
    }

    public function deleteEvaluationReport($id)
    {
        $report = EvaluationReport::findOrFail($id);
        $report->delete();
        
        return response()->json([
            'message' => 'Evaluation report deleted successfully'
        ]);
    }
}