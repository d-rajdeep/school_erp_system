<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::where('tenant_id', Auth::user()->tenant_id)
            ->with('class')
            ->latest()
            ->get();

        return view('school_admin.sections.index', compact('sections'));
    }


    public function create()
    {
        $classes = Classes::where('tenant_id', Auth::user()->tenant_id)
            ->get();

        return view('school_admin.sections.create', compact('classes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'name' => 'required'
        ]);

        Section::create([
            'tenant_id' => Auth::user()->tenant_id,
            'class_id' => $request->class_id,
            'name' => $request->name
        ]);

        return redirect()
            ->route('school_admin.sections.index')
            ->with('success', 'Section created successfully');
    }


    public function edit($id)
    {
        $section = Section::findOrFail($id);

        $classes = Classes::where('tenant_id', Auth::user()->tenant_id)
            ->get();

        return view(
            'school_admin.sections.edit',
            compact('section', 'classes')
        );
    }


    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $section->update([
            'class_id' => $request->class_id,
            'name' => $request->name
        ]);

        return redirect()
            ->route('school_admin.sections.index')
            ->with('success', 'Section updated successfully');
    }


    public function destroy($id)
    {
        Section::destroy($id);

        return redirect()
            ->route('school_admin.sections.index')
            ->with('success', 'Section deleted successfully');
    }
}
