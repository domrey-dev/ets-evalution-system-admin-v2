<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluation\EvaluationRequest;
use App\Http\Resources\Evaluation\EvaluationResource;
use App\Models\Evaluations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $evaluations = Evaluations::with(['createdBy', 'updatedBy', 'evaluationResult'])
            //search
            ->when($request->input('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search') . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render('Evaluation/Index', [
            'evaluations' => EvaluationResource::collection($evaluations),
        ]);
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
    public function store(EvaluationRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        Evaluations::create($data);

        return redirect()->route('evaluations.index')->with('success', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $evaluation = Evaluations::query()
            ->with(['createdBy', 'updatedBy', 'evaluationResult'])
            ->findOrFail($id);

        $total_responses = $evaluation->evaluationResult->count();

        logger($total_responses);

        return Inertia::render('Evaluation/Show', [
            'evaluation' => new EvaluationResource($evaluation),
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
            ->with(['createdBy', 'updatedBy'])
            ->findOrFail($evaluation);

        $evaluation = new EvaluationResource($evaluation);
        return Inertia::render('Evaluation/Edit', [
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

        return redirect()->route('evaluations.index')->with('success', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $evaluation = Evaluations::findOrFail($id);

        $evaluation->delete();

        return redirect()->route('evaluations.index')->with('success', 'Evaluation deleted successfully.');
    }
}
