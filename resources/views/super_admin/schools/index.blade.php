@extends('super_admin.layouts.app')
@section('content')
    <h2>Schools</h2>

    <a href="/schools/create">Add School</a>

    @foreach ($schools as $school)
        <p>{{ $school->name }}</p>
    @endforeach
@endsection
