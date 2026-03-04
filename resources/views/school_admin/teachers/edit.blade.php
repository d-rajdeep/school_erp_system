@extends('school_admin.layouts.app')

@section('title', 'Edit Teacher')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Edit Teacher</h2>
            <a href="{{ route('school_admin.teachers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Profile Preview --}}
                <div class="text-center mb-4">
                    @if ($teacher->profile)
                        <img src="{{ asset('storage/' . $teacher->profile) }}" class="rounded-circle mb-2"
                            style="width:90px; height:90px; object-fit:cover; border:3px solid #e2e8f0;">
                    @else
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-2"
                            style="width:90px; height:90px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    @endif
                    <div class="mt-1">
                        <span class="badge bg-primary">{{ $teacher->employee_register_id }}</span>
                    </div>
                </div>

                <form action="{{ route('school_admin.teachers.update', $teacher->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Section: Personal Info --}}
                    <h6 class="fw-bold text-muted text-uppercase mb-3 border-bottom pb-2">Personal Information</h6>
                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="fullname"
                                class="form-control @error('fullname') is-invalid @enderror"
                                value="{{ old('fullname', $teacher->fullname) }}">
                            @error('fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $teacher->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mobile</label>
                            <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror"
                                value="{{ old('mobile', $teacher->mobile) }}">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Password <span class="text-muted fw-normal">(leave blank
                                    to keep)</span></label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">-- Select --</option>
                                <option value="1" {{ old('gender', $teacher->gender) == '1' ? 'selected' : '' }}>Male
                                </option>
                                <option value="2" {{ old('gender', $teacher->gender) == '2' ? 'selected' : '' }}>
                                    Female</option>
                                <option value="3" {{ old('gender', $teacher->gender) == '3' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                                value="{{ old('dob', $teacher->dob ? \Carbon\Carbon::parse($teacher->dob)->format('d M Y') : 'N/A') }}">
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Religion</label>
                            <input type="text" name="religion"
                                class="form-control @error('religion') is-invalid @enderror"
                                value="{{ old('religion', $teacher->religion) }}">
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Father's Name</label>
                            <input type="text" name="father_name"
                                class="form-control @error('father_name') is-invalid @enderror"
                                value="{{ old('father_name', $teacher->father_name) }}">
                            @error('father_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mother's Name</label>
                            <input type="text" name="mother_name"
                                class="form-control @error('mother_name') is-invalid @enderror"
                                value="{{ old('mother_name', $teacher->mother_name) }}">
                            @error('mother_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Profile Photo</label>
                            <input type="file" name="profile" class="form-control @error('profile') is-invalid @enderror"
                                accept="image/*">
                            @error('profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address', $teacher->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Section: Employment Info --}}
                    <h6 class="fw-bold text-muted text-uppercase mb-3 border-bottom pb-2">Employment Information</h6>
                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Joining Date</label>
                            <input type="date" name="joining_date"
                                class="form-control @error('joining_date') is-invalid @enderror"
                                value="{{ old('joining_date', $teacher->joining_date ? \Carbon\Carbon::parse($teacher->joining_date)->format('d M Y') : 'N/A') }}">
                            @error('joining_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Register Date</label>
                            <input type="date" name="register_date"
                                class="form-control @error('register_date') is-invalid @enderror"
                                value="{{ old('register_date', $teacher->register_date ? \Carbon\Carbon::parse($teacher->register_date)->format('d M Y') : 'N/A') }}">
                            @error('register_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Salary</label>
                            <input type="number" name="salary" step="0.01"
                                class="form-control @error('salary') is-invalid @enderror"
                                value="{{ old('salary', $teacher->salary) }}">
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', $teacher->status) == '1' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="0" {{ old('status', $teacher->status) == '0' ? 'selected' : '' }}>
                                    De-active</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Section: Bank Info --}}
                    <h6 class="fw-bold text-muted text-uppercase mb-3 border-bottom pb-2">Bank Information</h6>
                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Bank Name</label>
                            <input type="text" name="bank_name"
                                class="form-control @error('bank_name') is-invalid @enderror"
                                value="{{ old('bank_name', $teacher->bank_name) }}">
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Account Number</label>
                            <input type="text" name="account_number"
                                class="form-control @error('account_number') is-invalid @enderror"
                                value="{{ old('account_number', $teacher->account_number) }}">
                            @error('account_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">IFSC Code</label>
                            <input type="text" name="ifsc_code"
                                class="form-control @error('ifsc_code') is-invalid @enderror"
                                value="{{ old('ifsc_code', $teacher->ifsc_code) }}">
                            @error('ifsc_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Teacher
                        </button>
                        <a href="{{ route('school_admin.teachers.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
