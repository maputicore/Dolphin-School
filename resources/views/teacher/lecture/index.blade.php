@extends('layouts.teacher')

@section('content')
{!! Form::open(['url' => 'lectures/create', 'method' => 'get']) !!}
    <button>Create new Lecture</button>
{!! Form::close() !!}
@endsection
