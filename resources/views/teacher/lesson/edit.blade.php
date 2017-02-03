@extends('layouts.teacher')

@section('content')

<div class="container">
    {!! Form::open(['url' => 'lesson/'.$lesson->id.'/update']) !!}
    {!! Form::label('name', 'タイトル') !!}
    {!! Form::text('name', $lesson->name) !!}
    {!! Form::label('description', '説明') !!}
    {!! Form::text('description', $lesson->description) !!}
    {!! Form::label('joining_qualification', '参加条件') !!}
    {!! Form::text('joining_qualification', $lesson->joining_qualification) !!}
    {!! Form::label('start_time', '始まり時間') !!}
    {!! Form::text('start_time', $lesson->start_time, ['id' => 'date_picker1']) !!}
    {!! Form::label('finish_time', '終わり時間') !!}
    {!! Form::text('finish_time', $lesson->finish_time, ['id' => 'date_picker2']) !!}
    {!! Form::submit('Update') !!}
    {!! Form::close() !!}
</div>

@endsection
