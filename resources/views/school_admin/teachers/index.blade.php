@extends('school_admin.layouts.app')

@section('title', 'Teachers')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Teachers</h2>
            <a href="{{ route('school_admin.teachers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Teacher
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Profile</th>
                                <th>Employee ID</th>
                                <th>Full Name</th>
                                <th>Mobile</th>
                                <th>Gender</th>
                                <th>Joining Date</th>
                                <th>Salary</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($teachers as $teacher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($teacher->profile)
                                            <img src="{{ asset('storage/' . $teacher->profile) }}" class="rounded-circle"
                                                style="width:38px; height:38px; object-fit:cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center"
                                                style="width:38px; height:38px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $teacher->employee_register_id ?? 'N/A' }}</td>
                                    <td>{{ $teacher->fullname ?? 'N/A' }}</td>
                                    <td>{{ $teacher->mobile ?? 'N/A' }}</td>
                                    <td>
                                        @if ($teacher->gender == 1)
                                            Male
                                        @elseif ($teacher->gender == 2)
                                            Female
                                        @elseif ($teacher->gender == 3)
                                            Other
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $teacher->joining_date ?? 'N/A' }}</td>
                                    <td>{{ $teacher->salary ? number_format($teacher->salary, 2) : 'N/A' }}</td>
                                    <td>
                                        @if ($teacher->status == 1)
                                            Active
                                        @else
                                            De-active
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-3 align-items-center">

                                            {{-- View --}}
                                            <a href="{{ route('school_admin.teachers.show', $teacher->id) }}"
                                                class="text-primary" title="View">
                                                <i class="fas fa-eye fa-lg"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('school_admin.teachers.edit', $teacher->id) }}"
                                                class="text-warning" title="Edit">
                                                <i class="fas fa-pen fa-lg"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('school_admin.teachers.delete', $teacher->id) }}"
                                                method="POST" class="d-inline m-0" id="delete-form-{{ $teacher->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="border-0 bg-transparent text-danger p-0"
                                                    title="Delete"
                                                    onclick="confirmDelete({{ $teacher->id }}, '{{ addslashes($teacher->fullname) }}')">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No teachers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        function confirmDelete(id, name) {
            if (!confirm('Are you sure you want to delete "' + name + '"?')) {
                return;
            }
            if (!confirm('WARNING!\n\nThis will permanently delete the teacher "' + name +
                    '" and all their data.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?')) {
                return;
            }
            document.getElementById('delete-form-' + id).submit();
        }
    </script>

@endsection
