@extends('layouts.app')

@section('content')
    <div class="container">
        @include('flash::message')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->title }}
                        @foreach($question->topics as $topic)
                            <a href="/topic/{{ $topic->id }}" class="topic">{{ $topic->name }}</a>
                        @endforeach
                    </div>

                    <div class="panel-body">
                        {!! $question->body !!}
                    </div>

                    <div class="panel-footer">
                        @if(Auth::user() && Auth::user()->owns($question))
                            <span class="edit">
                                <a class="btn btn-info btn-sm " href="/questions/{{ $question->id }}/edit">编辑</a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
