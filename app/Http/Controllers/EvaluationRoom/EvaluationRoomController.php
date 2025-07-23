<?php

namespace App\Http\Controllers\EvaluationRoom;

use App\Constants\ConstUserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\EvaluationRoom\EvaluationRoomRequest;
use App\Http\Resources\Evaluation\EvaluationResource;
use App\Models\EvaluationSummary;
use App\Models\EvaluationCriteriaResponse;
use App\Models\Evaluations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EvaluationRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get active tab from request
        $activeTab = $request->input('tab', 'self');
        
        // Auto-fill logic:
        // 1. If employeeId is provided in request (from department page), always use it
        // 2. If no employeeId and user is on 'self' tab, auto-fill with current user's info  
        // 3. If user role is USER and no employeeId, default to their own info
        $employeeId = $request->input('employeeId');
        
        if (!$employeeId) {
            if ($activeTab === 'self' || auth()->user()->role === ConstUserRole::USER) {
                $employeeId = auth()->user()->id;
            }
        }

        // Fetch basic user data
        $modelData = $this->getUserModelData($employeeId);

        // Only fetch evaluation results when needed
        $evaluationResults = $this->getEvaluationResults($employeeId);

        // Get selected evaluation ID from request or default to "Standard Performance Evaluation Form"
        $selectedEvaluationId = $request->input('evaluation_id');
        
        // If no evaluation_id specified, use the default "Standard Performance Evaluation Form"
        if (!$selectedEvaluationId) {
            $defaultEvaluation = Evaluations::where('title', 'Standard Performance Evaluation Form')->first();
            $selectedEvaluationId = $defaultEvaluation ? $defaultEvaluation->id : null;
        }

        // Get the selected evaluation with its criteria
        $selectedEvaluation = null;
        $criteria = collect();
        
        if ($selectedEvaluationId) {
            $selectedEvaluation = Evaluations::with(['createdBy', 'updatedBy', 'activeCriteria'])
                ->find($selectedEvaluationId);
            
            if ($selectedEvaluation) {
                $criteria = $selectedEvaluation->activeCriteria;
            }
        }
        
        // Always get all evaluations for the dropdown selection
        $allEvaluations = Evaluations::with(['createdBy', 'updatedBy'])
            ->orderByDesc('created_at')
            ->get();

        // Check permissions
        $canAccessStaff = auth()->user()->can('evaluation-room-staff');
        $canAccessSelf = auth()->user()->can('evaluation-room-self');
        $canAccessFinal = auth()->user()->can('evaluation-room-final');
        $canSubmit = auth()->user()->can('evaluation-room-submit');

        // For Final Evaluation, get existing staff and self evaluations for comparison
        $staffEvaluation = null;
        $selfEvaluation = null;
        
        if ($activeTab === 'final' && $employeeId) {
            $staffEvaluation = EvaluationSummary::with(['criteriaResponses.evaluationCriteria', 'evaluation'])
                ->where('user_id', $employeeId)
                ->where('evaluation_type', 'staff')
                ->first();
                
            $selfEvaluation = EvaluationSummary::with(['criteriaResponses.evaluationCriteria', 'evaluation'])
                ->where('user_id', $employeeId)
                ->where('evaluation_type', 'self')
                ->first();
        }

        return view('evaluation-room.index', [
            'criteria' => $criteria,
            'selectedEvaluation' => $selectedEvaluation,
            'allEvaluations' => $allEvaluations,
            'selectedEvaluationId' => $selectedEvaluationId,
            'modelData' => $modelData,
            'evaluationResults' => $evaluationResults,
            'activeTab' => $activeTab,
            'canAccessStaff' => $canAccessStaff,
            'canAccessSelf' => $canAccessSelf,
            'canAccessFinal' => $canAccessFinal,
            'canSubmit' => $canSubmit,
            'employeeId' => $employeeId,
            'staffEvaluation' => $staffEvaluation,
            'selfEvaluation' => $selfEvaluation,
        ]);
    }

    protected function getUserModelData($employeeId)
    {
        if (!$employeeId) {
            return [
                'department' => null,
                'jobTitle' => null,
                'searchId' => null,
                'employeeName' => null,
            ];
        }

        $user = User::with(['department', 'position'])->find($employeeId);

        return [
            'department' => optional($user->department)->name,
            'jobTitle' => optional($user->position)->name,
            'searchId' => $employeeId,
            'employeeName' => $user->name ?? null,
        ];
    }

    protected function getEvaluationResults($employeeId)
    {
        return [
            'self' => EvaluationSummary::query()
                    ->where('evaluation_type', 'self')
                    ->where('user_id', $employeeId)
                    ->with(['criteriaResponses.evaluationCriteria', 'evaluation'])
                    ->first() ?? [],

            'staff' => EvaluationSummary::query()
                    ->where('evaluation_type', 'staff')
                    ->where('user_id', $employeeId)
                    ->with(['criteriaResponses.evaluationCriteria', 'evaluation'])
                    ->first() ?? [],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criteria = Evaluations::with(['createdBy', 'updatedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('evaluation-room.create', [
            'criteria' => $criteria,
            'title' => 'Create Evaluation'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EvaluationRoomRequest $request)
    {
        // Debug: Log all request data for final evaluations
        if ($request->input('evaluation_type') === 'final') {
            logger()->info('🎯 Final evaluation submission received:', [
                'evaluation_type' => $request->input('evaluation_type'),
                'model_data' => $request->input('model_data'),
                'evaluation' => $request->input('evaluation'),
                'summary' => $request->input('summary'),
                'all_data' => $request->all(),
            ]);
            
            // Additional debugging
            logger()->info('🔍 Final evaluation key checks:', [
                'has_model_data' => $request->has('model_data'),
                'has_evaluation' => $request->has('evaluation'),
                'has_summary' => $request->has('summary'),
                'model_data_keys' => $request->has('model_data') ? array_keys($request->input('model_data')) : [],
                'evaluation_keys' => $request->has('evaluation') ? array_keys($request->input('evaluation')) : [],
                'summary_keys' => $request->has('summary') ? array_keys($request->input('summary')) : [],
                         ]);
         }

        try {
            $validated = $request->validated();
            
            if ($request->input('evaluation_type') === 'final') {
                logger()->info('✅ Final evaluation validation passed', [
                    'validated_data' => $validated
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->input('evaluation_type') === 'final') {
                logger()->error('❌ Final evaluation validation failed:', [
                    'errors' => $e->errors(),
                    'request_data' => $request->all()
                ]);
            }
            throw $e;
        }

        try {
            DB::beginTransaction();

            // Get the evaluations_id from the first criteria (they should all belong to the same evaluation)
            $firstCriteriaId = $validated['evaluation']['child_evaluations'][0]['evaluation_id'];
            $criteria = \App\Models\EvaluationCriteria::find($firstCriteriaId);
            $evaluationsId = $criteria ? $criteria->evaluations_id : null;

            // Check for duplicate final evaluations
            if ($validated['evaluation_type'] === 'final') {
                $existingFinalEvaluation = EvaluationSummary::where('user_id', $validated['model_data']['searchId'])
                    ->where('evaluation_type', 'final')
                    ->where('evaluations_id', $evaluationsId)
                    ->first();

                if ($existingFinalEvaluation) {
                    return back()->withInput()
                        ->with('error', 'A final evaluation already exists for this user. Please edit the existing one instead.');
                }
            }

            // Create evaluation summary record (NEW STRUCTURE)
            $evaluationSummary = EvaluationSummary::create([
                'evaluations_id' => $evaluationsId,
                'user_id' => $validated['model_data']['searchId'],
                'evaluation_type' => $validated['evaluation_type'],
                'evaluation_date' => $validated['model_data']['evaluationDate'],
                'total_score' => $validated['summary']['total_score'],
                'grade' => $validated['summary']['grade'],
                'improvement_points' => $validated['summary']['improvement_points'],
                'evaluator_name' => $validated['summary']['evaluator_name'],
                'summary_date' => $validated['summary']['evaluation_date'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            // Create criteria responses (NEW STRUCTURE)
            foreach ($validated['evaluation']['child_evaluations'] as $childEvaluation) {
                EvaluationCriteriaResponse::create([
                    'evaluation_summary_id' => $evaluationSummary->id,
                    'evaluation_criteria_id' => $childEvaluation['evaluation_id'],
                    'rating' => $childEvaluation['rating'],
                    'feedback' => $childEvaluation['feedback'],
                ]);
            }

            DB::commit();

            return redirect()->route('evaluation-room.index')
                ->with('success', 'Evaluation created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Evaluation creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'evaluation_type' => $request->input('evaluation_type'),
                'user_id' => $request->input('model_data.searchId'),
            ]);

            // More specific error message for debugging
            $errorMessage = 'Failed to create evaluation. Please try again.';
            if (app()->environment('local')) {
                $errorMessage .= ' Error: ' . $e->getMessage();
            }

            return back()->withInput()
                ->with('error', $errorMessage);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $evaluation = EvaluationSummary::with(['user', 'evaluation', 'criteriaResponses.evaluationCriteria'])
            ->findOrFail($id);

        return view('evaluation-room.show', [
            'evaluation' => $evaluation,
            'title' => 'View Evaluation Result'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EvaluationSummary $evaluationRoom)
    {
        $criteria = Evaluations::with(['createdBy', 'updatedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('evaluation-room.edit', [
            'evaluation' => $evaluationRoom->load(['user', 'evaluation', 'criteriaResponses.evaluationCriteria']),
            'criteria' => $criteria,
            'title' => 'Edit Evaluation'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EvaluationRoomRequest $request, EvaluationSummary $evaluationRoom)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // Update evaluation summary
            $evaluationRoom->update([
                'total_score' => $validated['summary']['total_score'],
                'evaluation_date' => $validated['model_data']['evaluationDate'],
                'evaluation_type' => $validated['evaluation_type'],
                'user_id' => $validated['model_data']['searchId'],
                'grade' => $validated['summary']['grade'],
                'improvement_points' => $validated['summary']['improvement_points'],
                'evaluator_name' => $validated['summary']['evaluator_name'],
                'summary_date' => $validated['summary']['evaluation_date'],
                'updated_by' => auth()->id(),
            ]);

            // Delete existing criteria responses
            $evaluationRoom->criteriaResponses()->delete();

            // Create new criteria responses
            foreach ($validated['evaluation']['child_evaluations'] as $childEvaluation) {
                EvaluationCriteriaResponse::create([
                    'evaluation_summary_id' => $evaluationRoom->id,
                    'evaluation_criteria_id' => $childEvaluation['evaluation_id'],
                    'feedback' => $childEvaluation['feedback'],
                    'rating' => $childEvaluation['rating'],
                ]);
            }

            DB::commit();

            return redirect()->route('evaluation-room.show', $evaluationRoom)
                ->with('success', 'Evaluation updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Evaluation update failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to update evaluation. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EvaluationSummary $evaluationRoom)
    {
        try {
            DB::beginTransaction();

            // Delete criteria responses first (cascade should handle this, but being explicit)
            $evaluationRoom->criteriaResponses()->delete();
            
            // Delete evaluation summary
            $evaluationRoom->delete();

            DB::commit();

            return redirect()->route('evaluation-room.index')
                ->with('success', 'Evaluation deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Evaluation deletion failed: ' . $e->getMessage());

            return back()
                ->with('error', 'Failed to delete evaluation. Please try again.');
        }
    }
}
