<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Evaluation\EvaluationResource;
use App\Models\EvaluationResult;
use App\Models\Evaluations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluatorController extends Controller
{
    /**
     * Display a listing of evaluations for the evaluator
     */
    public function index(Request $request)
    {
        // Get users with filtering (since the view expects users data)
        $query = User::query();

        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('phone')) {
            $query->where('phone', 'like', '%' . $request->input('phone') . '%');
        }
        if ($request->input('role')) {
            $query->where('role', 'like', '%' . $request->input('role') . '%');
        }
        if ($request->input('work_contract')) {
            $query->where('work_contract', $request->input('work_contract'));
        }
        if ($request->input('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        $users = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('evaluator.index', [
            'users' => $users,
            'search' => $request->input('name'),
        ]);
    }

    /**
     * Show evaluations assigned to me
     */
    public function myEvaluations(Request $request)
    {
        // Get evaluations where current user is being evaluated
        $myEvaluations = EvaluationResult::where('user_id', Auth::id())
            ->with(['evaluation', 'createdBy'])
            ->when($request->input('type'), function ($query) use ($request) {
                $query->where('evaluation_type', $request->input('type'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('evaluator.my-evaluations', [
            'evaluations' => $myEvaluations,
            'type' => $request->input('type'),
        ]);
    }

    /**
     * Show evaluation statistics
     */
    public function statistics()
    {
        $stats = [
            'total_evaluations' => EvaluationResult::where('created_by', Auth::id())->count(),
            'self_evaluations' => EvaluationResult::where('created_by', Auth::id())
                ->where('evaluation_type', 'self')->count(),
            'staff_evaluations' => EvaluationResult::where('created_by', Auth::id())
                ->where('evaluation_type', 'staff')->count(),
            'final_evaluations' => EvaluationResult::where('created_by', Auth::id())
                ->where('evaluation_type', 'final')->count(),
            'pending_evaluations' => User::whereDoesntHave('evaluationResults', function ($query) {
                $query->where('created_by', Auth::id());
            })->count(),
        ];

        // Recent evaluations
        $recentEvaluations = EvaluationResult::where('created_by', Auth::id())
            ->with(['evaluation', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('evaluator.statistics', [
            'stats' => $stats,
            'recentEvaluations' => $recentEvaluations,
        ]);
    }

    /**
     * Show team members to evaluate
     */
    public function team(Request $request)
    {
        // Get team members (users in same department or reporting to current user)
        $currentUser = Auth::user();
        
        $teamMembers = User::with(['department', 'position'])
            ->when($currentUser->department_id, function ($query) use ($currentUser) {
                $query->where('department_id', $currentUser->department_id);
            })
            ->when($request->input('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            })
            ->where('id', '!=', $currentUser->id)
            ->paginate(10);

        // Add evaluation status for each team member
        $teamMembers->getCollection()->transform(function ($member) {
            $member->evaluation_status = [
                'self' => EvaluationResult::where('user_id', $member->id)
                    ->where('evaluation_type', 'self')
                    ->exists(),
                'staff' => EvaluationResult::where('user_id', $member->id)
                    ->where('evaluation_type', 'staff')
                    ->where('created_by', Auth::id())
                    ->exists(),
                'final' => EvaluationResult::where('user_id', $member->id)
                    ->where('evaluation_type', 'final')
                    ->exists(),
            ];
            return $member;
        });

        return view('evaluator.team', [
            'teamMembers' => $teamMembers,
            'search' => $request->input('search'),
        ]);
    }

    /**
     * Quick evaluate a team member
     */
    public function quickEvaluate(Request $request, User $user)
    {
        $evaluations = Evaluations::with(['createdBy', 'updatedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('evaluator.quick-evaluate', [
            'user' => $user,
            'evaluations' => EvaluationResource::collection($evaluations),
        ]);
    }
} 