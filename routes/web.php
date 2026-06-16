<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssessmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route('dashboard') 
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('patients', \App\Http\Controllers\PatientController::class);
    Route::resource('patients.assessments', AssessmentController::class)->shallow()->except(['index', 'destroy']);
    Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
    Route::get('/reports', function () { return view('placeholder', ['module' => 'Reports']); })->name('reports.index');
    Route::get('/users', function () { return view('placeholder', ['module' => 'Users']); })->name('users.index')->middleware('role:Admin');
    Route::get('/settings', function () { return view('placeholder', ['module' => 'Settings']); })->name('settings.index')->middleware('role:Admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/assessments/{assessment}/pdf', [\App\Http\Controllers\AssessmentController::class, 'exportPdf'])->middleware('auth')->name('assessments.pdf');
