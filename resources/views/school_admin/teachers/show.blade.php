@extends('school_admin.layouts.app')

@section('title', 'Teacher Details')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Teacher Details</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('school_admin.teachers.edit', $teacher->id) }}" class="btn btn-warning">
                    <i class="fas fa-pen me-2"></i>Edit
                </a>
                <a href="{{ route('school_admin.teachers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                {{-- Profile Banner --}}
                <div class="d-flex align-items-center gap-4 mb-4 pb-4 border-bottom">
                    @if ($teacher->profile)
                        <img src="{{ asset('storage/' . $teacher->profile) }}" alt="Profile" class="rounded-circle"
                            style="width:100px; height:100px; object-fit:cover; border:3px solid #e2e8f0;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                            style="width:100px; height:100px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                    <div>
                        <h4 class="fw-bold mb-1">{{ $teacher->fullname ?? 'N/A' }}</h4>
                        <span class="badge bg-primary fs-6">{{ $teacher->employee_register_id ?? 'N/A' }}</span>
                        <span class="ms-1 badge {{ $teacher->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $teacher->status == 1 ? 'Active' : 'De-active' }}
                        </span>
                    </div>
                </div>

                {{-- Personal Information --}}
                <h6 class="fw-bold text-muted text-uppercase mb-3 border-bottom pb-2">Personal Information</h6>
                <div class="row g-4 mb-4">

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Email</p>
                        <p class="fw-semibold mb-0">{{ $teacher->email ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Mobile</p>
                        <p class="fw-semibold mb-0">{{ $teacher->mobile ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Gender</p>
                        <p class="fw-semibold mb-0">
                            @if ($teacher->gender == 1)
                                Male
                            @elseif ($teacher->gender == 2)
                                Female
                            @elseif ($teacher->gender == 3)
                                Other
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Date of Birth</p>
                        <p class="fw-semibold mb-0">
                            {{ $teacher->dob ? \Carbon\Carbon::parse($teacher->dob)->format('d M Y') : 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Religion</p>
                        <p class="fw-semibold mb-0">{{ $teacher->religion ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Father's Name</p>
                        <p class="fw-semibold mb-0">{{ $teacher->father_name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Mother's Name</p>
                        <p class="fw-semibold mb-0">{{ $teacher->mother_name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-12">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Address</p>
                        <p class="fw-semibold mb-0">{{ $teacher->address ?? 'N/A' }}</p>
                    </div>

                </div>

                {{-- Employment Information --}}
                <h6 class="fw-bold text-muted text-uppercase mb-3 border-bottom pb-2">Employment Information</h6>
                <div class="row g-4 mb-4">

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Employee ID</p>
                        <p class="fw-semibold mb-0">{{ $teacher->employee_register_id ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Joining Date</p>
                        <p class="fw-semibold mb-0">
                            {{ $teacher->joining_date ? \Carbon\Carbon::parse($teacher->joining_date)->format('d M Y') : 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Register Date</p>
                        <p class="fw-semibold mb-0">
                            {{ $teacher->register_date ? \Carbon\Carbon::parse($teacher->register_date)->format('d M Y') : 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Salary</p>
                        <p class="fw-semibold mb-0">
                            {{ $teacher->salary ? '₹ ' . number_format($teacher->salary, 2) : 'N/A' }}
                        </p>
                    </div>

                </div>

                {{-- Bank Information --}}
                <h6 class="fw-bold text-muted text-uppercase mb-3 border-bottom pb-2">Bank Information</h6>
                <div class="row g-4 mb-4">

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Bank Name</p>
                        <p class="fw-semibold mb-0">{{ $teacher->bank_name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Account Number</p>
                        <p class="fw-semibold mb-0">{{ $teacher->account_number ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">IFSC Code</p>
                        <p class="fw-semibold mb-0">{{ $teacher->ifsc_code ?? 'N/A' }}</p>
                    </div>

                </div>

                {{-- Delete --}}
                <div class="pt-3 border-top">
                    <form action="{{ route('school_admin.teachers.delete', $teacher->id) }}" method="POST"
                        class="d-inline" id="delete-form-{{ $teacher->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            onclick="confirmDelete({{ $teacher->id }}, '{{ addslashes($teacher->fullname) }}')">
                            <i class="fas fa-trash me-2"></i>Delete Teacher
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            if (!confirm('Are you sure you want to delete "' + name + '"?')) {
                return;
            }
            if (!confirm('WARNING!\n\nThis will permanently delete the teacher "' + name +
                    '" and all their data.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?')) {
                return;
            }
            document.getElementById('delete-form-' + id).submit();
        }
    </script>

@endsection
