@extends('school_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Edit Student</h2>
            <a href="{{ route('school_admin.student.register.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('school_admin.student.register.update', $student->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Profile Image --}}
                        <div class="col-12 text-center mb-2">
                            @if ($student->profile)
                                <img src="{{ asset('storage/' . $student->profile) }}" alt="Profile"
                                    class="rounded-circle mb-2"
                                    style="width:90px; height:90px; object-fit:cover; border:3px solid #e2e8f0;">
                            @else
                                <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-2"
                                    style="width:90px; height:90px;">
                                    <i class="fas fa-user fa-2x text-white"></i>
                                </div>
                            @endif
                            <div>
                                <label class="form-label fw-semibold">Profile Photo</label>
                                <input type="file" name="profile" class="form-control" accept="image/*">
                            </div>
                        </div>

                        {{-- Student ID (readonly) --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Student ID</label>
                            <input type="text" class="form-control bg-light" value="{{ $student->student_id }}" readonly>
                        </div>

                        {{-- Name --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $student->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $student->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mobile --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mobile</label>
                            <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror"
                                value="{{ old('mobile', $student->mobile) }}">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Password <span class="text-muted fw-normal">(leave blank
                                    to keep)</span></label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gender --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">-- Select --</option>
                                <option value="1" {{ old('gender', $student->gender) == '1' ? 'selected' : '' }}>Male
                                </option>
                                <option value="2" {{ old('gender', $student->gender) == '2' ? 'selected' : '' }}>
                                    Female</option>
                                <option value="3" {{ old('gender', $student->gender) == '3' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Father Name --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Father's Name</label>
                            <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror"
                                value="{{ old('fname', $student->fname) }}">
                            @error('fname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mother Name --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Mother's Name</label>
                            <input type="text" name="mname" class="form-control @error('mname') is-invalid @enderror"
                                value="{{ old('mname', $student->mname) }}">
                            @error('mname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Religion --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Religion</label>
                            <input type="text" name="religion"
                                class="form-control @error('religion') is-invalid @enderror"
                                value="{{ old('religion', $student->religion) }}">
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DOB --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                                value="{{ old('dob', $student->dob) }}">
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Register Date --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Register Date</label>
                            <input type="date" name="register_date"
                                class="form-control @error('register_date') is-invalid @enderror"
                                value="{{ old('register_date', $student->register_date) }}">
                            @error('register_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Year --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Year</label>
                            <input type="text" name="year"
                                class="form-control @error('year') is-invalid @enderror"
                                value="{{ old('year', $student->year) }}" maxlength="4">
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Transport --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Transport</label>
                            <input type="text" name="transport"
                                class="form-control @error('transport') is-invalid @enderror"
                                value="{{ old('transport', $student->transport) }}">
                            @error('transport')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="">-- Select --</option>
                                <option value="1" {{ old('status', $student->status) == '1' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="2" {{ old('status', $student->status) == '2' ? 'selected' : '' }}>
                                    De-active</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $student->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Student
                        </button>
                        <a href="{{ route('school_admin.student.register.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
