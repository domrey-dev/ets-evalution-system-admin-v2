<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\Project;
use App\Models\Department;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Base queries
        $pendingTasksQuery = Task::query()->where('status', 'pending');
        $progressTasksQuery = Task::query()->where('status', 'in_progress');
        $completedTasksQuery = Task::query()->where('status', 'completed');

        // Apply date filters if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Custom date range filtering
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $pendingTasksQuery->whereBetween('created_at', [$startDate, $endDate]);
            $progressTasksQuery->whereBetween('created_at', [$startDate, $endDate]);
            $completedTasksQuery->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($request->filled('month')) {
            // Month filtering
            $month = $request->input('month');
            $monthNumber = date('m', strtotime("1 $month 2023"));

            $pendingTasksQuery->whereMonth('created_at', $monthNumber);
            $progressTasksQuery->whereMonth('created_at', $monthNumber);
            $completedTasksQuery->whereMonth('created_at', $monthNumber);
        }

        // Apply project filter if provided
        if ($request->filled('project')) {
            $projectId = $request->input('project');

            $pendingTasksQuery->where('project_id', $projectId);
            $progressTasksQuery->where('project_id', $projectId);
            $completedTasksQuery->where('project_id', $projectId);
        }

        // Apply department filter if provided
        if ($request->filled('department')) {
            $departmentId = $request->input('department');

            // Filter tasks by users who belong to the selected department
            $pendingTasksQuery->whereHas('assignedUser', function($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });
            $progressTasksQuery->whereHas('assignedUser', function($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });
            $completedTasksQuery->whereHas('assignedUser', function($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });
        }

        // Get the counts
        $totalPendingTasks = $pendingTasksQuery->count();
        $myPendingTasks = $pendingTasksQuery->clone()->where('assigned_user_id', $user->id)->count();

        $totalProgressTasks = $progressTasksQuery->count();
        $myProgressTasks = $progressTasksQuery->clone()->where('assigned_user_id', $user->id)->count();

        $totalCompletedTasks = $completedTasksQuery->count();
        $myCompletedTasks = $completedTasksQuery->clone()->where('assigned_user_id', $user->id)->count();

        // Get active tasks (using the filters)
        $activeTasksQuery = Task::query()
            ->whereIn('status', ['pending', 'in_progress'])
            ->where('assigned_user_id', $user->id);

        // Apply the same filters to active tasks
        if ($request->filled('project')) {
            $activeTasksQuery->where('project_id', $request->input('project'));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $activeTasksQuery->whereBetween('created_at', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        } elseif ($request->filled('month')) {
            $month = $request->input('month');
            $monthNumber = date('m', strtotime("1 $month 2023"));
            $activeTasksQuery->whereMonth('created_at', $monthNumber);
        }

        $activeTasks = $activeTasksQuery->limit(10)->get();

        $projects = Project::all(['id', 'name']);

        // Fetch departments from the database and format for dropdown
        $departments = Department::all(['id', 'name'])->map(function ($dept) {
            return [
                'value' => $dept->id, // Use department ID as value for filtering users
                'label' => $dept->name
            ];
        });

        $gradeDistribution = [
            'A' => 10,
            'B' => 20,
            'C' => 30,
            'D' => 25,
            'E' => 15
        ];

        $monthlyPerformance = [
            'January' => 800,
            'February' => 750,
            'March' => 900,
            'April' => 852,
            'May' => 955,
            'June' => 700,
            'July' => 850,
            'August' => 900,
            'September' => 805,
            'October' => 995,
            'November' => 890,
            'December' => 990
        ];

        $projectPerformance = [
            'January' => 800,
            'February' => 750,
            'March' => 900,
            'April' => 852,
            'May' => 955,
            'June' => 700,
        ];

        $departmentPerformance = [
            'January' => 400,
            'February' => 300,
            'March' => 600,
            'April' => 500,
            'May' => 400,
            'June' => 700,
        ];

        $monthOptions = [
            ['value' => '', 'label' => 'Select Month'],
            ['value' => 'jan', 'label' => 'January'],
            ['value' => 'feb', 'label' => 'February'],
            ['value' => 'mar', 'label' => 'March'],
            ['value' => 'apr', 'label' => 'April'],
            ['value' => 'may', 'label' => 'May'],
            ['value' => 'jun', 'label' => 'June'],
            ['value' => 'jul', 'label' => 'July'],
            ['value' => 'aug', 'label' => 'August'],
            ['value' => 'sep', 'label' => 'September'],
            ['value' => 'oct', 'label' => 'October'],
            ['value' => 'nov', 'label' => 'November'],
            ['value' => 'dec', 'label' => 'December']
        ];

        $gradeColorMap = [
            'A' => '#0088FE',
            'B' => '#00C49F',
            'C' => '#FFBB28',
            'D' => '#FF8042',
            'E' => '#9966FF',
            'F' => '#FF0000'
        ];
        $formattedGradeData = [];
        foreach ($gradeDistribution as $grade => $value) {
            $formattedGradeData[] = [
                'name' => $grade,
                'value' => $value,
                'color' => $gradeColorMap[$grade] ?? '#CCCCCC'
            ];
        }

        // Convert active tasks for Blade (not Inertia resource)
        // $activeTasks = TaskResource::collection($activeTasks); // Remove this line

        // FIXED: Return Blade view instead of Inertia
        return view('dashboard', compact(
            'totalPendingTasks',
            'myPendingTasks',
            'totalProgressTasks',
            'myProgressTasks',
            'totalCompletedTasks',
            'myCompletedTasks',
            'activeTasks',
            'projects',
            'departments',
            'gradeDistribution',
            'monthlyPerformance',
            'projectPerformance',
            'departmentPerformance',
            'monthOptions',
            'formattedGradeData'
        ));
    }
}
