@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(58))

@section('content')

{{-- contact-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/contact-page.css') }}">

<div class="container-fluid px-0" style="overflow: hidden;">
	<br>
	<br>
	<br>
	<div class="row contact-page-row" style="height: 100vh;">
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-5">
			<h1 style="margin-top: 5%;">{{ App\MaintenanceLocale::getLocale(122) }}</h1>
			<p class="text-muted" style="color: #D4D4D4!important">{{ App\MaintenanceLocale::getLocale(123) }}</p>
			<br>
			@include('flash-message')
			<form method="POST" action="{{ route('contact.store')}}">
				@csrf
				<input type="text" placeholder="{{ App\MaintenanceLocale::getLocale(124) }}" class="form-control" name="name" ><br>
				<div class="row">
					<div class="col-lg-6 col-sm-12">
						<input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "11" placeholder="{{ App\MaintenanceLocale::getLocale(125) }}" class="form-control" name="phoneNumber"><br>
					</div>
					<div class="col-lg-6 col-sm-12">
						<input type="email" placeholder="{{ App\MaintenanceLocale::getLocale(126) }}" class="form-control" name="email"><br>
					</div>
				</div>
			
				<textarea placeholder="{{ App\MaintenanceLocale::getLocale(127) }}" class="form-control" rows="4" name="message"></textarea>
				<br>
				<button type="submit" name="sendbtn" class="btn btn-primary col-lg-2 col-md-2 col-sm-12">
					<i class="fa fa-send"> {{ App\MaintenanceLocale::getLocale(128) }}</i>
				</button>
			</form>
		</div>
		<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 mx-auto" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(/contacts/{{ $pagecontents->contact }}); background-size:cover; background-position: center right; background-attachment: fixed;background-repeat: no-repeat;">
			@foreach($customerservicesupports as $css)
			<h3 class="text-center p-5 text-white">{{ App\MaintenanceLocale::getLocale(58) }}</h3>
			<br>
			<p class="mb-4 text-center  text-white">
			<i class="fa fa-map-marker" aria-hidden="true" style="margin-right:10px;"></i>
			{{ $css->address }}
			</p>
			<p class="mb-4 text-center  text-white">
			<i class="fa fa-mobile" aria-hidden="true" style="margin-right:10px;"></i>
			+{{ $css->phone }}
			</p>
			<p class="mb-4 text-center  text-white">
			<i class="fa fa-phone" aria-hidden="true" style="margin-right:10px;"></i> 
			{{ $css->telephone }}
			</p>	
			<p class="mb-4 text-center  text-white">
			<i class="fa fa-envelope" aria-hidden="true" style="margin-right:10px;"></i>{{ $css->email }}</p>
			@endforeach
		</div>
	</div>
</div>
@endsection


{{-- Photo by Evgeny Tchebotarev from Pexels --}}