@extends('school_admin.layouts.app')

@section('title', 'Create Class')

@section('content')

    <div class="container mt-4">

        <div class="card">

            <div class="card-header">
                Create Class
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('school_admin.classes.store') }}">

                    @csrf

                    <div class="mb-3">

                        <label>Class Name</label>

                        <input type="text" name="name" class="form-control" required>

                    </div>


                    <button class="btn btn-success">
                        Save
                    </button>

                    <a href="{{ route('school_admin.classes.index') }}" class="btn btn-secondary">
                        Back
                    </a>

                </form>

            </div>

        </div>

    </div>

@endsection
