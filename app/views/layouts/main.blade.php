<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Course Management System</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"/>
    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="{{ asset('assets/js/ie8-responsive-file-warning.js') }}"></script><![endif]-->
    <script src="{{ asset('assets/js/ie-emulation-modes-warning.js') }}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Course Management System [  {{ Auth::user()->role->name }} : {{ Auth::user()->getName() }} ]</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            
            <li {{ $active_nav=='course'?'class="active"':null; }} ><a href="{{ url('course') }}">Course</a></li>
            @if( Auth::user()->role->name == 'Admin' )
            <li {{ $active_nav=='membership'?'class="active"':null; }}><a href="{{ url('membership') }}">Membership</a></li>
            @endif
            <li {{ $active_nav=='profile'?'class="active"':null; }}><a href="{{ url('membership/profile/'.Auth::user()->id) }}">Profile</a></li>
            <li><a href="{{ url('logout') }}">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>

            <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
        @endif
      <div class="row">
        {{ $content }}
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <!-- <script src="{{ asset('assets/js/vendor/holder.js') }}"></script> -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>
    @yield('script')
  </body>
</html>
