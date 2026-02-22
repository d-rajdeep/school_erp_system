@extends('school_admin.layouts.app')
@section('content')
<h2>Students</h2>

<a href="{{route('school_admin.students.create')}}">Add Student</a>

<table border="1">

    <tr>
        <th>Admission No</th>
        <th>Name</th>
        <th>Class</th>
        <th>Section</th>
    </tr>

    @foreach ($students as $student)
        <tr>

            <td>{{ $student->admission_no }}</td>

            <td>{{ $student->name }}</td>

            <td>{{ $student->class }}</td>

            <td>{{ $student->section }}</td>

        </tr>
    @endforeach

</table>
@endsection
