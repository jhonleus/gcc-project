@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(429))

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
							<a class="nav-link active" href="#interview" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(550) }} <span class="badge badge-light ml-2">{{ $courses->total() }}</span></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#approves" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(273) }} <span class="badge badge-light ml-2">{{ $approves->total() }}</span></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#pending" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(272) }} <span class="badge badge-light ml-2">{{ $pending->total() }}</span></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#rejects" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(274) }} <span class="badge badge-light ml-2">{{ $rejects->total() }}</span></a>
						</li>
					</ul>
				</div>

				<div class="tab-content" style="margin-top: 10px;">
					<div class="tab-pane active" id="interview">
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

						@foreach($courses as $profile)
						<div class="card profile-content">
							<div class="card-body profile-body">
								<div class="row">
									<div class="col-sm-2 text-center"> 
										<h1 class="display-4">
											<span class="badge badge-secondary">{{date("d", strtotime($profile->schedule_date))}}</span>
										</h1>
										<h2 class="profile-title-2">{{date("M", strtotime($profile->schedule_date))}}</h2>
									</div>
									<div class="col-sm-10"> 
										<div class="row">
											<div class="col-sm-8">
												<a href="{{ url('courses/'.Crypt::encrypt($profile->courseId)) }}" class="profile-title" target="_blank"><strong>{{$profile->course ? $profile->course->course : ""}}</strong></a>
												<a href="{{ url('school/'.Crypt::encrypt($profile->companyId)) }}" class="profile-subtitle" target="_blank">{{$profile->course ? $profile->course->course : ""}}</a>
											</div>
											<div class="col-sm-4">
											@if($profile->response->isAccept==3)
												<p class="profile-actions">
													<label class="approve-profile profile-blue" data-id="{{$profile->id}}">
														<i class="fa fa-check-circle" aria-hidden="true"></i> 
														{{ App\MaintenanceLocale::getLocale(76) }}
													</label>

													<label class="reschedule-profile profile-orange row{{$profile->id}}" data-id="{{$profile->id}}" row="{{$profile->id}}">
														<i class="fa fa-check-circle" aria-hidden="true"></i> 
														{{ App\MaintenanceLocale::getLocale(383) }}
													</label>

													<label class="reject-profile profile-red" data-id="{{$profile->id}}">
														<i class="fa fa-trash" aria-hidden="true"></i> 
														{{ App\MaintenanceLocale::getLocale(243) }}
													</label>
						                        </p>
						                    @elseif($profile->response->isAccept==1)
						                    	<div class="text-right">
						                        	<span class="badge badge-success text-uppercase" style="font-size:12px;">{{ App\MaintenanceLocale::getLocale(380) }}</span>
						                        </div>
					                        @elseif($profile->response->isAccept==0)
						                        <div class="text-right">
						                        	<span class="badge badge-danger text-uppercase" style="font-size:12px;">{{ App\MaintenanceLocale::getLocale(274) }}</span>
						                        </div>
					                        @else
						                        <div class="text-right">
						                        	<span class="badge badge-info text-uppercase" style="font-size:12px;">{{ App\MaintenanceLocale::getLocale(383) }}</span>
						                        </div>
											@endif
											</div> 
										</div>
										<ul class="list-inline">
										    <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> {{date("l", strtotime($profile->schedule_date))}}</li>
											<li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ Helper::getTime($profile->schedule_date) }}</li>
											<li class="list-inline-item"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $profile->address ? $profile->address->street ? $profile->address->street : '' : '' }} {{ $profile->address ? $profile->address->city ? $profile->address->city . ',' : '' : '' }} {{ $profile->address ? $profile->address->zipcode ? $profile->address->zipcode : '' : '' }}</li>
										</ul>
										<div class="description">{!!$profile->message!!}</div>
									</div>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $courses->appends(request()->except('page'))->onEachSide(1)->links() }}
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

						@foreach($approves as $profile)
						<div class="card profile-content">
							<div class="card-body profile-body">
								<div class="profile-header">
									<a href="{{ url('courses/'.Crypt::encrypt($profile->courseId)) }}" class="profile-title-3" target="_blank">
										{{$profile->course ? $profile->course->course : ""}}
									</a>
									<a href="{{ url('school/'.Crypt::encrypt($profile->companyId)) }}" class="profile-school" target="_blank">
										{{ $profile->school->school }}
									</a>
								</div>
								<div class="row">
									<div class="col-sm-9">
										<label class="profile-details">
											<i class="fas fa-hourglass-start"></i>
											{{ date('F d, Y', strtotime($profile->course->class_start)) }}
										</label>

										<label class="profile-details">
											<i class="fa fa-hourglass-end" aria-hidden="true"></i>
											{{ date('F d, Y', strtotime($profile->course->class_end)) }} 
										</label>

										<label class="profile-details">
											<i class="fas fa-map-marker-alt"></i>
											{{ $profile->course->country->nicename }}
										</label>

										<label class="profile-details profile-money">
											<i class="fas fa-money profile-black"></i>
											{{ $profile->course->currency->name }}
											{{ $profile->course->fee }}
										</label>

										<label class="profile-details">
											@if(!is_null($profile->course->schedules))
											<i class="fa fa-calendar" aria-hidden="true"></i>
												@php
												 	$sheds="";
												@endphp
												@foreach($profile->course->schedules as $schedule)
													@php
														$scheds = $schedule->day . " - " . $schedule->time;

														$sheds = $sheds . $scheds . ", ";
													@endphp
												@endforeach
											@endif
											{{rtrim($sheds, ', ')}}
										</label>

										<label class="profile-description">
											{!!$profile->course->details!!}
										</label>
									</div>
									<div class="col-sm-3">
										@if(!is_null($profile->user->documents))
											@foreach($profile->user->documents as $file)
												@if($file->filetype==="profile")
													<img class="profile-image" src="{{ url($file->path . $file->filename)}}">
												@endif
											@endforeach
										@endif
									</div>
								</div>

								<div class="profile-footer">
									<label class="profile-label-posted">{{ App\MaintenanceLocale::getLocale(552) }}: {{ Helper::getDate($profile->created_at) }}</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $approves->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>

					<div class="tab-pane" id="pending">
						@php
							$currentDisplay = $pending->currentPage() * $pending->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($pending->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $pending->total() ? $currentDisplay : $pending->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $pending->total() }}</span> )
							</small>
						</div>
						
						@foreach($pending as $profile)
						<div class="card profile-content">
							<div class="card-body profile-body">
								<div class="profile-header">
									<a href="{{ url('courses/'.Crypt::encrypt($profile->courseId)) }}" class="profile-title-3" target="_blank">
										{{$profile->course ? $profile->course->course : ""}}
									</a>
									<a href="{{ url('school/'.Crypt::encrypt($profile->companyId)) }}" class="profile-school" target="_blank">
										{{ $profile->school->school }}
									</a>
								</div>
								<div class="row">
									<div class="col-sm-9">
										<label class="profile-details">
											<i class="fas fa-hourglass-start"></i>
											{{ date('F d, Y', strtotime($profile->course->class_start)) }}
										</label>

										<label class="profile-details">
											<i class="fa fa-hourglass-end" aria-hidden="true"></i>
											{{ date('F d, Y', strtotime($profile->course->class_end)) }} 
										</label>

										<label class="profile-details">
											<i class="fas fa-map-marker-alt"></i>
											{{ $profile->course->country->nicename }}
										</label>

										<label class="profile-details profile-money">
											<i class="fas fa-money profile-black"></i>
											{{ $profile->course->currency->name }}
											{{ $profile->course->fee }}
										</label>

										<label class="profile-details">
											@if(!is_null($profile->course->schedules))
											<i class="fa fa-calendar" aria-hidden="true"></i>
												@php
												 	$sheds="";
												@endphp
												@foreach($profile->course->schedules as $schedule)
													@php
														$scheds = $schedule->day . " - " . $schedule->time;

														$sheds = $sheds . $scheds . ", ";
													@endphp
												@endforeach
											@endif
											{{rtrim($sheds, ', ')}}
										</label>

										<label class="profile-description">
											{!!$profile->course->details!!}
										</label>
									</div>
									<div class="col-sm-3">
										@if(!is_null($profile->user->documents))
											@foreach($profile->user->documents as $file)
												@if($file->filetype==="profile")
													<img class="profile-image" src="{{ url($file->path . $file->filename)}}">
												@endif
											@endforeach
										@endif
									</div>
								</div>

								<div class="profile-footer">
									<label class="profile-label-posted">{{ App\MaintenanceLocale::getLocale(552) }}: {{ Helper::getDate($profile->created_at) }}</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $pending->appends(request()->except('page'))->onEachSide(1)->links() }}
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

						@foreach($rejects as $profile)
						<div class="card profile-content">
							<div class="card-body profile-body">
								<div class="profile-header">
									<a href="{{ url('courses/'.Crypt::encrypt($profile->courseId)) }}" class="profile-title-3" target="_blank">
										{{$profile->course ? $profile->course->course : ""}}
									</a>
									<a href="{{ url('school/'.Crypt::encrypt($profile->companyId)) }}" class="profile-school" target="_blank">
										{{ $profile->school->school }}
									</a>
								</div>
								<div class="row">
									<div class="col-sm-9">
										<label class="profile-details">
											<i class="fas fa-hourglass-start"></i>
											{{ date('F d, Y', strtotime($profile->course->class_start)) }}
										</label>

										<label class="profile-details">
											<i class="fa fa-hourglass-end" aria-hidden="true"></i>
											{{ date('F d, Y', strtotime($profile->course->class_end)) }} 
										</label>

										<label class="profile-details">
											<i class="fas fa-map-marker-alt"></i>
											{{ $profile->course->country->nicename }}
										</label>

										<label class="profile-details profile-money">
											<i class="fas fa-money profile-black"></i>
											{{ $profile->course->currency->name }}
											{{ $profile->course->fee }}
										</label>

										<label class="profile-details">
											@if(!is_null($profile->course->schedules))
											<i class="fa fa-calendar" aria-hidden="true"></i>
												@php
												 	$sheds="";
												@endphp
												@foreach($profile->course->schedules as $schedule)
													@php
														$scheds = $schedule->day . " - " . $schedule->time;

														$sheds = $sheds . $scheds . ", ";
													@endphp
												@endforeach
											@endif
											{{rtrim($sheds, ', ')}}
										</label>

										<label class="profile-description">
											{!!$profile->course->details!!}
										</label>
									</div>
									<div class="col-sm-3">
										@if(!is_null($profile->user->documents))
											@foreach($profile->user->documents as $file)
												@if($file->filetype==="profile")
													<img class="profile-image" src="{{ url($file->path . $file->filename)}}">
												@endif
											@endforeach
										@endif
									</div>
								</div>

								<div class="profile-footer">
									<label class="profile-label-posted">{{ App\MaintenanceLocale::getLocale(552) }}: {{ Helper::getDate($profile->created_at) }}</label>
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
							Are you sure you want to <font class="status_msg">accept</font> this course?
						</p>

						<br>

						<div class="profile-forms availability-forms">
							<h1 class="profile-label-select">{{ App\MaintenanceLocale::getLocale(553) }}:</h1>

							<div id="select-date"></div>
						
							<div class="error-container">
								<label class="label-error error-date">{{ $message['ER:01:22'] }}</label>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn profile-button btn-secondary close-button" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
					</div>
				</div>
			</div>
		</div> 

		<input type="hidden" id="date">
		<input type="hidden" id="proper_format">
	</div>

	<script>
		$(document).ready(function(){
			$("#courses-list").removeClass("profile-label-settings-content");
			$("#courses-list").addClass("profile-label-settings-content-active");
		});

		$('#select-date').datetimepicker({
			viewMode: 'YMDHMS',
			onDateChange: function() {
				var now 			= new Date();
			    	date_format 	= this.getText("yyyy-MM-dd hh:mm:ss");
			    	proper_format 	= this.getValue();

			    if (proper_format < now) {
			    	$(".error-date").show();
			    	$(".error-date").html("{{ $message['ER:01:23'] }}");
			    }
			    else {
			   		$(".error-date").hide();
			    }

			    $("#date").val(date_format);
			    $("#proper_format").val(proper_format);
			},
		});

		$(".close-button").click(function() {
    		$("#accept-profile").remove();
		});

		$(".reschedule-profile").click(function() {
			@if($errors->any()) 
			var row = "{{ old('row') }}";
			@else
			var row = $(this).attr("row");
			@endif

			var id 		= $(".row").data("id");
				status 	= 2;

			$(".availability-forms").show();
			$(".status_msg").html("request for reschedule for");
			$('#warning-modal').modal('show'); 
			$(".close-button").after(approve_profile(id, status, row));
		});

		$(".approve-profile").click(function() {
			var id 		= $(this).data("id");
				status 	= 1;

			$(".availability-forms").hide();
			$(".status_msg").html("approve");
			$('#warning-modal').modal('show'); 
			$(".close-button").after(approve_profile(id, status, 0));
		});

		$(".reject-profile").click(function() {
			var id 		= $(this).data("id");
				status 	= 0;

			$(".availability-forms").hide();
			$(".status_msg").html("reject");
			$('#warning-modal').modal('show'); 
			$(".close-button").after(approve_profile(id, status, 0));
		});

		function approve_profile(id, status, row) {
		    return $('<button/>', {
		        text: 	'Yes',
		        id: 	'accept-profile',
		        class: 	'btn profile-button btn-danger',
		        click: function() {
					var now 	= new Date();
			    		date 	= $("#date").val();
			    		proper_format 	=  new Date(date);

    		       	if(status==2 && proper_format < now) {
    		       		$(".error-date").show();
    		       		$(".error-date").html("{{ $message['ER:01:23'] }}");
    		       	}
    		       	else {
    		       		$("#warning-modal").modal('hide');
	        			$("#accept-profile").remove();

						basePath = window.location.origin;
			        	$.ajax({
			        		headers: {
			        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
			        		},
			        	    type : "POST",
			        	    url  : `${basePath}/applicant/accept_course`,
			        	    dataType : "json",
			        	    data : {
			        	        id 			: id,
			        	        status 		: status,
			        	        date 		: date,
			        	        row 		: row
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
			   		        				Swal.fire('Ooops', "{{ $message['ER:01:20'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "{{ $message['ER:01:21'] }}", 'error')
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
				        			else if(msg['date']!==undefined) {
				        				$(".reschedule-profile").click();
			        					
			        					if(msg['date'][0].match(/required/)) {
			   		        				$(".error-date").show();
			   		        				$(".error-date").html("{{ $message['ER:01:22'] }}");
			   		        			}
			   		        			else {
			   		        				$(".error-date").show();
			   		        				$(".error-date").html("{{ $message['ER:01:23'] }}");
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
		        }
		    });
		}
	</script>
@endsection
