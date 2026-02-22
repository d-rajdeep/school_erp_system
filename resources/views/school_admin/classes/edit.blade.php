@extends('school_admin.layouts.app')

@section('title', 'Edit Class')

@section('content')

    <div class="container mt-4">

        <div class="card">

            <div class="card-header">
                Edit Class
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('school_admin.classes.update', $class->id) }}">

                    @csrf

                    <div class="mb-3">

                        <label>Class Name</label>

                        <input type="text" name="name" value="{{ $class->name }}" class="form-control" required>

                    </div>


                    <button class="btn btn-success">
                        Update
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection
