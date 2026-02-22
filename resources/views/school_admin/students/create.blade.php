@extends('school_admin.layouts.app')
@section('content')
    <h2>Add Student</h2>

    <form method="POST" action="{{route('school_admin.students.store')}}">

        @csrf

        <input name="admission_no" placeholder="Admission No" required>
        <br><br>

        <input name="name" placeholder="Name" required>
        <br><br>

        <input name="email" placeholder="Email">
        <br><br>

        <input name="phone" placeholder="Phone">
        <br><br>

        <input name="class" placeholder="Class">
        <br><br>

        <input name="section" placeholder="Section">
        <br><br>

        <input type="date" name="admission_date">
        <br><br>

        <button type="submit">Save</button>

    </form>
@endsection
