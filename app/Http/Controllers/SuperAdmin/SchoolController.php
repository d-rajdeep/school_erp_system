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
        $schools = School::all();

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
