@extends('school_admin.layouts.app')

@section('title', 'Add Teacher')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Add Teacher</h2>
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

                <form action="{{ route('school_admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Section: Personal Info --}}
                    <h6 class="fw-bold text-muted text-uppercase mb-3 border-bottom pb-2">Personal Information</h6>
                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="fullname"
                                class="form-control @error('fullname') is-invalid @enderror" value="{{ old('fullname') }}">
                            @error('fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mobile</label>
                            <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror"
                                value="{{ old('mobile') }}">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
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
                                <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Male</option>
                                <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>Female</option>
                                <option value="3" {{ old('gender') == '3' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                                value="{{ old('dob') }}">
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Religion</label>
                            <input type="text" name="religion"
                                class="form-control @error('religion') is-invalid @enderror" value="{{ old('religion') }}">
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Father's Name</label>
                            <input type="text" name="father_name"
                                class="form-control @error('father_name') is-invalid @enderror"
                                value="{{ old('father_name') }}">
                            @error('father_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mother's Name</label>
                            <input type="text" name="mother_name"
                                class="form-control @error('mother_name') is-invalid @enderror"
                                value="{{ old('mother_name') }}">
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
                            <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
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
                                value="{{ old('joining_date') }}">
                            @error('joining_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Register Date</label>
                            <input type="date" name="register_date"
                                class="form-control @error('register_date') is-invalid @enderror"
                                value="{{ old('register_date') }}">
                            @error('register_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Salary</label>
                            <input type="number" name="salary" step="0.01"
                                class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary') }}">
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>De-active</option>
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
                                value="{{ old('bank_name') }}">
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Account Number</label>
                            <input type="text" name="account_number"
                                class="form-control @error('account_number') is-invalid @enderror"
                                value="{{ old('account_number') }}">
                            @error('account_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">IFSC Code</label>
                            <input type="text" name="ifsc_code"
                                class="form-control @error('ifsc_code') is-invalid @enderror"
                                value="{{ old('ifsc_code') }}">
                            @error('ifsc_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Teacher
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
