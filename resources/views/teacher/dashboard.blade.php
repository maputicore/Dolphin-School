@extends('layouts.teacher')

@section('content')

{!! Form::open(['url' => '/lesson/create', 'method' => 'get']) !!}
    <button>Create new Lesson</button>
{!! Form::close() !!}

<h1>Lesson List</h1>
@foreach($lessons as $lesson)
<h1><a href="{{ '/lesson/'.$lesson->id }}">{{ $lesson->name }}</a></h1>
@endforeach

@endsection
