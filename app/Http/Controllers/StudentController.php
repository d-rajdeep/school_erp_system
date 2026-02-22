<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('school_admin.students.index', compact('students'));
    }


    public function create()
    {
        return view('school_admin.students.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'admission_no' => 'required|unique:students',
            'name' => 'required'
        ]);

        Student::create([
            'tenant_id' => auth()->user()->tenant_id,
            'admission_no' => $request->admission_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'class' => $request->class,
            'section' => $request->section,
            'admission_date' => $request->admission_date
        ]);

        return redirect()->route('school_admin.students.index')
            ->with('success', 'Student added');
    }
}
