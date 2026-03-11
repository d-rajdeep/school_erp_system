@extends('school_admin.layouts.app')

@section('title', 'Fee Receipt')

@section('content')
    <div class="container-fluid px-4 mb-5">

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
            <h4 class="fw-bold">Fee Receipt</h4>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Print Receipt
                </button>
                <a href="{{ route('school_admin.fees.payments_index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        {{-- Receipt --}}
        <div class="card shadow-sm printable-area" style="border: 2px solid #000; max-width: 700px; margin: 0 auto;">
            <div class="card-body p-5">

                {{-- Header --}}
                <div class="text-center mb-4" style="border-bottom: 2px solid #000; padding-bottom: 20px;">
                    <h3 class="fw-bold text-uppercase mb-1">Your School Name Here</h3>
                    <p class="mb-1" style="font-size:14px;">123 Education Lane, City, State, ZIP</p>
                    <p class="mb-2" style="font-size:13px;">Email: info@yourschool.com | Phone: +1 234 567 890</p>
                    <h5 class="fw-bold mt-3 text-uppercase" style="text-decoration: underline;">Fee Payment Receipt</h5>
                </div>

                {{-- Receipt Details --}}
                <div class="row mb-4" style="font-size:15px;">
                    <div class="col-6">
                        <p class="mb-1"><strong>Receipt No:</strong>
                            <span class="text-primary fw-bold">{{ $payment->receipt_number }}</span>
                        </p>
                        <p class="mb-1"><strong>Payment Date:</strong>
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                        </p>
                        <p class="mb-1"><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-1"><strong>Student Name:</strong> {{ $payment->student->name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Student ID:</strong> {{ $payment->student->student_id ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Class:</strong> {{ $payment->schoolClass->name ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Payment Table --}}
                <table class="table table-bordered border-dark text-center align-middle mb-4" style="border-width: 2px;">
                    <thead class="table-light" style="border-bottom: 2px solid #000;">
                        <tr>
                            <th class="text-start">Fee Type</th>
                            <th>Amount Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-start fw-semibold">{{ $payment->feeType->name ?? 'N/A' }}</td>
                            <td class="fw-bold">₹ {{ number_format($payment->paid_amount, 2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot style="border-top: 2px solid #000;">
                        <tr>
                            <th class="text-end pe-3">Total Paid:</th>
                            <th>₹ {{ number_format($payment->paid_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>

                {{-- Remarks --}}
                @if ($payment->remarks)
                    <div class="mb-4 p-3" style="background:#f8f9fa; border:1px solid #000; border-radius:4px;">
                        <strong>Remarks:</strong> {{ $payment->remarks }}
                    </div>
                @endif

                {{-- Signatures --}}
                <div class="row mt-5 pt-4 text-center" style="font-size:15px;">
                    <div class="col-6">
                        <hr style="border:1px solid #000; width:60%; margin: 0 auto 10px;">
                        <p class="mb-0 fw-semibold">Received By</p>
                    </div>
                    <div class="col-6">
                        <hr style="border:1px solid #000; width:60%; margin: 0 auto 10px;">
                        <p class="mb-0 fw-semibold">Parent / Guardian</p>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .printable-area,
            .printable-area * {
                visibility: visible;
            }

            .printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none !important;
                box-shadow: none !important;
                max-width: 100% !important;
            }

            .table-bordered,
            .border-dark {
                border-color: #000 !important;
            }

            .table-light {
                background-color: #e9ecef !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>

@endsection
