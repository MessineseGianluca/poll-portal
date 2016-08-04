@extends('layouts.app')
@section('content')
<div class="container">
  <div class="poll centered-text" id="{{ $poll->id }}">
    <h1 class="inline"><small>{{ $poll->title }}</small></h1>
    <button class="invisible-btn edit">
      <span class="glyphicon glyphicon-pencil gly-top"
            aria-hidden="true"></span>
    </button>
    <button class="invisible-btn add">
      <span class="glyphicon glyphicon-plus gly-top"
            aria-hidden="true"></span>
    </button>
  </div>
  <div class="form-group">
    <label for="sel1">Select a question:</label>
      <select class="form-control poll-select" id="sel1">
        @foreach($poll->questions as $question)
          <option value="{{ $question->id }}">
            {{ $question->text }}
          </option>
        @endforeach
      </select>
    </label>
  </div>
  @foreach($poll->questions as $question)
    <div id="{{ $question->id }}" class="modify-question question hidden">
      <h1 class="inline"><small> {{ $question->text }} </small></h1>
      <button class="invisible-btn edit">
        <span class="glyphicon glyphicon-pencil gly-top"
              aria-hidden="true"></span>
      </button>
      <button class="invisible-btn add">
        <span class="glyphicon glyphicon-plus gly-top"
              aria-hidden="true"></span>
      </button>
      <button class="invisible-btn trash">
        <span class="glyphicon glyphicon-trash gly-top"
              aria-hidden="true"></span>
      </button>
      @if($question->type != 'c')
        @foreach($question->options as $option)
        <div class="row">
          <div id="{{ $option->id}}" class="col-lg-12 option">
            <p class="option-margin inline">{{ $option->text }}</p>
            <button class="invisible-btn edit">
              <span class="glyphicon glyphicon-pencil"
                    aria-hidden="true"></span>
            </button>
            <button class="invisible-btn trash">
              <span class="glyphicon glyphicon-trash"
                    aria-hidden="true"></span>
            </button>
          </div>
        </div>
        @endforeach
      @endif
    </div>
  @endforeach
  <form class="form-delete" action="" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="DELETE" class="spoofing">
    <input type="submit" class="hidden submit-delete-btn" >
  </form>

  <form class="form-edit hidden" action="" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" class="spoofing">
    <div class="form-group">
      <label class="label-edit" for="edit-text">Some Text:</label>
      <input type="text" name="title" class="form-control" id="edit-text">
    </div>
    <button type="button" class="btn btn-danger cancel-edit pull-right">
      Cancel
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
    </button>
    <button type="submit" class="submit-edit-btn btn btn-default" >
      Confirm
    </button>
  </form>
</div>
@endsection
