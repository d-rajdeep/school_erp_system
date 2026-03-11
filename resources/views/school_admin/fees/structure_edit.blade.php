@extends('school_admin.layouts.app')

@section('title', 'Edit Fee Structure')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Edit Fee Structure</h2>
            <a href="{{ route('school_admin.fees.structure_index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">

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

                {{-- Read-only Info --}}
                <div class="row g-4 mb-4 pb-4 border-bottom">
                    <div class="col-md-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Academic Year</p>
                        <p class="fw-semibold mb-0">{{ $structure->academicYear->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Class</p>
                        <p class="fw-semibold mb-0">{{ $structure->schoolClass->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1 small fw-semibold text-uppercase">Fee Type</p>
                        <p class="fw-semibold mb-0">{{ $structure->feeType->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <form action="{{ route('school_admin.fees.structure_update', $structure->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="amount" step="0.01" min="0"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $structure->amount) }}">
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <p class="text-muted small mt-3 mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Only the amount can be edited. To change the class or fee type, delete and recreate.
                    </p>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Amount
                        </button>
                        <a href="{{ route('school_admin.fees.structure_index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
