@extends('super_admin.layouts.app')

@section('title', 'Edit School')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">Edit School</h2>
            <a href="{{ route('super_admin.schools.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Schools
            </a>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-primary text-white py-3 border-0"
                style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                <h5 class="mb-0 fw-bold"><i class="fas fa-school me-2"></i>School Details</h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('super_admin.schools.update', $school->id) }}" method="POST">
                    @csrf
                    {{-- Notice: We are using a standard POST request here because your web.php route is defined as Route::post --}}

                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3 pb-2 border-bottom">School Information</h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">School Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $school->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">School Code <span class="text-danger">*</span></label>
                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $school->code) }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3 pb-2 border-bottom">Admin Credentials</h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Admin Name <span class="text-danger">*</span></label>
                                <input type="text" name="admin_name"
                                    class="form-control @error('admin_name') is-invalid @enderror"
                                    value="{{ old('admin_name', $admin->name ?? '') }}" required>
                                @error('admin_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Admin Email <span class="text-danger">*</span></label>
                                <input type="email" name="admin_email"
                                    class="form-control @error('admin_email') is-invalid @enderror"
                                    value="{{ old('admin_email', $admin->email ?? '') }}" required>
                                @error('admin_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password" name="admin_password"
                                    class="form-control @error('admin_password') is-invalid @enderror"
                                    placeholder="Leave blank to keep current password">
                                <small class="text-muted">Only fill this if you want to change the admin's password (min 6
                                    characters).</small>
                                @error('admin_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold" style="border-radius: 8px;">
                            <i class="fas fa-save me-2"></i>Update School
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
