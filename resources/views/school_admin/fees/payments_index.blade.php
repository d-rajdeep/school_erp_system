@extends('school_admin.layouts.app')

@section('title', 'Fee Payments')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Fee Payments & Collection</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Search Student Form --}}
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
            <div class="card-body bg-light rounded p-4">
                <form method="GET" action="{{ route('school_admin.fees.payments_index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-search me-1"></i> Search Student to Collect Fee or View Receipts
                            </label>
                            <input type="text" name="search" class="form-control form-control-lg border-0 shadow-sm"
                                placeholder="Enter Student ID (e.g., SCH0002) or Name..." value="{{ request('search') }}"
                                required>
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1 shadow-sm fw-semibold">
                                Search
                            </button>
                            <a href="{{ route('school_admin.fees.payments_index') }}"
                                class="btn btn-secondary btn-lg shadow-sm" title="Reset">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (!request()->filled('search'))
            {{-- Empty State (When page first loads) --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 100px; height: 100px;">
                            <i class="fas fa-wallet fa-3x text-primary opacity-75"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-dark">Search to Manage Fees</h4>
                    <p class="text-muted mb-0 max-w-md mx-auto">Please enter a student's name or ID above to collect new
                        fees or view their past payment receipts.</p>
                </div>
            </div>
        @else
            {{-- Search Results --}}
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0 text-primary">Student Details</h6>
                </div>
                <div class="card-body">
                    @if ($searchResults && $searchResults->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($searchResults as $s)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $s->student_id }}</td>
                                            <td class="fw-semibold">{{ $s->name }}</td>
                                            <td>{{ $s->mobile ?? '-' }}</td>
                                            <td class="text-end">
                                                @if ($s->admission)
                                                    <a href="{{ route('school_admin.fees.payments_collect', [
                                                        'student_id' => $s->id,
                                                        'class_id' => $s->admission->class_id,
                                                    ]) }}"
                                                        class="btn btn-primary shadow-sm px-4 rounded-pill">
                                                        <i class="fas fa-hand-holding-usd me-2"></i>Collect Fee
                                                    </a>
                                                @else
                                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                                        <i class="fas fa-exclamation-circle me-1"></i> Not Admitted
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-user-slash fa-2x mb-3 opacity-50"></i>
                            <p class="mb-0">No students found matching "<strong>{{ request('search') }}</strong>".</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Filtered Payment History --}}
            @if ($recentPayments && $recentPayments->count() > 0)
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0 text-success">Payment Receipts for "{{ request('search') }}"</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>Receipt No</th>
                                        <th>Student</th>
                                        <th>Fee Type</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Method</th>
                                        <th class="text-center">Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentPayments as $payment)
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark bg-opacity-10 text-dark border px-2 py-1">
                                                    {{ $payment->receipt_number }}
                                                </span>
                                            </td>
                                            <td class="fw-semibold">{{ $payment->student->name ?? 'N/A' }}</td>
                                            <td>{{ $payment->feeType->name ?? 'N/A' }}</td>
                                            <td class="fw-bold text-success">₹
                                                {{ number_format($payment->paid_amount, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge bg-info text-white">{{ $payment->payment_method }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('school_admin.fees.payments_receipt', $payment->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Print/View Receipt">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            {{ $recentPayments->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @endif

    </div>
@endsection
