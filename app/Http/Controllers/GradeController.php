<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradeController extends Controller
{
    /**
     * Display a listing of the grades.
     */
    public function index()
    {
        return Inertia::render('Admin/Grades', [
            'grades' => Grade::orderBy('level')->get(),
            'students' => Student::all(),
            'subjects' => Subject::all(),
            'teachers' => Teacher::all(),
        ]);
    }

    /**
     * Store a newly created grade.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level' => 'required|integer|min:7|max:12|unique:grades,level',
            'description' => 'nullable|string|max:255'
        ]);

        Grade::create($validated);

        return redirect()->back()->with('success', 'Grade level added successfully');
    }

    /**
     * Update the specified grade.
     */
    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'level' => 'required|integer|min:7|max:12|unique:grades,level,' . $grade->id,
            'description' => 'nullable|string|max:255'
        ]);

        $grade->update($validated);

        return redirect()->back()->with('success', 'Grade level updated successfully');
    }

    /**
     * Remove the specified grade.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->back()->with('success', 'Grade level deleted successfully');
    }
} 