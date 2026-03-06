<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    // Helper function to ensure strict multi-tenancy
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    public function index()
    {
        $subjects = Subject::where('tenant_id', $this->getTenantId())
            ->latest()
            ->get();

        return view('school_admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('school_admin.subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:50',
            'type'   => 'required|in:1,2',
            'status' => 'nullable|in:0,1',
        ]);

        $validated['tenant_id'] = $this->getTenantId();
        $validated['status'] = $request->has('status') ? $request->status : 1;

        Subject::create($validated);

        return redirect()->route('school_admin.subjects.index')
            ->with('success', 'Subject created successfully!');
    }

    public function edit($id)
    {
        $subject = Subject::where('tenant_id', $this->getTenantId())->findOrFail($id);

        return view('school_admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::where('tenant_id', $this->getTenantId())->findOrFail($id);

        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:50',
            'type'   => 'required|in:1,2',
            'status' => 'nullable|in:0,1',
        ]);

        $subject->update($validated);

        return redirect()->route('school_admin.subjects.index')
            ->with('success', 'Subject updated successfully!');
    }

    public function destroy($id)
    {
        $subject = Subject::where('tenant_id', $this->getTenantId())->findOrFail($id);
        $subject->delete();

        return redirect()->route('school_admin.subjects.index')
            ->with('success', 'Subject deleted successfully!');
    }
}
