@extends('school_admin.layouts.app')

@section('title', 'Fee Types')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Fee Types</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">

            {{-- Add Fee Type Form --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Add Fee Type</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('school_admin.fees.types_store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Fee Type Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="e.g. Tuition Fee">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Optional description...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Save Fee Type
                            </button>

                        </form>
                    </div>
                </div>
            </div>

            {{-- Fee Types List --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">All Fee Types</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($feeTypes as $feeType)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $feeType->name }}</td>
                                            <td>{{ $feeType->description ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex gap-3 align-items-center">

                                                    {{-- Edit --}}
                                                    <a href="#" class="text-warning" title="Edit"
                                                        onclick="openEditModal({{ $feeType->id }}, '{{ addslashes($feeType->name) }}', '{{ addslashes($feeType->description) }}')">
                                                        <i class="fas fa-pen fa-lg"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <form
                                                        action="{{ route('school_admin.fees.types_delete', $feeType->id) }}"
                                                        method="POST" class="d-inline m-0"
                                                        id="delete-form-{{ $feeType->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="border-0 bg-transparent text-danger p-0" title="Delete"
                                                            onclick="confirmDelete({{ $feeType->id }}, '{{ addslashes($feeType->name) }}')">
                                                            <i class="fas fa-trash fa-lg"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No fee types found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Fee Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Fee Type Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" id="edit_description" rows="3" class="form-control"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, name, description) {
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;

            let url = "{{ route('school_admin.fees.types_update', '__id__') }}";
            document.getElementById('editForm').action = url.replace('__id__', id);

            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function confirmDelete(id, name) {
            if (!confirm('Are you sure you want to delete "' + name + '"?')) return;
            if (!confirm('WARNING!\n\nDeleting "' + name +
                    '" may affect existing fee records.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?'))
                return;
            document.getElementById('delete-form-' + id).submit();
        }
    </script>

@endsection
