@extends('layouts.teacher')

@section('content')

<div class="container">
    {!! Form::open(['url' => '/lesson/create', 'method' => 'get']) !!}
        <button>Create new Lesson</button>
    {!! Form::close() !!}

    <h1>Lesson List</h1>
    @foreach($lessons as $lesson)
    <div id="lessons" class="row list-group">
        <div class="item  col-xs-4 col-lg-4 grid-group-item list-group-item">
            <div class="thumbnail">
                <img class="group list-group-image" src="http://placehold.it/400x250/000/fff" alt="" />
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        <a class="" href="{{ '/lesson/'.$lesson->id }}">{{ $lesson->name }}</a>
                    </h4>
                    <p class="group inner list-group-item-text">
                        日時 : {{ date("Y年 m月 d日 H時 i分", strtotime($lesson->start_time)) }} to {{ date("H時 i分", strtotime($lesson->finish_time)) }}
                    </p>
                    <p class="group inner list-group-item-text">
                        内容 : {{ $lesson->description }}
                    </p>
                    <p class="group inner list-group-item-text">
                        参加条件 : {{ $lesson->joining_qualification }}
                    </p>
                    <a class="btn btn-success" href="{{ '/lesson/'.$lesson->id }}">Go</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
