<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Poll-Portal</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <style>
      
      body {
        margin: 0;
      }

      .container {
        padding: 0;
        margin: 0;
      }
      
      .masthead {  
        width: 100vw;
        height: 100vh;
        background-color: #ebebe0      
      }

      .masthead span {
        position: absolute;
        top: 40%;
        left: 50%; 
        transform: translate(-50%, -50%);
        text-align: center;
      }
      
      .masthead span h1 {
        font-size: 4em;
        letter-spacing: 2px; 
      }

      .masthead span button {
        background-color: white;
        font-size: 2em;
        margin-top: 50px;
      }

    </style>
</head>
<body>
    
    @yield('content')
    
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>