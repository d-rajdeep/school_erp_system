@extends('school_admin.layouts.app')

@section('title', 'Subjects')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Subjects</h2>
            <a href="{{ route('school_admin.subjects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Subject
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
                                <th>Subject Name</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subjects as $subject)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code ?? '-' }}</td>
                                    <td>
                                        @if ($subject->type == 1)
                                            <span class="badge bg-primary">Theory</span>
                                        @elseif ($subject->type == 2)
                                            <span class="badge bg-info text-dark">Practical</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subject->status == 1)
                                            Active
                                        @else
                                            De-active
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-3 align-items-center">

                                            {{-- Edit --}}
                                            <a href="{{ route('school_admin.subjects.edit', $subject->id) }}"
                                                class="text-warning" title="Edit">
                                                <i class="fas fa-pen fa-lg"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('school_admin.subjects.delete', $subject->id) }}"
                                                method="POST" class="d-inline m-0" id="delete-form-{{ $subject->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="border-0 bg-transparent text-danger p-0"
                                                    title="Delete"
                                                    onclick="confirmDelete({{ $subject->id }}, '{{ addslashes($subject->name) }}')">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No subjects found.</td>
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
                    '" will permanently remove this subject and all related data.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?'
                    )) {
                return;
            }
            document.getElementById('delete-form-' + id).submit();
        }
    </script>

@endsection
