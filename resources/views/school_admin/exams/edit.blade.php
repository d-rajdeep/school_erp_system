@extends('school_admin.layouts.app')

@section('title', 'Edit Exam')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Edit Exam</h2>
            <a href="{{ route('school_admin.exams.index') }}" class="btn btn-secondary">
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

                <form action="{{ route('school_admin.exams.update', $exam->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Exam Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $exam->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>

                            {{-- 'pointer-events: none' and gray background make it act like a read-only field --}}
                            <select name="year_id" class="form-select @error('year_id') is-invalid @enderror"
                                style="pointer-events: none; background-color: #f3f4f6;">

                                @foreach ($years as $year)
                                    {{-- Only display the year that is currently attached to this specific exam --}}
                                    @if ($year->id == $exam->year_id)
                                        <option value="{{ $year->id }}" selected>
                                            {{ $year->name }}
                                        </option>
                                    @endif
                                @endforeach

                            </select>

                            @error('year_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Start Date</label>
                            <input type="date" name="start_date"
                                class="form-control @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date', $exam->start_date) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">End Date</label>
                            <input type="date" name="end_date"
                                class="form-control @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date', $exam->end_date) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', $exam->status) == '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ old('status', $exam->status) == '0' ? 'selected' : '' }}>
                                    De-active</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Exam
                        </button>
                        <a href="{{ route('school_admin.exams.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
