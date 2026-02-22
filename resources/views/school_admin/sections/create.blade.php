@extends('school_admin.layouts.app')

@section('title', 'Create Section')

@section('content')

    <div class="container mt-4">

        <div class="card">

            <div class="card-header">
                Create Section
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('school_admin.sections.store') }}">

                    @csrf


                    <div class="mb-3">

                        <label>Class</label>

                        <select name="class_id" class="form-control" required>

                            <option value="">Select Class</option>

                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="mb-3">

                        <label>Section Name</label>

                        <input type="text" name="name" class="form-control" placeholder="A, B, C" required>

                    </div>


                    <button class="btn btn-success">
                        Save
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection
