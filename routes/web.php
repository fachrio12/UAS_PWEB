<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing page
Route::get('/', [PageController::class, 'index'])->name('home');

// Authentication
Route::get('/login', [PageController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [PageController::class, 'registerPage'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [PageController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/profile', [PageController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/profile/update', [PageController::class, 'updateAdminProfile'])->name('admin.profile.update');
    // Assessment management
    Route::get('/assessments', [PageController::class, 'assessmentManagement'])->name('admin.assessments');
    Route::get('/assessments/create', [PageController::class, 'createAssessment'])->name('admin.assessments.create');
    Route::post('/assessments', [AssessmentController::class, 'store'])->name('admin.assessments.store');
    Route::get('/assessments/{assessment}/edit', [PageController::class, 'editAssessment'])->name('admin.assessments.edit');
    Route::put('/assessments/{assessment}', [AssessmentController::class, 'update'])->name('admin.assessments.update');
    Route::delete('/assessments/{assessment}', [AssessmentController::class, 'destroy'])->name('admin.assessments.destroy');
    
    // Questions and options
    Route::get('/assessments/{assessment}/questions', [PageController::class, 'manageQuestions'])->name('admin.questions');
    Route::post('/questions', [AssessmentController::class, 'storeQuestion'])->name('admin.questions.store');
    Route::post('/admin/questions/multi-store', [AssessmentController::class, 'multiStore'])->name('admin.questions.multi_store');
    Route::put('/questions/{question}', [AssessmentController::class, 'updateQuestion'])->name('admin.questions.update');
    Route::delete('/questions/{question}', [AssessmentController::class, 'destroyQuestion'])->name('admin.questions.destroy');
});

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/assessments', [PageController::class, 'userAssessments'])->name('user.assessments');
    Route::get('/assessments/{assessment}', [PageController::class, 'takeAssessment'])->name('user.assessments.take');
    Route::post('/assessments/{assessment}/submit', [UserController::class, 'submitAssessment'])->name('user.assessments.submit');
    Route::get('/profile', [PageController::class, 'userProfile'])->name('user.profile');
    Route::get('/progress', [PageController::class, 'userProgress'])->name('user.progress');
    Route::get('/results/{session}', [PageController::class, 'viewResults'])->name('user.results');
});