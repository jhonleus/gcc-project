@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(61))

@section('content')

{{-- privacy-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/privacy-page.css') }}">

<div class="container">
	<br>
	<br>
	<br>
	<br>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="terms-page-content1">
					<h1 class="text-left text-muted">{{ App\MaintenanceLocale::getLocale(61) }}</h1>
					<p class="privacy-page-text">{!! App\MaintenanceLocale::getLocale(489) !!}</p>
			</div>
		</div>
	</div>
</div>
@endsection
