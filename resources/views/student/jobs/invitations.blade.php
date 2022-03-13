@extends('layouts.header')

@section('title', 'Job Aplications')

@section('content')
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/css/datetime/jquery.datetimepicker.min.css') }}">
	<script src="{{ asset('resources/js/datetime/jquery.datetimepicker.js') }}"></script>

	<div class="container profile-container">
		<div class="row">
			<div class="col-sm-3">
				@include('applicant.sidebar.profile')
				@include('applicant.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card page-title">
					<ul class="nav nav-tabs" data-tabs="tabs">
						<li class="nav-item">
							<a class="nav-link active" href="#interview" data-toggle="tab">For interview <span class="badge badge-light ml-2">{{ $jobs->total() }}</span></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#approves" data-toggle="tab">Approved <span class="badge badge-light ml-2">{{ $approves->total() }}</span></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#rejects" data-toggle="tab">Rejected <span class="badge badge-light ml-2">{{ $rejects->total() }}</span></a>
						</li>
					</ul>
				</div>

				<div class="tab-content" style="margin-top: 10px;">

					<div class="tab-pane active" id="interview">
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
							<div class="card profile-content">
								<div class="card-body profile-body">
									<div class="row">
										<div class="col-sm-2 text-center"> 
											<h1 class="display-4">
												<span class="badge badge-secondary">{{date("d", strtotime($job->scheduled))}}</span>
											</h1>
											<h2 class="profile-title-2">{{date("M", strtotime($job->scheduled))}}</h2>
										</div>
										<div class="col-sm-10"> 
											<div class="row">
												<div class="col-sm-8">
													<a href="{{ url('jobs/'.Crypt::encrypt($job->jobId)) }}" class="profile-title" target="_blank"><strong>{{$job->jobs ? $job->jobs->title : ""}}</strong></a>
													<a href="{{ url('company/'.Crypt::encrypt($job->companyId)) }}" class="profile-subtitle" target="_blank">{{$job->employer ? $job->employer->company : ""}}</a>
												</div>
												<div class="col-sm-4">
													<p class="profile-actions">
														<label class="approve-profile profile-blue" data-id="{{$job->id}}">
															<i class="fa fa-check-circle" aria-hidden="true"></i> 
															Accept
														</label>

														<label class="reject-profile profile-red" data-id="{{$job->id}}">
															<i class="fa fa-trash" aria-hidden="true"></i> 
															Reject
														</label>
							                        </p>
												</div> 
											</div>
											<ul class="list-inline">
											    <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> {{date("l", strtotime($job->scheduled))}}</li>
												<li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ Helper::getTime($job->scheduled) }}</li>
												<li class="list-inline-item"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $job->eaddress ? $job->eaddress->street ? $job->eaddress->street : '' : '' }} {{ $job->eaddress ? $job->eaddress->city ? $job->eaddress->city . ',' : '' : '' }} {{ $job->eaddress ? $job->eaddress->zipcode ? $job->eaddress->zipcode : '' : '' }}</li>
											</ul>
											<div class="description">{!!$job->message!!}</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach

						<div class="mt-2">
							{{ $jobs->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>

					<div class="tab-pane" id="approves">
						@php
							$currentDisplay = $approves->currentPage() * $approves->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($approves->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $approves->total() ? $currentDisplay : $approves->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $approves->total() }}</span> )
							</small>
						</div>

						@foreach($approves as $job)
							<div class="card profile-content">
								<div class="card-body profile-body">
									<div class="row">
										<div class="col-sm-2 text-center"> 
											<h1 class="display-4">
												<span class="badge badge-secondary">{{date("d", strtotime($job->scheduled))}}</span>
											</h1>
											<h2 class="profile-title-2">{{date("M", strtotime($job->scheduled))}}</h2>
										</div>
										<div class="col-sm-10"> 
											<a href="{{ url('jobs/'.Crypt::encrypt($job->jobId)) }}" class="profile-title" target="_blank"><strong>{{$job->jobs ? $job->jobs->title : ""}}</strong></a>
											<a href="{{ url('company/'.Crypt::encrypt($job->companyId)) }}" class="profile-subtitle" target="_blank">{{$job->employer ? $job->employer->company : ""}}</a>
												
											<ul class="list-inline">
											    <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> {{date("l", strtotime($job->scheduled))}}</li>
												<li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ Helper::getTime($job->scheduled) }}</li>
												<li class="list-inline-item"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $job->eaddress ? $job->eaddress->street ? $job->eaddress->street : '' : '' }} {{ $job->eaddress ? $job->eaddress->city ? $job->eaddress->city . ',' : '' : '' }} {{ $job->eaddress ? $job->eaddress->zipcode ? $job->eaddress->zipcode : '' : '' }}</li>
											</ul>
											<div class="description">{!!$job->message!!}</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach

						<div class="mt-2">
							{{ $approves->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>

					<div class="tab-pane" id="rejects">
						@php
							$currentDisplay = $rejects->currentPage() * $rejects->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($rejects->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $rejects->total() ? $currentDisplay : $rejects->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $rejects->total() }}</span> )
							</small>
						</div>

						@foreach($rejects as $job)
							<div class="card profile-content">
								<div class="card-body profile-body">
									<div class="row">
										<div class="col-sm-2 text-center"> 
											<h1 class="display-4">
												<span class="badge badge-secondary">{{date("d", strtotime($job->scheduled))}}</span>
											</h1>
											<h2 class="profile-title-2">{{date("M", strtotime($job->scheduled))}}</h2>
										</div>
										<div class="col-sm-10"> 
											<a href="{{ url('jobs/'.Crypt::encrypt($job->jobId)) }}" class="profile-title" target="_blank"><strong>{{$job->jobs ? $job->jobs->title : ""}}</strong></a>
											<a href="{{ url('company/'.Crypt::encrypt($job->companyId)) }}" class="profile-subtitle" target="_blank">{{$job->employer ? $job->employer->company : ""}}</a>
												
											<ul class="list-inline">
											    <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> {{date("l", strtotime($job->scheduled))}}</li>
												<li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ Helper::getTime($job->scheduled) }}</li>
												<li class="list-inline-item"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $job->eaddress ? $job->eaddress->street ? $job->eaddress->street : '' : '' }} {{ $job->eaddress ? $job->eaddress->city ? $job->eaddress->city . ',' : '' : '' }} {{ $job->eaddress ? $job->eaddress->zipcode ? $job->eaddress->zipcode : '' : '' }}</li>
											</ul>
											<div class="description">{!!$job->message!!}</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach

						<div class="mt-2">
							{{ $rejects->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="warning-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
			<input type="hidden" class="courseprofileId" name="courseprofileId">
			<div class="modal-dialog modal-for-actions modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<div class="status-box confirmation-label">
							<i class="material-icons fa fa-remove"></i>
						</div>				
					</div>

					<div class="modal-body">
						<p class="profile-note">
							Are you sure you want to <font class="status_msg">accept</font> this job?
						</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn profile-button btn-secondary close-button" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div> 

		<input type="hidden" id="date">
		<input type="hidden" id="proper_format">
	</div>

	<script>
		$(document).ready(function(){
			$("#invitations-list").removeClass("profile-label-settings-content");
			$("#invitations-list").addClass("profile-label-settings-content-active");
		});

		$(".approve-profile").click(function() {
			var id 		= $(this).data("id");
				status 	= 2;

			$(".status_msg").html("approve");
			$('#warning-modal').modal('show'); 
			$(".close-button").after(approve_profile(id, status));
		});

		$(".reject-profile").click(function() {
			var id 		= $(this).data("id");
				status 	= 0;

			$(".availability-forms").hide();
			$(".status_msg").html("reject");
			$('#warning-modal').modal('show'); 
			$(".close-button").after(approve_profile(id, status));
		});

		function approve_profile(id, status) {
		    return $('<button/>', {
		        text: 	'Yes',
		        id: 	'accept-profile',
		        class: 	'btn profile-button btn-danger',
		        click: function() {
		       		$("#warning-modal").modal('hide');
        			$("#accept-profile").remove();

					basePath = window.location.origin;
		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    type : "POST",
		        	    url  : `${basePath}/applicant/invitations_response`,
		        	    dataType : "json",
		        	    data : {
		        	        id 			: id,
		        	        status 		: status
		        	    },
		        	    success: function(response) {
		        			if (response.result === true) {
   								Swal.fire(
   								  response.message,
   								  '',
   								  'success'
   								).then(function(){ 
									location.reload();
								});
   		        			}
   		        			else {
   		        				if(msg['id']!==undefined) {
		        					if(msg['id'][0].match(/required/)) {
		   		        				Swal.fire('Ooops', "{{ $message['ER:01:16'] }}", 'error')
		   		        			}
		   		        			else {
		   		        				Swal.fire('Ooops', "{{ $message['ER:01:17'] }}", 'error')
		   		        			}
			        			}
   		        				else if(msg['status']!==undefined) {
		        					if(msg['status'][0].match(/required/)) {
		   		        				Swal.fire('Ooops', "{{ $message['ER:00:81'] }}", 'error')
		   		        			}
		   		        			else {
		   		        				Swal.fire('Ooops', "{{ $message['ER:00:82'] }}", 'error')
		   		        			}
			        			}
			        			else {
			        				Swal.fire(
			        				  'Ooops',
			        				  response.message,
			        				  'error'
			        				)
			        			}
   		        			}
		        	    }
		        	});
		        }
		    });
		}
	</script>
@endsection
