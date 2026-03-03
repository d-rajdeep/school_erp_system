<?php

namespace App\Http\Controllers;

use App\Models\StudentAdmission;
use App\Models\StudentRegister;
use App\Models\Classes;
use App\Models\Section;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StudentAdmissionController extends Controller
{
    public function index()
    {
        $tenant_id = Auth::user()->tenant_id;

        // Eager load all related models to prevent database slowdowns
        $admissions = StudentAdmission::with(['student', 'schoolClass', 'section', 'academicYear'])
            ->where('tenant_id', $tenant_id)
            ->latest()
            ->get();

        return view('school_admin.admission.index', compact('admissions'));
    }

    public function create()
    {
        $tenant_id = Auth::user()->tenant_id;

        $students = StudentRegister::where('tenant_id', $tenant_id)->get();
        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $sections = Section::where('tenant_id', $tenant_id)->get();

        $activeYear = AcademicYear::where('tenant_id', $tenant_id)
            ->where('current_year', 1)
            ->first();

        return view('school_admin.admission.create', compact('students', 'classes', 'sections', 'activeYear'));
    }

    public function store(Request $request)
    {
        $tenant_id = \Illuminate\Support\Facades\Auth::user()->tenant_id;

        // 1. Validate the incoming request
        $validated = $request->validate([
            'student_id'     => 'required|exists:student_registers,id', // Validating the hidden input
            'class_id'       => 'required|exists:classes,id',
            'section_id'     => 'required|exists:sections,id',
            'year_id'        => 'required|exists:academic_years,id',
            'admission_date' => 'required|date',
            'roll_number'    => 'nullable|string|max:50',
            'fees_pay'       => 'nullable|in:0,1',
            // Check for duplicate admissions
            'student_id' => [
                'required',
                'exists:student_registers,id',
                \Illuminate\Validation\Rule::unique('student_admissions')->where(function ($query) use ($request, $tenant_id) {
                    return $query->where('year_id', $request->year_id)
                        ->where('tenant_id', $tenant_id);
                })
            ],
        ], [
            'student_id.unique' => 'This student is already admitted to a class for the selected academic year.',
        ]);

        // 2. Auto-generate an Admission Number
        $lastAdmission = StudentAdmission::where('tenant_id', $tenant_id)->orderBy('id', 'desc')->first();
        $nextAdmissionId = $lastAdmission ? $lastAdmission->id + 1 : 1;
        $validated['admission_no'] = 'ADM-' . date('Y') . '-' . str_pad($nextAdmissionId, 4, '0', STR_PAD_LEFT);

        // 3. Set defaults
        $validated['tenant_id'] = $tenant_id;
        $validated['status'] = 1;
        $validated['fees_pay'] = $request->has('fees_pay') ? $validated['fees_pay'] : '0';

        // 4. Save to database
        StudentAdmission::create($validated);

        return redirect()->route('school_admin.students.index')
            ->with('success', 'Student admitted successfully! Admission No: ' . $validated['admission_no']);
    }

    // Add this to StudentAdmissionController
    public function searchStudent(Request $request)
    {
        $tenant_id = \Illuminate\Support\Facades\Auth::user()->tenant_id;
        $regNo = $request->query('reg_no');

        // Search the StudentRegister table for the SCH0001 code
        $student = \App\Models\StudentRegister::where('tenant_id', $tenant_id)
            ->where('student_id', $regNo)
            ->first();

        if ($student) {
            return response()->json([
                'success' => true,
                'student' => [
                    'id' => $student->id, // Real database ID
                    'name' => $student->name // Name to show on screen
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No student found with this Registration Number.'
        ]);
    }

    public function edit($id)
    {
        $tenant_id = Auth::user()->tenant_id;

        $admission = StudentAdmission::with(['student', 'schoolClass', 'section', 'academicYear'])
            ->where('tenant_id', $tenant_id)
            ->findOrFail($id);

        $students  = StudentRegister::where('tenant_id', $tenant_id)->get();
        $classes   = Classes::where('tenant_id', $tenant_id)->get();
        $sections  = Section::where('tenant_id', $tenant_id)->get();
        $activeYear = AcademicYear::where('tenant_id', $tenant_id)
            ->where('current_year', 1)
            ->first();

        return view('school_admin.admission.edit', compact('admission', 'students', 'classes', 'sections', 'activeYear'));
    }

    public function update(Request $request, $id)
    {
        $tenant_id = Auth::user()->tenant_id;

        $admission = StudentAdmission::where('tenant_id', $tenant_id)->findOrFail($id);

        $validated = $request->validate([
            'student_id'     => [
                'required',
                'exists:student_registers,id',
                Rule::unique('student_admissions')->where(function ($query) use ($request, $tenant_id) {
                    return $query->where('year_id', $request->year_id)
                        ->where('tenant_id', $tenant_id);
                })->ignore($admission->id),
            ],
            'class_id'       => 'required|exists:classes,id',
            'section_id'     => 'required|exists:sections,id',
            'year_id'        => 'required|exists:academic_years,id',
            'admission_date' => 'required|date',
            'roll_number'    => 'nullable|string|max:50',
            'fees_pay'       => 'nullable|in:0,1',
            'status'         => 'nullable|in:0,1',
        ], [
            'student_id.unique' => 'This student is already admitted to a class for the selected academic year.',
        ]);

        $validated['fees_pay'] = $request->has('fees_pay') ? $validated['fees_pay'] : '0';

        $admission->update($validated);

        return redirect()->route('school_admin.students.index')
            ->with('success', 'Admission updated successfully! Admission No: ' . $admission->admission_no);
    }

    public function show($id)
    {
        $admission = StudentAdmission::with(['student', 'schoolClass', 'section', 'academicYear'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        return view('school_admin.admission.show', compact('admission'));
    }

    public function destroy($id)
    {
        $tenant_id = Auth::user()->tenant_id;

        $admission = StudentAdmission::where('tenant_id', $tenant_id)->findOrFail($id);
        $admissionNo = $admission->admission_no;

        $admission->delete();

        return redirect()->route('school_admin.students.index')
            ->with('success', 'Admission ' . $admissionNo . ' deleted successfully.');
    }
}
