@extends('layouts.header')

@section('title', "Posted Courses")

@section('content')
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('school.sidebar.profile')
				@include('school.sidebar.index')
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
				<div class="card page-contents">
					<div class="card-body sidebar-body">
						<div class="row">
							<div class="col-sm-6">
								<a href="{{url("courses/".Crypt::encrypt($course->id)) }}" class="content-title" target="_blank">
									{{$course->course}}
								</a>
								
								@if($course->isActive==1 && $course->isDeleted==0)
			                    	<span class="badge badge-success" style="font-size:12px;">
			                    		ACTIVE
			                    	</span>
			                    @else
			                    	<span class="badge badge-danger" style="font-size:12px;">
			                    		INACTIVE
			                    	</span>
		                    	@endif

		                    	<div style="display:block">
		                    		<label class="label-description-2">
		                    			Posted on
                    					{{date('F d Y', strtotime($course->created_at))}}
		                    		</label>

		                    		<br>

		                    		<a href="{{url("school/summary/students/".$course->id) }}" class="job-action" target="_blank">
		                    			view summary
		                    		</a>

		                    		| 

		                    		<a href="{{ url('courses/'.Crypt::encrypt($course->id)) }}" class="job-action" target="_blank">
		                    			view course post
		                    		</a>
		                    	</div>
							</div> 

							<div class="col-sm-2 text-center">
								<a class="jobs-label" href="{{ url("school/summary/students/unprocessed/".$course->id) }}" target="_blank">{{$course->unprocessed()}}
									<label class="jobs-title">UNPROCESSED</label>
								</a>
							</div>

							<div class="col-sm-2 text-center">
								<a class="jobs-label" href="{{ url("school/summary/students/interview/".$course->id) }}" target="_blank">{{$course->interview()}}
									<label class="jobs-title">INTERVIEW</label>
								</a>
							</div>

							<div class="col-sm-2 text-center">
								<a class="jobs-label" href="{{ url("school/summary/students/rejected/".$course->id) }}" target="_blank">{{$course->rejected()}}
									<label class="jobs-title">REJECTED</label>
								</a>
							</div>
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
			$("#coursesum-list").removeClass("sidebar-list-title");
			$("#coursesum-list").addClass("sidebar-list-title-active");
		});
	</script>
@endsection
