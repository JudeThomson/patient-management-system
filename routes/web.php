<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssessmentController;
use App\Models\Patient;
use App\Models\Assessment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route('dashboard') 
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    $stats = [
        'totalPatients' => Patient::count(),
        'totalAssessments' => Assessment::count(),
        'completedAssessments' => Assessment::where('status', 'Completed')->count(),
        'draftAssessments' => Assessment::where('status', 'Draft')->count(),
    ];

    $recentPatients = Patient::latest()->take(5)->get();
    $recentAssessments = Assessment::with('patient')->latest()->take(5)->get();

    return view('dashboard', compact('stats', 'recentPatients', 'recentAssessments'));
})->middleware(['auth', 'verified', 'prevent-back-history'])->name('dashboard');
Route::middleware(['auth', 'verified', 'prevent-back-history'])->group(function () {
    Route::resource('patients', \App\Http\Controllers\PatientController::class);
    Route::resource('patients.assessments', AssessmentController::class)->shallow()->except(['index', 'destroy']);
    Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
    Route::get('/reports', function () { return view('placeholder', ['module' => 'Reports']); })->name('reports.index');
    Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('role:Admin');
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index')->middleware('role:Admin');
    Route::post('/settings/backup', [\App\Http\Controllers\SettingsController::class, 'downloadBackup'])->name('settings.backup')->middleware('role:Admin');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/assessments/{assessment}/pdf', [\App\Http\Controllers\AssessmentController::class, 'exportPdf'])->middleware('auth')->name('assessments.pdf');
