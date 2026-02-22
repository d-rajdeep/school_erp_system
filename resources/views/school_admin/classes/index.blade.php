@extends('school_admin.layouts.app')

@section('title', 'Classes')

@section('content')

    <div class="container mt-4">

        <div class="d-flex justify-content-between mb-3">
            <h4>Classes</h4>

            <a href="{{ route('school_admin.classes.create') }}" class="btn btn-primary">
                Add Class
            </a>
        </div>


        <div class="card">
            <div class="card-body">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Class Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($classes as $class)
                            <tr>

                                <td>{{ $class->id }}</td>

                                <td>{{ $class->name }}</td>

                                {{-- <td>

                                    <a href="{{ route('school_admin.classes.edit', $class->id) }}"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <a href="{{ route('school_admin.classes.delete', $class->id) }}"
                                        class="btn btn-sm btn-danger" onclick="return confirm('Delete this class?')">
                                        Delete
                                    </a>

                                </td> --}}

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3">No classes found</td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>

@endsection
