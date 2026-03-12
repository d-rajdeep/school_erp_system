<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::with('admin')
            ->withCount([
                'students',
                'teachers',
                'classes',
            ])
            ->latest()
            ->get();

        return view('super_admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('super_admin.schools.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:schools',
            'admin_name' => 'required',
            'admin_email' => 'required|unique:users,email',
            'admin_password' => 'required|min:6'
        ]);

        // Create school
        $school = School::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        // Create school admin
        $admin = User::create([
            'tenant_id' => $school->id,
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->admin_password)
        ]);

        // Assign role
        $admin->assignRole('school_admin');

        // Update school admin reference
        $school->update([
            'school_admin_id' => $admin->id
        ]);

        return redirect('/schools')->with('success', 'School created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $school = School::findOrFail($id);

        // Fetch the admin user associated with this school
        // Assuming you save the admin ID in school_admin_id or tenant_id
        $admin = User::where('tenant_id', $school->id)->first();

        return view('super_admin.schools.edit', compact('school', 'admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $school = School::findOrFail($id);
        $admin = User::where('tenant_id', $school->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            // Ignore current school's code for unique validation
            'code' => 'required|string|max:255|unique:schools,code,' . $school->id,
            'admin_name' => 'required|string|max:255',
            // Ignore current admin's email for unique validation
            'admin_email' => 'required|email|unique:users,email,' . ($admin ? $admin->id : ''),
            'admin_password' => 'nullable|min:6'
        ]);

        // Update school
        $school->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        // Update school admin
        if ($admin) {
            $adminData = [
                'name' => $request->admin_name,
                'email' => $request->admin_email,
            ];

            // Only hash and update password if the field was filled
            if ($request->filled('admin_password')) {
                $adminData['password'] = Hash::make($request->admin_password);
            }

            $admin->update($adminData);
        }

        return redirect()->route('super_admin.schools.index')
            ->with('success', 'School updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $school = School::findOrFail($id);
        $tenant_id = $school->id;

        // 1. Check if crucial related data exists
        $hasStudents = \App\Models\StudentRegister::where('tenant_id', $tenant_id)->exists();
        $hasTeachers = \App\Models\Teacher::where('tenant_id', $tenant_id)->exists();
        $hasClasses = \App\Models\Classes::where('tenant_id', $tenant_id)->exists();

        // 2. Block deletion if data exists
        if ($hasStudents || $hasTeachers || $hasClasses) {
            return redirect()->route('super_admin.schools.index')
                ->with('error', 'Action Denied: This school contains active records (students, teachers, or classes). Please remove them first.');
        }

        // 3. Safe to delete: Delete users of this school first
        \App\Models\User::where('tenant_id', $tenant_id)->delete();

        // 4. Delete the school itself
        $school->delete();

        return redirect()->route('super_admin.schools.index')
            ->with('success', 'School deleted successfully.');
    }
}
