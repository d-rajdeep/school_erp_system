@extends('school_admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Admitted Students</h4>
                        <a href="{{ route('school_admin.students.create') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Add Admission
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Admission No</th>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Roll No</th>
                                    <th>Fees</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admissions as $key => $admission)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="font-weight-bold text-primary">{{ $admission->admission_no }}</td>

                                        <td>{{ $admission->student->name ?? 'N/A' }}</td>
                                        <td>{{ $admission->schoolClass->name ?? 'N/A' }}</td>
                                        <td>{{ $admission->section->name ?? 'N/A' }}</td>

                                        <td>{{ $admission->roll_number ?? '-' }}</td>

                                        <td>
                                            @if ($admission->fees_pay == '1')
                                                <span class="badge badge-success">Paid</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="#" class="btn btn-info btn-sm p-2" title="View">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-dark btn-sm p-2" title="Edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No student admissions found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
