@extends('school_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Register New Student</h2>
            <a href="{{ route('school_admin.student.register.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>

        <!-- Create Form -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('school_admin.student.register.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Student Basic Information -->
                    <h4 class="mb-3">Basic Information</h4>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile"
                                name="mobile" value="{{ old('mobile') }}">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="profile" class="form-label">Profile Photo</label>
                            <input type="file" class="form-control @error('profile') is-invalid @enderror" id="profile"
                                name="profile">
                            @error('profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                name="gender">
                                <option value="">Select Gender</option>
                                <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Male</option>
                                <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>Female</option>
                                <option value="3" {{ old('gender') == '3' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="religion" class="form-label">Religion</label>
                            <input type="text" class="form-control @error('religion') is-invalid @enderror"
                                id="religion" name="religion" value="{{ old('religion') }}">
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Parent Information -->
                    <h4 class="mb-3 mt-4">Parent Information</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fname" class="form-label">Father's Name</label>
                            <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname"
                                name="fname" value="{{ old('fname') }}">
                            @error('fname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="mname" class="form-label">Mother's Name</label>
                            <input type="text" class="form-control @error('mname') is-invalid @enderror"
                                id="mname" name="mname" value="{{ old('mname') }}">
                            @error('mname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Registration Details -->
                    <h4 class="mb-3 mt-4">Registration Details</h4>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                                name="dob" value="{{ old('dob') }}">
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="register_date" class="form-label">Register Date</label>
                            <input type="date" class="form-control @error('register_date') is-invalid @enderror"
                                id="register_date" name="register_date"
                                value="{{ old('register_date', date('Y-m-d')) }}">
                            @error('register_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="year" class="form-label">Year</label>
                            <input type="text" class="form-control @error('year') is-invalid @enderror"
                                id="year" name="year" value="{{ old('year', date('Y')) }}" readonly>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="transport" class="form-label">Transport</label>
                            <select class="form-control @error('transport') is-invalid @enderror" id="transport"
                                name="transport">
                                <option value="">Select</option>
                                <option value="1" {{ old('transport') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('transport') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('transport')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status"
                                name="status">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>De-active</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Register Student</button>
                            <a href="{{ route('school_admin.student.register.index') }}"
                                class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
