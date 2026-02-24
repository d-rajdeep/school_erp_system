<?php

namespace App\Http\Controllers;

use App\Models\StudentRegister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentRegisterController extends Controller
{
    public function index()
    {
        $students = StudentRegister::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('school_admin.register.index', compact('students'));
    }

    public function create()
    {
        return view('school_admin.register.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:1,2,3',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'fname' => 'nullable|string|max:255',
            'mname' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'register_date' => 'nullable|date',
            'year' => 'nullable|string|max:4',
            'transport' => 'nullable|string|max:255',
            'status' => 'nullable|in:1,2',
        ]);

        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('profiles', 'public');
            $validated['profile'] = $path;
        }

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }

        $validated['tenant_id'] = Auth::user()->tenant_id;

        $lastStudent = StudentRegister::where('tenant_id', Auth::user()->tenant_id)
            // Removed the whereYear line entirely
            ->orderBy('id', 'desc')
            ->first();

        if ($lastStudent && $lastStudent->student_id) {
            $lastNumber = intval(substr($lastStudent->student_id, 3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Generates: SCH0001, SCH0002... continuing forever
        $validated['student_id'] = 'SCH' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        StudentRegister::create($validated);

        return redirect()->route('school_admin.student.register.index')
            ->with('success', 'Student registered successfully. Student ID: ' . $validated['student_id']);
    }
}
