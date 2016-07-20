@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        @foreach ($questions as $question)
            
            @foreach($question->options as $option)
            
                <br>{{ $option->text }}
            
            @endforeach

        @endforeach

    <div>
</div>
@endsection
