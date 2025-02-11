<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Grade;
use App\Models\Strand;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index()
    {
        try {
            $subjects = Subject::with(['teacher', 'grade', 'users'])->get()->map(function($subject) {
                return [
                    'id' => $subject->id,
                    'code' => $subject->code,
                    'name' => $subject->name,
                    'teacher' => $subject->teacher ? [
                        'id' => $subject->teacher->id,
                        'name' => $subject->teacher->name
                    ] : null,
                    'grade' => $subject->grade ? [
                        'id' => $subject->grade->id,
                        'level' => $subject->grade->level
                    ] : null,
                    'schedule' => $subject->schedule,
                    'enrollment_count' => $subject->users()->count(),
                    'status' => $this->getSubjectStatus($subject),
                    'available_slots' => 40 - $subject->users()->count()
                ];
            });

            return Inertia::render('Admin/Subject', [
                'subjects' => $subjects,
                'teachers' => Teacher::all(),
                'grades' => Grade::all()
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading subjects: ' . $e->getMessage());
        }
    }

    private function getSubjectStatus($subject)
    {
        $enrollmentCount = $subject->users()->count();
        $maxSlots = 40; // Adjust this number as needed

        if ($enrollmentCount >= $maxSlots) {
            return 'Full';
        } elseif ($enrollmentCount >= ($maxSlots * 0.8)) {
            return 'Limited';
        } else {
            return 'Available';
        }
    }

    public function store(Request $request)
    {
        // First validate the grade level
        $gradeValidation = $request->validate([
            'name' => 'required|string|max:255',
            'grade_id' => 'required|exists:grades,id',
            'description' => 'nullable|string'
        ]);

        // Get the grade level
        $grade = Grade::find($request->grade_id);
        $gradeLevel = $grade->level;

        // Additional validation rules based on grade level
        if ($gradeLevel >= 10) {
            $request->validate([
                'strand_id' => 'required|exists:strands,id',
            ]);
        }

        // Create the subject
        $validated = array_merge($gradeValidation, [
            'strand_id' => $gradeLevel >= 10 ? $request->strand_id : null,
            'code' => strtolower(preg_replace('/[^a-z0-9]/', '', $request->name)) . rand(100, 999)
        ]);

        Subject::create($validated);
        return redirect()->back()->with('success', 'Subject added successfully');
    }

    public function update(Request $request, Subject $subject)
    {
        // First validate the grade level
        $gradeValidation = $request->validate([
            'name' => 'required|string|max:255',
            'grade_id' => 'required|exists:grades,id',
            'description' => 'nullable|string'
        ]);

        // Get the grade level
        $grade = Grade::find($request->grade_id);
        $gradeLevel = $grade->level;

        // Additional validation rules based on grade level
        if ($gradeLevel >= 10) {
            $request->validate([
                'strand_id' => 'required|exists:strands,id',
            ]);
        }

        // Update the subject
        $validated = array_merge($gradeValidation, [
            'strand_id' => $gradeLevel >= 10 ? $request->strand_id : null
        ]);

        $subject->update($validated);
        return redirect()->back()->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully');
    }

    public function updateEnrollmentStatus(Request $request, Subject $subject, User $user)
    {
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected'
        ]);

        $subject->users()->updateExistingPivot($user->id, [
            'status' => $validated['status'],
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Enrollment status updated successfully');
    }
}