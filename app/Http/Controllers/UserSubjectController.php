<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Subject;
use Illuminate\Http\Request;

class UserSubjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get all available subjects for the user's grade level
        $availableSubjects = Subject::with(['teacher', 'grade'])
            ->where(function($query) use ($user) {
                // Get subjects for user's grade level
                $query->where('grade_id', $user->grade_id);
                
                // If user is in senior high, also check strand
                if ($user->grade && $user->grade->level >= 11) {
                    $query->where('strand_id', $user->strand_id);
                }
            })
            ->whereDoesntHave('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->available() // Use the scope we defined in Subject model
            ->get()
            ->map(function($subject) {
                return [
                    'id' => $subject->id,
                    'code' => $subject->code,
                    'name' => $subject->name,
                    'teacher' => $subject->teacher ? [
                        'name' => $subject->teacher->name
                    ] : null,
                    'grade' => $subject->grade ? [
                        'level' => $subject->grade->level
                    ] : null,
                    'schedule' => $subject->schedule,
                    'available_slots' => 40 - $subject->users()->count(),
                    'status' => 'Available'
                ];
            });

        // Get user's enrolled subjects
        $enrolledSubjects = $user->subjects()
            ->with(['teacher', 'grade'])
            ->get()
            ->map(function($subject) {
                return [
                    'id' => $subject->id,
                    'code' => $subject->code,
                    'name' => $subject->name,
                    'teacher' => $subject->teacher ? [
                        'name' => $subject->teacher->name
                    ] : null,
                    'schedule' => $subject->schedule,
                    'status' => $subject->pivot->status
                ];
            });

        return Inertia::render('User/MySubjects', [
            'availableSubjects' => $availableSubjects,
            'enrolledSubjects' => $enrolledSubjects,
            'user' => [
                'id' => $user->id,
                'grade_level' => $user->grade ? $user->grade->level : null,
                'strand' => $user->strand ? $user->strand->name : null
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string',
            'subject_name' => 'required|string',
            'teacher_name' => 'required|string',
            'schedule' => 'required|string'
        ]);

        auth()->user()->subjects()->create($validated);
        return redirect()->back()->with('success', 'Subject added successfully');
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string',
            'subject_name' => 'required|string',
            'teacher_name' => 'required|string',
            'schedule' => 'required|string'
        ]);

        $subject->update($validated);
        return redirect()->back()->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully');
    }

    public function enroll(Request $request, Subject $subject)
    {
        $user = auth()->user();
        
        // Check if already enrolled
        if ($user->subjects()->where('subject_id', $subject->id)->exists()) {
            return redirect()->back()->with('error', 'Already enrolled in this subject');
        }

        // Enroll with pending status
        $user->subjects()->attach($subject->id, [
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Enrollment request submitted');
    }

    public function requestDrop(Request $request, Subject $subject)
    {
        $user = auth()->user();
        
        $enrollment = $user->subjects()
            ->where('subject_id', $subject->id)
            ->first();

        if (!$enrollment) {
            return redirect()->back()->with('error', 'Not enrolled in this subject');
        }

        // Update status to "Drop Requested"
        $user->subjects()->updateExistingPivot($subject->id, [
            'status' => 'Drop Requested',
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Drop request submitted');
    }
} 