@extends('super_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Schools Management</h2>
                <p class="text-muted">Manage all schools in the system</p>
            </div>
            <a href="{{ route('super_admin.schools.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Add New School
            </a>
        </div>

        <!-- Schools List -->
        @if ($schools->count() > 0)
            <div class="row">
                @foreach ($schools as $school)
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-primary text-white py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-school me-2"></i>{{ $school->name }}
                                    </h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('super_admin.schools.edit', $school->id) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('super_admin.schools.index', $school->id) }}">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-sign-in-alt me-2"></i>Login as Admin
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('super_admin.schools.delete', $school->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this school?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- School Code -->
                                <div class="mb-3">
                                    <span class="badge bg-info text-white">
                                        <i class="fas fa-qrcode me-1"></i>
                                        Code: {{ $school->code ?? 'SCH' . str_pad($school->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>

                                <!-- School Details -->
                                <div class="mb-3">
                                    @if ($school->email)
                                        <p class="mb-2">
                                            <i class="fas fa-envelope text-primary me-2"></i>
                                            {{ $school->email }}
                                        </p>
                                    @endif

                                    @if ($school->phone)
                                        <p class="mb-2">
                                            <i class="fas fa-phone text-primary me-2"></i>
                                            {{ $school->phone }}
                                        </p>
                                    @endif

                                    @if ($school->address)
                                        <p class="mb-2">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            {{ $school->address }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Stats Row -->
                                <div class="row text-center border-top border-bottom py-3 mb-3">
                                    <div class="col-4">
                                        <h5 class="fw-bold mb-0">{{ $school->students_count ?? 0 }}</h5>
                                        <small class="text-muted">Students</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="fw-bold mb-0">{{ $school->teachers_count ?? 0 }}</h5>
                                        <small class="text-muted">Teachers</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="fw-bold mb-0">{{ $school->classes_count ?? 0 }}</h5>
                                        <small class="text-muted">Classes</small>
                                    </div>
                                </div>

                                <!-- Admin Info -->
                                @if ($school->admin)
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-light rounded-circle p-2 me-3">
                                            <i class="fas fa-user-shield text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="fw-bold mb-0">{{ $school->admin->name }}</p>
                                            <small class="text-muted">{{ $school->admin->email }}</small>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning py-2 mb-3">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        No admin assigned
                                    </div>
                                @endif

                                <!-- Status Badge -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-{{ $school->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($school->status ?? 'Active') }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $school->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if (method_exists($schools, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $schools->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-school fa-4x text-muted"></i>
                </div>
                <h3>No Schools Found</h3>
                <p class="text-muted mb-4">Get started by adding your first school to the system.</p>
                <a href="{{ route('super_admin.schools.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Add Your First School
                </a>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <!-- Bootstrap Icons (if not already included) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@push('scripts')
    <!-- Bootstrap JS (if not already included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
