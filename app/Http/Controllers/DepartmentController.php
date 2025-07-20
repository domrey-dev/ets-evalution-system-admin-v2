<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Http\Requests\Department\DepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Department::with('createdBy'); // Load the relationship for created_by

        $sortField = $request->get("sort_field", 'created_at');
        $sortDirection = $request->get("sort_direction", "desc");

        // Apply filters
        if ($request->filled("name")) {
            $searchTerm = $request->input("name");
            $query->whereRaw("LOWER(name) LIKE ?", ["%" . strtolower($searchTerm) . "%"]);
        }

        $departments = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->withQueryString(); // Preserves query parameters in pagination

        // Return Blade view instead of Inertia
        return view("departments.index", [
            "departments" => $departments,
            'queryParams' => $request->query() ?: null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validatedData['created_by'] = Auth::id();
        $validatedData['updated_by'] = Auth::id();
        
        Department::create($validatedData);

        return redirect()->route('department.index')
            ->with('success', 'Department was created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view('departments.show', [
            'department' => $department->load('createdBy', 'updatedBy'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', [
            'department' => $department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validatedData['updated_by'] = Auth::id();
        
        $department->update($validatedData);

        return redirect()->route('department.index')
            ->with('success', "Department \"{$department->name}\" was updated successfully");
            }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $name = $department->name;
        $department->delete();

        return redirect()->route('department.index')
            ->with('success', "Department \"$name\" was deleted successfully");
    }
}
