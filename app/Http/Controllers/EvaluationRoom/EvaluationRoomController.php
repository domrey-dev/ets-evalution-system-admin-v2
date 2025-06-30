<?php

namespace App\Http\Controllers\EvaluationRoom;

use App\Constants\ConstUserRole;
use App\Http\Controllers\Controller;
use App\Http\Resources\Evaluation\EvaluationResource;
use App\Models\EvaluationResult;
use App\Models\Evaluations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EvaluationRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employeeId = auth()->user()->role === ConstUserRole::USER
            ? auth()->user()->id
            : $request->input('employeeId');

        // Fetch basic user data
        $modelData = $this->getUserModelData($employeeId);

        // Only fetch evaluation results when needed
        $evaluationResults = $this->getEvaluationResults($employeeId);

        return Inertia::render('EvaluationRoom/Index', [
            'criteria' => EvaluationResource::collection(
                Evaluations::with(['createdBy', 'updatedBy'])
                    ->orderByDesc('created_at')
                    ->paginate(25)
            ),
            'model_data' => $modelData,
            'final' => $evaluationResults,
            'filters' => $request->only(['employeeId', 'tab']),
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
        //
        return Inertia::render('Evaluation/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'model_data' => 'required|array',
            'evaluation_type' => 'required|in:staff,self,final',
            'evaluation' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $parentEvaluation = EvaluationResult::create([
                'monthly_performance' => $validated['model_data']['monthlyPerformance'],
                'evaluation_date' => $validated['model_data']['evaluationDate'],
                'evaluation_type' => $validated['evaluation_type'],
                'user_id' => $validated['model_data']['searchId'],
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

            return redirect()->route('dashboard')
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluations $evaluations)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
