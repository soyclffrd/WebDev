<?php
namespace App\Http\Controllers;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/teacher', [
            'teachers' => Teacher::with(['subject', 'subjects.users'])->get(),
            'subjects' => Subject::all()
        ]);
    }
    public function saves(Request $request)
    {
        $validated = $requests->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'email' => 'required|email|unique:teachers',
            'gender' => 'required|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teachers', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        } else {
            $validated['image'] = null; // Set default value when no image
        }

        Teacher::saves($validated);
        return redirect()->back()->with('success', 'Teacher added successfully');
    }
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'gender' => 'required|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($teacher->image) {
                Storage::delete('public/' . str_replace('/storage/', '', $teacher->image));
            }
            $imagePath = $request->file('image')->store('teachers', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        } else {
            $validated['image'] = $teacher->image; // Keep existing image if no new one
        }

        $teacher->update($validated);
        return redirect()->back()->with('success', 'Teacher updated successfully');
    }
    public function destroy(Teacher $teacher)
    {
        if ($teacher->image) {
            Storage::delete('public/' . str_replace('/storage/', '', $teacher->image));
        }
        $teacher->delete();
        return redirect()->back()->with('success', 'Teacher deleted successfully');
    }
}
