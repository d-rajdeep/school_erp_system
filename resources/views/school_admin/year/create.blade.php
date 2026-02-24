@extends('school_admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Add Academic Year</h4>
                        <a href="{{ route('school_admin.year.index') }}" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Back
                        </a>
                    </div>

                    <form class="forms-sample" action="{{ route('school_admin.year.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Academic Year Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="e.g. 2024-2025" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="current_year">Make this the Current Active Year? <span
                                    class="text-danger">*</span></label>
                            <select class="form-control form-select @error('current_year') is-invalid @enderror"
                                id="current_year" name="current_year" required>
                                <option value="0" {{ old('current_year') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('current_year') == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                            <small class="text-muted mt-1 d-block">Selecting 'Yes' will automatically deactivate any
                                currently active year.</small>

                            @error('current_year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
