<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StrandController;
use App\Http\Controllers\MyGradeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\UserSubjectController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Authentication Routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Google Authentication Routes
Route::prefix('auth/google')->group(function () {
    Route::get('/', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Root Route
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.teacher.index');
    }
    return Inertia::render('Auth/Login');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
        // User Dashboard
        Route::get('/dashboard', function () {
            return Inertia::render('Admin/dashboard');
        })->name('user.dashboard');

    // Teacher Management Routes
    Route::prefix('teacher')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('admin.teacher.index');
        Route::post('/store', [TeacherController::class, 'store'])->name('admin.teacher.store');
        Route::post('/{teacher}/update', [TeacherController::class, 'update'])
            ->name('admin.teacher.update');
        Route::delete('/{teacher}', [TeacherController::class, 'destroy'])
            ->name('admin.teacher.destroy');
    });

    // Student Management Routes
    Route::prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('admin.student.index');
        Route::post('/store', [StudentController::class, 'store'])->name('admin.student.store');
        Route::post('/{student}/update', [StudentController::class, 'update'])
            ->name('admin.student.update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])
            ->name('admin.student.destroy');
    });

    // Subject Management Routes
    Route::prefix('subject')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('admin.subject.index');
        Route::post('/store', [SubjectController::class, 'store'])->name('admin.subject.store');
        Route::post('/{subject}/update', [SubjectController::class, 'update'])
            ->name('admin.subject.update');
        Route::delete('/{subject}', [SubjectController::class, 'destroy'])
            ->name('admin.subject.destroy');
    });

    // Strand Management Routes
    Route::prefix('strand')->group(function () {
        Route::get('/', [StrandController::class, 'index'])->name('admin.strand.index');
        Route::post('/store', [StrandController::class, 'store'])->name('admin.strand.store');
        Route::post('/{strand}/update', [StrandController::class, 'update'])
            ->name('admin.strand.update');
        Route::delete('/{strand}', [StrandController::class, 'destroy'])
            ->name('admin.strand.destroy');
    });

    // Grade Management Routes
    Route::prefix('grades')->group(function () {
        Route::get('/', [GradeController::class, 'index'])->name('admin.grades.index');
        Route::post('/store', [GradeController::class, 'store'])->name('admin.grades.store');
        Route::post('/{grade}/update', [GradeController::class, 'update'])
            ->name('admin.grades.update');
        Route::delete('/{grade}', [GradeController::class, 'destroy'])
            ->name('admin.grades.destroy');
    });

    // Section Management Routes
    Route::prefix('section')->group(function () {
        Route::get('/', [SectionController::class, 'index'])->name('admin.section.index');
        Route::post('/store', [SectionController::class, 'store'])->name('admin.section.store');
        Route::post('/{section}/update', [SectionController::class, 'update'])
            ->name('admin.section.update');
        Route::delete('/{section}', [SectionController::class, 'destroy'])
            ->name('admin.section.destroy');
    });

    Route::get('/strand', [StrandController::class, 'index'])->name('admin.strand.index');
    Route::post('/strand/store', [StrandController::class, 'store'])->name('admin.strand.store');
    Route::post('/strand/{strand}/update', [StrandController::class, 'update'])->name('admin.strand.update');
    Route::delete('/strand/{strand}', [StrandController::class, 'destroy'])->name('admin.strand.destroy');

    Route::get('/section', [SectionController::class, 'index'])
    ->name('admin.section.index');
Route::post('/section/store', [SectionController::class, 'store'])
    ->name('admin.section.store');
Route::post('/section/{section}/update', [SectionController::class, 'update'])
    ->name('admin.section.update');
Route::delete('/section/{section}', [SectionController::class, 'destroy'])
    ->name('admin.section.destroy');

    Route::post('/subject/{subject}/enrollment/{user}', [SubjectController::class, 'updateEnrollmentStatus'])
        ->name('admin.subject.enrollment.update');
});

// User Routes
Route::middleware(['auth'])->prefix('user')->group(function () {
    // Profile Management
    Route::get('/profile', function () {
        return Inertia::render('User/student-profile');
    })->name('user.profile');

    // Class
    Route::get('/class', function () {
        return Inertia::render('User/class');
    })->name('user.class');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CSRF Token Route
Route::middleware(['auth'])->get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

// Registration Route
Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

// Include Laravel's default authentication routes
require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    // Existing routes..

    Route::post('/admin/student/store', [StudentController::class, 'store'])
        ->name('admin.student.store');
    Route::post('/admin/student/{student}/update', [StudentController::class, 'update'])
        ->name('admin.student.update');
    Route::delete('/admin/student/{student}', [StudentController::class, 'destroy'])
        ->name('admin.student.destroy');

    // User subject routes
    Route::prefix('user')->group(function () {
        Route::get('/my-subjects', [UserSubjectController::class, 'index'])
            ->name('user.subjects.index');
        Route::post('/subjects/{subject}/enroll', [UserSubjectController::class, 'enroll'])
            ->name('user.subjects.enroll');
        Route::post('/subjects/{subject}/drop', [UserSubjectController::class, 'requestDrop'])
            ->name('user.subjects.drop');
    });
    
    Route::prefix('user')->group(function () {
        Route::get('/my-grades', [MyGradeController::class, 'index'])
            ->name('user.grades.index');
    });

});

// Add these routes
Route::middleware(['auth'])->group(function () {
    // User routes
    Route::get('/user/my-subjects', function () {
        // Redirect admin to dashboard
        if (auth()->user()->email === '@ssct.edu.ph') {
            return redirect('/user/my-subjects');
        }
        return Inertia::render('User/MySubjects');
    })->name('user.subjects');

    // Admin routes
    Route::get('/admin/dashboard', function () {
        // Only allow admin access
        if (auth()->user()->email !== 'admin@gmail.com') {
            return redirect('/admin/teacher');
        }
        return Inertia::render('Admin/dashboard');
    })->name('admin.dashboard');
});
