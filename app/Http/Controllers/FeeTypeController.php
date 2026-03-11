<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeTypeController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    public function index()
    {
        $feeTypes = FeeType::where('tenant_id', $this->getTenantId())->latest()->get();
        return view('school_admin.fees.types_index', compact('feeTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['tenant_id'] = $this->getTenantId();

        FeeType::create($validated);

        return back()->with('success', 'Fee Type created successfully!');
    }

    public function edit($id)
    {
        $tenant_id = $this->getTenantId();

        // Fetch the specific fee type
        $feeType = FeeType::where('tenant_id', $tenant_id)->findOrFail($id);

        return view('school_admin.fees.types_edit', compact('feeType'));
    }

    public function update(Request $request, $id)
    {
        $feeType = FeeType::where('tenant_id', $this->getTenantId())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $feeType->update($validated);

        return back()->with('success', 'Fee Type updated successfully!');
    }

    public function destroy($id)
    {
        $feeType = FeeType::where('tenant_id', $this->getTenantId())->findOrFail($id);
        $feeType->delete();

        return back()->with('success', 'Fee Type deleted successfully!');
    }
}
