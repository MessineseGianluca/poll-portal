@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <h1> {{ $poll->title }} </h1>
        </div>
    </div>
    <form action='/home/opened/{{ $poll->id }}' method='post'>
    @foreach ($questions as $question)
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 questions">
                <h2> {{ $question->text }}</h2>
                @if($question->type !== 'a')  
                    @if( $question->type == 'b' )
      	    	
            	    	@foreach($question->options as $option)
                            
                	    	<br>         
                	    	<input type="radio" 
                	    	       name="answer_ques_{{ $question->id }}"
                	    	       value="{{ $option->id }}">{{ $option->text }}
  							    
                    	@endforeach
                        
                    @else 

                        @foreach($question->options as $option)
                            
                            <br>
                	    	<input type='checkbox' 
                	    	       name='answer_ques_{{ $question->id }}[]' 
                	    	       value='{{ $option->id }}'>{{ $option->text }}
                    
                    	@endforeach

                    @endif

            	@else
            	  <textarea> insert answer here... </textarea>
            	@endif
            </div>
        </div>
    @endforeach
    </form>
</div>
@endsection
