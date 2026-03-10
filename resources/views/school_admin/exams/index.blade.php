@extends('school_admin.layouts.app')

@section('title', 'Exams')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Exams</h2>
            <a href="{{ route('school_admin.exams.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Exam
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
                                <th>Exam Name</th>
                                <th>Academic Year</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($exams as $exam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $exam->name }}</td>
                                    <td>{{ $exam->academicYear->name ?? 'N/A' }}</td>
                                    <td>{{ $exam->start_date ? \Carbon\Carbon::parse($exam->start_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td>{{ $exam->end_date ? \Carbon\Carbon::parse($exam->end_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        @if ($exam->status == 1)
                                            Active
                                        @else
                                            De-active
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-3 align-items-center">

                                            {{-- Edit --}}
                                            <a href="{{ route('school_admin.exams.edit', $exam->id) }}" class="text-warning"
                                                title="Edit">
                                                <i class="fas fa-pen fa-lg"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('school_admin.exams.delete', $exam->id) }}"
                                                method="POST" class="d-inline m-0" id="delete-form-{{ $exam->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="border-0 bg-transparent text-danger p-0"
                                                    title="Delete"
                                                    onclick="confirmDelete({{ $exam->id }}, '{{ addslashes($exam->name) }}')">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No exams found.</td>
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
            if (!confirm('WARNING!\n\nDeleting "' + name +
                    '" will permanently remove this exam and all related data.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?'
                )) {
                return;
            }
            document.getElementById('delete-form-' + id).submit();
        }
    </script>

@endsection
