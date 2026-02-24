<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;


class AcademicYearController extends Controller
{
    public function index()
    {
        $data = AcademicYear::latest()->get();
        return view('school_admin.year.index', compact('data'));
    }

    public function create()
    {
        return view('school_admin.year.create');
    }

    public function store(Request $request)
    {
        $tenant_id = \Illuminate\Support\Facades\Auth::user()->tenant_id;

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'current_year' => 'required|in:0,1',
        ]);

        // Add the tenant_id to the data array BEFORE saving
        $data['tenant_id'] = $tenant_id;

        if ($data['current_year'] == 1) {
            // ONLY deactivate years for THIS specific school!
            AcademicYear::where('tenant_id', $tenant_id)
                ->where('current_year', 1)
                ->update(['current_year' => 0]);
        }

        AcademicYear::create($data);

        return redirect()->route('school_admin.year.index')
            ->with('success', 'Year created successfully');
    }

    public function form($id = null)
    {
        if ($id) {
            $id = hashid()->decode($id);
            $data = AcademicYear::findOrFail($id);
            return view('admin.academic.year.form', compact('data'));
        } else {
            return view('admin.academic.year.form');
        }
    }

    public function submit(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'id' => 'nullable|numeric|exists:student_years,id',
            'name' => 'required|string|unique:student_years,name,' . $request->post('id'),
        ]);

        $id = $request->id;

        if ($id) {
            $data = AcademicYear::findOrFail($id);
            $msg = "Year Update Successfully !!";
        } else {
            $data = new AcademicYear();
            $msg = "Year Add Successfully !!";
        }

        $data->name = $request->name;
        $data->save();
        return redirect()->route('admin.academic.year.list')->with('success', $msg);
    }

    public function status($id)
    {
        $data = AcademicYear::findOrFail($id);
        $data->status = $data->status == 1 ? 2 : 1;
        $data->save();
        return back()->with('success', 'Status Update Successfully !!');
    }

    public function setYearActive(Request $request)
    {
        try {
            $tenant_id = \Illuminate\Support\Facades\Auth::user()->tenant_id;

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
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function delete(Request $request)
    {
        try {
            $data = AcademicYear::findOrFail($request->id);
            $data->delete();

            return redirect()->back()->with('success', 'Year Deleted Successfully');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
