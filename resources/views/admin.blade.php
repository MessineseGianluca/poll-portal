@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="centered-text"><small> Welcome to your admin area </small></h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <h2 class="centered-text"><small> Modify a poll </small></h1>
      <form action="" method="post" class="modify-form">
        <div class="form-group">
          <label for="sel1">Select a poll:</label>
            <select class="form-control modify-select" id="sel1">
              @foreach($polls as $poll)
                <option value="{{ $poll->id }}"> {{ $poll->title }} </option>
              @endforeach
            </select>
            <button class="btn btn-default modify-button" type="button">
              Modify
              <span class="glyphicon glyphicon-pencil" aria-hidden="true">
              </span>
            </button>
            <button class="btn btn-danger delete-button pull-right"
                    type="button">
              Delete
              <span class="glyphicon glyphicon-trash" aria-hidden="true">
              </span>
            </button>
          </label>
        </div>
      </form>
    </div>
    <div class="col-lg-6 centered-text">
      <h2 class="centered-text"><small> Or create a new one</small></h1>
      <button class="btn btn-default btn-lg create-poll">Create</button>
    </div>
  </div>
</div>
@endsection
