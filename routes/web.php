<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Evaluation\EvaluationController;
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
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';