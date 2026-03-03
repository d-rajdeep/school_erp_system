@extends('school_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Student Details</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('school_admin.student.register.edit', $student->id) }}" class="btn btn-warning">
                    <i class="fas fa-pen me-2"></i>Edit
                </a>
                <a href="{{ route('school_admin.student.register.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                {{-- Profile + ID --}}
                <div class="d-flex align-items-center gap-4 mb-4 pb-4 border-bottom">
                    @if ($student->profile)
                        <img src="{{ asset('storage/' . $student->profile) }}" alt="Profile" class="rounded-circle"
                            style="width:100px; height:100px; object-fit:cover; border:3px solid #e2e8f0;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                            style="width:100px; height:100px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                    <div>
                        <h4 class="fw-bold mb-1">{{ $student->name ?? 'N/A' }}</h4>
                        <span class="badge bg-primary fs-6">{{ $student->student_id ?? 'N/A' }}</span>
                        <span class="ms-2 badge {{ $student->status == '1' ? 'bg-success' : 'bg-danger' }}">
                            {{ $student->status == '1' ? 'Active' : 'De-active' }}
                        </span>
                    </div>
                </div>

                {{-- Details Grid --}}
                <div class="row g-4">

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Email</p>
                        <p class="fw-semibold mb-0">{{ $student->email ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Mobile</p>
                        <p class="fw-semibold mb-0">{{ $student->mobile ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Gender</p>
                        <p class="fw-semibold mb-0">
                            @if ($student->gender == '1')
                                Male
                            @elseif ($student->gender == '2')
                                Female
                            @elseif ($student->gender == '3')
                                Other
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Father's Name</p>
                        <p class="fw-semibold mb-0">{{ $student->fname ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Mother's Name</p>
                        <p class="fw-semibold mb-0">{{ $student->mname ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Religion</p>
                        <p class="fw-semibold mb-0">{{ $student->religion ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Date of Birth</p>
                        <p class="fw-semibold mb-0">{{ $student->dob ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Register Date</p>
                        <p class="fw-semibold mb-0">{{ $student->register_date ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Year</p>
                        <p class="fw-semibold mb-0">{{ $student->year ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Transport</p>
                        <p class="fw-semibold mb-0">{{ $student->transport ? 'Yes' : 'No' }}</p>
                    </div>

                    <div class="col-12">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Address</p>
                        <p class="fw-semibold mb-0">{{ $student->address ?? 'N/A' }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
