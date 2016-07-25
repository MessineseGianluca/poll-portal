@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row poll-title">
        <div class="col-lg-10 col-lg-offset-1">
            <h1><small> {{ $poll->title }}</small></h1>
        </div>
    </div>
    <div class="questions">
      {{ csrf_field() }}

      @foreach ($questions as $question)
        <div class="row question">
            <div class="col-lg-7 col-lg-offset-3">
              <h2><small> · {{ $question->text }}</small></h2>
                
              <div class="row">
                <div class="col-lg-8 col-lg-offset-1 opened-answers">
                  
                  @if($question->type == 'a') 

                      {{--*/ $i = 0 /*--}}
                   
                      @foreach($question->options as $option)
                          
                        @if($i < 5)
                         
                          <div class="row">

                          
                        @else

                          <div class="row hidden">

                        @endif  
                          	  
                          <div class="col-lg-12">
                            {{ $option->content }}
                          </div>
                        </div> 

                        {{--*/ $i++ /*--}}

                      @endforeach

                      @if(count($question->options) > 5)

                        <div class="row see-more">
                          <button> 
                            <strong>See more answers</strong>           
                            <span class="glyphicon glyphicon-triangle-bottom" 
                                  aria-hidden="true"></span>
                          </button>
                        </div>

                      @endif

                  @else 
            	    	
            	    @foreach($question->options as $option)
                      
                      @if( $option->percentual )   
                        <div class="row">
                          <div class="col-lg-6">
                            {{ $option->text }}
                          </div>
                          <div class="col-lg-6">
      	                  	<div class="progress">
  					       	  <div class="progress-bar progress-bar-striped active" 
  							       role="progressbar"
  								   aria-valuenow="{{ $option->percentual }}" 
  								   aria-valuemin="0" 
  								   aria-valuemax="100" 
  								   style="width:{{ $option->percentual }}%">
                                {{ $option->percentual }}%
  							  </div>
						    </div>
						  </div>
						</div> 

					  @else
					    
					    <div class="row none">
					      <div class="col-lg-6">
                            {{ $option->text }}
                          </div>
                          <div class="col-lg-6">
                            <span>none.</span>
                          </div>
                        </div>
                      
                      @endif
                    
                    @endforeach
                  
            	  @endif

            	</div>
              </div>
            </div>
        </div>

      @endforeach

  </div>
</div>
@endsection
