@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(59))

@section('content')

{{-- feedback-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/feedback-page.css') }}">

{{-- container-start --}}
<div class="container-fluid px-0" style="overflow: hidden;">
	<div class="row feedback-page-container" style="height: 100vh;">
		<div class="col-lg-4 col-md-4 col-sm-none" style="background-image: url(/feedbacks/{{ $pagecontents->feedback }}); background-position: center center center center; background-attachment: fixed;background-size: contain; background-repeat: no-repeat;  "></div>
			{{-- Photo by Satoshi Hirayama from Pexels --}}
			<div class="col-lg-8 col-md- col-sm-12 col-xs-12 mx-auto p-5">
				<form method="POST" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto mt-5" action="{{ route('feedback.store') }}" enctype="multipart/form-data">  
            		@csrf
					<h1 class="text-center font-weight-bold">{{ App\MaintenanceLocale::getLocale(129) }}</h1>
					<p class="text-center text-muted">{{ App\MaintenanceLocale::getLocale(130) }}</p>
					<div class="row">
						<div class="col-lg-6 col-sm-12">
							<div class="form-group">
    					  		<small class="form-text text-muted">Name</small>
    							<input type="text" class="form-control"  name="name" required>	
					  		</div>
						</div>
					  	<div class="col-lg-6 col-sm-12">
					  		<div class="form-group">
								<small class="form-text text-muted">Work Specialization/Position</small>
					  			<input type="text" class="form-control" name="work" placeholder="(leave blank if don't have)">	
					  		</div>
						</div>
					</div>
  					<div class="form-group mt-3">
    					<small class="form-text text-muted">{{ App\MaintenanceLocale::getLocale(131) }}</small>
    					<textarea type="textarea" class="form-control" name="message" rows="8" required></textarea>
  					</div>
  					<button type="submit" class="btn btn-primary btn-md feedback-page-btn col-lg-3 col-md-3 mt-3 col-sm-12">{{ App\MaintenanceLocale::getLocale(77) }}</button>
				</form>
			<h1 class="feedback-page-bg">FEEDBACK</h1>	
		</div>
	</div>
</div>
{{-- container-end --}}
@endsection

