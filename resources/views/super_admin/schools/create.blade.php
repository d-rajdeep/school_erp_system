@extends('super_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Create New School</h2>
                <p class="text-muted">Add a new school and assign an administrator</p>
            </div>
            <a href="{{ route('super_admin.schools.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Schools
            </a>
        </div>

        <!-- Form Card -->
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('super_admin.schools.store') }}">
                    @csrf

                    <!-- School Information Section -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="fas fa-school text-primary me-2"></i>
                            School Information
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    School Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Enter school name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label fw-semibold">
                                    School Code <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code') }}" placeholder="e.g., SCH001"
                                    required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Unique code to identify the school</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">School Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="school@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">School Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 234 567 890">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">School Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2"
                                placeholder="Enter full address">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Admin Information Section -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="fas fa-user-shield text-primary me-2"></i>
                            School Administrator Information
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="admin_name" class="form-label fw-semibold">
                                    Admin Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('admin_name') is-invalid @enderror"
                                    id="admin_name" name="admin_name" value="{{ old('admin_name') }}"
                                    placeholder="Full name" required>
                                @error('admin_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admin_email" class="form-label fw-semibold">
                                    Admin Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control @error('admin_email') is-invalid @enderror"
                                    id="admin_email" name="admin_email" value="{{ old('admin_email') }}"
                                    placeholder="admin@example.com" required>
                                @error('admin_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="admin_password" class="form-label fw-semibold">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control @error('admin_password') is-invalid @enderror"
                                    id="admin_password" name="admin_password" placeholder="Create password" required>
                                @error('admin_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admin_password_confirmation" class="form-label fw-semibold">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control" id="admin_password_confirmation"
                                    name="admin_password_confirmation" placeholder="Confirm password" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="admin_phone" class="form-label fw-semibold">Admin Phone</label>
                                <input type="text" class="form-control @error('admin_phone') is-invalid @enderror"
                                    id="admin_phone" name="admin_phone" value="{{ old('admin_phone') }}"
                                    placeholder="+1 234 567 890">
                                @error('admin_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Settings -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2 mb-4">
                            <i class="fas fa-cog text-primary me-2"></i>
                            Additional Settings
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="subscription_plan" class="form-label fw-semibold">Subscription Plan</label>
                                <select class="form-select @error('subscription_plan') is-invalid @enderror"
                                    id="subscription_plan" name="subscription_plan">
                                    <option value="basic" {{ old('subscription_plan') == 'basic' ? 'selected' : '' }}>
                                        Basic</option>
                                    <option value="standard"
                                        {{ old('subscription_plan') == 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="premium" {{ old('subscription_plan') == 'premium' ? 'selected' : '' }}>
                                        Premium</option>
                                </select>
                                @error('subscription_plan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="max_students" class="form-label fw-semibold">Max Students Limit</label>
                                <input type="number" class="form-control @error('max_students') is-invalid @enderror"
                                    id="max_students" name="max_students" value="{{ old('max_students', 500) }}"
                                    placeholder="500">
                                @error('max_students')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <span class="fw-semibold">Active</span>
                                    <span class="text-muted d-block small">School will be immediately available</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('super_admin.schools.index') }}" class="btn btn-light px-4">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fas fa-save me-2"></i>Create School
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Font Awesome (if not already included) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('scripts')
    <script>
        // Password confirmation validation
        document.getElementById('admin_password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('admin_password').value;
            const confirm = this.value;

            if (password !== confirm) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        // Auto-generate school code based on name
        document.getElementById('name').addEventListener('input', function() {
            const codeField = document.getElementById('code');
            if (!codeField.value) {
                const name = this.value;
                const initials = name.split(' ')
                    .map(word => word.charAt(0))
                    .join('')
                    .toUpperCase()
                    .substring(0, 3);
                if (initials) {
                    codeField.placeholder = `e.g., ${initials}001`;
                }
            }
        });
    </script>
@endpush
