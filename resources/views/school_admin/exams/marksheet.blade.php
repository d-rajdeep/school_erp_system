@extends('school_admin.layouts.app')

@section('title', 'Marksheet - ' . $student->student->name)

@section('content')
    <div class="container-fluid px-4 mb-5">

        {{-- Action Buttons (Hidden when printing) --}}
        <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
            <h4 class="fw-bold">Student Marksheet</h4>
            <div>
                <button onclick="window.print()" class="btn btn-primary shadow-sm">
                    <i class="fas fa-print me-2"></i> Print Marksheet
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary shadow-sm ms-2">Back</a>
            </div>
        </div>

        {{-- The Marksheet Container --}}
        <div class="card shadow-sm printable-area" style="border: 2px solid #000;">
            <div class="card-body p-5">

                {{-- Header Section --}}
                <div class="text-center mb-4" style="border-bottom: 2px solid #000; padding-bottom: 20px;">
                    <h2 class="fw-bold text-uppercase mb-1" style="color: #000;">Your School Name Here</h2>
                    <p class="mb-1" style="font-size: 16px;">123 Education Lane, City, State, ZIP</p>
                    <p class="mb-2" style="font-size: 14px;">Email: info@yourschool.com | Phone: +1 234 567 890</p>
                    <h4 class="fw-bold mt-3 text-uppercase" style="text-decoration: underline;">Academic Performance Report
                    </h4>
                    <h5 class="fw-semibold mt-2">{{ $exam->name }}</h5>
                </div>

                {{-- Student Details Section --}}
                <div class="row mb-4" style="font-size: 16px;">
                    <div class="col-sm-6">
                        <p class="mb-1"><strong>Student Name:</strong> {{ $student->student->name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Registration No:</strong> {{ $student->student->student_id ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Date of Birth:</strong>
                            {{ \Carbon\Carbon::parse($student->student->dob)->format('d-M-Y') ?? 'N/A' }}</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <p class="mb-1"><strong>Class:</strong> {{ $student->schoolClass->name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Section:</strong> {{ $student->section->name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Roll Number:</strong> {{ $student->roll_number ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Marks Table Section --}}
                <table class="table table-bordered border-dark text-center align-middle mb-4" style="border-width: 2px;">
                    <thead class="table-light" style="border-bottom: 2px solid #000;">
                        <tr>
                            <th class="text-start" style="width: 40%;">Subject</th>
                            <th style="width: 20%;">Total Marks</th>
                            <th style="width: 20%;">Marks Obtained</th>
                            <th style="width: 20%;">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marks as $mark)
                            <tr>
                                <td class="text-start fw-semibold">
                                    {{ $mark->subject->name ?? 'N/A' }}
                                    {{ ($mark->subject->type ?? null) == 2 ? '(Practical)' : '' }}
                                </td>
                                <td>{{ number_format($mark->total_marks, 0) }}</td>
                                <td>{{ number_format($mark->obtained_marks, 0) }}</td>
                                <td class="fw-bold">{{ $mark->grade }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="border-top: 2px solid #000; font-size: 18px;">
                        <tr>
                            <th class="text-end pe-3">Grand Total:</th>
                            <th class="text-center">{{ number_format($grandTotal, 0) }}</th>
                            <th class="text-center">{{ number_format($totalObtained, 0) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

                {{-- Overall Performance Section --}}
                <div class="row mb-5 p-3" style="background-color: #f8f9fa; border: 1px solid #000; border-radius: 5px;">
                    <div class="col-sm-4 text-center border-end border-dark">
                        <span class="d-block text-muted mb-1">Percentage</span>
                        <h3 class="fw-bold mb-0">{{ number_format($percentage, 2) }}%</h3>
                    </div>
                    <div class="col-sm-4 text-center border-end border-dark">
                        <span class="d-block text-muted mb-1">Overall Grade</span>
                        <h3 class="fw-bold mb-0">{{ $overallGrade }}</h3>
                    </div>
                    <div class="col-sm-4 text-center">
                        <span class="d-block text-muted mb-1">Final Result</span>
                        <h3 class="fw-bold mb-0 {{ $resultStatus == 'PASS' ? 'text-success' : 'text-danger' }}">
                            {{ $resultStatus }}
                        </h3>
                    </div>
                </div>

                {{-- Signatures Section --}}
                <div class="row mt-5 pt-5 text-center" style="font-size: 16px;">
                    <div class="col-4">
                        <hr style="border: 1px solid #000; width: 60%; margin: 0 auto 10px;">
                        <p class="mb-0 fw-semibold">Class Teacher</p>
                    </div>
                    <div class="col-4">
                        <hr style="border: 1px solid #000; width: 60%; margin: 0 auto 10px;">
                        <p class="mb-0 fw-semibold">Parent / Guardian</p>
                    </div>
                    <div class="col-4">
                        <hr style="border: 1px solid #000; width: 60%; margin: 0 auto 10px;">
                        <p class="mb-0 fw-semibold">Principal</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Custom CSS for Printing --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
                /* Hide everything by default */
            }

            .printable-area,
            .printable-area * {
                visibility: visible;
                /* Show only the marksheet */
            }

            .printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none !important;
                box-shadow: none !important;
            }

            /* Ensure background colors and borders print correctly */
            .table-bordered,
            .border-dark {
                border-color: #000 !important;
            }

            .table-light {
                background-color: #e9ecef !important;
                -webkit-print-color-adjust: exact;
            }

            h2,
            h3,
            h4,
            h5 {
                color: #000 !important;
            }
        }
    </style>
@endsection
