@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(110))

@section('content')
	<link rel="stylesheet" href="{{ asset('css/content-page/verify-page.css') }}">

    <div class="container verify-container" style="height: 100vh;">
    	<div class="verify-body">
			@if (session('resent'))
				<div class="alert alert-success" role="alert">
					{{ App\MaintenanceLocale::getLocale(109) }}
				</div>
			@endif
	        <div class="card verify-contents">
	        	<div class="card-header verify-header">
	        		<label class="verify-title">{{ App\MaintenanceLocale::getLocale(110) }}</label>
	        	</div>

	        	<div class="card-body">
					<label class="verify-label">{{ App\MaintenanceLocale::getLocale(111) }},
						 <a href="{{ route('verification.resend') }}">{{ App\MaintenanceLocale::getLocale(112) }}</a>.</label>
	            </div>
	        </div>
	    </div>
    </div>
@endsection
