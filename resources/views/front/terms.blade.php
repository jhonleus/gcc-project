@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(60))

@section('content')

{{-- privacy-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/terms-page.css') }}">
{{-- container-start --}}
<div class="container">
	<br>
	<br>
	<br>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="terms-page-content1">
					<h1 class="text-muted mt-5">{{ App\MaintenanceLocale::getLocale(60) }}</h1>
					<p class="terms-page-text">{!! App\MaintenanceLocale::getLocale(488) !!}</p>
				</div>
			</div>
		</div>
	
</div>
{{-- container-end --}}
@endsection
