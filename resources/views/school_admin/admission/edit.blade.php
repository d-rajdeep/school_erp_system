@extends('school_admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Edit Admission
                            <span class="badge bg-primary ms-2">{{ $admission->admission_no }}</span>
                        </h4>
                        <a href="{{ route('school_admin.students.index') }}" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Back
                        </a>
                    </div>

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

                    <form action="{{ route('school_admin.students.update', $admission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- Admission No (readonly) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Admission No</label>
                                <input type="text" class="form-control bg-light" value="{{ $admission->admission_no }}"
                                    readonly>
                            </div>

                            {{-- Student (readonly — cannot change the student on an existing admission) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Student</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $admission->student->name ?? 'N/A' }}" readonly>
                                <input type="hidden" name="student_id" value="{{ $admission->student_id }}">
                            </div>

                            {{-- Class --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-select @error('class_id') is-invalid @enderror">
                                    <option value="">-- Select Class --</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ old('class_id', $admission->class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Section --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Section <span class="text-danger">*</span></label>
                                <select name="section_id" class="form-select @error('section_id') is-invalid @enderror">
                                    <option value="">-- Select Section --</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"
                                            {{ old('section_id', $admission->section_id) == $section->id ? 'selected' : '' }}>
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Academic Year --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Academic Year</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $admission->academicYear->name ?? 'N/A' }}" readonly>
                                <input type="hidden" name="year_id" value="{{ $admission->year_id }}">
                            </div>

                            {{-- Admission Date --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Admission Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="admission_date"
                                    class="form-control @error('admission_date') is-invalid @enderror"
                                    value="{{ old('admission_date', $admission->admission_date) }}">
                                @error('admission_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Roll Number --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Roll Number</label>
                                <input type="text" name="roll_number"
                                    class="form-control @error('roll_number') is-invalid @enderror"
                                    value="{{ old('roll_number', $admission->roll_number) }}">
                                @error('roll_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="1"
                                        {{ old('status', $admission->status) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0"
                                        {{ old('status', $admission->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Fees Pay --}}
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Fees Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="fees_pay" value="1"
                                        id="feesToggle"
                                        {{ old('fees_pay', $admission->fees_pay) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feesToggle">Mark as Paid</label>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save me-1"></i> Update Admission
                            </button>
                            <a href="{{ route('school_admin.students.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
