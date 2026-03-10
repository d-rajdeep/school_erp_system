<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    public function index()
    {
        $exams = Exam::with('academicYear')
            ->where('tenant_id', $this->getTenantId())
            ->latest()
            ->get();

        return view('school_admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $years = AcademicYear::where('tenant_id', $this->getTenantId())->get();
        return view('school_admin.exams.create', compact('years'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year_id'    => 'required|exists:academic_years,id',
            'name'       => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'status'     => 'nullable|in:0,1',
        ]);

        $validated['tenant_id'] = $this->getTenantId();
        $validated['status'] = $request->has('status') ? $request->status : 1;

        Exam::create($validated);

        return redirect()->route('school_admin.exams.index')
            ->with('success', 'Exam created successfully!');
    }

    public function edit($id)
    {
        $tenant_id = $this->getTenantId();
        $exam = Exam::where('tenant_id', $tenant_id)->findOrFail($id);
        $years = AcademicYear::where('tenant_id', $tenant_id)->get();

        return view('school_admin.exams.edit', compact('exam', 'years'));
    }

    public function update(Request $request, $id)
    {
        $tenant_id = $this->getTenantId();
        $exam = Exam::where('tenant_id', $tenant_id)->findOrFail($id);

        $validated = $request->validate([
            'year_id'    => 'required|exists:academic_years,id',
            'name'       => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'status'     => 'nullable|in:0,1',
        ]);

        $validated['status'] = $request->has('status') ? $request->status : 0;

        $exam->update($validated);

        return redirect()->route('school_admin.exams.index')
            ->with('success', 'Exam updated successfully!');
    }

    public function destroy($id)
    {
        $exam = Exam::where('tenant_id', $this->getTenantId())->findOrFail($id);
        $exam->delete();

        return redirect()->route('school_admin.exams.index')
            ->with('success', 'Exam deleted successfully!');
    }
}
