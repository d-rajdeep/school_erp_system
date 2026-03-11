<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\FeeType;
use App\Models\Classes;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeStructureController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    public function index(Request $request)
    {
        $tenant_id = $this->getTenantId();

        // Load relations for the table
        $query = FeeStructure::with(['schoolClass', 'feeType', 'academicYear'])
            ->where('tenant_id', $tenant_id);

        // Optional filtering by class or year
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('year_id')) {
            $query->where('year_id', $request->year_id);
        }

        $structures = $query->latest()->get();

        // Dropdowns for the filter and create forms
        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $years = AcademicYear::where('tenant_id', $tenant_id)->get();
        $feeTypes = FeeType::where('tenant_id', $tenant_id)->get();

        return view('school_admin.fees.structure_index', compact('structures', 'classes', 'years', 'feeTypes'));
    }

    public function store(Request $request)
    {
        $tenant_id = $this->getTenantId();

        $validated = $request->validate([
            'year_id' => 'required|exists:academic_years,id',
            'class_id' => 'required|exists:classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $validated['tenant_id'] = $tenant_id;

        // Prevent duplicate fee types for the same class in the same year
        $exists = FeeStructure::where('tenant_id', $tenant_id)
            ->where('year_id', $validated['year_id'])
            ->where('class_id', $validated['class_id'])
            ->where('fee_type_id', $validated['fee_type_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This fee type is already assigned to this class for the selected academic year. Please edit the existing record instead.');
        }

        FeeStructure::create($validated);

        return back()->with('success', 'Fee Structure assigned successfully!');
    }

    public function edit($id)
    {
        $tenant_id = $this->getTenantId();

        // Fetch the specific fee structure along with its relationships
        $structure = FeeStructure::with(['schoolClass', 'feeType', 'academicYear'])
            ->where('tenant_id', $tenant_id)
            ->findOrFail($id);

        // Load dropdown data so we can display the names in the edit view
        $classes = Classes::where('tenant_id', $tenant_id)->get();
        $years = AcademicYear::where('tenant_id', $tenant_id)->get();
        $feeTypes = FeeType::where('tenant_id', $tenant_id)->get();

        return view('school_admin.fees.structure_edit', compact('structure', 'classes', 'years', 'feeTypes'));
    }

    public function update(Request $request, $id)
    {
        $tenant_id = $this->getTenantId();
        $structure = FeeStructure::where('tenant_id', $tenant_id)->findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            // Typically, you only allow editing the amount.
            // If they picked the wrong class/fee type, they should delete and recreate it.
        ]);

        $structure->update($validated);

        return back()->with('success', 'Fee amount updated successfully!');
    }

    public function destroy($id)
    {
        $structure = FeeStructure::where('tenant_id', $this->getTenantId())->findOrFail($id);
        $structure->delete();

        return back()->with('success', 'Fee Structure removed successfully!');
    }
}
