<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Chat</title>
	<meta name="generator" content="Bootply">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="/styles/bootstrap.min.css" rel="stylesheet">
	<link href="/styles/style.css" type="text/css" rel="stylesheet">

	@yield('extra_style')

</head>

<body cz-shortcut-listen="true" ng-controller='AppCtrl'>
	<i class="fa fa-spin fa-refresh fa-5x" id="loader" style="display: none;"></i>
	@include('layouts.navbar')
  @yield('content')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
	<script type="text/javascript " src="/scripts/angular.min.js "></script>
	<script type="text/javascript " src="/scripts/app.js "></script>
	<script src="/scripts/angular-avatar.js"></script>
</body>

</html>
