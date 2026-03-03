<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\StudentRegister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $school = Auth::user()->school;

        $data = [
            'school' => $school,
            'totalStudents' => StudentRegister::where('tenant_id', $school->id)->count(),
            // 'totalTeachers' => Teacher::where('school_id', $school->id)->count(),
            // 'totalClasses' => Classes::where('school_id', $school->id)->count(),
            'todayAttendance' => 85, // Calculate based on your attendance logic
        ];

        return view('school_admin.dashboard', compact('school'));
    }
}
