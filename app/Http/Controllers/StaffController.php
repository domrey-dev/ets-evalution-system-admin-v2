<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staff\StaffRequest;
use App\Models\Department;
use App\Models\Position;
use App\Models\Project;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Staff::with('createdBy', 'projects', 'position', 'department'); // Load the relationship

        $sortField = $request->get("sort_field", 'created_at');
        $sortDirection = $request->get("sort_direction", "desc");

        // Apply filters
        if ($request->filled("name")) {
            $query->where("en_name", "like", "%" . $request->input("name") . "%");
        }

        if ($request->filled("status")) {
            $query->where("status", $request->input("status"));
        }

        $staff = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->withQueryString();
        return view("staff.index", [
            "staff" => $staff,
            'queryParams' => $request->query() ?: null,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('staff.create', ['title' => 'Staff']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['status'] = 1;
        $data['department_id'] = Department::query()->first()->id;
        $data['position_id'] = Position::query()->first()->id;
        $data['project_id'] = Project::query()->first()->id;
        $data['start_date'] = date('Y-m-d');
        Staff::create($data);
        return redirect()->route('staff.index')->with('success', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $staff = Staff::query()
            ->with(['createdBy', 'project', 'position'])
            ->findOrFail($id);
        return view('staff.show', ['staff' => $staff, 'title' => 'Staff']);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $staff = Staff::query()
            ->with(['createdBy', 'project', 'position'])
            ->findOrFail($id);
        return view('staff.edit', ['staff' => $staff, 'title' => 'Staff']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'en_name' => 'required|string|max:255'
        ]);
        $staff = Staff::query()
            ->with(['createdBy', 'project', 'position'])
            ->findOrFail($id);
        $staff->update($validated);
        return redirect()->route('staff.index')->with('success', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $staff = Staff::query()
            ->with(['createdBy', 'project', 'position'])
            ->findOrFail($id);
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Task deleted.');
    }
}
