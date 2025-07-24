<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentRequest;
use App\Models\Department;
use App\Models\EvaluationSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Inertia\Inertia; // Commented out since we're using Blade views

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::with(['createdBy', 'updatedBy', 'users'])
            ->withCount([
                'users',
                'users as completed_evaluations_count' => function($query) {
                    $query->whereHas('evaluationSummaries', function($subQuery) {
                        $subQuery->where('evaluation_type', 'final');
                    });
                },
                'users as incomplete_evaluations_count' => function($query) {
                    $query->whereDoesntHave('evaluationSummaries', function($subQuery) {
                        $subQuery->where('evaluation_type', 'final');
                    });
                }
            ])
            ->when(request('name'), function($query) {
                $query->where('name', 'like', '%' . request('name') . '%');
            })
            ->paginate(10);
        
        return view('departments.index', compact('departments'));
    }
    public function create()
    {
        return view('departments.create');
    }
    public function store(DepartmentRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        Department::create($data);

        return redirect()->route('department.index')->with('success', 'Task created.');
    }

    public function show(Department $department)
    {
        $department->load([
            'createdBy', 
            'updatedBy', 
            'users.position', 
            'users.department',
            'users.evaluationSummaries' => function($query) {
                $query->whereIn('evaluation_type', ['self', 'staff', 'final']);
            }
        ]);

        // Calculate evaluation counts
        $staffCount = $department->users()->count();
        $completedEvaluations = $department->users()
            ->whereHas('evaluationSummaries', function($query) {
                $query->where('evaluation_type', 'final');
            })->count();
        $incompleteEvaluations = $staffCount - $completedEvaluations;
        
        return view('departments.show', compact('department', 'completedEvaluations', 'incompleteEvaluations'));
    }
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

        ]);

        $department->update($validated);

        return redirect()->route('department.index')->with('success', 'Task updated.');
    }
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('department.index')->with('success', 'Task deleted.');
    }
}
