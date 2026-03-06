<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Section;
use App\Models\StudentAdmission;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    // Step 1: Show the form to select Class, Section, and Date
    public function index(Request $request)
    {
        $tenant_id = $this->getTenantId();
        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $sections = Section::where('tenant_id', $tenant_id)->get();

        $students = [];
        $attendanceDate = $request->date ?? date('Y-m-d');
        $selectedClass = $request->class_id;
        $selectedSection = $request->section_id;

        // Step 2: Load students if class and section are selected
        if ($selectedClass && $selectedSection) {
            $students = StudentAdmission::with(['student', 'student.attendances' => function ($query) use ($attendanceDate, $tenant_id) {
                // Pre-load today's attendance if it exists, so the UI can show currently saved status
                $query->where('attendance_date', $attendanceDate)
                    ->where('tenant_id', $tenant_id);
            }])
                ->where('tenant_id', $tenant_id)
                ->where('class_id', $selectedClass)
                ->where('section_id', $selectedSection)
                ->where('status', 1) // Active students only
                ->get();
        }

        return view('school_admin.attendance.student', compact('classes', 'sections', 'students', 'attendanceDate', 'selectedClass', 'selectedSection'));
    }

    // Step 3: Bulk save the attendance
    public function store(Request $request)
    {
        $tenant_id = $this->getTenantId();

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array', // Array of student_id => status
        ]);

        $date = $request->attendance_date;

        $statusMap = ['present' => 1, 'absent' => 2, 'late' => 3, 'leave' => 4];

        foreach ($request->attendance as $student_id => $status) {
            StudentAttendance::updateOrCreate(
                [
                    'tenant_id'       => $tenant_id,
                    'student_id'      => $student_id,
                    'attendance_date' => $date,
                ],
                [
                    'class_id'   => $request->class_id,
                    'section_id' => $request->section_id,
                    'status'     => $statusMap[$status] ?? 1,
                ]
            );
        }

        return back()->with('success', 'Student Attendance saved successfully for ' . date('d-M-Y', strtotime($date)));
    }

    public function report(Request $request)
    {
        $tenant_id = $this->getTenantId();

        // Fetch classes and sections for the filter dropdowns
        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $sections = Section::where('tenant_id', $tenant_id)->get();

        // Start building the query with relationships
        $query = StudentAttendance::with(['student', 'schoolClass', 'section'])->where('tenant_id', $tenant_id);

        // 1. Filter by Class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // 2. Filter by Section
        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        // 3. Filter by Exact Date
        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        }

        // 4. Filter by Month
        if ($request->filled('month')) {
            $query->whereMonth('attendance_date', $request->month);
        }

        // 5. Filter by Year
        if ($request->filled('year')) {
            $query->whereYear('attendance_date', $request->year);
        }

        // Fallback: If no date filters are applied, show the current month by default
        if (!$request->filled('date') && !$request->filled('month') && !$request->filled('year')) {
            $query->whereMonth('attendance_date', date('m'))
                ->whereYear('attendance_date', date('Y'));
        }

        // Get the results, ordered by date (newest first)
        $attendances = $query->orderBy('attendance_date', 'desc')->get();

        return view('school_admin.attendance.student_report', compact('classes', 'sections', 'attendances'));
    }
}
