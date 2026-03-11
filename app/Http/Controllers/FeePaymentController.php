<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\StudentRegister;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FeePaymentController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenant_id;
    }

    // 1. Show the search page & recent payments
    public function index(Request $request)
    {
        $tenant_id = $this->getTenantId();

        $searchResults = null;

        if ($request->filled('search')) {
            $searchResults = StudentRegister::with('admission')
                ->where('tenant_id', $tenant_id)
                ->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('student_id', 'like', '%' . $request->search . '%');
                })->get();
        }

        $recentPayments = FeePayment::with(['student', 'feeType', 'schoolClass'])
            ->where('tenant_id', $tenant_id)
            ->latest()
            ->paginate(20);

        return view('school_admin.fees.payments_index', compact('recentPayments', 'searchResults'));
    }

    // 2. Show the collection form for a specific student
    public function collect($student_id, $class_id)
    {
        $tenant_id = $this->getTenantId();

        $currentYear = AcademicYear::where('tenant_id', $tenant_id)->where('current_year', 1)->firstOrFail();
        $student = StudentRegister::with('admission')->where('tenant_id', $tenant_id)->findOrFail($student_id);

        $assignedFees = FeeStructure::with('feeType')
            ->where('tenant_id', $tenant_id)
            ->where('year_id', $currentYear->id)
            ->where('class_id', $class_id)
            ->get();

        foreach ($assignedFees as $fee) {
            $paidAmount = FeePayment::where('tenant_id', $tenant_id)
                ->where('year_id', $currentYear->id)
                ->where('student_id', $student_id)
                ->where('fee_type_id', $fee->fee_type_id)
                ->sum('paid_amount');

            // --- ADMISSION FEE LOGIC ---
            // If this fee is related to "Admission" and the admission table says it was paid...
            if (stripos($fee->feeType->name, 'admission') !== false && $student->admission && $student->admission->fees_pay == 1) {
                // ...force the paid amount to equal the total amount so they owe 0.
                $paidAmount = $fee->amount;
            }

            $fee->already_paid = $paidAmount;
            $fee->balance = $fee->amount - $paidAmount;
        }

        return view('school_admin.fees.payments_collect', compact('student', 'assignedFees', 'currentYear', 'class_id'));
    }

    // 3. Process the payment
    public function store(Request $request)
    {
        $tenant_id = $this->getTenantId();

        $validated = $request->validate([
            'year_id' => 'required|exists:academic_years,id',
            'student_id' => 'required|exists:student_registers,id',
            'class_id' => 'required|exists:classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'paid_amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'remarks' => 'nullable|string|max:500',
        ]);

        $validated['tenant_id'] = $tenant_id;

        // Generate a unique receipt number: RCPT-20260311-A8B9
        $validated['receipt_number'] = 'RCPT-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $payment = FeePayment::create($validated);

        // Redirect to the receipt printing page
        return redirect()->route('school_admin.fees.payments_receipt', $payment->id)
            ->with('success', 'Payment collected successfully!');
    }

    // 4. Print the Receipt
    public function receipt($id)
    {
        $tenant_id = $this->getTenantId();

        $payment = FeePayment::with(['student', 'feeType', 'schoolClass'])
            ->where('tenant_id', $tenant_id)
            ->findOrFail($id);

        return view('school_admin.fees.payments_receipt', compact('payment'));
    }
}
