@extends('school_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold">School Admin Dashboard</h1>
                <p class="text-muted">
                    <i class="fas fa-school me-2"></i>School: <strong>{{ $school->name }}</strong> |
                    <i class="fas fa-user me-2"></i>Welcome, <strong>{{ auth()->user()->name }}</strong>
                </p>
            </div>
            <div>
                <span class="badge bg-primary p-3">{{ date('F d, Y') }}</span>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Total Students</h6>
                                <h3 class="mb-0">{{ $totalStudents ?? 0 }}</h3>
                            </div>
                            <i class="fas fa-user-graduate fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Total Teachers</h6>
                                <h3 class="mb-0">{{ $totalTeachers ?? 0 }}</h3>
                            </div>
                            <i class="fas fa-chalkboard-teacher fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Total Classes</h6>
                                <h3 class="mb-0">{{ $totalClasses ?? 0 }}</h3>
                            </div>
                            <i class="fas fa-building fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Today's Attendance</h6>
                                <h3 class="mb-0">{{ $todayAttendance ?? 0 }}%</h3>
                            </div>
                            <i class="fas fa-calendar-check fa-3x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Cards Row 1 -->
        <div class="row g-4 mb-4">
            <!-- Student Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-user-graduate text-primary me-2"></i>Student Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <a href="#" class="text-decoration-none text-dark">Student List</a>
                                <div>
                                    <a href="#" class="badge bg-info text-white me-1" title="View">View</a>
                                    <a href="#" class="badge bg-warning text-white me-1" title="Edit">Edit</a>
                                    <a href="#" class="badge bg-danger text-white" title="Delete">Delete</a>
                                </div>
                            </div>
                            <a href="#" class="list-group-item list-group-item-action px-0">Add Student</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Promote Student</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Transfer Student</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teacher Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-chalkboard-teacher text-success me-2"></i>Teacher Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action px-0">Teacher List</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Add Teacher</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Edit Teacher</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Assign Class</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class & Section Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-building text-warning me-2"></i>Class & Section Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action px-0">Class List</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Add Class</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Section List</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Add Section</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Cards Row 2 -->
        <div class="row g-4 mb-4">
            <!-- Timetable Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-calendar-alt text-info me-2"></i>Timetable Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action px-0">View Timetable</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Create Timetable</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Edit Timetable</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-check-circle text-success me-2"></i>Attendance Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action px-0">Student Attendance</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Staff Attendance</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exam Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-pencil-alt text-danger me-2"></i>Exam Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action px-0">Exam List</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Create Exam</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Marks Entry</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Report Cards</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Cards Row 3 -->
        <div class="row g-4 mb-4">
            <!-- Fee Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>Fee Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action px-0">Fee Structure</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Collect Fee</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Payment History</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Reports</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Communication -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-bullhorn text-warning me-2"></i>Communication
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action px-0">Notices</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Circulars</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Send Notifications</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CMS Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-file-alt text-info me-2"></i>CMS Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action px-0">Pages</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Gallery</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Events</a>
                            <a href="#" class="list-group-item list-group-item-action px-0">Website Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Cards Row 4 -->


        <!-- Recent Activity -->

    </div>

    <style>
        .list-group-item-action:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
            transition: all 0.3s ease;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .bg-success {
            background: linear-gradient(135deg, #1cc88a 0%, #13855e 100%) !important;
        }

        .bg-info {
            background: linear-gradient(135deg, #36b9cc 0%, #258391 100%) !important;
        }

        .bg-warning {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%) !important;
        }
    </style>
@endsection
