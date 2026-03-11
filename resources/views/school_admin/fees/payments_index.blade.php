@extends('school_admin.layouts.app')

@section('title', 'Fee Payments')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Fee Payments</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Search Student --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="fas fa-search me-2 text-primary"></i>Search Student to Collect Fee</h5>
                <form method="GET" action="{{ route('school_admin.fees.payments_index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Student ID / Name</label>
                            <input type="text" name="search" class="form-control"
                                placeholder="Enter Student ID or Name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Search Results --}}
                @if (request('search') && isset($searchResults))
                    <div class="mt-4">
                        <h6 class="fw-semibold mb-2">Search Results</h6>
                        @if ($searchResults->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($searchResults as $s)
                                            <tr>
                                                <td>{{ $s->student_id }}</td>
                                                <td>{{ $s->name }}</td>
                                                <td>{{ $s->mobile ?? '-' }}</td>
                                                <td>
                                                    @if ($s->admission)
                                                        <a href="{{ route('school_admin.fees.payments_collect', [
                                                            'student_id' => $s->id,
                                                            'class_id' => $s->admission->class_id,
                                                        ]) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-money-bill me-1"></i>Collect Fee
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">Not admitted</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No students found for "{{ request('search') }}".</p>
                        @endif
                    </div>
                @endif

            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Recent Payments</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Receipt No</th>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Fee Type</th>
                                <th>Amount Paid</th>
                                <th>Date</th>
                                <th>Method</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPayments as $payment)
                                <tr>
                                    <td>{{ $recentPayments->firstItem() + $loop->index }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $payment->receipt_number }}</span>
                                    </td>
                                    <td>{{ $payment->student->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->schoolClass->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->feeType->name ?? 'N/A' }}</td>
                                    <td>₹ {{ number_format($payment->paid_amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $payment->payment_method }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('school_admin.fees.payments_receipt', $payment->id) }}"
                                            class="text-primary" title="View Receipt">
                                            <i class="fas fa-eye fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-3">No payments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $recentPayments->withQueryString()->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
