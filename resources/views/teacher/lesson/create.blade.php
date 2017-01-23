@extends('layouts.teacher')

@section('content')
<div class="container">
    {!! Form::open(['url' => 'lessons']) !!}
    {!! Form::label('name', 'タイトル') !!}
    {!! Form::text('name') !!}
    {!! Form::label('description', '説明') !!}
    {!! Form::text('description') !!}
    {!! Form::label('start_time', '始まり時間') !!}
    {!! Form::text('start_time', '', ['id' => 'date_picker1']) !!}
    {!! Form::label('finish_time', '終わり時間') !!}
    {!! Form::text('finish_time', '', ['id' => 'date_picker2']) !!}
    {!! Form::submit('Add') !!}
    {!! Form::close() !!}
</div>
@endsection
