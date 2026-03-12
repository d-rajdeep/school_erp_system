<nav class="sidebar sidebar-offcanvas shadow" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center justify-content-center pb-4 pt-3">
        <a class="sidebar-brand brand-logo text-decoration-none" href="#">
            <h2 class="text-black font-weight-bold mb-0">School Admin</h2>
        </a>
        <a class="sidebar-brand brand-logo-mini text-decoration-none" href="#">
            <h2 class="text-black font-weight-bold mb-0">SA</h2>
        </a>
    </div>
<br>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="/school-admin/dashboard">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#student-mgmt" aria-expanded="false"
                aria-controls="student-mgmt">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">Student Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="student-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.year.index') }}">Academic
                            Year</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.student.register.index') }}">Student Register</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.students.index') }}">Student
                            Admission</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Promote Student</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Transfer Student</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#class-mgmt" aria-expanded="false"
                aria-controls="class-mgmt">
                <i class="mdi mdi-google-classroom menu-icon"></i>
                <span class="menu-title">Class & Section</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="class-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.classes.index') }}">Class
                            List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.sections.index') }}">Section
                            List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.subjects.index') }}">Subject
                            List</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#teacher-mgmt" aria-expanded="false"
                aria-controls="teacher-mgmt">
                <i class="mdi mdi-teach menu-icon"></i>
                <span class="menu-title">Teacher Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="teacher-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.teachers.index') }}">Teacher
                            List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.teachers.create') }}">Add
                            Teacher</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#timetable-mgmt" aria-expanded="false"
                aria-controls="timetable-mgmt">
                <i class="mdi mdi-calendar-clock menu-icon"></i>
                <span class="menu-title">Timetable Mgmt</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="timetable-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.timetable.index') }}">View
                            Timetable</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.timetable.create') }}">Assign
                            Teacher</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#attendance-mgmt" aria-expanded="false"
                aria-controls="attendance-mgmt">
                <i class="mdi mdi-calendar-check menu-icon"></i>
                <span class="menu-title">Attendance</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="attendance-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.attendance.student') }}">Student Attendance</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.attendance.student.report') }}">View Student Report</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.attendance.staff') }}">Staff Attendance</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.attendance.staff.report') }}">View Staff Report</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#exam-mgmt" aria-expanded="false"
                aria-controls="exam-mgmt">
                <i class="mdi mdi-file-document-edit menu-icon"></i>
                <span class="menu-title">Exam Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="exam-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.exams.index') }}">Exam
                            List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('school_admin.exams.create') }}">Create
                            Exam</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.exams.marks_entry') }}">Marks Entry</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.exams.marks_index') }}">Report Cards</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#fee-mgmt" aria-expanded="false"
                aria-controls="fee-mgmt">
                <i class="mdi mdi-currency-inr menu-icon"></i> <span class="menu-title">Fee Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="fee-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.fees.types_index') }}">Fee Types</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.fees.structure_index') }}">Fee Structure</a></li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('school_admin.fees.payments_index') }}">Payments & Collection</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#communication-mgmt" aria-expanded="false"
                aria-controls="communication-mgmt">
                <i class="mdi mdi-message-text menu-icon"></i>
                <span class="menu-title">Communication</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="communication-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Notices</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Circulars</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Send Notifications</a></li>
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
                    <li class="nav-item"> <a class="nav-link" href="#">Pages</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Gallery</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Events</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Website Settings</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#settings-mgmt" aria-expanded="false"
                aria-controls="settings-mgmt">
                <i class="mdi mdi-cog menu-icon"></i>
                <span class="menu-title">Settings</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="settings-mgmt">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">School Profile</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Academic Year</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">System Settings</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item sidebar-actions mt-3">
            <div class="nav-link pt-0">
                <a href="/logout"
                    class="btn btn-danger text-white w-100 d-flex align-items-center justify-content-center shadow-sm"
                    style="border-radius: 8px;">
                    <i class="mdi mdi-logout me-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
