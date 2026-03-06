@extends('school_admin.layouts.app')

@section('title', 'Student Attendance Report')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Student Attendance Report</h2>
        </div>

        {{-- Filter Form --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('school_admin.attendance.student.report') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Class</label>
                            <select name="class_id" class="form-select">
                                <option value="">-- All Classes --</option>
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
                                <option value="">-- All Sections --</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Month</label>
                            <select name="month" class="form-select">
                                <option value="">-- Month --</option>
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1">
                            <label class="form-label fw-semibold">Year</label>
                            <select name="year" class="form-select">
                                <option value="">-- Year --</option>
                                @foreach (range(date('Y'), date('Y') - 5) as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            <a href="{{ route('school_admin.attendance.student.report') }}"
                                class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Summary Badges --}}
        @if ($attendances->count() > 0)
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body py-3">
                            <h4 class="fw-bold text-success mb-0">
                                {{ $attendances->where('status', 1)->count() }}
                            </h4>
                            <p class="text-muted mb-0 small fw-semibold">Present</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body py-3">
                            <h4 class="fw-bold text-danger mb-0">
                                {{ $attendances->where('status', 2)->count() }}
                            </h4>
                            <p class="text-muted mb-0 small fw-semibold">Absent</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body py-3">
                            <h4 class="fw-bold text-warning mb-0">
                                {{ $attendances->where('status', 3)->count() }}
                            </h4>
                            <p class="text-muted mb-0 small fw-semibold">Late</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body py-3">
                            <h4 class="fw-bold text-info mb-0">
                                {{ $attendances->where('status', 4)->count() }}
                            </h4>
                            <p class="text-muted mb-0 small fw-semibold">Leave</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Report Table --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Date</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $attendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') }}</td>
                                    <td>{{ $attendance->student->student_id ?? 'N/A' }}</td>
                                    <td>{{ $attendance->student->name ?? 'N/A' }}</td>
                                    <td>{{ $attendance->schoolClass->name ?? 'N/A' }}</td>
                                    <td>{{ $attendance->section->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($attendance->status == 1)
                                            <span class="badge bg-success">Present</span>
                                        @elseif ($attendance->status == 2)
                                            <span class="badge bg-danger">Absent</span>
                                        @elseif ($attendance->status == 3)
                                            <span class="badge bg-warning text-dark">Late</span>
                                        @elseif ($attendance->status == 4)
                                            <span class="badge bg-info text-dark">Leave</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">
                                        No attendance records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
