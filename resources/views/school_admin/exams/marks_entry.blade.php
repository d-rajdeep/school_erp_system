@extends('school_admin.layouts.app')

@section('title', 'Marks Entry')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Marks Entry</h2>
            <a href="{{ route('school_admin.exams.marks_index') }}" class="btn btn-secondary">
                <i class="fas fa-list me-2"></i>View All Marks
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Filter Form --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('school_admin.exams.marks_entry') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Exam <span class="text-danger">*</span></label>
                            <select name="exam_id" class="form-select" required>
                                <option value="">-- Select Exam --</option>
                                @foreach ($exams as $exam)
                                    <option value="{{ $exam->id }}"
                                        {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                            <select name="class_id" class="form-select" required>
                                <option value="">-- Select Class --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Section <span class="text-danger">*</span></label>
                            <select name="section_id" class="form-select" required>
                                <option value="">-- Select Section --</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                            <select name="subject_id" class="form-select" required>
                                <option value="">-- Select Subject --</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ request('subject_id') == $subject->id ? 'selected' : '' }}>

                                        {{-- Append '(Practical)' if type is 2, otherwise append nothing --}}
                                        {{ $subject->name }} {{ $subject->type == 2 ? '(Practical)' : '' }}

                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Load Students
                            </button>
                            <a href="{{ route('school_admin.exams.marks_entry') }}"
                                class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Marks Entry Table --}}
        @if (request()->filled(['exam_id', 'class_id', 'section_id', 'subject_id']))
            <div class="card">
                <div class="card-body">

                    @if (count($students) > 0)

                        <form method="POST" action="{{ route('school_admin.exams.marks_store') }}">
                            @csrf

                            <input type="hidden" name="exam_id" value="{{ request('exam_id') }}">
                            <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                            <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                            <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Total Marks <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="total_marks"
                                        class="form-control @error('total_marks') is-invalid @enderror"
                                        value="{{ old('total_marks', 100) }}" min="1" required>
                                    @error('total_marks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl. No</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Roll No</th>
                                            <th>Obtained Marks</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $admission)
                                            @php
                                                $existingMark = $admission->student->examMarks->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $admission->student->student_id ?? 'N/A' }}</td>
                                                <td>{{ $admission->student->name ?? 'N/A' }}</td>
                                                <td>{{ $admission->roll_number ?? '-' }}</td>
                                                <td>
                                                    <input type="number" name="marks[{{ $admission->student_id }}]"
                                                        class="form-control form-control-sm mark-input"
                                                        style="width: 100px;"
                                                        value="{{ $existingMark->obtained_marks ?? '' }}" min="0"
                                                        step="0.5" placeholder="0">
                                                </td>
                                                <td>
                                                    @if ($existingMark)
                                                        <span
                                                            class="badge
                                                            @if ($existingMark->grade == 'A+') bg-success
                                                            @elseif($existingMark->grade == 'A') bg-primary
                                                            @elseif($existingMark->grade == 'B') bg-info text-dark
                                                            @elseif($existingMark->grade == 'C') bg-warning text-dark
                                                            @elseif($existingMark->grade == 'D') bg-secondary
                                                            @else bg-danger @endif">
                                                            {{ $existingMark->grade }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Marks
                                </button>
                            </div>

                        </form>
                    @else
                        <p class="text-center text-muted py-3">
                            No active students found for the selected class and section.
                        </p>
                    @endif

                </div>
            </div>
        @endif

    </div>
@endsection
