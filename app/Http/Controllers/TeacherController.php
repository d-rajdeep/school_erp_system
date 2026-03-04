<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    // Helper function to ensure strict multi-tenancy
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    public function index()
    {
        $teachers = Teacher::where('tenant_id', $this->getTenantId())
            ->latest()
            ->get();

        return view('school_admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('school_admin.teachers.create');
    }

    public function store(Request $request)
    {
        $tenant_id = $this->getTenantId();

        // 1. Validate ALL fields based on the migration
        $validated = $request->validate([
            'fullname'       => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'mobile'         => 'nullable|string|max:20',
            'password'       => 'required|string|min:6',
            'address'        => 'nullable|string',
            'gender'         => 'nullable|in:1,2,3',
            'profile'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'father_name'    => 'nullable|string|max:255',
            'mother_name'    => 'nullable|string|max:255',
            'religion'       => 'nullable|string|max:255',
            'dob'            => 'nullable|date',
            'joining_date'   => 'nullable|date',
            'salary'         => 'nullable|numeric',
            'register_date'  => 'nullable|date',
            'bank_name'      => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code'      => 'nullable|string|max:255',
            'status'         => 'nullable|in:0,1',
        ]);

        // 2. Auto-generate the employee_register_id (e.g., EMPSCH012026)
        $lastTeacher = Teacher::where('tenant_id', $tenant_id)->orderBy('id', 'desc')->first();
        $nextId = $lastTeacher ? $lastTeacher->id + 1 : 1;

        // str_pad ensures single digits get a leading zero (1 becomes 01, 12 stays 12)
        $validated['employee_register_id'] = 'EMPSCH' . str_pad($nextId, 2, '0', STR_PAD_LEFT) . date('Y');

        // 3. Handle Profile Image Upload
        if ($request->hasFile('profile')) {
            $validated['profile'] = $request->file('profile')->store('teacher_profiles', 'public');
        }

        // 4. Set Defaults and Hash Password
        $validated['tenant_id'] = $tenant_id;
        $validated['password'] = Hash::make($request->password);
        $validated['status'] = $request->has('status') ? $request->status : 1;

        Teacher::create($validated);

        return redirect()->route('school_admin.teachers.index')
            ->with('success', 'Teacher added successfully! ID: ' . $validated['employee_register_id']);
    }

    public function edit($id)
    {
        // Fetch the teacher, ensuring they belong to this specific school
        $teacher = Teacher::where('tenant_id', $this->getTenantId())->findOrFail($id);

        return view('school_admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $tenant_id = $this->getTenantId();
        $teacher = Teacher::where('tenant_id', $tenant_id)->findOrFail($id);

        $validated = $request->validate([
            'fullname'       => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'mobile'         => 'nullable|string|max:20',
            'password'       => 'nullable|string|min:6', // Optional on update
            'address'        => 'nullable|string',
            'gender'         => 'nullable|in:1,2,3',
            'profile'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'father_name'    => 'nullable|string|max:255',
            'mother_name'    => 'nullable|string|max:255',
            'religion'       => 'nullable|string|max:255',
            'dob'            => 'nullable|date',
            'joining_date'   => 'nullable|date',
            'salary'         => 'nullable|numeric',
            'register_date'  => 'nullable|date',
            'bank_name'      => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code'      => 'nullable|string|max:255',
            'status'         => 'nullable|in:0,1',
        ]);

        // Handle Profile Image Upload & delete old image
        if ($request->hasFile('profile')) {
            if ($teacher->profile) {
                Storage::disk('public')->delete($teacher->profile);
            }
            $validated['profile'] = $request->file('profile')->store('teacher_profiles', 'public');
        }

        // Handle Password (only update if the user typed a new one)
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']); // Keep the old password
        }

        $teacher->update($validated);

        return redirect()->route('school_admin.teachers.index')
            ->with('success', 'Teacher profile updated successfully!');
    }

    public function show($id)
    {
        $teacher = Teacher::where('tenant_id', $this->getTenantId())
            ->findOrFail($id);

        return view('school_admin.teachers.show', compact('teacher'));
    }

    public function destroy($id)
    {
        $teacher = Teacher::where('tenant_id', $this->getTenantId())->findOrFail($id);

        // Delete the profile image from storage if it exists
        if ($teacher->profile) {
            Storage::disk('public')->delete($teacher->profile);
        }

        $teacher->delete();

        return redirect()->route('school_admin.teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}
