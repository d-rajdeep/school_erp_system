@extends('school_admin.layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Academic Years List</h4>
                        <a href="{{ route('school_admin.year.create') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Add New Year
                        </a>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Academic Year</th>
                                    <th>Status</th>
                                    <th>Set as Current Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $key => $year)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="font-weight-bold">{{ $year->name }}</td>

                                        <td>
                                            <a href="{{ route('school_admin.year.status', $year->id) }}"
                                                class="badge {{ $year->status == 1 ? 'badge-success' : 'badge-danger' }} text-decoration-none">
                                                {{ $year->status == 1 ? 'Active' : 'Inactive' }}
                                            </a>
                                        </td>

                                        <td>
                                            <div class="form-check form-check-primary m-0">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input set-current-year"
                                                        name="current_year" value="{{ $year->id }}"
                                                        {{ $year->current_year == 1 ? 'checked' : '' }}>
                                                    Current
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </td>

                                        <td>
                                            <form action="{{ route('school_admin.year.delete') }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this year?');">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $year->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm p-2">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No Academic Years found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('.set-current-year');

            radioButtons.forEach(button => {
                button.addEventListener('change', function() {
                    let yearId = this.value;

                    // Sending GET request as defined in your routes
                    fetch(`{{ route('school_admin.setYearActive') }}?id=${yearId}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Optional: Show a subtle toast or alert here
                                console.log(data.message);
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Something went wrong!');
                        });
                });
            });
        });
    </script>
@endsection
