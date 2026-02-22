@extends('super_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold">Super Admin Dashboard</h1>
                <p class="text-muted">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your system.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#quickActionsModal">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </button>
                <button class="btn btn-primary" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Total Schools</h6>
                                <h2 class="mb-0">{{ $totalSchools ?? 245 }}</h2>
                            </div>
                            <i class="fas fa-school fa-3x text-white-50"></i>
                        </div>
                        <div class="mt-3 small">
                            <span class="text-white-50">+{{ $newSchoolsThisMonth ?? 12 }} this month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Total Users</h6>
                                <h2 class="mb-0">{{ $totalUsers ?? 15230 }}</h2>
                            </div>
                            <i class="fas fa-users fa-3x text-white-50"></i>
                        </div>
                        <div class="mt-3 small">
                            <span class="text-white-50">{{ $activeUsers ?? 12500 }} active users</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Active Modules</h6>
                                <h2 class="mb-0">{{ $activeModules ?? 24 }}</h2>
                            </div>
                            <i class="fas fa-puzzle-piece fa-3x text-white-50"></i>
                        </div>
                        <div class="mt-3 small">
                            <span class="text-white-50">{{ $totalModules ?? 32 }} total modules</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Revenue (Monthly)</h6>
                                <h2 class="mb-0">${{ number_format($monthlyRevenue ?? 45250) }}</h2>
                            </div>
                            <i class="fas fa-dollar-sign fa-3x text-white-50"></i>
                        </div>
                        <div class="mt-3 small">
                            <span class="text-white-50">↑ {{ $revenueGrowth ?? 8.5 }}% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-xl-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">System Growth Overview</h5>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary active">Weekly</button>
                                <button class="btn btn-sm btn-outline-primary">Monthly</button>
                                <button class="btn btn-sm btn-outline-primary">Yearly</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="growthChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">School Distribution</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="schoolDistributionChart" height="250"></canvas>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-circle text-primary me-2"></i>Active Schools</span>
                                <span class="fw-bold">{{ $activeSchools ?? 210 }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-circle text-warning me-2"></i>Pending Schools</span>
                                <span class="fw-bold">{{ $pendingSchools ?? 25 }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-circle text-danger me-2"></i>Suspended Schools</span>
                                <span class="fw-bold">{{ $suspendedSchools ?? 10 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Cards Row 1 -->
        <div class="row g-4 mb-4">
            <!-- Schools Management -->
            <div class="col-xl-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-school text-primary me-2"></i>Schools Management
                        </h5>
                        <span class="badge bg-primary">Core Feature</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('super_admin.schools.index') }}" class="text-decoration-none">
                                    <div class="p-3 border rounded-3 hover-shadow">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                                <i class="fas fa-eye text-primary"></i>
                                            </div>
                                            <h6 class="mb-0 fw-semibold">View Schools</h6>
                                        </div>
                                        <p class="text-muted small mb-0">Browse and manage all schools</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('super_admin.schools.create') }}" class="text-decoration-none">
                                    <div class="p-3 border rounded-3 hover-shadow">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
                                                <i class="fas fa-plus-circle text-success"></i>
                                            </div>
                                            <h6 class="mb-0 fw-semibold">Add School</h6>
                                        </div>
                                        <p class="text-muted small mb-0">Create new school with admin</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 hover-shadow cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#editSchoolModal">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded-3 me-3">
                                            <i class="fas fa-edit text-warning"></i>
                                        </div>
                                        <h6 class="mb-0 fw-semibold">Edit School</h6>
                                    </div>
                                    <p class="text-muted small mb-0">Modify school details</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 hover-shadow cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#manageSchoolModal">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded-3 me-3">
                                            <i class="fas fa-ban text-danger"></i>
                                        </div>
                                        <h6 class="mb-0 fw-semibold">Disable/Delete</h6>
                                    </div>
                                    <p class="text-muted small mb-0">Manage school status</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 p-3 bg-light rounded-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Recently added: 3 schools this week</span>
                                <a href="{{ route('super_admin.schools.index') }}" class="small">View All <i
                                        class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Module Management -->
            <div class="col-xl-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-puzzle-piece text-info me-2"></i>Module Management
                        </h5>
                        <span class="badge bg-info">System Feature</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 hover-shadow cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#enableModulesModal">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        <h6 class="mb-0 fw-semibold">Enable Modules</h6>
                                    </div>
                                    <p class="text-muted small mb-0">Activate system modules</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 hover-shadow cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#disableModulesModal">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded-3 me-3">
                                            <i class="fas fa-times-circle text-danger"></i>
                                        </div>
                                        <h6 class="mb-0 fw-semibold">Disable Modules</h6>
                                    </div>
                                    <p class="text-muted small mb-0">Deactivate system modules</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="fw-semibold mb-3">Popular Modules</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark p-2">Student Management <i
                                        class="fas fa-check-circle text-success ms-1"></i></span>
                                <span class="badge bg-light text-dark p-2">Teacher Portal <i
                                        class="fas fa-check-circle text-success ms-1"></i></span>
                                <span class="badge bg-light text-dark p-2">Fee Management <i
                                        class="fas fa-check-circle text-success ms-1"></i></span>
                                <span class="badge bg-light text-dark p-2">Exam System <i
                                        class="fas fa-times-circle text-danger ms-1"></i></span>
                                <span class="badge bg-light text-dark p-2">Library <i
                                        class="fas fa-times-circle text-danger ms-1"></i></span>
                                <span class="badge bg-light text-dark p-2">Transport <i
                                        class="fas fa-check-circle text-success ms-1"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Cards Row 2 -->
        <div class="row g-4 mb-4">
            <!-- CMS Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-file-alt text-warning me-2"></i>CMS Management
                        </h5>
                        <span class="badge bg-warning">Content</span>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file me-2 text-primary"></i>
                                    <span>Page Builder</span>
                                </div>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#pageBuilderModal">
                                    Manage <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-bars me-2 text-success"></i>
                                    <span>Menu Builder</span>
                                </div>
                                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#menuBuilderModal">
                                    Manage <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-paint-brush me-2 text-info"></i>
                                    <span>Theme Manager</span>
                                </div>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#themeManagerModal">
                                    Manage <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-cubes me-2 text-warning"></i>
                                    <span>Content Blocks</span>
                                </div>
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#contentBlocksModal">
                                    Manage <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-users text-success me-2"></i>User Management
                        </h5>
                        <span class="badge bg-success">Security</span>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    <span>View Users</span>
                                </div>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#viewUsersModal">
                                    View All <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-user-tag me-2 text-info"></i>
                                    <span>Assign Roles</span>
                                </div>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#assignRolesModal">
                                    Assign <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="fw-semibold mb-3">User Statistics</h6>
                            <div class="progress-stacked">
                                <div class="progress" role="progressbar" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: 60%"></div>
                                    <div class="progress-bar bg-info" style="width: 25%"></div>
                                    <div class="progress-bar bg-warning" style="width: 15%"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 small">
                                <span><i class="fas fa-circle text-primary me-1"></i>School Admins (60%)</span>
                                <span><i class="fas fa-circle text-info me-1"></i>Teachers (25%)</span>
                                <span><i class="fas fa-circle text-warning me-1"></i>Others (15%)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports & Analytics -->
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-chart-line text-danger me-2"></i>Reports & Analytics
                        </h5>
                        <span class="badge bg-danger">Insights</span>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush mb-3">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-chart-pie me-2 text-primary"></i>
                                    <span>System Analytics</span>
                                </div>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#analyticsModal">
                                    View <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3">
                                    <h5 class="mb-1 fw-bold">85%</h5>
                                    <small class="text-muted">System Uptime</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3">
                                    <h5 class="mb-1 fw-bold">4.8/5</h5>
                                    <small class="text-muted">User Rating</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Recent System Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>User</th>
                                        <th>School</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fas fa-plus-circle text-success me-2"></i>New School Created</td>
                                        <td>John Doe</td>
                                        <td>Springfield Elementary</td>
                                        <td>5 minutes ago</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-edit text-warning me-2"></i>School Updated</td>
                                        <td>Jane Smith</td>
                                        <td>Riverside High</td>
                                        <td>15 minutes ago</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-user-plus text-info me-2"></i>New Admin Assigned</td>
                                        <td>Mike Johnson</td>
                                        <td>Lincoln Academy</td>
                                        <td>1 hour ago</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-ban text-danger me-2"></i>Module Disabled</td>
                                        <td>Sarah Wilson</td>
                                        <td>System Wide</td>
                                        <td>2 hours ago</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Modal -->
    <div class="modal fade" id="quickActionsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="{{ route('super_admin.schools.create') }}"
                            class="list-group-item list-group-item-action">
                            <i class="fas fa-plus-circle text-primary me-2"></i>Add New School
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#enableModulesModal">
                            <i class="fas fa-puzzle-piece text-success me-2"></i>Enable Module
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#viewUsersModal">
                            <i class="fas fa-users text-info me-2"></i>Manage Users
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#analyticsModal">
                            <i class="fas fa-chart-line text-warning me-2"></i>View Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add CSS for hover effects and transitions -->
    <style>
        .hover-shadow {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .hover-shadow:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 10px;
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Growth Chart
        const ctx1 = document.getElementById('growthChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Schools',
                    data: [65, 78, 90, 105, 120, 145, 168, 185, 200, 220, 235, 245],
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Users',
                    data: [8000, 9200, 10500, 11800, 12500, 13500, 14200, 14800, 15200, 15230, 15230,
                        15230],
                    borderColor: '#1cc88a',
                    backgroundColor: 'rgba(28, 200, 138, 0.05)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // School Distribution Chart
        const ctx2 = document.getElementById('schoolDistributionChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Active Schools', 'Pending Schools', 'Suspended Schools'],
                datasets: [{
                    data: [210, 25, 10],
                    backgroundColor: ['#4e73df', '#f6c23e', '#e74a3b'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });
    </script>
@endpush
