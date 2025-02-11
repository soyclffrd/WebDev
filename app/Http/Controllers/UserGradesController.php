<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Grade;
use Illuminate\Http\Request;

class UserGradesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $grades = $user->subjects()
            ->with(['teacher'])
            ->get()
            ->map(function($subject) {
                return [
                    'id' => $subject->id,
                    'subject' => [
                        'code' => $subject->code,
                        'name' => $subject->name,
                        'teacher' => $subject->teacher
                    ],
                    'midterm' => $subject->pivot->midterm_grade,
                    'finals' => $subject->pivot->final_grade,
                    'final_grade' => $subject->pivot->computed_grade,
                    'remarks' => $this->getRemarks($subject->pivot->computed_grade)
                ];
            });

        return Inertia::render('User/MyGrades', [
            'grades' => $grades
        ]);
    }

    private function getRemarks($grade)
    {
        if (!$grade) return null;
        return $grade >= 75 ? 'Passed' : 'Failed';
    }
} 