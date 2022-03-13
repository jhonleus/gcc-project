@extends('layouts.header')

@section('title', 'Course Details')

@section('content')
	<!-- CSS FOR FRONT COURSE DETAILS-->
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/course-details-page.css') }}">

	<div class="container course-container">	
		@if(Auth::check() && Auth::user()->rolesId==1)
		@if(!$detailsStatus)
		<div class="alert alerts alert-warning" role="alert">
			Please complete your details <a href="{{ url('applicant/personal/'.Auth::user()->id.'/edit') }}">here</a> before applying!
		</div>
		@elseif(!$profileStatus)
		<div class="alert alerts alert-warning" role="alert">
			Please upload your profile picture <a href="{{ url('applicant/profile') }}">here</a> before applying!
		</div>
		@endif
		@endif

		<div class="card course-contents">
			<div class="row">
				<div class="col-sm-6">
					<h1 class="course-name">
						{{$course->course}}
					</h1>
					<p class="course-company">
						{{$course->employers->school}}
					</p>
				</div>

				<div class="col-sm-6 course-body">
					@if(!Auth::check()) 
						<a  href="/login" class="course-login">
							Login to Apply
						</a>
					@else
						@if(Auth::user()->rolesId == 1)
							@if($courseStatus)
								@if(!$applied)
									@if($detailsStatus)
										<button class="btn btn-chinese course-button" data-toggle="modal" data-target="#courseModal">
											Apply to this course
										</button>
									@endif
								@else
									<button class="btn btn-chinese course-button disabled" disabled>
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
				<div class="card course-contents">
					<div class="content-title">
						<h1 class="course-label">
							Class starts on:
						</h1>
					</div>

					<div class="course-content-description">
						<label class="course-description">
							{{ date('F d, Y', strtotime($course->class_start)) }}
						</label>
					</div>

					<div class="content-title">
						<h1 class="course-label">
							Class will end on:
						</h1>
					</div>

					<div class="course-content-description">
						<label class="course-description">
							{{ date('F d, Y', strtotime($course->class_end)) }}
						</label>
					</div>


					@if(!is_null($course->schedules))
					<div class="content-title">
						<h1 class="course-label">
							Class Schedules
						</h1>
					</div>

					<div class="course-content-description">
						@foreach($course->schedules as $schedule)
						<label class="course-description">
							{{$schedule->day}}
							({{$schedule->time}})
						</label>
						@endforeach
					</div>
					@endif

					<div class="content-title">
						<h1 class="course-label">
							Course Details:
						</h1>
					</div>

					<div class="course-content-description">
						<label class="course-description">
							{!! $course->details !!}
						</label>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card course-contents">
					<label class="course-label-2">
						<i class="fas fa-map-marker-alt"></i>
						{{ $course->country->nicename }}
					</label>

					<label class="course-label-2 course-label-money">
						<i class="fas fa-money course-label-black"></i>
						{{ $course->currency->name }}
						{{ $course->fee }}
					</label>
				</div>

				@if(!$affilations->isEmpty())
				<div class="card course-contents">
					<div class="content-title">
						<h1 class="course-label">
							Affilated Company
						</h1>
					</div>

					<div class="course-content-description">
						@foreach($affilations as $affilation)
						<label class="course-label-2">
		                    @if($course->usersId==$affilation->usersId)
	                    		@if($affilation->co_user->rolesId==4)
	                    			<a href="{{url("school/".Crypt::encrypt($affilation->companyId)) }}" class="course-link" target="_blank">
										{{$affilation->co_school ? $affilation->co_school->school : ""}}
									</a>
	                    		@else
									<a href="{{url("company/".Crypt::encrypt($affilation->companyId)) }}" class="course-link" target="_blank">
										{{$affilation->co_affilation ? $affilation->co_affilation->company : ""}}
									</a>
								@endif
							@else
	                    		@if($affilation->user->rolesId==4)
	                    			<a href="{{url("school/".Crypt::encrypt($affilation->usersId)) }}" class="course-link" target="_blank">
										{{$affilation->school ? $affilation->school->school : ""}}
									</a>
	                    		@else
									<a href="{{url("company/".Crypt::encrypt($affilation->usersId)) }}" class="course-link" target="_blank">
										{{$affilation->affilation ? $affilation->affilation->company : ""}}
									</a>
								@endif
							@endif
						</label>
						@endforeach
					</div>
				</div>
				@endif

				@if(Auth::check()) 
					@if(Auth::user()->rolesId == 1)
					<form method="POST" action="{{ route('applicant.saved_course') }}"  enctype="multipart/form-data">
						@csrf
						<button class="btn @if($bookMarkStatus==0) course-book @else course-unbook @endif course-bookmark-button">
							<i class="fas fa-bookmark" aria-hidden="true"></i>
							@if($bookMarkStatus==0) Bookmark @else Unbookmarked @endif
						</button>
						<input type="hidden" name="courseId" value="{{Crypt::encrypt($course->id)}}">
					</form>
					@endif
				@endif
				<a href="{{ url('school/'.Crypt::encrypt($course->usersId)) }}" class="course-profile-button" target="_blank">
					View School Profile
					<i class="fa fa-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>

	<div class="modal" tabindex="-1" role="dialog" id="courseModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="POST" action="{{ route('applicant.courses.store') }}"  enctype="multipart/form-data">
					@csrf
				<div class="modal-header"></div>

				<div class="modal-body">
					<div class="course-forms">
						<h1 class="course-title">Birth Certificate</h1>

						<input type="file" name="certificate" id="certificate">
					
						<div class="error-container">
							<label class="label-error error-certificate">No files selected.</label>
						</div>
					</div>

					<div class="course-forms">
						<h1 class="course-title">Transcript of Record</h1>

						<input type="file" name="records" id="records">
					
						<div class="error-container">
							<label class="label-error error-records">No files selected.</label>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<input type="hidden" name="courseId" value="{{Crypt::encrypt($course->id)}}">
					<input type="hidden" name="companyId" value="{{Crypt::encrypt($course->usersId)}}">

					<button type="button" class="btn course-button btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn course-button btn-primary apply_button">Apply</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(".apply_button").click(function(e) {
			var certificate 	= $('#certificate').get(0).files.length;
			 	records 		= $('#records').get(0).files.length;
			 	completeDetails = @if($detailsStatus) "true" @else "false" @endif;

			if(completeDetails==="false") {
				e.preventDefault();
			}
			else if (certificate === 0 || records === 0) {
				e.preventDefault();

				if (certificate === 0) {
				    $(".error-certificate").show();
				}

				if (records === 0) {
				    $(".error-records").show();
				}
			}
		});

		$("#certificate").change(function() {
			var certificate = $(this).get(0).files.length;

			if(certificate===0) {
			    $(".error-certificate").show();
			}
			else {
			    $(".error-certificate").hide();
			}
		});

		$("#records").change(function() {
			var records = $(this).get(0).files.length;

			if(records===0) {
			    $(".error-records").show();
			}
			else {
			    $(".error-records").hide();
			}
		});
	</script>
@endsection