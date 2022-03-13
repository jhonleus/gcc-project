@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(426))

@section('content')
	<div class="container profile-container">
		<div class="row">
			<div class="col-sm-3">
				@include('applicant.sidebar.profile')
				@include('applicant.sidebar.index')
			</div>

			<div class="col-sm-9">
				@php
					$currentDisplay = $bookmarks->currentPage() * $bookmarks->perPage();
				@endphp

				<div class="text-right" style="margin-bottom: 10px;">
					<small class="form-text text-muted mb-2">
						{{ App\MaintenanceLocale::getLocale(118) }} (
						<span id="start-page">{{ $currentDisplay - ($bookmarks->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $bookmarks->total() ? $currentDisplay : $bookmarks->total() }}</span>
						{{ App\MaintenanceLocale::getLocale(207) }}
						<span id="total-blog">{{ $bookmarks->total() }}</span> )
					</small>
				</div>

				@foreach($bookmarks as $bookmark)
				<div class="card profile-content">
					<div class="card-body profile-body">
						<div class="profile-header">
							<div class="row">
								<div class="col-sm-9">
									<a href="{{ url('jobs/'.Crypt::encrypt($bookmark->jobId)) }}" class="profile-title-3" target="_blank">
										{{ $bookmark->bookmark ? $bookmark->bookmark->title : "" }}
									</a>
									<a href="{{ url('courses/'.Crypt::encrypt($bookmark->usersId)) }}" class="profile-school" target="_blank">
										{{ $bookmark->bookmark ? $bookmark->bookmark->employers ? $bookmark->bookmark->employers->company : "" : "" }}
									</a>
								</div>
								<div class="col-sm-3">
									<p class="profile-forms-right">
										<label type="submit" class="job-book profile-buttons-saved row{{$bookmark->id}}" jobId="{{Crypt::encrypt($bookmark->jobId)}}" row="{{$bookmark->id}}">
											<i class="fa fa-bookmark" aria-hidden="true"></i>
										</label>
			                        </p>
								</div> 
							</div>
						</div>
						<div class="row">
							<div class="col-sm-9">
								<label class="profile-details">
									<i class="fa fa-user"></i>
									{{ $bookmark->bookmark ? $bookmark->bookmark->employments ? $bookmark->bookmark->employments->name : "" : "" }}
								</label>

								<label class="profile-details">
									<i class="fas fa-map-marker-alt"></i>
									{{ $bookmark->bookmark ? $bookmark->bookmark->country ? $bookmark->bookmark->country->nicename : "" : "" }}
								</label>

								<label class="profile-details">
									<i class="fa fa-address-book"></i>
									{{ $bookmark->bookmark ? $bookmark->bookmark->specializations ? $bookmark->bookmark->specializations->name : "" : "" }}
								</label>

								<label class="profile-details">
									<i class="fa fa-file"></i>
									{{ $bookmark->bookmark ? $bookmark->bookmark->positions ? $bookmark->bookmark->positions->name : "" : "" }}
								</label>

								<label class="profile-details profile-green">
									<i class="fas fa-money profile-black"></i>
									{{ $bookmark->bookmark ? $bookmark->bookmark->currency ? $bookmark->bookmark->currency->name : "" : "" }} {{ $bookmark->bookmark ? number_format($bookmark->bookmark->min,2) : "" }}-{{ $bookmark->bookmark ? number_format($bookmark->bookmark->max,2) : "" }}
								</label>

								<label class="profile-description">
									{!! strlen($bookmark->bookmark->description) > 200 ? str_limit($bookmark->bookmark->description, 200) : '' !!} @if(strlen($bookmark->bookmark->description) > 200) <a href="{{ url('jobs/'.Crypt::encrypt($bookmark->jobId)) }}" target="_blank">Read more...</a> @endif
								</label>
							</div>
							<div class="col-sm-3">
								@if(!is_null($bookmark->bookmark->documents))
									@foreach($bookmark->bookmark->documents as $file)
										@if($file->filetype==="profile")
											<img class="profile-image" src="{{ url($file->path . $file->filename)}}">
										@endif
									@endforeach
								@endif
							</div>
						</div>

						<div class="profile-footer">
							<label class="profile-label-posted">POSTED: {{ $bookmark->bookmark ? $bookmark->bookmark->created_at->diffForHumans() : "" }}</label>
						</div>
					</div>
				</div>
				@endforeach

				<div class="mt-2">
					{{ $bookmarks->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#jobsaved-list").removeClass("profile-label-settings-content");
			$("#jobsaved-list").addClass("profile-label-settings-content-active");
		});

		$(".job-book").click(function() {
			var jobId 	= $(this).attr("jobId");
			 	key 	= $(this).attr("row");

			if($(this).hasClass("profile-buttons-saved")) {
				status = "unsaved";
			}
			else {
				status = "save";
			}

			Swal.fire({
				title: "Do want to " + status + " this job?",
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
		        	    url  : `${basePath}/applicant/saved_job`,
		        	    dataType : "json",
		        	    data : {
		        	        jobId		: 	jobId,
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
									if($(".row"+response.jobId).hasClass("profile-buttons-saved")) {
										$(".row"+response.jobId).addClass('profile-buttons')
										$(".row"+response.jobId).removeClass('profile-buttons-saved')
									}
									else {
										$(".row"+response.jobId).addClass('profile-buttons-saved')
										$(".row"+response.jobId).removeClass('profile-buttons')
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
