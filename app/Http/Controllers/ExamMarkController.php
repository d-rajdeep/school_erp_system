<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\StudentAdmission;
use App\Models\ExamMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamMarkController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    // --- BULK ENTRY METHODS ---

    public function entry(Request $request)
    {
        $tenant_id = $this->getTenantId();

        $exams = Exam::where('tenant_id', $tenant_id)->where('status', 1)->get();
        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $sections = Section::where('tenant_id', $tenant_id)->get();
        $subjects = Subject::where('tenant_id', $tenant_id)->where('status', 1)->get();

        $students = [];

        if ($request->filled(['exam_id', 'class_id', 'section_id', 'subject_id'])) {
            $students = StudentAdmission::with(['student', 'student.examMarks' => function ($query) use ($request, $tenant_id) {
                $query->where('exam_id', $request->exam_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('tenant_id', $tenant_id);
            }])
                ->where('tenant_id', $tenant_id)
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->where('status', 1)
                ->get();
        }

        return view('school_admin.exams.marks_entry', compact('exams', 'classes', 'sections', 'subjects', 'students'));
    }

    public function store(Request $request)
    {
        $tenant_id = $this->getTenantId();

        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'total_marks' => 'required|numeric|min:1',
            'marks' => 'required|array',
        ]);

        foreach ($request->marks as $student_id => $obtained_marks) {
            // Skip empty inputs
            if (is_null($obtained_marks)) continue;

            // Calculate Grade dynamically
            $percentage = ($obtained_marks / $request->total_marks) * 100;
            $grade = $this->calculateGrade($percentage);

            ExamMark::updateOrCreate(
                [
                    'tenant_id' => $tenant_id,
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'student_id' => $student_id,
                ],
                [
                    'class_id' => $request->class_id,
                    'section_id' => $request->section_id,
                    'total_marks' => $request->total_marks,
                    'obtained_marks' => $obtained_marks,
                    'grade' => $grade,
                ]
            );
        }

        return back()->with('success', 'Marks saved successfully!');
    }

    // --- SINGLE RECORD CRUD METHODS ---

    // Displays a paginated list of all entered marks for quick searching
    public function index(Request $request)
    {
        $tenant_id = $this->getTenantId();

        // 1. Fetch data for the filter dropdowns
        $exams = Exam::where('tenant_id', $tenant_id)->get();
        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $sections = Section::where('tenant_id', $tenant_id)->get();

        // 2. Start the query
        $query = ExamMark::with(['student', 'exam', 'subject', 'schoolClass', 'section'])
            ->where('tenant_id', $tenant_id);

        // 3. Apply Filters if they exist in the request
        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->filled('student_name')) {
            // Search inside the related 'student' table
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student_name . '%');
            });
        }

        // 4. Paginate the results (50 per page is a safe number)
        $marks = $query->latest()->paginate(50);

        return view('school_admin.exams.marks_index', compact('marks', 'exams', 'classes', 'sections'));
    }

    public function edit($id)
    {
        $tenant_id = $this->getTenantId();
        $mark = ExamMark::with(['student', 'exam', 'subject'])->where('tenant_id', $tenant_id)->findOrFail($id);

        return view('school_admin.exams.marks_edit', compact('mark'));
    }

    public function update(Request $request, $id)
    {
        $tenant_id = $this->getTenantId();
        $mark = ExamMark::where('tenant_id', $tenant_id)->findOrFail($id);

        $validated = $request->validate([
            'total_marks'    => 'required|numeric|min:1',
            'obtained_marks' => 'required|numeric|min:0|lte:total_marks', // Ensure obtained is less than or equal to total
            'remarks'        => 'nullable|string|max:255',
        ]);

        // Recalculate Grade dynamically
        $percentage = ($validated['obtained_marks'] / $validated['total_marks']) * 100;
        $validated['grade'] = $this->calculateGrade($percentage);

        $mark->update($validated);

        return redirect()->route('school_admin.exams.marks_index')
            ->with('success', 'Student mark updated successfully!');
    }

    public function marksheet($exam_id, $student_id)
    {
        $tenant_id = $this->getTenantId();

        // 1. Fetch the Student details
        $student = StudentAdmission::with(['student', 'schoolClass', 'section'])
            ->where('tenant_id', $tenant_id)
            ->where('student_id', $student_id)
            ->firstOrFail();

        // 2. Fetch the Exam details
        $exam = Exam::where('tenant_id', $tenant_id)->findOrFail($exam_id);

        // 3. Fetch all marks for this student in this specific exam
        $marks = ExamMark::with('subject')
            ->where('tenant_id', $tenant_id)
            ->where('exam_id', $exam_id)
            ->where('student_id', $student_id)
            ->get();

        // If no marks exist, redirect back with a warning
        if ($marks->isEmpty()) {
            return back()->with('error', 'No marks found for this student in the selected exam.');
        }

        // 4. Calculate Totals
        $grandTotal = $marks->sum('total_marks');
        $totalObtained = $marks->sum('obtained_marks');
        $percentage = $grandTotal > 0 ? ($totalObtained / $grandTotal) * 100 : 0;
        $overallGrade = $this->calculateGrade($percentage);

        // Determine Pass/Fail (Assuming 33% is the passing mark)
        $resultStatus = $percentage >= 33 ? 'PASS' : 'FAIL';

        return view('school_admin.exams.marksheet', compact(
            'student',
            'exam',
            'marks',
            'grandTotal',
            'totalObtained',
            'percentage',
            'overallGrade',
            'resultStatus'
        ));
    }

    public function destroy($id)
    {
        $mark = ExamMark::where('tenant_id', $this->getTenantId())->findOrFail($id);
        $mark->delete();

        return back()->with('success', 'Student mark deleted successfully!');
    }

    // --- HELPER METHOD ---

    private function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        return 'F';
    }
}
