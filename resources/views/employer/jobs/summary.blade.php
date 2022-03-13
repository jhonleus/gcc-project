@extends('layouts.header')

@section('title', "Posted Job")

@section('content')
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('employer.sidebar.profile')
				@include('employer.sidebar.index')
			</div>

			<div class="col-sm-9">
				@php
					$currentDisplay = $jobs->currentPage() * $jobs->perPage();
				@endphp

				<div class="text-right" style="margin-bottom: 10px;">
					<small class="form-text text-muted mb-2">
						{{ App\MaintenanceLocale::getLocale(118) }} (
						<span id="start-page">{{ $currentDisplay - ($jobs->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $jobs->total() ? $currentDisplay : $jobs->total() }}</span>
						{{ App\MaintenanceLocale::getLocale(207) }}
						<span id="total-blog">{{ $jobs->total() }}</span> )
					</small>
				</div>

				@foreach($jobs as $job)
				<div class="card page-contents">
					<div class="card-body sidebar-body">
						<div class="row">
							<div class="col-sm-6">
								<a href="{{url("jobs/".Crypt::encrypt($job->id)) }}" class="content-title" target="_blank">
									{{$job->title}}
								</a>
								
								@if($job->isActive==1 && $job->isDeleted==0)
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
		                    			{{date('F d Y', strtotime($job->created_at))}}
		                    		</label>

		                    		<br>

		                    		<a href="{{url("employer/summary/applicants/".$job->id) }}" class="job-action" target="_blank">
		                    			view summary
		                    		</a>

		                    		| 

		                    		<a href="{{ url('jobs/'.Crypt::encrypt($job->id)) }}" class="job-action" target="_blank">
		                    			view job post
		                    		</a>
		                    	</div>
							</div> 

							<div class="col-sm-2 text-center">
								<a class="jobs-label" href="{{ url("employer/summary/applicants/unprocessed/".$job->id) }}" target="_blank">{{$job->unprocessed()}}
									<label class="jobs-title">UNPROCESSED</label>
								</a>
							</div>

							<div class="col-sm-2 text-center">
								<a class="jobs-label" href="{{ url("employer/summary/applicants/interview/".$job->id) }}" target="_blank">{{$job->interview()}}
									<label class="jobs-title">INTERVIEW</label>
								</a>
							</div>

							<div class="col-sm-2 text-center">
								<a class="jobs-label" href="{{ url("employer/summary/applicants/rejected/".$job->id) }}" target="_blank">{{$job->rejected()}}
									<label class="jobs-title">REJECTED</label>
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach

				<div class="mt-2">
					{{ $jobs->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#jobsum-list").removeClass("sidebar-list-title");
			$("#jobsum-list").addClass("sidebar-list-title-active");
		});
	</script>
@endsection
