@extends('school_admin.layouts.app')

@section('title', 'Edit Mark')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Edit Mark</h2>
            <a href="{{ route('school_admin.exams.marks_index') }}" class="btn btn-secondary">
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

                {{-- Read-only Info --}}
                <div class="row g-4 mb-4 pb-4 border-bottom">
                    <div class="col-md-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Student</p>
                        <p class="fw-semibold mb-0">{{ $mark->student->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Exam</p>
                        <p class="fw-semibold mb-0">{{ $mark->exam->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Subject</p>
                        <p class="fw-semibold mb-0">{{ $mark->subject->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <form action="{{ route('school_admin.exams.marks_update', $mark->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Total Marks <span class="text-danger">*</span></label>
                            <input type="number" name="total_marks"
                                class="form-control @error('total_marks') is-invalid @enderror"
                                value="{{ old('total_marks', $mark->total_marks) }}" min="1">
                            @error('total_marks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Obtained Marks <span class="text-danger">*</span></label>
                            <input type="number" name="obtained_marks"
                                class="form-control @error('obtained_marks') is-invalid @enderror"
                                value="{{ old('obtained_marks', $mark->obtained_marks) }}" min="0" step="0.5">
                            @error('obtained_marks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Current Grade</label>
                            <div class="form-control bg-light">
                                <span
                                    class="badge
                                    @if ($mark->grade == 'A+') bg-success
                                    @elseif($mark->grade == 'A') bg-primary
                                    @elseif($mark->grade == 'B') bg-info text-dark
                                    @elseif($mark->grade == 'C') bg-warning text-dark
                                    @elseif($mark->grade == 'D') bg-secondary
                                    @else bg-danger @endif fs-6">
                                    {{ $mark->grade }}
                                </span>
                                <small class="text-muted ms-2">(auto-recalculated on save)</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Remarks</label>
                            <textarea name="remarks" rows="2" class="form-control @error('remarks') is-invalid @enderror"
                                placeholder="Optional remarks...">{{ old('remarks', $mark->remarks) }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Mark
                        </button>
                        <a href="{{ route('school_admin.exams.marks_index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
