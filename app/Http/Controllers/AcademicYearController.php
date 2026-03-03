<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademicYearController extends Controller
{
    // Helper function to get current tenant
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    public function index()
    {
        // FIX: Only load academic years for THIS specific school
        $data = AcademicYear::where('tenant_id', $this->getTenantId())
            ->latest()
            ->get();

        return view('school_admin.year.index', compact('data'));
    }

    public function create()
    {
        return view('school_admin.year.create');
    }

    public function store(Request $request)
    {
        $tenant_id = $this->getTenantId();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'current_year' => 'required|in:0,1',
        ]);

        $data['tenant_id'] = $tenant_id;

        if ($data['current_year'] == 1) {
            AcademicYear::where('tenant_id', $tenant_id)
                ->where('current_year', 1)
                ->update(['current_year' => 0]);
        }

        AcademicYear::create($data);

        return redirect()->route('school_admin.year.index')
            ->with('success', 'Year created successfully');
    }

    public function status($id)
    {
        // FIX: Ensure the user can't change the status of another school's year via URL tampering
        $data = AcademicYear::where('tenant_id', $this->getTenantId())->findOrFail($id);

        $data->status = $data->status == 1 ? 2 : 1;
        $data->save();

        return back()->with('success', 'Status Update Successfully !!');
    }

    public function setYearActive(Request $request)
    {
        try {
            $tenant_id = $this->getTenantId();

            // Find the year and ensure it belongs to this tenant
            $year = AcademicYear::where('tenant_id', $tenant_id)
                ->findOrFail($request->id);

            $year->current_year = 1;
            $year->save();

            // ONLY deactivate other years for THIS specific school!
            AcademicYear::where('tenant_id', $tenant_id)
                ->where('id', '!=', $request->id)
                ->update(['current_year' => 0]);

            return response()->json(['success' => true, 'message' => 'Year Activated Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Year not found or unauthorized.']);
        }
    }

    public function delete(Request $request)
    {
        try {
            // FIX: Ensure they can only delete their own data
            $data = AcademicYear::where('tenant_id', $this->getTenantId())->findOrFail($request->id);
            $data->delete();

            return redirect()->back()->with('success', 'Year Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
