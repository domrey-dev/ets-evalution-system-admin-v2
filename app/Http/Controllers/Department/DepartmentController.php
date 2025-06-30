<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DepartmentController extends Controller
{

    public function index()
    {
        return Inertia::render('Department/Index', [
            'departments' => Department::all(),
        ]);
    }
    public function create()
    {
        return Inertia::render('Department/Create');
    }
    public function store(DepartmentRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        Department::create($data);

        return redirect()->route('department.index')->with('success', 'Task created.');
    }
    public function edit(Department $department)
    {
        return Inertia::render('Department/Edit', [
            'department' => $department,
        ]);
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
