@extends('layouts.header')

@section('title', 'Job Details')

@section('content')
	<!-- CSS FOR FRONT JOB DETAILS-->
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/job-details-page.css') }}">

	<div class="container job-container">	
		@if(Auth::check() && Auth::user()->rolesId==1)
		@if(!$detailsStatus)
		<div class="alert alerts alert-warning" role="alert">
			Please complete your details <a href="{{ url('applicant/personal/'.Auth::user()->id.'/edit') }}">here</a> before applying!
		</div>
		@elseif(!$profileStatus)
		<div class="alert alerts alert-warning" role="alert">
			Please upload your profile picture <a href="{{ url('applicant/profile') }}">here</a> before applying!
		</div>
		@elseif(!$resumeStatus)
		<div class="alert alerts alert-warning" role="alert">
			Please upload your resume <a href="{{ url('applicant/profile') }}">here</a> before applying!
		</div>
		@endif
		@endif

		<div class="card job-contents">
			<div class="row">
				<div class="col-sm-6">
					<h1 class="job-name">
						{{ $job->title }} 
					</h1>
					<p class="job-company">
						{{ $job->employers->company }} ({{ $job->employers->industry->getName() }})
					</p>
				</div>

				<div class="col-sm-6 job-body">
					@if(!Auth::check()) 
						<a  href="/login" class="job-login">
							Login to Apply
						</a>
					@else
						@if(Auth::user()->rolesId == 1)
							@if($jobStatus)
								@if(!$applied)
									@if($detailsStatus && $profileStatus && $resumeStatus)
										<button class="btn btn-chinese job-button" data-toggle="modal" data-target="#jobModel">
											Apply to this job
										</button>
									@endif
								@else
									<button class="btn btn-chinese job-button disabled" disabled>
										Already Applied
									</button>
								@endif
							@endif
						@endif
					@endif
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card job-contents">
					<div class="content-title">
						<h1 class="job-label">
							Job Description
						</h1>
					</div>

					<div class="job-content-description">
						<label class="job-description">
							{!! $job->description !!}
						</label>
					</div>

					<div class="content-title">
						<h1 class="job-label">
							Job Respobilities
						</h1>
					</div>

					<div class="job-content-description">
						<label class="job-description">
							{!! $job->responsibilities !!}
						</label>
					</div>

					<div class="content-title">
						<h1 class="job-label">
							Job Qualification
						</h1>
					</div>

					<div class="job-content-description">
						<label class="job-description">
							{!! $job->qualification !!}
						</label>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card job-contents">
					<label class="job-label-2">
						<i class="fa fa-user"></i>
						{{ $job->employments->name }}
					</label>

					<label class="job-label-2">
						<i class="fas fa-map-marker-alt"></i>
						{{ $job->locationCity }}, {{ $job->country->nicename }}
					</label>

					<label class="job-label-2">
						<i class="fa fa-address-book"></i>
						{{ $job->specializations->name }}
					</label>

					<label class="job-label-2">
						<i class="fa fa-file"></i>
						{{ $job->positions->name }}
					</label>

					<label class="job-label-2 job-label-money">
						<i class="fas fa-money job-label-black"></i>
						@if(!Auth::check())
							<a href="{{ url('login') }}" target="_blank">Login to view salary</a>
						@else
						{{ $job->currency->name }} {{ number_format($job->min,2)  }}-{{ number_format($job->max,2) }}
						@endif
					</label>
				</div>

				@if(!$affilations->isEmpty())
				<div class="card job-contents">
					<div class="content-title">
						<h1 class="job-label">
							Co./Org
						</h1>
					</div>

					<div class="job-content-description">
						@foreach($affilations as $affilation)
						<label class="job-description">
		                    @if($job->usersId==$affilation->usersId)
		                    	@if(!is_null($affilation->co_user))
		                    		@if($affilation->co_user->rolesId==4)
		                    			<a href="=" class="job-link">
											School
										</a>
		                    		@else
										<a href="" class="job-link">
											{{$affilation->co_affilation ? $affilation->co_affilation->industry ? $affilation->co_affilation->industry->name : $affilation->co_affilation->company : ""}}
										</a>
									@endif
								@endif
							@else
		                    	@if(!is_null($affilation->user))
		                    		@if($affilation->user->rolesId==4)
		                    			<a href="" class="job-link">
											School
										</a>
		                    		@else
										<a href="" class="job-link">
											{{$affilation->affilation ? $affilation->affilation->industry ? $affilation->affilation->industry->name : $affilation->affilation->company : ""}}
										</a>
									@endif
								@endif
							@endif
						</label>
						@endforeach
					</div>
				</div>
				@endif

				@if(Auth::check()) 
					@if(Auth::user()->rolesId == 1)
					<form method="POST" action="{{ route('applicant.saved_job') }}"  enctype="multipart/form-data">
						@csrf
						<button class="btn @if($bookMarkStatus==0) job-book @else job-unbook @endif job-bookmark-button">
							<i class="fas fa-bookmark" aria-hidden="true"></i>
							@if($bookMarkStatus==0) Bookmark @else Unbookmarked @endif
						</button>
						<input type="hidden" name="jobId" value="{{Crypt::encrypt($job->id)}}">
					</form>
					@endif
				@endif
				<a href="{{ url('company/'.Crypt::encrypt($job->usersId)) }}" class="job-profile-button">
					{{ $job->info ? $job->info->rolesId == 3 ? "View Organization Profile" : "View Company Profile"  : "View Company Profile" }}
					<i class="fa fa-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>

	<div class="modal" tabindex="-1" role="dialog" id="jobModel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="POST" action="{{ route('applicant.jobs.store') }}"  enctype="multipart/form-data">
					@csrf
				<div class="modal-header"></div>

				<div class="modal-body">
					<div class="job-forms">
						<h1 class="job-title">Resume</h1>

						<input type="file" name="resume" id="resume">
					
						<div class="error-container">
							<label class="label-error error-resume">No files selected.</label>
						</div>
					</div>

					<div class="job-forms">
						<input type="checkbox" id="resumeCheck" name="resumeCheck">
						<h1 class="job-title-2">Select resume from profile</h1>
					</div>
				</div>

				<div class="modal-footer">
					<input type="hidden" name="jobId" value="{{$job->id}}">
					<input type="hidden" name="organizationId" value="{{$job->employers->usersId}}">

					<button type="button" class="btn job-button btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn job-button btn-primary apply_button">Apply</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(".apply_button").click(function(e) {
			var resume 			= $('#resume').get(0).files.length;
			 	completeDetails = @if($detailsStatus) "true" @else "false" @endif;

			if(completeDetails==="false") {
				e.preventDefault();
			}
			else if (!$('#resumeCheck').prop('checked') && resume === 0) {
				e.preventDefault();

				if (resume === 0) {
				    $(".error-resume").show();
				}
			}
		});

		$("#resume").change(function() {
			var resume = $(this).get(0).files.length;

			if(resume===0) {
			    $(".error-resume").show();
			}
			else {
			    $(".error-resume").hide();
			}
		});

		$("#resumeCheck").change(function() {
			if (!$('#resumeCheck').prop('checked')) {
			    $(".error-resume").show();
			}
			else {
				var resume = $("#resume").get(0).files.length;
			    $(".error-resume").hide();
			}
		});
	</script>
@endsection