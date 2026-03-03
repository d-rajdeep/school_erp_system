@extends('school_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Admitted Students</h2>
            <a href="{{ route('school_admin.students.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Admission
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Admissions Table -->
        <div class="card">
            <div class="card-body">
                @if ($admissions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Admission No</th>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Roll No</th>
                                    <th>Academic Year</th>
                                    <th>Fees</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admissions as $key => $admission)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $admission->admission_no ?? 'N/A' }}</td>
                                        <td>{{ $admission->student->name ?? 'N/A' }}</td>
                                        <td>{{ $admission->schoolClass->name ?? 'N/A' }}</td>
                                        <td>{{ $admission->section->name ?? 'N/A' }}</td>
                                        <td>{{ $admission->roll_number ?? '-' }}</td>
                                        <td>{{ $admission->academicYear->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($admission->fees_pay == '1')
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($admission->status == '1')
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-3 align-items-center">

                                                {{-- View --}}
                                                <a href="{{ route('school_admin.students.show', $admission->id) }}"
                                                    class="text-primary" title="View">
                                                    <i class="fas fa-eye fa-lg"></i>
                                                </a>

                                                {{-- Edit --}}
                                                <a href="{{ route('school_admin.students.edit', $admission->id) }}"
                                                    class="text-warning" title="Edit">
                                                    <i class="fas fa-pen fa-lg"></i>
                                                </a>

                                                {{-- Delete --}}
                                                <form action="{{ route('school_admin.students.delete', $admission->id) }}"
                                                    method="POST" class="d-inline m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border-0 bg-transparent text-danger p-0"
                                                        onclick="return confirm('Delete this admission?')" title="Delete">
                                                        <i class="fas fa-trash fa-lg"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">No admissions found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
