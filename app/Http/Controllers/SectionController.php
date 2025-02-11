<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Section', [
            'sections' => Section::with('students')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sections',
            'description' => 'nullable|string'
        ]);

        Section::create($validated);

        return redirect()->back()->with('success', 'Section added successfully');
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sections,name,' . $section->id,
            'description' => 'nullable|string'
        ]);

        $section->update($validated);

        return redirect()->back()->with('success', 'Section updated successfully');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->back()->with('success', 'Section deleted successfully');
    }
} 