<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::where('tenant_id', tenant_id())->get();

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
            'tenant_id' => tenant_id(),
            'admission_no' => $request->admission_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'class' => $request->class,
            'section' => $request->section,
            'admission_date' => $request->admission_date
        ]);

        return redirect('/students')->with('success', 'Student added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
