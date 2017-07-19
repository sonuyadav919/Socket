<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Chat</title>
	<meta name="generator" content="Bootply">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="/styles/bootstrap.min.css" rel="stylesheet">
	<link href="/styles/style.css" type="text/css" rel="stylesheet">
</head>

<body cz-shortcut-listen="true" ng-controller='AppCtrl'>
	<i class="fa fa-spin fa-refresh fa-5x" id="loader" style="display: none;"></i>

  <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
          <div class="navbar-header">

              <!-- Collapsed Hamburger -->
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                  <span class="sr-only">Toggle Navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>

              <!-- Branding Image -->
              <a class="navbar-brand" href="{{ url('/') }}">
                  Laravel
              </a>
          </div>

          <div class="collapse navbar-collapse" id="app-navbar-collapse">
              <!-- Left Side Of Navbar -->
              <ul class="nav navbar-nav">
                  <li><a href="{{ url('/home') }}">Home</a></li>
              </ul>

              <!-- Right Side Of Navbar -->
              <ul class="nav navbar-nav navbar-right">
                  <!-- Authentication Links -->
                  @if (Auth::guest())
                      <li><a href="{{ url('/login') }}">Login</a></li>
                      <li><a href="{{ url('/register') }}">Register</a></li>
                  @else
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                              {{ Auth::user()->name }} <span class="caret"></span>
                          </a>

                          <ul class="dropdown-menu" role="menu">
                              <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                          </ul>
                      </li>
                  @endif
              </ul>
          </div>
      </div>
  </nav>


  @yield('content')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
	<script type="text/javascript " src="/scripts/angular.min.js "></script>
	<script type="text/javascript " src="/scripts/app.js "></script>
</body>

</html>
