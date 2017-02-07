@extends('layouts.teacher')

@section('content')
<div class="container">
    {!! Form::open(['url' => 'lesson']) !!}
    <div class="form-group">
    {!! Form::label('name', 'タイトル') !!}
    {!! Form::text('name', '', ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
    {!! Form::label('description', '説明') !!}
    {!! Form::textarea('description', '', ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
    {!! Form::label('joining_qualification', '参加条件') !!}
    {!! Form::text('joining_qualification', '', ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
    {!! Form::label('start_time', '始まり時間') !!}
    {!! Form::text('start_time', '', ['id' => 'date_picker1', 'class' => 'form-control']) !!}
    </div>
    <div class="form-group">
    {!! Form::label('finish_time', '終わり時間') !!}
    {!! Form::text('finish_time', '', ['id' => 'date_picker2', 'class' => 'form-control']) !!}
    </div>
    {!! Form::submit('Add', ['class' => 'btn btn-default']) !!}
    {!! Form::close() !!}
</div>
@endsection
