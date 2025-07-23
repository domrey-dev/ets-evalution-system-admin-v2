<?php

namespace App\Http\Controllers\EvaluationRoom;

use App\Constants\ConstUserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\EvaluationRoom\EvaluationRoomRequest;
use App\Http\Resources\Evaluation\EvaluationResource;
use App\Models\EvaluationResult;
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
            $staffEvaluation = EvaluationResult::with('childEvaluations.evaluation')
                ->where('user_id', $employeeId)
                ->where('evaluation_type', 'staff')
                ->first();
                
            $selfEvaluation = EvaluationResult::with('childEvaluations.evaluation')
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
            'self' => EvaluationResult::query()
                    ->where('evaluation_type', 'self')
                    ->where('user_id', $employeeId)
                    ->with('childEvaluations')
                    ->first() ?? [],

            'staff' => EvaluationResult::query()
                    ->where('evaluation_type', 'staff')
                    ->where('user_id', $employeeId)
                    ->with('childEvaluations')
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
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $parentEvaluation = EvaluationResult::create([
                'monthly_performance' => $validated['model_data']['monthlyPerformance'],
                'evaluation_date' => $validated['model_data']['evaluationDate'],
                'evaluation_type' => $validated['evaluation_type'],
                'user_id' => $validated['model_data']['searchId'],
                // Section 3: Summary fields
                'improvement_points' => $validated['summary']['improvement_points'],
                'total_score' => $validated['summary']['total_score'],
                'grade' => $validated['summary']['grade'],
                'evaluator_name' => $validated['summary']['evaluator_name'],
                'summary_date' => $validated['summary']['evaluation_date'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            // Handle child evaluations from the payload
            foreach ($validated['evaluation']['child_evaluations'] as $childEvaluation) {
                EvaluationResult::create([
                    'parent_evaluation_id' => $parentEvaluation->id,
                    'evaluation_id' => $childEvaluation['evaluation_id'],
                    'feedback' => $childEvaluation['feedback'],
                    'rating' => $childEvaluation['rating'],
                    'evaluation_type' => $validated['evaluation_type'],
                    'user_id' => $validated['model_data']['searchId'],
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('evaluation-room.index')
                ->with('success', 'Evaluation created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Evaluation creation failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to create evaluation. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $evaluation = EvaluationResult::with(['user', 'evaluation', 'childEvaluations'])
            ->findOrFail($id);

        return view('evaluation-room.show', [
            'evaluation' => $evaluation,
            'title' => 'View Evaluation Result'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EvaluationResult $evaluationRoom)
    {
        $criteria = Evaluations::with(['createdBy', 'updatedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('evaluation-room.edit', [
            'evaluation' => $evaluationRoom->load(['user', 'evaluation', 'childEvaluations']),
            'criteria' => $criteria,
            'title' => 'Edit Evaluation'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EvaluationRoomRequest $request, EvaluationResult $evaluationRoom)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // Update parent evaluation
            $evaluationRoom->update([
                'monthly_performance' => $validated['model_data']['monthlyPerformance'],
                'evaluation_date' => $validated['model_data']['evaluationDate'],
                'evaluation_type' => $validated['evaluation_type'],
                'user_id' => $validated['model_data']['searchId'],
                'updated_by' => auth()->id(),
            ]);

            // Delete existing child evaluations
            $evaluationRoom->childEvaluations()->delete();

            // Create new child evaluations
            foreach ($validated['evaluation']['child_evaluations'] as $childEvaluation) {
                EvaluationResult::create([
                    'parent_evaluation_id' => $evaluationRoom->id,
                    'evaluation_id' => $childEvaluation['evaluation_id'],
                    'feedback' => $childEvaluation['feedback'],
                    'rating' => $childEvaluation['rating'],
                    'evaluation_type' => $validated['evaluation_type'],
                    'user_id' => $validated['model_data']['searchId'],
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
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
    public function destroy(EvaluationResult $evaluationRoom)
    {
        try {
            DB::beginTransaction();

            // Delete child evaluations first
            $evaluationRoom->childEvaluations()->delete();
            
            // Delete parent evaluation
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
