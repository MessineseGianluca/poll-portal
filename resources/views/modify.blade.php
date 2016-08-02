@extends('layouts.app')
@section('content')
<div class="container">
  <h1><small>{{ $poll->title }}</small></h1>
  <div class="form-group">
    <label for="sel1">Select a poll:</label>
      <select class="form-control poll-select" id="sel1">
        <option></option>
        @foreach($poll->questions as $question)
          <option value="{{ $question->id }}">
            {{ $question->text }}
          </option>
        @endforeach
      </select>
    </label>
  </div>
  @foreach($poll->questions as $question)
    <div id="{{ $question->id }}" class="modify-question hidden">
      <h1><small> {{ $question->text }} </small></h1>
      @if($question->type != 'c')
        @foreach($question->options as $option)
          <p id="{{ $option->id}}">{{ $option->text }}</p>
        @endforeach
      @endif
    </div>
  @endforeach
</div>
@endsection
