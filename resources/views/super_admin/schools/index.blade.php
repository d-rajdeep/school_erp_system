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
                        {{-- Added 'school-card-hover' custom class for a smooth lift effect --}}
                        <div class="card h-100 shadow-sm border-0 school-card-hover"
                            style="border-radius: 12px; overflow: hidden;">

                            {{-- Modern Gradient Header --}}
                            <div class="card-header py-3 border-0"
                                style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0 text-white fw-bold d-flex align-items-center">
                                        <div class="bg-white bg-opacity-25 rounded p-2 me-2 d-flex align-items-center justify-content-center"
                                            style="width: 35px; height: 35px;">
                                            <i class="fas fa-school text-white"></i>
                                        </div>
                                        {{ $school->name }}
                                    </h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm text-white bg-white bg-opacity-25 border-0 rounded-circle"
                                            style="width: 32px; height: 32px;" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                            style="border-radius: 8px;">
                                            <li>
                                                <a class="dropdown-item py-2"
                                                    href="{{ route('super_admin.schools.edit', $school->id) }}">
                                                    <i class="fas fa-edit text-warning me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-2"
                                                    href="{{ route('super_admin.schools.index', $school->id) }}">
                                                    <i class="fas fa-eye text-info me-2"></i>View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-2" href="#">
                                                    <i class="fas fa-sign-in-alt text-primary me-2"></i>Login as Admin
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('super_admin.schools.delete', $school->id) }}"
                                                    method="POST" class="d-inline m-0"
                                                    id="delete-school-{{ $school->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger py-2"
                                                        onclick="confirmSchoolDelete({{ $school->id }}, '{{ addslashes($school->name) }}')">
                                                        <i class="fas fa-trash-alt me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="mb-4">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2"
                                        style="border-radius: 6px;">
                                        <i class="fas fa-qrcode me-1"></i>
                                        Code: <span
                                            class="fw-bold">{{ $school->code ?? 'SCH' . str_pad($school->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <ul class="list-unstyled mb-0">
                                        @if ($school->email)
                                            <li class="d-flex align-items-start mb-2 text-muted">
                                                <i class="fas fa-envelope text-primary mt-1 me-3" style="width: 16px;"></i>
                                                <span>{{ $school->email }}</span>
                                            </li>
                                        @endif
                                        @if ($school->phone)
                                            <li class="d-flex align-items-start mb-2 text-muted">
                                                <i class="fas fa-phone text-primary mt-1 me-3" style="width: 16px;"></i>
                                                <span>{{ $school->phone }}</span>
                                            </li>
                                        @endif
                                        @if ($school->address)
                                            <li class="d-flex align-items-start text-muted">
                                                <i class="fas fa-map-marker-alt text-primary mt-1 me-3"
                                                    style="width: 16px;"></i>
                                                <span>{{ $school->address }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                {{-- Stats Row (Upgraded to soft boxed stats) --}}
                                <div class="row g-2 text-center mb-4">
                                    <div class="col-4">
                                        <div class="bg-light p-2 rounded">
                                            <h5 class="fw-bold text-dark mb-0">{{ $school->students_count ?? 0 }}</h5>
                                            <small class="text-muted"
                                                style="font-size: 0.75rem fw-semibold;">Students</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-light p-2 rounded">
                                            <h5 class="fw-bold text-dark mb-0">{{ $school->teachers_count ?? 0 }}</h5>
                                            <small class="text-muted"
                                                style="font-size: 0.75rem fw-semibold;">Teachers</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-light p-2 rounded">
                                            <h5 class="fw-bold text-dark mb-0">{{ $school->classes_count ?? 0 }}</h5>
                                            <small class="text-muted"
                                                style="font-size: 0.75rem fw-semibold;">Classes</small>
                                        </div>
                                    </div>
                                </div>

                                @if ($school->admin)
                                    <div
                                        class="d-flex align-items-center mb-4 p-2 border rounded border-light bg-white shadow-sm">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center me-3"
                                            style="width: 45px; height: 45px;">
                                            <i class="fas fa-user-tie text-primary fa-lg"></i>
                                        </div>
                                        <div>
                                            <p class="fw-bold text-dark mb-0">{{ $school->admin->name }}</p>
                                            <small class="text-muted d-block"
                                                style="font-size: 0.8rem;">{{ $school->admin->email }}</small>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning py-2 mb-4 d-flex align-items-center border-0"
                                        style="background-color: #fff3cd; color: #856404; border-radius: 8px;">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <span class="fw-semibold" style="font-size: 0.85rem;">No admin assigned</span>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    @if ($school->status == 'active')
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i> Active
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-2 rounded-pill">
                                            {{ ucfirst($school->status ?? 'Inactive') }}
                                        </span>
                                    @endif

                                    <small class="text-muted fw-medium">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $school->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if (method_exists($schools, 'links'))
                <div class="d-flex justify-content-end mt-4">
                    {{ $schools->links() }}
                </div>
            @endif
        @else
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 100px; height: 100px;">
                            <i class="fas fa-school fa-3x text-muted opacity-50"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-dark">No Schools Found</h4>
                    <p class="text-muted mb-4 max-w-md mx-auto">It looks like there are no schools registered in the system
                        yet. Get started by adding your first school.</p>
                    <a href="{{ route('super_admin.schools.create') }}" class="btn btn-primary px-4 py-2 fw-semibold"
                        style="border-radius: 8px;">
                        <i class="fas fa-plus-circle me-2"></i>Add Your First School
                    </a>
                </div>
            </div>
        @endif

        {{-- Add this CSS anywhere in your file or global stylesheet to enable the smooth hover lift --}}
        <style>
            .school-card-hover {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            }

            .school-card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            }
        </style>
    </div>
    <script>
        function confirmSchoolDelete(id, name) {
            if (!confirm('Are you sure you want to delete "' + name + '"?')) return;
            if (!confirm('WARNING!\n\nDeleting "' + name +
                    '" will permanently remove the school and ALL its data including students, teachers, classes, fees, exams and staff accounts.\n\nThis action CANNOT be undone.\n\nAre you absolutely sure?'
                )) return;
            document.getElementById('delete-school-' + id).submit();
        }
    </script>
@endsection

@push('styles')
    <!-- Bootstrap Icons (if not already included) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@push('scripts')
    <!-- Bootstrap JS (if not already included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
