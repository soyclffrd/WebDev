<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Strand;
use App\Models\Grade;
use App\Models\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Student', [
            'students' => Student::with(['grade', 'strand', 'section'])->get(),
            'sections' => Section::all(),
            'grades' => Grade::all(),
            'strands' => Strand::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'grade_id' => 'required|exists:grades,id',
            'strand_id' => 'required|exists:strands,id',
            'section_id' => 'required|exists:sections,id',
            'gender' => 'required|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('students', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        }

        Student::create($validated);
        return redirect()->back()->with('success', 'Student added successfully');
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'gender' => 'required|in:Male,Female',
            'grade_id' => 'required|exists:grades,id',
            'section_id' => 'required|exists:sections,id',
            'strand_id' => 'required|exists:strands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($student->image) {
                Storage::delete('public/' . str_replace('/storage/', '', $student->image));
            }
            $imagePath = $request->file('image')->store('students', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        }

        $student->update($validated);
        return redirect()->back()->with('success', 'Student updated successfully');
    }

    public function destroy(Student $student)
    {
        if ($student->image) {
            Storage::delete('public/' . str_replace('/storage/', '', $student->image));
        }
        
        $student->delete();
        return redirect()->back()->with('success', 'Student deleted successfully');
    }
}