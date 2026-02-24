@extends('school_admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Student Registrations</h2>
            <a href="{{route('school_admin.student.register.create')}}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Student
            </a>
        </div>

        <!-- Students Table -->
        <div class="card">
            <div class="card-body">
                @if ($students->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Gender</th>
                                    <th>Father</th>
                                    <th>Mother</th>
                                    <th>DOB</th>
                                    <th>Register Date</th>
                                    <th>Year</th>
                                    <th>Transport</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->student_id ?? 'N/A' }}</td>
                                        <td>{{ $student->name ?? 'N/A' }}</td>
                                        <td>{{ $student->email ?? 'N/A' }}</td>
                                        <td>{{ $student->mobile ?? 'N/A' }}</td>
                                        <td>
                                            @if ($student->gender == '1')
                                                Male
                                            @elseif($student->gender == '2')
                                                Female
                                            @elseif($student->gender == '3')
                                                Other
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $student->fname ?? 'N/A' }}</td>
                                        <td>{{ $student->mname ?? 'N/A' }}</td>
                                        <td>{{ $student->dob ?? 'N/A' }}</td>
                                        <td>{{ $student->register_date ?? 'N/A' }}</td>
                                        <td>{{ $student->year ?? 'N/A' }}</td>
                                        <td>{{ $student->transport ? 'Yes' : 'No' }}</td>
                                        <td>
                                            @if ($student->status == '1')
                                                Active
                                            @else
                                                De-active
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <a href="{{ route('school_admin.student_registers.edit', $student->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form
                                                action="{{ route('school_admin.student_registers.destroy', $student->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this student?')">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{-- <div class="mt-3">
                        {{ $students->links() }}
                    </div> --}}
                @else
                    <p class="text-center">No students found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
