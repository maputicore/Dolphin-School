@extends('layouts.teacher')

@section('content')
{!! Form::open(['url' => 'lessons/create', 'method' => 'get']) !!}
    <button>Create new Lesson</button>
{!! Form::close() !!}
@endsection
