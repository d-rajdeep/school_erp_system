<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="sidebar-brand brand-logo text-decoration-none" href="#">
            <h2 class="text-black font-weight-bold mb-0">Super Admin</h2>
        </a>
        <a class="sidebar-brand brand-logo-mini text-decoration-none" href="#">
            <h2 class="text-black font-weight-bold mb-0">SA</h2>
        </a>
    </div>
    <br></br>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{route('super_admin.dashboard')}}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#schools-mgmt" aria-expanded="false"
                aria-controls="schools-mgmt">
                <i class="mdi mdi-domain menu-icon"></i>
                <span class="menu-title">Schools Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="schools-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('super_admin.schools.index')}}">View Schools</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('super_admin.schools.create')}}">Add School</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#module-mgmt" aria-expanded="false"
                aria-controls="module-mgmt">
                <i class="mdi mdi-view-module menu-icon"></i>
                <span class="menu-title">Module Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="module-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Enable/Disable Modules</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#cms-mgmt" aria-expanded="false"
                aria-controls="cms-mgmt">
                <i class="mdi mdi-web menu-icon"></i>
                <span class="menu-title">CMS Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="cms-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Page Builder</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Menu Builder</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Theme Manager</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Content Blocks</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#user-mgmt" aria-expanded="false"
                aria-controls="user-mgmt">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">User Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="user-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">View Users</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Assign Roles</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#reports-mgmt" aria-expanded="false"
                aria-controls="reports-mgmt">
                <i class="mdi mdi-chart-areaspline menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="reports-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">System Analytics</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item sidebar-actions">
            <div class="nav-link pt-0">
                <div class="mt-4">
                    <ul class="mt-4 ps-0 list-unstyled">
                        <li>
                            <a href="/logout"
                                class="btn btn-block btn-danger text-white w-100 d-flex align-items-center justify-content-center">
                                <i class="mdi mdi-logout me-2"></i> Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</nav>
