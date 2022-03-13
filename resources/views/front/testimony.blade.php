@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(53))

@section('content')

{{-- testimony-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/testimony-page.css') }}">

<div class="container">
	<div class="testimony-page-section1">
		<div class="row">
			<div class="col-md-12">
				<div class="testimony-page-content1">
					<img src="{{ asset('images/testimoniallogo-01.svg')}}" class="img-fluid testimony-page-logo" alt="Responsive image">
					<h1>{{ App\MaintenanceLocale::getLocale(53) }}</h1>
					<div class="testimony-page-line"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="testimony-page-content2" data-aos="fade-up">
		
		@php
		$currentDisplay = $feedbacks->currentPage() * $feedbacks->perPage();
		@endphp

		<div style="text-align:right"><small class="form-text text-muted">
			{{ App\MaintenanceLocale::getLocale(118) }} (
			<span id="start-page">{{ $currentDisplay - ($feedbacks->perPage() - 1) }}</span>
			-
			<span id="end-page">{{ $currentDisplay < $feedbacks->total() ? $currentDisplay : $feedbacks->total() }}</span>
			{{ App\MaintenanceLocale::getLocale(207) }}
			<span id="total-blog">{{ $feedbacks->total() }}</span> )
		</small></div>

		<div class="row mt-3">
			@foreach ($feedbacks as $feedback)
			<div class="col-md-12 mb-5">
				<div class="card">
					<div class="card-body">
						<p class="card-text font-italic text-muted">"{{$feedback->message}}"</p>
						<hr>
						@if ($feedback->id % 2 == 0)
						<div class="text-right">
							<h6 class="text-muted m-0">{{$feedback->name}} {{$feedback->work != '' ? '- '.$feedback->work : ''}}</h6>
							<small class="text-muted">{{ date('m/d/Y', strtotime( $feedback->created_at )) }}</small>
						</div>
						@else
						<div class="text-left">
							<h6 class="text-muted m-0">{{$feedback->name}} {{$feedback->work != '' ? '- '.$feedback->work : ''}}</h6>
							<small class="text-muted">{{ date('m/d/Y', strtotime( $feedback->created_at )) }}</small>
						</div>
						@endif
					</div>
				</div>
			</div>
			@endforeach		
		</div>

		<div class="mt-3">
			{{ $feedbacks->appends(request()->except('page'))->onEachSide(1)->links() }}
		</div>
	</div>
</div>
@endsection