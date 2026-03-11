@extends('school_admin.layouts.app')

@section('title', 'Fee Structure')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Fee Structure</h2>
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

        <div class="row g-4">

            {{-- Add Fee Structure Form --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Assign Fee Structure</h5>

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

                        <form action="{{ route('school_admin.fees.structure_store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Academic Year <span
                                        class="text-danger">*</span></label>

                                {{-- 'pointer-events: none' and gray background make it act like a read-only field --}}
                                <select name="year_id" class="form-select @error('year_id') is-invalid @enderror"
                                    style="pointer-events: none; background-color: #f3f4f6;">

                                    @foreach ($years as $year)
                                        {{-- Only display the active current year --}}
                                        @if ($year->current_year == 1)
                                            <option value="{{ $year->id }}" selected>
                                                {{ $year->name }}
                                            </option>
                                        @endif
                                    @endforeach

                                </select>

                                @error('year_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-select @error('class_id') is-invalid @enderror">
                                    <option value="">-- Select Class --</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Fee Type <span class="text-danger">*</span></label>
                                <select name="fee_type_id" class="form-select @error('fee_type_id') is-invalid @enderror">
                                    <option value="">-- Select Fee Type --</option>
                                    @foreach ($feeTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('fee_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fee_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="amount" step="0.01" min="0"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        value="{{ old('amount') }}" placeholder="0.00">
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Assign Fee
                            </button>

                        </form>
                    </div>
                </div>
            </div>

            {{-- Fee Structure List --}}
            <div class="col-md-8">

                {{-- Filter --}}
                <div class="card mb-3">
                    <div class="card-body py-3">
                        <form method="GET" action="{{ route('school_admin.fees.structure_index') }}">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small">Filter by Class</label>
                                    <select name="class_id" class="form-select form-select-sm">
                                        <option value="">-- All Classes --</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md-4">
                                    <label class="form-label fw-semibold small">Filter by Year</label>
                                    <select name="year_id" class="form-select form-select-sm">
                                        <option value="">-- All Years --</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year->id }}"
                                                {{ request('year_id') == $year->id ? 'selected' : '' }}>
                                                {{ $year->year_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}


                                <div class="col-md-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-filter me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('school_admin.fees.structure_index') }}"
                                        class="btn btn-outline-secondary btn-sm w-100">
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
                                        <th>Academic Year</th>
                                        <th>Class</th>
                                        <th>Fee Type</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($structures as $structure)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $structure->academicYear->name ?? 'N/A' }}</td>
                                            <td>{{ $structure->schoolClass->name ?? 'N/A' }}</td>
                                            <td>{{ $structure->feeType->name ?? 'N/A' }}</td>
                                            <td>₹ {{ number_format($structure->amount, 2) }}</td>
                                            <td>
                                                <div class="d-flex gap-3 align-items-center">

                                                    {{-- Edit --}}
                                                    <a href="#" class="text-warning" title="Edit"
                                                        onclick="openEditModal({{ $structure->id }}, {{ $structure->amount }}, '{{ addslashes($structure->schoolClass->name ?? '') }}', '{{ addslashes($structure->feeType->name ?? '') }}')">
                                                        <i class="fas fa-pen fa-lg"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <form
                                                        action="{{ route('school_admin.fees.structure_delete', $structure->id) }}"
                                                        method="POST" class="d-inline m-0"
                                                        id="delete-form-{{ $structure->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="border-0 bg-transparent text-danger p-0" title="Delete"
                                                            onclick="confirmDelete({{ $structure->id }}, '{{ addslashes($structure->feeType->name ?? '') }}')">
                                                            <i class="fas fa-trash fa-lg"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No fee structures found.</td>
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
                    <h5 class="modal-title fw-bold">Edit Fee Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Class</label>
                            <input type="text" id="edit_class" class="form-control bg-light" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Fee Type</label>
                            <input type="text" id="edit_fee_type" class="form-control bg-light" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="amount" id="edit_amount" class="form-control"
                                    step="0.01" min="0" required>
                            </div>
                        </div>

                        <p class="text-muted small mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Only the amount can be edited. To change the class or fee type, delete and recreate.
                        </p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Amount
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, amount, className, feeTypeName) {
            document.getElementById('edit_amount').value = amount;
            document.getElementById('edit_class').value = className;
            document.getElementById('edit_fee_type').value = feeTypeName;

            let url = "{{ route('school_admin.fees.structure_update', '__id__') }}";
            document.getElementById('editForm').action = url.replace('__id__', id);

            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function confirmDelete(id, name) {
            if (!confirm('Are you sure you want to delete the "' + name + '" fee structure?')) return;
            if (!confirm(
                    'WARNING!\n\nThis may affect existing fee payment records.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?'
                    )) return;
            document.getElementById('delete-form-' + id).submit();
        }
    </script>

@endsection
