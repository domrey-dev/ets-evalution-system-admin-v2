<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with('createdBy'); // Load the relationship for created_by

        $sortField = $request->get("sort_field", 'created_at');
        $sortDirection = $request->get("sort_direction", "desc");

        // Apply filters
        if ($request->filled("name")) {
            $query->where("name", "like", "%" . $request->input("name") . "%");
        }
        
        if ($request->filled("status")) {
            $query->where("status", $request->input("status"));
        }

        $projects = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->withQueryString(); // Preserves query parameters in pagination

        // Return Blade view instead of Inertia
        return view("projects.index", [
            "projects" => $projects,
            'queryParams' => $request->query() ?: null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return Blade view instead of Inertia
        return view("projects.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        
        /** @var $image \Illuminate\Http\UploadedFile */
        $image = $data['image'] ?? null;
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        
        if ($image) {
            $data['image_path'] = $image->store('project/' . Str::random(), 'public');
        }
        
        Project::create($data);

        // Use redirect instead of to_route for better compatibility
        return redirect()->route('project.index')
            ->with('success', 'Project was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Request $request)
    {
        // Load the project with its relationships
        $project->load('createdBy');
        
        $query = $project->tasks();

        $sortField = $request->get("sort_field", 'created_at');
        $sortDirection = $request->get("sort_direction", "desc");

        if ($request->filled("name")) {
            $query->where("name", "like", "%" . $request->input("name") . "%");
        }
        
        if ($request->filled("status")) {
            $query->where("status", $request->input("status"));
        }

        $tasks = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->withQueryString();

        // Return Blade view instead of Inertia
        return view('projects.show', [
            'project' => $project,
            "tasks" => $tasks,
            'queryParams' => $request->query() ?: null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        // Return Blade view instead of Inertia
        return view('projects.edit', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        $data['updated_by'] = Auth::id();
        
        if ($image) {
            if ($project->image_path) {
                Storage::disk('public')->deleteDirectory(dirname($project->image_path));
            }
            $data['image_path'] = $image->store('project/' . Str::random(), 'public');
        }
        
        $project->update($data);

        return redirect()->route('project.index')
            ->with('success', "Project \"$project->name\" was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $name = $project->name;
        
        if ($project->image_path) {
            Storage::disk('public')->deleteDirectory(dirname($project->image_path));
        }
        
        $project->delete();

        return redirect()->route('project.index')
            ->with('success', "Project \"$name\" was deleted");
    }
}