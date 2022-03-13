@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(52))

@section('content')

<link rel="stylesheet" href="{{ asset('css/content-page/blog-page.css') }}">

<div class="container">
	<div class="row" {{-- style="margin-bottom: 100vh;" --}}>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 blog-page-container1">
			<h1 class="blog-page-title1 font-weight-light text-center text-muted position-relative" style="margin-top:15%;">{{ App\MaintenanceLocale::getLocale(52) }}</h1>
			<div class="blog-page-line mx-auto mb-3" style="display: block; margin: 0px auto;"></div>

			@php
			$currentDisplay = $blogs->currentPage() * $blogs->perPage();
			@endphp

			<div style="text-align:right">
				<small class="form-text text-muted">
				{{ App\MaintenanceLocale::getLocale(118) }} (
				<span id="start-page">{{ $currentDisplay - ($blogs->perPage() - 1) }}</span>
				-
				<span id="end-page">{{ $currentDisplay < $blogs->total() ? $currentDisplay : $blogs->total() }}</span>
				{{ App\MaintenanceLocale::getLocale(207) }}
				<span id="total-blog">{{ $blogs->total() }}</span> )
				</small></div>
		</div>
		
		@foreach ($blogs as $blog)	
		<div class="col-lg-4 col-md-4 col-sm-12 mt-3 blog-page-container2 mb-5">
			<div class="card-deck">
			<div class="card blog-page-content" data-aos="fade-up" style="width: 25rem; display: block; margin: 0px auto;">

				{{-- blog post image --}}
				<div class="card-img-top" style="background-image: url({{ asset('blogs/' .$blog->filename)}}); height: 250px; background-size: cover;  background-position: center;"></div>
				<div class="card-body">
					{{-- blog post title --}}
					<h3 class="font-weight-bold" style="color: #343434;">{{$blog->title}}</h3>

					{{-- blog post subtitle --}}
					<small class="font-weight-light text-muted">{{$blog->subtitle}}</small>
					
					{{-- blog post main content --}}
					<p class="mt-2">{{ strlen($blog->content) > 50 ? str_limit($blog->content,50) : ''}} @if(strlen($blog->content) > 50) <a href="/blog/{{$blog->id}}">{{ App\MaintenanceLocale::getLocale(280) }}</a> @endif</p>
					
					{{-- blog post came from --}}
					<small class="font-italic text-muted mt-2">{{ App\MaintenanceLocale::getLocale(303) }}: {{$blog->users ? $blog->users->firstName ." ". $blog->users->lastName : 'Admin'}}</small>
				</div>
				<div class="card-footer bg-white container">

					{{-- blog post date created --}}
					<small class="font-weight-light text-muted">{{ App\MaintenanceLocale::getLocale(304) }}: {{$blog->created_at->diffForHumans()}}</small>
				</div>
			</div>
		</div>
		</div>
		@endforeach
	<div class="mt-3 mx-auto">
		{{ $blogs->appends(request()->except('page'))->onEachSide(1)->links() }}
	</div>
	</div>
</div>
@endsection