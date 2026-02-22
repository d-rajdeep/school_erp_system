@extends('school_admin.layouts.app')

@section('title', 'Sections')

@section('content')

    <div class="container mt-4">

        <div class="d-flex justify-content-between mb-3">

            <h4>Sections</h4>

            <a href="{{ route('school_admin.sections.create') }}" class="btn btn-primary">
                Add Section
            </a>

        </div>


        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Class</th>

                    <th>Section</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

                @foreach ($sections as $section)
                    <tr>

                        <td>{{ $section->id }}</td>

                        <td>{{ $section->class->name }}</td>

                        <td>{{ $section->name }}</td>

                        <td>

                            {{-- <a href="{{ route('school_admin.sections.edit', $section->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <a href="{{ route('school_admin.sections.delete', $section->id) }}" class="btn btn-danger btn-sm">
                                Delete
                            </a> --}}

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

@endsection
