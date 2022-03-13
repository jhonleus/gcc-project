@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(428))

@section('content')
	<div class="container profile-container">
		<div class="row">
			<div class="col-sm-3">
				@include('applicant.sidebar.profile')
				@include('applicant.sidebar.index')
			</div>

			<div class="col-sm-9">
				@php
					$currentDisplay = $courses->currentPage() * $courses->perPage();
				@endphp

				<div class="text-right" style="margin-bottom: 10px;">
					<small class="form-text text-muted mb-2">
						{{ App\MaintenanceLocale::getLocale(118) }} (
						<span id="start-page">{{ $currentDisplay - ($courses->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $courses->total() ? $currentDisplay : $courses->total() }}</span>
						{{ App\MaintenanceLocale::getLocale(207) }}
						<span id="total-blog">{{ $courses->total() }}</span> )
					</small>
				</div>

				@foreach($courses as $course)
				<div class="card profile-content">
					<div class="card-body profile-body">
						<div class="profile-header">
							<div class="row">
								<div class="col-sm-9">
									<a href="{{ url('courses/'.Crypt::encrypt($course->courseId)) }}" class="profile-title-3" target="_blank">
										{{ $course->user ? $course->user->course : "" }}
									</a>
									<a href="{{ url('school/'.Crypt::encrypt($course->user->usersId)) }}" class="profile-school" target="_blank">
										{{ $course->user ? $course->user->employers ? $course->user->employers->school : "" : "" }}
									</a>
								</div>
								<div class="col-sm-3">
									<p class="profile-forms-right">
										<label type="submit" class="course-book profile-buttons-saved row{{$course->id}}" courseId="{{Crypt::encrypt($course->courseId)}}" row="{{$course->id}}">
											<i class="fa fa-bookmark" aria-hidden="true"></i>
										</label>
			                        </p>
								</div> 
							</div>
						</div>
						<div class="row">
							<div class="col-sm-9">
								<label class="profile-details">
									<i class="fas fa-hourglass-start"></i>
									{{ date('F d, Y', strtotime($course->user ? $course->user->class_start : "")) }}
								</label>

								<label class="profile-details">
									<i class="fa fa-hourglass-end" aria-hidden="true"></i>
									{{ date('F d, Y', strtotime($course->user ? $course->user->class_end : "")) }} 
								</label>

								<label class="profile-details">
									<i class="fas fa-map-marker-alt"></i>
									{{ $course->user ? $course->user->country ? $course->user->country->nicename : "" : "" }}
								</label>

								<label class="profile-details profile-money">
									<i class="fas fa-money profile-black"></i>
									{{ $course->user ? $course->user->currency ? $course->user->currency->name : "" : "" }}
									{{ $course->user ? $course->user->fee : "" }}
								</label>

								<label class="profile-details">
									@if(!is_null($course->user->schedules))
									<i class="fa fa-calendar" aria-hidden="true"></i>
										@php
										 	$sheds="";
										@endphp
										@foreach($course->user->schedules as $schedule)
											@php
												$scheds = $schedule->day . " - " . $schedule->time;

												$sheds = $sheds . $scheds . ", ";
											@endphp
										@endforeach
									@endif
									{{rtrim($sheds, ', ')}}
								</label>

								<label class="profile-description">
									{!! strlen($course->user->details) > 200 ? str_limit($course->user->details, 200) : '' !!} @if(strlen($bookmark->bookmark->description) > 200) <a href="{{ url('courses/'.Crypt::encrypt($course->courseId)) }}" target="_blank">Read more...</a> @endif
								</label>
							</div>
							<div class="col-sm-3">
								@if(!is_null($course->user->documents))
									@foreach($course->user->documents as $file)
										@if($file->filetype==="profile")
											<img class="profile-image" src="{{ url($file->path . $file->filename)}}">
										@endif
									@endforeach
								@endif
							</div>
						</div>

						<div class="profile-footer">
							<label class="profile-label-posted">{{ App\MaintenanceLocale::getLocale(304) }}: {{ $course->user ? $course->user->created_at->diffForHumans() : "" }}</label>
						</div>
					</div>
				</div>
				@endforeach

				<div class="mt-2">
					{{ $courses->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#coursesaved-list").removeClass("profile-label-settings-content");
			$("#coursesaved-list").addClass("profile-label-settings-content-active");
		});

		$(".course-book").click(function() {
			var courseId 	= $(this).attr("courseId");
			 	key 		= $(this).attr("row");

			if($(this).hasClass("profile-buttons-saved")) {
				status = "unsaved";
			}
			else {
				status = "save";
			}

			Swal.fire({
				title: "Do want to " + status + " this course?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#6c757d',
				confirmButtonText: 'Yes',
				cancelButtonText: 'No'
			}).then((result) => {
				if (result.value) {
    		       	ajax = true;

					basePath = window.location.origin;
		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    type : "POST",
		        	    url  : `${basePath}/applicant/saved_course`,
		        	    dataType : "json",
		        	    data : {
		        	        courseId		: 	courseId,
		        	        ajax 		: 	ajax,
		        	        key 		: 	key
		        	    },
		        	    success: function(response) {
		        			if (response.result === true) {
   								Swal.fire(
   								  response.message,
   								  '',
   								  'success'
   								).then(function(){ 
									if($(".row"+response.courseId).hasClass("profile-buttons-saved")) {
										$(".row"+response.courseId).addClass('profile-buttons')
										$(".row"+response.courseId).removeClass('profile-buttons-saved')
									}
									else {
										$(".row"+response.courseId).addClass('profile-buttons-saved')
										$(".row"+response.courseId).removeClass('profile-buttons')
									}
								});
   		        			}
   		        			else {
   								Swal.fire(
   								  'Ooops',
   								  response.message,
   								  'error'
   								)
   		        			}
		        	    }
		        	});
				}
			})
		});
	</script>
@endsection
