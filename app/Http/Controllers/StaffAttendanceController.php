<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAttendanceController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    public function index(Request $request)
    {
        $tenant_id = $this->getTenantId();
        $attendanceDate = $request->date ?? date('Y-m-d');

        // Load all active teachers and their attendance for the selected date
        $staff = Teacher::with(['attendances' => function ($query) use ($attendanceDate, $tenant_id) {
            $query->where('attendance_date', $attendanceDate)
                ->where('tenant_id', $tenant_id);
        }])
            ->where('tenant_id', $tenant_id)
            ->where('status', 1)
            ->get();

        return view('school_admin.attendance.staff', compact('staff', 'attendanceDate'));
    }

    public function store(Request $request)
    {
        $tenant_id = $this->getTenantId();

        $request->validate([
            'attendance_date' => 'required|date',
            'attendance' => 'required|array', // Array of teacher_id => status
        ]);

        $date = $request->attendance_date;

        $statusMap = ['present' => 1, 'absent' => 2, 'late' => 3];

        foreach ($request->attendance as $teacher_id => $status) {
            StaffAttendance::updateOrCreate(
                [
                    'tenant_id'       => $tenant_id,
                    'teacher_id'      => $teacher_id,
                    'attendance_date' => $date,
                ],
                [
                    'status' => $statusMap[$status] ?? 1,
                ]
            );
        }

        return back()->with('success', 'Staff Attendance saved successfully for ' . date('d-M-Y', strtotime($date)));
    }

    public function report(Request $request)
    {
        $tenant_id = $this->getTenantId();

        // Get teachers for the filter dropdown
        $teachers = Teacher::where('tenant_id', $tenant_id)->where('status', 1)->get();

        // Start building the query
        $query = StaffAttendance::with('teacher')->where('tenant_id', $tenant_id);

        // 1. Filter by Teacher
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        // 2. Filter by Exact Date
        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        }

        // 3. Filter by Month
        if ($request->filled('month')) {
            $query->whereMonth('attendance_date', $request->month);
        }

        // 4. Filter by Year
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

        return view('school_admin.attendance.staff_report', compact('teachers', 'attendances'));
    }
}
