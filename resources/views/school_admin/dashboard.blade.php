@extends('school_admin.layouts.app')
@section('content')
    <h1>School Admin Dashboard</h1>

    <p>School Name: {{ $school->name }}</p>

    <p>Welcome, {{ auth()->user()->name }}</p>
@endsection
