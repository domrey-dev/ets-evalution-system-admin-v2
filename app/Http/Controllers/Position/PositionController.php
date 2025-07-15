<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\Controller;
use App\Http\Requests\Position\PositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = Position::with('createdBy', 'updatedBy');
        $sortField = $request->get("sort_field", 'created_at');
        $sortDirection = $request->get("sort_direction", "desc");

        if ($request->filled("name")) {
            $query->where("name", "like", "%" . $request->input("name") . "%");
        }
        $position = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->withQueryString();
        return view("position.index", [
            "position" => $position,
            'queryParams' => $request->query() ?: null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('position.create', ['title' => 'Position']);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PositionRequest $request)
    {
        //
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        Position::create($data);
        return redirect()->route('position.index')->with('success', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $position = Position::query()
            ->with(['createdBy', 'updatedBy'])
            ->findOrFail($id);
        return view('position.show', ['position' => $position, 'title' => 'Position']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $position = Position::query()
            ->with(['createdBy', 'updatedBy'])
            ->findOrFail($id);
        return view('position.edit', ['position' => $position, 'title' => 'Position']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $position = Position::query()
            ->with(['createdBy', 'updatedBy'])
            ->findOrFail($id);
        $position->update($validated);
        return redirect()->route('position.index')->with('success', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

    }
}
