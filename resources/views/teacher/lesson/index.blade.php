@extends('layouts.teacher')

@section('content')
{!! Form::open(['url' => 'lessons/create', 'method' => 'get']) !!}
    <button>Create new Lesson</button>
{!! Form::close() !!}

@foreach($lessons as $lesson)
<h1>{{ $lesson->name }}</h1>
<h1>{{ $lesson->start_time }}</h1>
<h1>{{ $lesson->finish_time }}</h1>
@endforeach
@endsection
