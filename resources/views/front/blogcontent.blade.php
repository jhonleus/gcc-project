@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(52))

@section('content')

{{-- blogcontent-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/blogcontent-page.css') }}">

{{-- container-start --}}
<div class="container">
	<div class="row">
		<div class="col-lg-12 {{-- shadow p-0 mb-5 bg-white rounded --}} blogcontent-page-container">

			{{-- blog content image --}}
			<div class="card-img-top" style="background-image: url({{ asset('blogs/' .$blogs->filename)}}); height: 550px; background-size: cover;  background-position: center;"></div>

			{{-- blog title --}}
			<h3 class="m-0 p-lg-3 p-sm-5">{{$blogs->title}}</h3>

			{{-- blog subtitle --}}
			<small class="font-weight-light text-muted p-lg-3 p-3">{{$blogs->subtitle}}</small>
			
			{{-- blog text content --}}
			<p class="container my-5">{{ $blogs->content }}</p>

			<div class="container mt-5 p-4">
				<div class="row d-flex justify-content-between">
					<div style="float:left">
						<small class="font-weight-light text-muted">{{ App\MaintenanceLocale::getLocale(303) }}:</small>

						{{-- creator of the blog --}}
						<small class="ml-1 font-italic"> {{$blogs->users ? $blogs->users->firstName ." ". $blogs->users->lastName : 'Admin'}}</small>
					</div>
					<div style="float:right">
						<small class="font-weight-light text-muted">{{ App\MaintenanceLocale::getLocale(304) }}:</small>
						
						{{-- blog created --}}
						<small class="ml-1 font-italic">{{$blogs->created_at->diffForHumans()}}</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{-- container-end --}}

@endsection