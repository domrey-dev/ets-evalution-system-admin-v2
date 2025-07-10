<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{

    public function index()
    {
        return view('departments.index', [
            'departments' => Department::all(),
        ]);
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

        return redirect()->route('departments.index')->with('success', 'Department created.');
    }

    public function show(Department $department)
    {
        return view('departments.show', [
            'department' => $department,
        ]);
    }

    public function edit(Department $department)
    {
        return view('departments.edit', [
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

        return redirect()->route('departments.index')->with('success', 'Department updated.');
    }
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted.');
    }
}
