@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row poll-title">
    <div class="col-lg-10 col-lg-offset-1">
      <h1><small> {{ $poll->title }}</small></h1>
    </div>
  </div>
  <div class="questions">
    <form action='/home/opened/{{ $poll->id }}' method='post'>

      {{ csrf_field() }}

      @foreach ($questions as $question)
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
              <h2><small> · {{ $question->text }}</small></h2>

              <div class="row">
                <div class="col-lg-8 col-lg-offset-1">
                @if($question->type !== 'a')

                    @if( $question->type == 'b' )

            	    	@foreach($question->options as $option)

                      <div class="radio">
  						          <label>
                	    	  <input type="radio"
                	    	         name="answered_ques_{{ $question->id }}"
                	    	         value="{{ $option->id }}" required>
                                 {{ $option->text }}
  							        </label>
  						        </div>

                    	@endforeach

                    @else

                        @foreach($question->options as $option)

                            <div class="checkbox">
    						              <label>
                	    	        <input type='checkbox'
                	    	               name='answered_ques_{{ $question->id }}[]'
                	    	               value='{{ $option->id }}'
                                       required>{{ $option->text }}
                              </label>
                            </div>

                    	@endforeach

                    @endif

            	@else
            	  <textarea class="form-control"
            	            rows="2"
                          maxlength="255"
                          name="answered_ques_{{ $question->id }}"
            	            placeholder="insert answer here(max 255)..."
            	            required></textarea>
            	@endif

            	</div>
              </div>
            </div>
        </div>

      @endforeach
      <div class="row confirm">
        <div class="col-lg-6 col-lg-offset-5">
          <button type="button"
                  class="btn btn-default">Confirm</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
