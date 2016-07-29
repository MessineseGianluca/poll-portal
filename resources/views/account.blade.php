@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
		  <h1>
		    <small>
		      {{ Auth::user()->surname }} {{ Auth::user()->name }}'s Account
		    </small>
		  </h1> 
		</div>
	</div>
	<div class="row">
	  <div class="col-lg-6">
	  	<h2><small>Change your email</small></h2>
	    @if (count($errors) > 0)
    		<div class="alert alert-danger">
        	<ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        	</ul>
    		</div>
			@endif
	  	<form action="{{ url('/account/email') }}" method="post">
	  	  
	  	  {{ csrf_field() }}

	  	  <!-- form method spoofing -->
	  	  {{ method_field('PUT') }}

			  <div class="input-group input-group-lg">
  				<span class="input-group-addon" id="sizing-addon1">
  					<span class="glyphicon glyphicon-envelope" aria-hidden="true">
  					</span>
  				</span>
  				<input type="text"
  				       name="old_email" 
  				       class="form-control" 
  				       placeholder="Your old email..." 
  				       aria-describedby="sizing-addon1">
				</div>
				<div class="input-group input-group-lg">
  				<span class="input-group-addon" id="sizing-addon1">
  					<span class="glyphicon glyphicon-envelope" aria-hidden="true">
  					</span>
  				</span>
 					<input type="text"
 					       name="new_email" 
 					       class="form-control" 
 					       placeholder="Your new email..." 
 					       aria-describedby="sizing-addon1">
				</div>
				<button type="submit" class="btn btn-lg btn-default">
					<span class="glyphicon glyphicon-send" aria-hidden="true"> </span>
				  Submit
				</button>
      </form>
	  </div>
	  <div class="col-lg-6">
	    <h2><small>Change your password</small></h2>
	    @if (count($errors) > 0)
    		<div class="alert alert-danger">
        	<ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        	</ul>
    		</div>
			@endif
	  	<form action="{{ url('/account/password') }}" method="post">
	  	  
	  	  {{ csrf_field() }}

	  	  <!-- form method spoofing -->
	  	  {{ method_field('PUT') }}

				<div class="input-group input-group-lg">
  				<span class="input-group-addon" id="sizing-addon1">
  					<span class="glyphicon glyphicon-lock" aria-hidden="true">
  					</span>
  				</span>
 					<input type="password"
 					       name="old_password" 
 					       class="form-control" 
 					       placeholder="Your old password..." 
 					       aria-describedby="sizing-addon1">
				</div>
				<div class="input-group input-group-lg">
  				<span class="input-group-addon" id="sizing-addon1">
  					<span class="glyphicon glyphicon-lock" aria-hidden="true">
  					</span>
  				</span>
 					<input type="password" 
 					 			 name="new_password"
 					       class="form-control" 
 					       placeholder="Your new password..." 
 					       aria-describedby="sizing-addon1">
				</div>
				<div class="input-group input-group-lg">
  				<span class="input-group-addon" id="sizing-addon1">
  					<span class="glyphicon glyphicon-lock" aria-hidden="true">
  					</span>
  				</span>
 					<input type="password"
 								 name="new_password_confirm" 
 					       class="form-control" 
 					       placeholder="Your new password again..." 
 					       aria-describedby="sizing-addon1">
				</div>
        <button type="submit" class="btn btn-lg btn-default">
  				<span class="glyphicon glyphicon-send" aria-hidden="true"> </span>
        	Submit
        </button>
      </form>	    
	  </div>
	</div>
</div>
@endsection