@extends('school_admin.layouts.app')

@section('title', 'Timetable')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Timetable</h2>
            <a href="{{ route('school_admin.timetable.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Slot
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Filter --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('school_admin.timetable.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Filter by Class</label>
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
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Filter by Section</label>
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
                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            <a href="{{ route('school_admin.timetable.index') }}" class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Day</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Room</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($timetables as $timetable)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $timetable->day_of_week }}</span>
                                    </td>
                                    <td>{{ $timetable->schoolClass->name ?? 'N/A' }}</td>
                                    <td>{{ $timetable->section->name ?? 'N/A' }}</td>
                                    <td>{{ $timetable->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $timetable->teacher->fullname ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($timetable->start_time)->format('h:i A') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($timetable->end_time)->format('h:i A') }}</td>
                                    <td>{{ $timetable->room_number ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-3 align-items-center">

                                            {{-- Edit --}}
                                            <a href="{{ route('school_admin.timetable.edit', $timetable->id) }}"
                                                class="text-warning" title="Edit">
                                                <i class="fas fa-pen fa-lg"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('school_admin.timetable.delete', $timetable->id) }}"
                                                method="POST" class="d-inline m-0" id="delete-form-{{ $timetable->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="border-0 bg-transparent text-danger p-0"
                                                    title="Delete" onclick="confirmDelete({{ $timetable->id }})">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No timetable slots found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        function confirmDelete(id) {
            if (!confirm('Are you sure you want to delete this timetable slot?')) {
                return;
            }
            if (!confirm(
                    'WARNING!\n\nThis will permanently delete this slot.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?'
                    )) {
                return;
            }
            document.getElementById('delete-form-' + id).submit();
        }
    </script>

@endsection
