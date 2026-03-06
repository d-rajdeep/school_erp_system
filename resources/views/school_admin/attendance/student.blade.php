@extends('school_admin.layouts.app')

@section('title', 'Student Attendance')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Student Attendance</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Step 1: Filter Form --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('school_admin.attendance.student') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                            <select name="class_id" class="form-select" required>
                                <option value="">-- Select Class --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ $selectedClass == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Section <span class="text-danger">*</span></label>
                            <select name="section_id" class="form-select" required>
                                <option value="">-- Select Section --</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ $selectedSection == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ $attendanceDate }}"
                                required>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Load Students
                            </button>
                            <a href="{{ route('school_admin.attendance.student') }}"
                                class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Step 2: Attendance Form --}}
        @if ($selectedClass && $selectedSection)
            <div class="card">
                <div class="card-body">

                    @if (count($students) > 0)

                        <form method="POST" action="{{ route('school_admin.attendance.student.store') }}">
                            @csrf

                            <input type="hidden" name="class_id" value="{{ $selectedClass }}">
                            <input type="hidden" name="section_id" value="{{ $selectedSection }}">
                            <input type="hidden" name="attendance_date" value="{{ $attendanceDate }}">

                            {{-- Mark All Buttons --}}
                            <div class="d-flex gap-2 mb-3">
                                <button type="button" class="btn btn-sm btn-success" onclick="markAll('present')">
                                    <i class="fas fa-check me-1"></i>Mark All Present
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="markAll('absent')">
                                    <i class="fas fa-times me-1"></i>Mark All Absent
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" onclick="markAll('late')">
                                    <i class="fas fa-clock me-1"></i>Mark All Late
                                </button>
                                <button type="button" class="btn btn-sm btn-info" onclick="markAll('leave')">
                                    <i class="fas fa-calendar-minus me-1"></i>Mark All Leave
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl. No</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Roll No</th>
                                            <th class="text-center">Present</th>
                                            <th class="text-center">Absent</th>
                                            <th class="text-center">Late</th>
                                            <th class="text-center">Leave</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $admission)
                                            @php
                                                $existingStatus =
                                                    $admission->student->attendances->first()->status ?? 'present';
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $admission->student->student_id ?? 'N/A' }}</td>
                                                <td>{{ $admission->student->name ?? 'N/A' }}</td>
                                                <td>{{ $admission->roll_number ?? '-' }}</td>
                                                <td class="text-center">
                                                    <input type="radio" name="attendance[{{ $admission->student_id }}]"
                                                        value="present" class="form-check-input"
                                                        {{ $existingStatus == 1 ? 'checked' : '' }}>
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio" name="attendance[{{ $admission->student_id }}]"
                                                        value="absent" class="form-check-input"
                                                        {{ $existingStatus == 2 ? 'checked' : '' }}>
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio" name="attendance[{{ $admission->student_id }}]"
                                                        value="late" class="form-check-input"
                                                        {{ $existingStatus == 3 ? 'checked' : '' }}>
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio" name="attendance[{{ $admission->student_id }}]"
                                                        value="leave" class="form-check-input"
                                                        {{ $existingStatus == 4 ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Attendance
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

    <script>
        function markAll(status) {
            document.querySelectorAll('input[type="radio"][value="' + status + '"]').forEach(function(radio) {
                radio.checked = true;
            });
        }
    </script>

@endsection
