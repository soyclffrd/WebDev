<?php
// app/Http/Controllers/AdminDashboardController.php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Strand;
use App\Models\Grade;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/dashboard', [
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'subjects' => Subject::count(),
            'strands' => Strand::count(),
            'grades' => Grade::count(),
        ]);
    }
}
