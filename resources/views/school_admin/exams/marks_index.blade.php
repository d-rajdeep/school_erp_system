@extends('school_admin.layouts.app')

@section('title', 'All Marks')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">All Exam Marks</h2>
            <a href="{{ route('school_admin.exams.marks_entry') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Marks Entry
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- FILTER FORM --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('school_admin.exams.marks_index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Exam</label>
                        <select name="exam_id" class="form-select">
                            <option value="">All Exams</option>
                            @foreach ($exams as $exam)
                                <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Class</label>
                        <select name="class_id" class="form-select">
                            <option value="">All Classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Section</label>
                        <select name="section_id" class="form-select">
                            <option value="">All Sections</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Student Name</label>
                        <input type="text" name="student_name" value="{{ request('student_name') }}"
                            class="form-control" placeholder="Search by name...">
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                        <a href="{{ route('school_admin.exams.marks_index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        {{-- END FILTER FORM --}}

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Student</th>
                                <th>Exam</th>
                                <th>Subject</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Total</th>
                                <th>Obtained</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($marks as $mark)
                                <tr>
                                    <td>{{ $marks->firstItem() + $loop->index }}</td>
                                    <td>{{ $mark->student->name ?? 'N/A' }}</td>
                                    <td>{{ $mark->exam->name ?? 'N/A' }}</td>
                                    <td>
                                        {{ $mark->subject->name ?? 'N/A' }}
                                        {{ ($mark->subject->type ?? null) == 2 ? '(Practical)' : '' }}
                                    </td>
                                    <td>{{ $mark->schoolClass->name ?? 'N/A' }}</td>
                                    <td>{{ $mark->section->name ?? 'N/A' }}</td>
                                    <td>{{ $mark->total_marks }}</td>
                                    <td>{{ $mark->obtained_marks }}</td>
                                    <td>
                                        <span
                                            class="badge
                                            @if ($mark->grade == 'A+') bg-success
                                            @elseif($mark->grade == 'A') bg-primary
                                            @elseif($mark->grade == 'B') bg-info text-dark
                                            @elseif($mark->grade == 'C') bg-warning text-dark
                                            @elseif($mark->grade == 'D') bg-secondary
                                            @else bg-danger @endif">
                                            {{ $mark->grade }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-3 align-items-center">
                                            {{-- Edit --}}
                                            <a href="{{ route('school_admin.exams.marks_edit', $mark->id) }}"
                                                class="text-warning" title="Edit">
                                                <i class="fas fa-pen fa-lg"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('school_admin.exams.marks_delete', $mark->id) }}"
                                                method="POST" class="d-inline m-0" id="delete-form-{{ $mark->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="border-0 bg-transparent text-danger p-0"
                                                    title="Delete" onclick="confirmDelete({{ $mark->id }})">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">No marks found for the selected
                                        filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
<br>
                    <div class="d-flex gap-2 align-items-center">

                        {{-- View / Print Report Card --}}
                        <a href="{{ route('school_admin.exams.marksheet', ['exam' => $mark->exam_id, 'student' => $mark->student_id]) }}"
                            class="btn btn-sm btn-info text-white shadow-sm d-flex align-items-center"
                            title="View Report Card">
                            <i class="fas fa-file-invoice me-1"></i> Download Marksheet
                        </a>
                    </div>

                    {{-- Pagination with Query String --}}
                    <div class="mt-3">
                        {{ $marks->withQueryString()->links() }}
                    </div>

                </div>
            </div>

        </div>

        <script>
            function confirmDelete(id) {
                if (!confirm('Are you sure you want to delete this mark record?')) return;
                if (!confirm(
                        'WARNING!\n\nThis will permanently delete this mark.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?'
                    )) return;
                document.getElementById('delete-form-' + id).submit();
            }
        </script>
    @endsection
