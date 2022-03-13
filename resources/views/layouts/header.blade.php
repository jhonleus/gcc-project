<!DOCTYPE html>
<html lang="en">
	<head>
		<title>@yield('title')</title>

		{{-- GCC icon --}}
		<link rel="shortcut icon" href="{{ asset('images/gcc icon-01.png') }}">
		
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- FOR JS -->
		<script src="{{ asset('resources/js/jquery.min.js') }}"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  		
		<!-- CUSTOM CSS -->
		<link rel="stylesheet" href="{{ asset('resources/css/custom/main.css') }}">
		<link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
  		
		<!-- FOR BOOTSTRAP -->
		<link rel="stylesheet" href="{{ asset('resources/css/bootstrap/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('resources/css/bootstrap/bootstrap.min.css') }}">
		<script src={{ asset('resources/js/bootstrap/bootstrap.js') }}></script>

		<!-- CSS FOR APPLICANT -->
		@if(Auth::check() && (Auth::user()->rolesId == 1 || Auth::user()->rolesId == 5))
			<link rel="stylesheet" href="{{ asset('resources/css/content-page/applicant.css') }}">
		@endif

		@if(Auth::check() && Auth::user()->rolesId != 1)
			<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber.css') }}">
		@endif
		<!-- CSS FOR CUSTOM MODAL -->
		<link rel="stylesheet" href="{{ asset('resources/css/custom/modal.css') }}">

		<!-- FOR ANIMATION -->
		<script src="{{ asset('resources/js/animation/aos.js') }}"></script>
		<link href="{{ asset('resources/css/animation/aos.css') }}" rel="stylesheet">

		<!-- FOR ICONS -->		
		<link href="{{ asset('resources/css/free.min.css') }}" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{ asset('resources/css/font-awesome.min.css') }}">
	</head>

	<style>
	.imgs-logo {
		height: 64px;
		width: 321px;
	}

	.dropdown-menu {
		min-width: 60px !important;
	}
	</style>
	
	<body>
		<!--navigationbar-->
		@if(Auth::check() && (Auth::user()->rolesId == 0))
			<script>window.location.href = "{{ url('/') }}";</script>
		@endif

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
						<img class="imgs-logo" src="/company_logo/{{ $company_logo->photo_name }}">
					</a>
				@else
					<a href="/">
						<img class="imgs-logo" src="/company_logo/{{ $company_logo->photo_name }}"> 
					</a>
				@endif
			</div>
			<div class="nav-wrapper">
				<ul class="nav justify-content-end">
					<li class="nav-item">
						<a href="/" id="home">
							{{ App\MaintenanceLocale::getLocale(63) }}
						</a>
					</li>

					@if (Auth::check())
						<li class="nav-item">
							<a href="{{ url(Auth::user()->roles->getPrefix()) }}">
								Dashboard
							</a>
						</li>
					@endif

					@if ($pagecontents->url)
					<li class="nav-item">
						<a href="/"  data-toggle="modal" data-target=".bd-example-modal-lg">
							{{ App\MaintenanceLocale::getLocale(64) }}
						</a>
					</li>
					@endif

					@if(Auth::check() && Auth::user()->rolesId != 1 && Auth::user()->rolesId != 5)
						<li class="nav-item">
							<a href="{{ url('pricing') }}">
								{{ App\MaintenanceLocale::getLocale(50) }}
							</a>
						</li>
					@endif

					@if(!Auth::check() || Auth::user()->rolesId == 1)
						<li class="nav-item">
							<a href="/jobs" id="search">
								{{ App\MaintenanceLocale::getLocale(65) }}
							</a>
						</li>
					@endif

					@if(!Auth::check() || Auth::user()->rolesId == 5)
						<li class="nav-item">
							<a href="/courses" id="courses">
								{{ App\MaintenanceLocale::getLocale(66) }}
							</a>
						</li>
					@endif

					@if(!Auth::check() || Auth::user()->rolesId == 1 || Auth::user()->rolesId == 5)
						<li class="nav-item">
							<a href="/companies" id="companies">
								{{ App\MaintenanceLocale::getLocale(67) }}
							</a>
						</li>
					@endif

					@if(Auth::check() && Auth::user()->rolesId != 1 && Auth::user()->rolesId != 4 && Auth::user()->rolesId != 5)
					<li class="nav-item">
						<a href="{{ url('subscriber/applicants') }}">
							{{ App\MaintenanceLocale::getLocale(315) }}
						</a>
					</li>
					@endif

					@if(Auth::check() && Auth::user()->rolesId == 2)
					<li class="nav-item">
						<a href="{{ url('employer/recruiters') }}">
							Search Recruiter
						</a>
					</li>
					@endif

					@if(Auth::check() && Auth::user()->rolesId == 3)
					<li class="nav-item">
						<a href="{{ url('organization/companies') }}">
							Search Company
						</a>
					</li>
					@endif

					@if(Auth::check() && Auth::user()->rolesId == 4)
						<li class="nav-item">
							<a href="{{ url('school/course/create') }}" id="postcourse">{{ App\MaintenanceLocale::getLocale(306) }}</a>
						</li>
					@endif

					@if(Auth::check() && (Auth::user()->rolesId == 2 || Auth::user()->rolesId == 3))
						<li class="nav-item">
							<a href="{{ url(Auth::user()->roles->getPrefix().'/jobs/create') }}" id="postjob">{{ App\MaintenanceLocale::getLocale(305) }}</a>
						</li>
					@endif

					@if(Auth::check() && Auth::user()->rolesId != 1 && Auth::user()->rolesId != 5)
						<li class="nav-item">
							<a href="{{ url(Auth::user()->roles->getPrefix().'/blogs/create') }}" id="newsandevents">{{ App\MaintenanceLocale::getLocale(287) }}</a>
						</li>
					@endif

					@if(Auth::check() && (Auth::user()->rolesId == 4))
						@if (App\SchoolDetail::where('subscriptionId', '2')->orWhere('subscriptionId', '3')->exists())
						<li class="nav-item">
							<a href="{{ url(Auth::user()->roles->getPrefix().'/blogs/create') }}" id="newsandevents">{{ App\MaintenanceLocale::getLocale(287) }}</a>
						</li>
						@endif
					@endif

					

					@if (Auth::check() && Auth::user())
						<li class="nav-item dropdown" style="position:relative; top:-8px">
							{{-- <a class="dropdown-toggle" id="btnaccount" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</a> --}}
							
							<a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: block;border-radius: 50%; height: 40px; width: 40px; background-color: #EF2226;color: white;">
    						<span style="font-size: 20px;margin-top: -3px;display: block;text-align:center;position:relative;left:-1px;">{!! Str::limit(Auth::user()->firstName, 1,'') !!}{{-- {!! Str::limit(Auth::user()->lastName, 1,'') !!} --}}</span>
  							</a>

							<div class="dropdown-menu pt-2 pb-1" style=" right: auto;  left: 150%; -webkit-transform: translate(-50%, 0);-o-transform: translate(-50%, 0);transform: translate(-50%, 0);">
								<div class="mb-2" style="display: block;margin: 0px auto;background-color: red;height: 80px;width: 80px;border-radius: 50%;  background-position:center center;background-repeat: no-repeat;background-size: cover;"><span style="font-size: 50px;margin-top: -3px;display: block;color: white; text-align: center;">{!! Str::limit(Auth::user()->firstName, 1,'') !!}{{-- {!! Str::limit(Auth::user()->lastName, 1,'') !!} --}}</span></div>
								
								@if(Auth::user()->rolesId == 1)
								<p class="text-center font-weight-bold" style="font-size: 16px;">{!! ucfirst(Auth::user()->firstName) !!} {!! ucfirst(Auth::user()->lastName) !!}</p>
								@else
								<p class="text-center font-weight-bold" style="font-size: 16px;">{!! ucfirst(Auth::user()->firstName) !!}</p>
								@endif
								<p class="text-center font-weight-light text-muted  pl-5 pr-5" style="font-size: 14px;">{{ Auth::user()->email }}</p>
								<div class="dropdown-divider"></div>
								<p class="text-center"><a class="dropdown-item" href="{{ url(Auth::user()->roles->getPrefix(). '/profile') }}">{{ App\MaintenanceLocale::getLocale(113) }}</a></p>
								
								<div class="dropdown-divider"></div>
								<p class="text-center"><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" id="logout">{{ App\MaintenanceLocale::getLocale(114) }}</a></p>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
								</form>
							</div>
						</li>
					@else
						<li class="nav-item">
							<a href="{{ route('login') }}" id="login">
								{{ App\MaintenanceLocale::getLocale(49) }}
							</a>
								
						</li>
					@endif
					<!-- ========================================= LANGUAGE ==================================================== -->
					@if ($check_locale)
						@if ($check_locale->token == csrf_token())
							@if ($check_locale->locale == 1)

							<li class="nav-item dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: white; border: none;">
								<img src="{{ asset('images/united-kingdom.svg')}}" width="20px;">
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style=" width: -90px; position: absolute;">
									<a href="{{ url('locale/2') }}" style="margin:0px auto; display: block;"><img src="{{ asset('images/japan.svg')}}" width="20px"  style="margin:0px auto; display: block;"></a>
								</div>
							</li>

							@else

							<li class="nav-item dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: white; border: none;">
								<img src="{{ asset('images/japan.svg')}}" width="20px;">
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style=" width: -90px; position: absolute;">
									<a href="{{ url('locale/1') }}" style="margin:0px auto; display: block;"><img src="{{ asset('images/united-kingdom.svg')}}" width="20px"  style="margin:0px auto; display: block;"></a>
								</div>
							</li>

							@endif

						@else

						<li class="nav-item dropdown">
							<button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: white; border: none;">
							<img src="{{ asset('images/united-kingdom.svg')}}" width="20px;">
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style=" width: -90px; position: absolute;">
								<a href="{{ url('locale/2') }}" style="margin:0px auto; display: block;"><img src="{{ asset('images/japan.svg')}}" width="20px"  style="margin:0px auto; display: block;"></a>
							</div>
						</li>

						@endif

						@else

						<li class="nav-item dropdown">
							<button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: white; border: none;">
							<img src="{{ asset('images/united-kingdom.svg')}}" width="20px;">
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style=" width: -90px; position: absolute;">
								<a href="{{ url('locale/2') }}" style="margin:0px auto; display: block;"><img src="{{ asset('images/japan.svg')}}" width="20px"  style="margin:0px auto; display: block;"></a>
							</div>
						</li>
					@endif
					<!-- ========================================= LANGUAGE ==================================================== -->
					
				</ul>
			</div>
		</nav>
		<!--end of navigationbar-->

		@if (Auth::check())
			@if (Auth::user()->roles->id == 1)
				@include('layouts.modal')
			@endif
		@else 
			@include('layouts.modal')
		@endif

		@yield('content')
		
		
			
		
		<footer class="page-footer">
			<div class="container">
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<h6>{{ App\MaintenanceLocale::getLocale(54) }}</h6>
						<ul class="page-footer-links">
							<li><a href="/about">{{ App\MaintenanceLocale::getLocale(51) }}</a></li>
							<li><a href="/blog">{{ App\MaintenanceLocale::getLocale(52) }}</a></li>
							<li><a href="/testimony">{{ App\MaintenanceLocale::getLocale(53) }}</a></li>
						</ul>
					</div>

					<div class="col-xs-6 col-md-3">
						<h6>{{ App\MaintenanceLocale::getLocale(55) }}</h6>
						<ul class="page-footer-links">
							<li><a href="/contact">{{ App\MaintenanceLocale::getLocale(58) }}</a></li>
							<li><a href="/feedback">{{ App\MaintenanceLocale::getLocale(59) }}</a></li>
						</ul>
					</div>

					<div class="col-xs-6 col-md-3">
						<h6>{{ App\MaintenanceLocale::getLocale(56) }}</h6>
						<ul class="page-footer-links">
							<li><a href="/terms">{{ App\MaintenanceLocale::getLocale(60) }}</a></li>
							<li><a href="/privacy">{{ App\MaintenanceLocale::getLocale(61) }}</a></li>
							@if ($nda) <li><a href="/nda/download">{{ App\MaintenanceLocale::getLocale(164) }}</a></li> @endif
						</ul>
					</div>

					<div class="col-xs-6 col-md-3">
						<h6>{{ App\MaintenanceLocale::getLocale(57) }}</h6>
						<ul class="page-footer-links">
							<li><a href="{{ url('pricing') }}">{{ App\MaintenanceLocale::getLocale(50) }}</a></li>
							<li><a href="/faqs">{{ App\MaintenanceLocale::getLocale(62) }}</a></li>
						</ul>
					</div>
				</div>
				<hr>
			</div>
			{{-- <div class="container"> --}}
				<p class="page-footer-text">
					{{ App\MaintenanceLocale::getLocale(116) }} | Global Careers Creation | © 2019-2022
				</p>
			</div>
		</footer>

	</body>

	<script>

		AOS.init({
			 disable: 'mobile', //when in mobile platform the animation will turn off
			 once: true //running the scrolling animation once
		});

		$(".select").change(function() {
			if(!$(this).hasClass("select-selected")) {
				$(this).addClass('select-selected');
			}
		})
	</script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	@include('sweetalert::alert')
</html>
