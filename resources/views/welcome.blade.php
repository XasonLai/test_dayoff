<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

	<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
	<link rel="stylesheet" type="text/css" href="/css/main.css"/ >
	<link rel="stylesheet" type="text/css" href="/css/style.css"/ >
	<link rel="stylesheet" type="text/css" href="/css/animate.css"/ >
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	@yield('welcome_css')
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Laravel</a>
			</div>

			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					@if(auth()->guest())	
						<li><a href="{{ url('/') }}">welcome</a></li>
					@else
						<li><a href="{{ url('/staffs/provision') }}">請假規定</a></li>
						<li><a href="{{ url('/staffs/user') }}">個人資訊</a></li>
						<li><a href="{{ url('/staffs/personal') }}">休假一欄表</a></li>
						<li><a href="{{ url('/staffs/create') }}">請假</a></li>
						<li><a href="{{ url('/staffs/compensatory/create') }}">加班</a></li>
						<li><a href="{{ url('/staffs/test') }}">瓜瓜惡搞</a></li>
					@endif

					@yield('a_herf')
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if(auth()->guest())
						@if(!Request::is('auth/login'))
							<li><a href="{{ url('/auth/login') }}">Login</a></li>
						@endif
						@if(!Request::is('auth/register'))
							<li><a href="{{ url('/auth/register') }}">Register</a></li>
						@endif
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="/js/jquery.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	
  	<script src="/js/build/jquery.datetimepicker.full.js"></script>
	<script src="/js/build/jquery.datetimepicker.full.min.js"></script>

  	
	@yield('welcome_js')
</body>
</html>
