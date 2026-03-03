<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{
    public function index()
    {
        $classes = Classes::where('tenant_id', Auth::user()->tenant_id)
            ->latest()
            ->get();

        return view('school_admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('school_admin.classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Classes::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name'      => $request->name,
        ]);

        return redirect()->route('school_admin.classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function edit($id)
    {
        $class = Classes::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        return view('school_admin.classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class = Classes::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $class->update([
            'name' => $request->name,
        ]);

        return redirect()->route('school_admin.classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy($id)
    {
        $class = Classes::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $class->delete();

        return redirect()->route('school_admin.classes.index')
            ->with('success', 'Class deleted successfully.');
    }
}
