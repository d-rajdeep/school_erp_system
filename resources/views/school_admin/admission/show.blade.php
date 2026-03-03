@extends('school_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Admission Details</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('school_admin.students.edit', $admission->id) }}" class="btn btn-warning">
                    <i class="fas fa-pen me-2"></i>Edit
                </a>
                <a href="{{ route('school_admin.students.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                {{-- Profile + Admission Banner --}}
                <div class="d-flex align-items-center gap-4 mb-4 pb-4 border-bottom">
                    @if ($admission->student?->profile)
                        <img src="{{ asset('storage/' . $admission->student->profile) }}" alt="Profile"
                            class="rounded-circle"
                            style="width:100px; height:100px; object-fit:cover; border:3px solid #e2e8f0;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                            style="width:100px; height:100px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                    <div>
                        <h4 class="fw-bold mb-1">{{ $admission->student->name ?? 'N/A' }}</h4>
                        <span class="badge bg-primary fs-6">{{ $admission->admission_no ?? 'N/A' }}</span>
                        <span class="ms-1 badge bg-secondary fs-6">{{ $admission->student->student_id ?? 'N/A' }}</span>
                        <span class="ms-1 badge {{ $admission->status == '1' ? 'bg-success' : 'bg-danger' }}">
                            {{ $admission->status == '1' ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="ms-1 badge {{ $admission->fees_pay == '1' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $admission->fees_pay == '1' ? 'Fees Paid' : 'Fees Pending' }}
                        </span>
                    </div>
                </div>

                {{-- Details Grid --}}
                <div class="row g-4">

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Admission No</p>
                        <p class="fw-semibold mb-0">{{ $admission->admission_no ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Admission Date</p>
                        <p class="fw-semibold mb-0">{{ $admission->admission_date ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Academic Year</p>
                        <p class="fw-semibold mb-0">{{ $admission->academicYear->name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Class</p>
                        <p class="fw-semibold mb-0">{{ $admission->schoolClass->name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Section</p>
                        <p class="fw-semibold mb-0">{{ $admission->section->name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Roll Number</p>
                        <p class="fw-semibold mb-0">{{ $admission->roll_number ?? '-' }}</p>
                    </div>

                    {{-- Divider --}}
                    <div class="col-12">
                        <hr class="my-1">
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Student ID</p>
                        <p class="fw-semibold mb-0">{{ $admission->student->student_id ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Mobile</p>
                        <p class="fw-semibold mb-0">{{ $admission->student->mobile ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Email</p>
                        <p class="fw-semibold mb-0">{{ $admission->student->email ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Gender</p>
                        <p class="fw-semibold mb-0">
                            @if ($admission->student?->gender == '1')
                                Male
                            @elseif ($admission->student?->gender == '2')
                                Female
                            @elseif ($admission->student?->gender == '3')
                                Other
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Date of Birth</p>
                        <p class="fw-semibold mb-0">{{ $admission->student->dob ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Religion</p>
                        <p class="fw-semibold mb-0">{{ $admission->student->religion ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Father's Name</p>
                        <p class="fw-semibold mb-0">{{ $admission->student->fname ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Mother's Name</p>
                        <p class="fw-semibold mb-0">{{ $admission->student->mname ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Transport</p>
                        <p class="fw-semibold mb-0">{{ $admission->student->transport ? 'Yes' : 'No' }}</p>
                    </div>

                    <div class="col-12">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Address</p>
                        <p class="fw-semibold mb-0">{{ $admission->student->address ?? 'N/A' }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
