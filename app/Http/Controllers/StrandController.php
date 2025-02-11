<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StrandController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Strand', [
            'strands' => Strand::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        Strand::create($validated);
        return redirect()->back()->with('success', 'Strand added successfully');
    }

    public function update(Request $request, Strand $strand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $strand->update($validated);
        return redirect()->back()->with('success', 'Strand updated successfully');
    }

    public function destroy(Strand $strand)
    {
        $strand->delete();
        return redirect()->back()->with('success', 'Strand deleted successfully');
    }
} 