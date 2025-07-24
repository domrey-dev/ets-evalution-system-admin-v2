<?php

use App\Http\Controllers\Evaluation\EvaluationController;
use App\Http\Controllers\EvaluationRoom\EvaluationRoomController;
use App\Http\Controllers\Position\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

// Fix: Use the controller instead of an anonymous function
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Project routes
    Route::resource('project', ProjectController::class);

    // Department routes
    Route::resource('department', DepartmentController::class);

    // Staff routes
    Route::resource('staff', StaffController::class);

    // Evaluation routes
    Route::resource('evaluation', EvaluationController::class);
    
    // Evaluation criteria routes
    Route::get('/evaluation/{evaluation}/criteria/create', [EvaluationController::class, 'addCriteria'])->name('evaluations.criteria.create');
    Route::post('/evaluation/criteria', [EvaluationController::class, 'storeCriteria'])->name('evaluations.criteria.store');
    Route::get('/evaluation/{evaluation}/criteria/{criteria}/edit', [EvaluationController::class, 'editCriteria'])->name('evaluations.criteria.edit');
    Route::put('/evaluation/{evaluation}/criteria/{criteria}', [EvaluationController::class, 'updateCriteria'])->name('evaluations.criteria.update');
    Route::delete('/evaluation/{evaluation}/criteria/{criteria}', [EvaluationController::class, 'deleteCriteria'])->name('evaluations.criteria.delete');
    Route::post('/evaluation/{evaluation}/criteria/reorder', [EvaluationController::class, 'reorderCriteria'])->name('evaluations.criteria.reorder');

    // Evaluation Room routes
    Route::resource('evaluation-room', EvaluationRoomController::class)->names([
        'index' => 'evaluation-room.index',
        'create' => 'evaluation-room.create',
        'store' => 'evaluation-room.store',
        'show' => 'evaluation-room.show',
        'edit' => 'evaluation-room.edit',
        'update' => 'evaluation-room.update',
        'destroy' => 'evaluation-room.destroy'
    ]);

    // Position routes
    Route::resource('position', PositionController::class);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
