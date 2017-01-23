@extends('layouts.teacher')

@section('content')
@foreach ($students as $student)
    <p>email : {{ $student->email }}</p>
    <p>name : {{ $student->name }}</p>

@endforeach
@endsection
