<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Inertia\Inertia; // Commented out since we're using Blade views

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::with(['createdBy', 'updatedBy', 'staff'])
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
        $department->load(['createdBy', 'updatedBy', 'staff.position', 'staff.department']);
        
        return view('departments.show', compact('department'));
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
