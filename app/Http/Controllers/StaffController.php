<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = Staff::with('createdBy'); // Load the relationship for created_by

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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
