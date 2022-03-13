<!DOCTYPE html>
<html lang="en">
	<head>
		<title>@yield('title')</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

		<!-- FOR ANIMATION -->
		<script src="{{ asset('js/aos.js') }}"></script>
		<link href="{{ asset('css/aos.css') }}" rel="stylesheet">

		<!-- CUSTOM CSS -->
		<link rel="stylesheet" href="{{ asset('css/main2.css') }}">
		<link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
		<link href="{{ asset('css/back.css') }}" rel="stylesheet">
		<link href="{{ asset('css/progressbar.css') }}" rel="stylesheet">

		<!--CKEDITOR-->
    	<script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('js/jquery.expandable.js') }}"></script>
		<link href="{{ asset('css/jquery.expandable.css') }}" rel="stylesheet">



		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/a076d05399.js"></script>

	</head>
	
	<body>
		<!--navigationbar-->
		<nav>
			<input type="checkbox" id="nav" class="hidden">
			<label for="nav" class="nav-btn">
			<i></i>
			<i></i>
			<i></i>
			</label>
			<div class="logo">
				@if (Auth::check())
					<a href="{{ url(Auth::user()->roles->getPrefix()) }}">
						<img src="/images/{{ $company_logo->photo_name }}"> \
					</a>
				@else
					<a href="/">
						<img src="/images/{{ $company_logo->photo_name }}"> 
					</a>
				@endif
			</div>
			<div class="nav-wrapper">
				<ul class="nav justify-content-end">
					<li class="nav-item">
						<a href="/">HOME</a>
					</li>

					@if (Auth::check())
						<li class="nav-item">
							<a href="{{ url(Auth::user()->roles->getPrefix()) }}">DASHBOARD</a>
						</li>
					@endif

					@if(!Auth::check() || Auth::user()->rolesId == 1)
						<li class="nav-item">
							<a href="/"  data-toggle="modal" data-target=".bd-example-modal-lg">How It Works?</a>
						</li>

						<li class="nav-item">
							<a href="/faqs">FAQ</a>
						</li>

						<li class="nav-item">
						  	<a href="/jobs">Search Jobs</a>
						</li>

						<li class="nav-item">
							<a href="/companies">Companies</a>
						</li>
					@endif

					@if(Auth::check() && (Auth::user()->rolesId == 2 || Auth::user()->rolesId == 3))
						<li class="nav-item">
							<a href="{{ url('employer/jobs/create') }}">Post Job</a>
						</li>

						<li class="nav-item">
							<a href="{{ url('employer/timeline') }}">News and Events</a>
						</li>
					@endif

					@if(Auth::check() && Auth::user()->rolesId == 4)
						<li class="nav-item">
							<a href="{{ url('school/course/create') }}">Post Course</a>
						</li>
					@endif

					@if (Auth::check() && Auth::user())
						<li class="nav-item dropdown">
							<a class="dropdown-toggle" id="btnaccount" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</a>

							<div class="dropdown-menu">
								<a class="dropdown-item" href="{{ url(Auth::user()->roles->getPrefix(). '/profile') }}">My Profile</a>
								
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
								</form>
							</div>
						</li>
					@else
						<li class="nav-item">
							<a href="{{ route('login') }}">LOGIN</a>
						</li>
					@endif
				</ul>
			</div>
		</nav>
		<!--end of navigationbar-->

		<!--content-->
		@yield('content')
		<!--end of content-->

		<!--footer-->
		<footer>
			<p><a href="pricing">Pricing</a> | <a href="/about">About Us</a> | <a href="/testimony">Testimonials</a> | <a href="/contact">Contact Support</a> | <a href="/terms">Terms of Use</a> | <a href="/privacy">Privacy Policy</a> |  <a href="/help">Help</a></p>
			<p>All Right Reserved | Global Careers Creation | &copy; 2019-2022</p>
		</footer>
		<!--end offooter-->

		<div class="modal" tabindex="-1" role="dialog" id="exampleModal">
			<div class="modal-dialog modal-sm modal-for-actions" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="status-box confirmation-label">
							<i class="material-icons">
								<img src="" class="img-size-9">
							</i>
						</div>				
						<h4 class="modal-title label-page-title">Warning</h4>
					</div>
					<div class="modal-body">
						<p class="text-center warning-text">Are you sure you want to cancel?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button class="btns btns-red btns-med-size-1 close-modal-warning-button">Ok</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-lg">
			    <div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">HOW IT WORKS </h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

			        <div class="card">
			          	<div class="card-body">
			             	<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
								<div class="carousel-inner">
									<div class="carousel-item active">
										<img class="d-block" src="{{ asset('images/registermodal1-01.svg')}}" alt="First slide" style="width: 400px; margin: 0px auto;">

										<p class="text-center mt-5 step-titles">First register in our page</p>
										<p class="font-weight-light text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
										consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
										cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
										proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
									</div>
									<div class="carousel-item">
										<img class="d-block" src="{{ asset('images/registermodal2-01.svg')}}" alt="Second slide"  style="width: 400px; margin: 0px auto;">
										<p class="text-center mt-5 step-titles">Second find jobs</p>
										<p class="font-weight-light text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
										consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
										cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
										proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
									</div>
									<div class="carousel-item">
										<img class="d-block" src="{{ asset('images/fogg-payment-processed-1.png')}}" alt="Third slide" style="width: 400px; margin: 0px auto;">
										<p class="text-center mt-5 step-titles">Get hired</p>
										<p class="font-weight-light text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
										consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
										cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
										proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
									</div>
								</div>
								<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
									<div class="prevbtn">
										<span class="fa fa-angle-left" aria-hidden="true"></span>
									</div>
									<span class="sr-only">Previous</span>
								</a>
							</div>
						</div>
					</div>
					<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
						<div class="prevbtn">
							<span class="fa fa-angle-right" aria-hidden="true"></span>
						</div>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
	</body>
	<script>
		AOS.init({
			 disable: 'mobile'
			 once: 'true'
		});
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	@include('sweetalert::alert')
</html>
