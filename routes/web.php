<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Evaluation\EvaluationController;
use App\Http\Controllers\EvaluationRoom\EvaluationRoomController;
use App\Http\Controllers\EvaluatorController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

// Fix: Use the controller instead of anonymous function
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Project routes
    Route::resource('project', ProjectController::class);
    
    // Department routes
    Route::resource('departments', DepartmentController::class);
    
    // Staff routes
    Route::resource('staff', StaffController::class);
    
    // Evaluation routes
    Route::resource('evaluation', EvaluationController::class);
    
    // Evaluation Room routes
    Route::resource('evaluation-room', EvaluationRoomController::class);
    
    // Evaluator routes
    Route::prefix('evaluator')->name('evaluator.')->group(function () {
        Route::get('/', [EvaluatorController::class, 'index'])->name('index');
        Route::get('/my-evaluations', [EvaluatorController::class, 'myEvaluations'])->name('my-evaluations');
        Route::get('/statistics', [EvaluatorController::class, 'statistics'])->name('statistics');
        Route::get('/team', [EvaluatorController::class, 'team'])->name('team');
        Route::get('/quick-evaluate/{user}', [EvaluatorController::class, 'quickEvaluate'])->name('quick-evaluate');
    });
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';