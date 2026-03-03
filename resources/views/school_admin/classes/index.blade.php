@extends('school_admin.layouts.app')

@section('title', 'Classes')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Classes</h2>
            <a href="{{ route('school_admin.classes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Class
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
                                <th>Class Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classes as $class)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $class->name }}</td>
                                    <td>
                                        <div class="d-flex gap-3 align-items-center">

                                            {{-- Edit --}}
                                            <a href="{{ route('school_admin.classes.edit', $class->id) }}"
                                                class="text-warning" title="Edit">
                                                <i class="fas fa-pen fa-lg"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('school_admin.classes.destroy', $class->id) }}"
                                                method="POST" class="d-inline m-0" id="delete-form-{{ $class->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="border-0 bg-transparent text-danger p-0"
                                                    title="Delete"
                                                    onclick="confirmDelete({{ $class->id }}, '{{ addslashes($class->name) }}')">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No classes found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <script>
        function confirmDelete(id, className) {
            if (!confirm('Are you sure you want to delete "' + className + '"?')) {
                return;
            }
            if (!confirm('WARNING!\n\nDeleting "' + className +
                    '" will permanently remove ALL students assigned to this class.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?'
                    )) {
                return;
            }
            document.getElementById('delete-form-' + id).submit();
        }
    </script>
@endsection
