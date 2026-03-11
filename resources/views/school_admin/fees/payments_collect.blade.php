@extends('school_admin.layouts.app')

@section('title', 'Collect Fee')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Collect Fee</h2>
            <a href="{{ route('school_admin.fees.payments_index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Student Info Banner --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-4"
                style="background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 8px;">
                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width:60px; height:60px;">
                    @if ($student->profile)
                        <img src="{{ asset('storage/' . $student->profile) }}" class="rounded-circle"
                            style="width:60px; height:60px; object-fit:cover;">
                    @else
                        <i class="fas fa-user fa-2x text-secondary"></i>
                    @endif
                </div>
                <div class="text-white">
                    <h5 class="fw-bold mb-0">{{ $student->name }}</h5>
                    <small class="opacity-75">{{ $student->student_id }} &nbsp;|&nbsp; Academic Year:
                        {{ $currentYear->name }}</small>
                </div>
            </div>
        </div>

        {{-- Fee Summary Table --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Fee Summary</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Fee Type</th>
                                <th class="text-end">Total Amount</th>
                                <th class="text-end">Already Paid</th>
                                <th class="text-end">Balance</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignedFees as $fee)
                                <tr>
                                    <td class="fw-semibold">{{ $fee->feeType->name ?? 'N/A' }}</td>
                                    <td class="text-end">₹ {{ number_format($fee->amount, 2) }}</td>
                                    <td class="text-end text-success fw-semibold">₹
                                        {{ number_format($fee->already_paid, 2) }}</td>
                                    <td class="text-end fw-bold {{ $fee->balance > 0 ? 'text-danger' : 'text-success' }}">
                                        ₹ {{ number_format($fee->balance, 2) }}
                                    </td>
                                    <td class="text-center">
                                        @if ($fee->balance > 0)
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="openPayModal({{ $fee->fee_type_id }}, '{{ addslashes($fee->feeType->name) }}', {{ $fee->balance }})">
                                                <i class="fas fa-money-bill me-1"></i>Pay
                                            </button>
                                        @else
                                            <span class="badge bg-success">Paid</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        No fees assigned for this class in the current academic year.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- Payment Modal --}}
    <div class="modal fade" id="payModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Collect Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('school_admin.fees.payments_store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="year_id" value="{{ $currentYear->id }}">
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <input type="hidden" name="class_id" value="{{ $class_id }}">
                    <input type="hidden" name="fee_type_id" id="modal_fee_type_id">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Fee Type</label>
                            <input type="text" id="modal_fee_type_name" class="form-control bg-light" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Balance Due</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="text" id="modal_balance" class="form-control bg-light" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Amount Paying <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="paid_amount" id="modal_paid_amount" class="form-control"
                                    step="0.01" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Payment Method <span
                                    class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="Cash">Cash</option>
                                <option value="Online">Online</option>
                                <option value="Cheque">Cheque</option>
                                <option value="UPI">UPI</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Remarks</label>
                            <textarea name="remarks" rows="2" class="form-control" placeholder="Optional..."></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check me-2"></i>Confirm Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openPayModal(feeTypeId, feeTypeName, balance) {
            document.getElementById('modal_fee_type_id').value = feeTypeId;
            document.getElementById('modal_fee_type_name').value = feeTypeName;
            document.getElementById('modal_balance').value = balance.toFixed(2);

            let amountInput = document.getElementById('modal_paid_amount');
            amountInput.value = balance.toFixed(2);
            amountInput.max = balance.toFixed(2);

            new bootstrap.Modal(document.getElementById('payModal')).show();
        }
    </script>

@endsection
