@extends('layouts.student')

@section('content')
<h1>Lesson List</h1>
@foreach($lessons as $lesson)
<h1><a href="{{ '/lesson/'.$lesson->id }}">{{ $lesson->name }}</a></h1>
@endforeach

@endsection
