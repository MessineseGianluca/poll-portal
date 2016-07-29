@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Opened polls</div>
                @foreach ($opened_polls as $poll)
                    <div class="panel-body">
                      <a href="/home/opened/{{ $poll->id }}">{{ $poll->title }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Closed polls</div>
                @foreach ($closed_polls as $poll)
                    <div class="panel-body">
                      <a href="/home/closed/{{ $poll->id }}">{{ $poll->title }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Incoming polls</div>
                @foreach ($incoming_polls as $poll)
                    <div class="panel-body">
                        {{ $poll->title }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row answered">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Answered polls</div>
                @foreach ($answered_polls as $poll)
                    <div class="panel-body">
                        {{ $poll }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
