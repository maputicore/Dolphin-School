@extends('layouts.teacher')

@section('content')
{!! Form::open(['url' => 'lessons']) !!}
{!! Form::label('name', 'タイトル') !!}
{!! Form::text('name') !!}
{!! Form::label('description', '説明') !!}
{!! Form::text('description') !!}
{!! Form::label('start_time', '始まり時間') !!}
{!! Form::datetime('start_time', '', ['id' => 'datetimepicker']) !!}
{!! Form::label('finish_time', '終わり時間') !!}
{!! Form::datetime('finish_time', '', ['id' => 'datetimepicker']) !!}
{!! Form::submit('Add') !!}
{!! Form::close() !!}
@endsection
