<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluation\EvaluationRequest;
use App\Http\Requests\Evaluation\EvaluationCriteriaRequest;
use App\Http\Resources\Evaluation\EvaluationResource;
use App\Models\Evaluations;
use App\Models\EvaluationCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $evaluations = Evaluations::with(['createdBy', 'updatedBy', 'evaluationSummaries', 'criteria'])
            //search
            ->when($request->input('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search') . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('evaluations.index', [
            'evaluations' => $evaluations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('evaluations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EvaluationRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        Evaluations::create($data);

        return redirect()->route('evaluation.index')->with('success', 'Evaluation template created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $evaluation = Evaluations::query()
            ->with(['createdBy', 'updatedBy', 'evaluationSummaries', 'criteria' => function($query) {
                $query->orderBy('order_number');
            }])
            ->findOrFail($id);

        $total_responses = $evaluation->evaluationSummaries->count();

        return view('evaluations.show', [
            'evaluation' => $evaluation,
            'statistics' => [
                'total_responses' => $total_responses,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($evaluation)
    {
        $evaluation = Evaluations::query()
            ->with(['createdBy', 'updatedBy', 'criteria' => function($query) {
                $query->orderBy('order_number');
            }])
            ->findOrFail($evaluation);

        return view('evaluations.edit', [
            'evaluation' => $evaluation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $evaluations)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',

        ]);

        $evaluations = Evaluations::query()
            ->with(['createdBy', 'updatedBy'])
            ->findOrFail($evaluations);

        $evaluations->update($validated);

        return redirect()->route('evaluation.index')->with('success', 'Evaluation template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $evaluation = Evaluations::findOrFail($id);

        $evaluation->delete();

        return redirect()->route('evaluation.index')->with('success', 'Evaluation deleted successfully.');
    }

    /**
     * Add criteria to an evaluation
     */
    public function addCriteria($evaluationId)
    {
        $evaluation = Evaluations::findOrFail($evaluationId);
        
        // Get the next order number
        $nextOrder = $evaluation->criteria()->max('order_number') + 1;
        
        return view('evaluations.criteria.create', [
            'evaluation' => $evaluation,
            'nextOrder' => $nextOrder,
        ]);
    }

    /**
     * Store a new criteria
     */
    public function storeCriteria(EvaluationCriteriaRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        
        // Map evaluation_id to evaluations_id for database consistency
        $data['evaluations_id'] = $data['evaluation_id'];
        unset($data['evaluation_id']);
        
        EvaluationCriteria::create($data);

        return redirect()
            ->route('evaluation.show', $request->input('evaluation_id'))
            ->with('success', 'Evaluation criteria added successfully.');
    }

    /**
     * Show form to edit criteria
     */
    public function editCriteria($evaluationId, $criteriaId)
    {
        $evaluation = Evaluations::findOrFail($evaluationId);
        $criteria = EvaluationCriteria::where('evaluations_id', $evaluationId)
                                    ->findOrFail($criteriaId);
        
        return view('evaluations.criteria.edit', [
            'evaluation' => $evaluation,
            'criteria' => $criteria,
        ]);
    }

    /**
     * Update criteria
     */
    public function updateCriteria(EvaluationCriteriaRequest $request, $evaluationId, $criteriaId)
    {
        $criteria = EvaluationCriteria::where('evaluations_id', $evaluationId)
                                    ->findOrFail($criteriaId);
        
        $data = $request->validated();
        $data['updated_by'] = Auth::id();
        
        // Map evaluation_id to evaluations_id for database consistency
        if (isset($data['evaluation_id'])) {
            $data['evaluations_id'] = $data['evaluation_id'];
            unset($data['evaluation_id']);
        }
        
        $criteria->update($data);

        return redirect()
            ->route('evaluation.show', $evaluationId)
            ->with('success', 'Evaluation criteria updated successfully.');
    }

    /**
     * Delete criteria
     */
    public function deleteCriteria($evaluationId, $criteriaId)
    {
        $criteria = EvaluationCriteria::where('evaluations_id', $evaluationId)
                                    ->findOrFail($criteriaId);
        
        $criteria->delete();

        return redirect()
            ->route('evaluation.show', $evaluationId)
            ->with('success', 'Evaluation criteria deleted successfully.');
    }

    /**
     * Reorder criteria
     */
    public function reorderCriteria(Request $request, $evaluationId)
    {
        $request->validate([
            'criteria' => 'required|array',
            'criteria.*.id' => 'required|exists:evaluation_criteria,id',
            'criteria.*.order_number' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $evaluationId) {
            foreach ($request->criteria as $criteriaData) {
                EvaluationCriteria::where('evaluations_id', $evaluationId)
                                ->where('id', $criteriaData['id'])
                                ->update([
                                    'order_number' => $criteriaData['order_number'],
                                    'updated_by' => Auth::id(),
                                ]);
            }
        });

        return response()->json(['success' => true]);
    }
}
