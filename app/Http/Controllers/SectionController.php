<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::where('tenant_id', Auth::user()->tenant_id)
            ->latest()
            ->get();

        return view('school_admin.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('school_admin.sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Section::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name'      => $request->name,
        ]);

        return redirect()
            ->route('school_admin.sections.index')
            ->with('success', 'Section created successfully.');
    }

    public function edit($id)
    {
        $section = Section::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        return view('school_admin.sections.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $section = Section::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $section->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('school_admin.sections.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy($id)
    {
        $section = Section::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $section->delete();

        return redirect()
            ->route('school_admin.sections.index')
            ->with('success', 'Section deleted successfully.');
    }
}
