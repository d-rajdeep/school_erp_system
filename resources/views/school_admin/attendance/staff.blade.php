@extends('school_admin.layouts.app')

@section('title', 'Staff Attendance')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Staff Attendance</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Date Filter --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('school_admin.attendance.staff') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ $attendanceDate }}"
                                required>
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Load Staff
                            </button>
                            <a href="{{ route('school_admin.attendance.staff') }}" class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Attendance Form --}}
        <div class="card">
            <div class="card-body">

                @if ($staff->count() > 0)

                    <form method="POST" action="{{ route('school_admin.attendance.staff.store') }}">
                        @csrf

                        <input type="hidden" name="attendance_date" value="{{ $attendanceDate }}">

                        {{-- Mark All Buttons --}}
                        <div class="d-flex gap-2 mb-3">
                            <button type="button" class="btn btn-sm btn-success" onclick="markAll('present')">
                                <i class="fas fa-check me-1"></i>Mark All Present
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="markAll('absent')">
                                <i class="fas fa-times me-1"></i>Mark All Absent
                            </button>
                            <button type="button" class="btn btn-sm btn-info" onclick="markAll('leave')">
                                <i class="fas fa-calendar-minus me-1"></i>Mark All Late
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Profile</th>
                                        <th>Employee ID</th>
                                        <th>Full Name</th>
                                        <th>Mobile</th>
                                        <th class="text-center">Present</th>
                                        <th class="text-center">Absent</th>
                                        <th class="text-center">Late</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staff as $teacher)
                                        @php
                                            $existingStatus = $teacher->attendances->first()->status ?? 'present';
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($teacher->profile)
                                                    <img src="{{ asset('storage/' . $teacher->profile) }}"
                                                        class="rounded-circle"
                                                        style="width:36px; height:36px; object-fit:cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center"
                                                        style="width:36px; height:36px;">
                                                        <i class="fas fa-user text-white" style="font-size:14px;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $teacher->employee_register_id ?? 'N/A' }}</td>
                                            <td>{{ $teacher->fullname ?? 'N/A' }}</td>
                                            <td>{{ $teacher->mobile ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <input type="radio" name="attendance[{{ $teacher->id }}]"
                                                    value="present" class="form-check-input"
                                                    {{ $existingStatus == 1 ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" name="attendance[{{ $teacher->id }}]" value="absent"
                                                    class="form-check-input" {{ $existingStatus == 2 ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" name="attendance[{{ $teacher->id }}]" value="late"
                                                    class="form-check-input" {{ $existingStatus == 3 ? 'checked' : '' }}>
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
                    <p class="text-center text-muted py-3">No active staff found.</p>
                @endif

            </div>
        </div>

    </div>

    <script>
        function markAll(status) {
            document.querySelectorAll('input[type="radio"][value="' + status + '"]').forEach(function(radio) {
                radio.checked = true;
            });
        }
    </script>

@endsection
