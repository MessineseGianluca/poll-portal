@extends('layouts.app')
@section('content')
<div class="container">
  <form class="form-add" action="/admin/poll/new" method="post">
    {{ csrf_field() }}
    <div class="form-group">
      <label class="label-add" for="add-text">Insert Poll Name:</label>
      <input type="text"
             name="title"
             class="form-control"
             placeholder="Insert here..."
             maxlength="255"
             id="add-text"
             required>
      <span class="poll-date">
        <label for="poll-start-date">Insert start date:</label>
        <input type="date" id="poll-start-date" name="start_date"
               class="form-control" required>
        <label class="" for="poll-end-date">Insert end date:</label>
        <input type="date" id="poll-end-date" name="end_date"
               class="form-control" required>
      </span>
    </div>
    <button type="button" class="confirm-add-poll btn btn-success">
      Confirm
      <span class="glyphicon glyphicon-plus" aria-hidden="true"> </span>
    </button>
    <input type="submit" id="submit-poll" class="hidden">
  </form>
</div>
@endsection
