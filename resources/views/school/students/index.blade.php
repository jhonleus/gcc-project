@extends('layouts.header')

@section('title', 'Students')

@section('content')
	<!-- DATETIME PICKER JQUERY -->
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/css/datetime/jquery.datetimepicker.min.css') }}">
	<script src="{{ asset('resources/js/datetime/jquery.datetimepicker.js') }}"></script>
	<!--CKEDITOR-->
	<script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>

	<div class="container page-container">
		@include('flash-message')
		<div class="row">
			<div class="col-sm-3">
				@include('school.sidebar.profile')
				@include('school.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card page-title">
					<ul class="nav nav-tabs" data-tabs="tabs">
						<li class="nav-item">
							<a class="nav-link active" href="#pending" data-toggle="tab">Pending <span class="badge badge-light ml-2">{{$users->total()}}</span></a>
						</li>

						<!--
						<li class="nav-item">
							<a class="nav-link" href="#approves" data-toggle="tab">For Interview <span class="badge badge-light ml-2">{{$approves->total()}}</span></a>
						</li>
						-->

						<li class="nav-item">
							<a class="nav-link" href="#schedules" data-toggle="tab">Scheduled <span class="badge badge-light ml-2">{{$schedules->total()}}</span></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#rejected" data-toggle="tab">Rejected <span class="badge badge-light ml-2">{{$rejects->total()}}</span></a>
						</li>
					</ul>
				</div>

				<div class="tab-content">
					<div class="tab-pane active" id="pending">
						@php
							$currentDisplay = $users->currentPage() * $users->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($users->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $users->total() ? $currentDisplay : $users->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $users->total() }}</span> )
							</small>
						</div>

						@foreach($users as $user)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="content-header-1">
									<div class="row">
										<div class="col-sm-9">
											<label class="content-title"> 
												{{ $user->user->firstName }} {{ $user->user->lastName }}
											</label>
											<a href="{{url("courses/".Crypt::encrypt($user->course->id)) }}" class="content-actions">
												{{ $user->course->course }}
											</a>
										</div> 
										<div class="col-sm-3">
											@if($user->isActive==1)
											<p class="content-right">
												<label class="label-blue schedule-applicant" name="{{ $user->user->firstName }} {{ $user->user->lastName }}" email="{{$user->user->email}}" id="{{$user->id}}" course_name="{{ $user->course->course }}">
													<i class="fa fa-check-circle" aria-hidden="true"></i>
													Approve
												</label>

												<label class="premium-decline-applicant label-red" name="{{ $user->user->firstName }} {{ $user->user->lastName }}" email="{{$user->user->email}}" id="{{$user->id}}" course_name="{{ $user->course->course }}">
													<i class="fa fa-minus-circle" aria-hidden="true"></i>
													Decline
												</label>
					                        </p>
					                        @endif
										</div> 
									</div>
								</div>

								<div class="row">
									<div class="col-sm-9">
										<label class="content-details">
											<i class="fa fa-birthday-cake" aria-hidden="true"></i>
											{{date('F d Y', strtotime($user->detail->birthDate))}}
										</label>

										<label class="content-details">
											<i class="fa fa-venus-mars" aria-hidden="true"></i>
											{{$user->detail->genders->getName()}}
										</label>

										<label class="content-details">
											<i class="fa fa-phone-square" aria-hidden="true"></i>
											+{{$user->contact->codeId}} {{$user->contact->number}} 
										</label>

										<label class="content-details">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											{{$user->user->email}}
										</label>

										<label class="content-details">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											{{$user->address->street}}, {{$user->address->city}}, {{$user->address->country->getName()}}
										</label>

										<label class="content-details">
											<i class="fa fa-file" aria-hidden="true"></i>
											<a href="{{ url($user->path . $user->certificate)}}">
												Birth Certificate
											</a>
											,
											<a href="{{ url($user->path . $user->records) }}">
												Transcript of Records
											</a>
										</label>
									</div>

									<div class="col-sm-3">
										@foreach($user->documents as $file)
											@if($file->filetype==="profile")
												<img class="content-image" src="{{ url($file->path . $file->filename)}}">
											@endif
										@endforeach
									</div>
								</div>


								<div class="content-footer">
									<label class="label-date">APPLIED: {{ $user->created_at->diffForHumans() }}</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $users->appends(request()->except('page'))->onEachSide(1)->links() }}
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

						@foreach($approves as $user)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="content-header-1">
									<label class="content-title"> 
										{{ $user->user->firstName }} {{ $user->user->lastName }}
									</label>
									<a href="{{url("courses/".Crypt::encrypt($user->course->id)) }}" class="content-actions">
										{{ $user->course->course }}
									</a>
								</div>

								<div class="row">
									<div class="col-sm-9">
										<label class="content-details">
											<i class="fa fa-birthday-cake" aria-hidden="true"></i>
											{{date('F d Y', strtotime($user->detail->birthDate))}}
										</label>

										<label class="content-details">
											<i class="fa fa-venus-mars" aria-hidden="true"></i>
											{{$user->detail->genders->getName()}}
										</label>

										<label class="content-details">
											<i class="fa fa-phone-square" aria-hidden="true"></i>
											+{{$user->contact->codeId}} {{$user->contact->number}} 
										</label>

										<label class="content-details">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											{{$user->user->email}}
										</label>

										<label class="content-details">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											{{$user->address->street}}, {{$user->address->city}}, {{$user->address->country->getName()}}
										</label>

										<label class="content-details">
											<i class="fa fa-file" aria-hidden="true"></i>
											<a href="{{ url($user->path . $user->certificate)}}">
												Birth Certificate
											</a>
											,
											<a href="{{ url($user->path . $user->records) }}">
												Transcript of Records
											</a>
										</label>
									</div>

									<div class="col-sm-3">
										@foreach($user->documents as $file)
											@if($file->filetype==="profile")
												<img class="content-image" src="{{ url($file->path . $file->filename)}}">
											@endif
										@endforeach
									</div>
								</div>

								@if(!is_null($user->schedule_date))
								<div class="content-footer">
									<label class="label-date">APPOINTMENT: {{date('F d Y', strtotime($user->schedule_date))}}</label>
								</div>
								@endif
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $approves->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
                    </div>
                    <div class="tab-pane" id="schedules">
                    	@php
							$currentDisplay = $schedules->currentPage() * $schedules->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($schedules->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $schedules->total() ? $currentDisplay : $schedules->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $schedules->total() }}</span> )
							</small>
						</div>

						@foreach($schedules as $user)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="content-header-1">
									<div class="row">
										<div class="col-sm-8">
											<label class="content-title"> 
												{{ $user->user->firstName }} {{ $user->user->lastName }}
											</label>
											<a href="{{url("courses/".Crypt::encrypt($user->course->id)) }}" class="content-actions">
												{{ $user->course->course }}
											</a>
										</div> 
										<div class="col-sm-4">
											@if(!is_null($user->response))
												@if($user->response->isAccept==2)
													<div class="text-right">
														<span class="badge badge-warning" style="font-size:12px;color:white;">{{Helper::getDate($user->response->availability)}}</span>
													</div>
													<p class="content-right">
														<label class="label-orange schedule-applicant" name="{{ $user->user->firstName }} {{ $user->user->lastName }}" email="{{$user->user->email}}" id="{{$user->id}}" course_name="{{ $user->course->course }}">
															<i class="fa fa-check-circle" aria-hidden="true"></i>
															Reschedule
														</label>
							                        </p>
							                    @elseif($user->response->isAccept==1)
							                    <div class="text-right">
							                    	<span class="badge badge-success" style="font-size:12px;">GOING</span>
							                    </div>
							                    @elseif($user->response->isAccept==0)
							                    <div class="text-right">
							                    	<span class="badge badge-danger" style="font-size:12px;">NOT GOING</span>
							                    </div>
							                    @else
							                    <div class="text-right">
							                    	<span class="badge badge-primary" style="font-size:12px;">NO RESPONSE</span>
							                    </div>
							                    @endif
					                        @endif
										</div> 
									</div>
								</div>

								<div class="row">
									<div class="col-sm-9">
										<label class="content-details">
											<i class="fa fa-birthday-cake" aria-hidden="true"></i>
											{{date('F d Y', strtotime($user->detail->birthDate))}}
										</label>

										<label class="content-details">
											<i class="fa fa-venus-mars" aria-hidden="true"></i>
											{{$user->detail->genders->getName()}}
										</label>

										<label class="content-details">
											<i class="fa fa-phone-square" aria-hidden="true"></i>
											+{{$user->contact->codeId}} {{$user->contact->number}} 
										</label>

										<label class="content-details">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											{{$user->user->email}}
										</label>

										<label class="content-details">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											{{$user->address->street}}, {{$user->address->city}}, {{$user->address->country->getName()}}
										</label>

										<label class="content-details">
											<i class="fa fa-file" aria-hidden="true"></i>
											<a href="{{ url($user->path . $user->certificate)}}">
												Birth Certificate
											</a>
											,
											<a href="{{ url($user->path . $user->records) }}">
												Transcript of Records
											</a>
										</label>
									</div>

									<div class="col-sm-3">
										@foreach($user->documents as $file)
											@if($file->filetype==="profile")
												<img class="content-image" src="{{ url($file->path . $file->filename)}}">
											@endif
										@endforeach
									</div>
								</div>

								@if(!is_null($user->schedule_date))
								<div class="content-footer">
									<label class="label-date">APPOINTMENT: {{date('F d Y', strtotime($user->schedule_date))}}</label>
								</div>
								@endif
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $schedules->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
                    </div>
                    <div class="tab-pane" id="rejected">
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

                      	@foreach($rejects as $user)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="content-header-1">
									<label class="content-title"> 
										{{ $user->user->firstName }} {{ $user->user->lastName }}
									</label>
									<a href="{{url("courses/".Crypt::encrypt($user->course->id)) }})}}" class="content-actions">
										{{ $user->course->course }}
									</a>
								</div>

								<div class="row">
									<div class="col-sm-9">
										<label class="content-details">
											<i class="fa fa-birthday-cake" aria-hidden="true"></i>
											{{date('F d Y', strtotime($user->detail->birthDate))}}
										</label>

										<label class="content-details">
											<i class="fa fa-venus-mars" aria-hidden="true"></i>
											{{$user->detail->genders->getName()}}
										</label>

										<label class="content-details">
											<i class="fa fa-phone-square" aria-hidden="true"></i>
											+{{$user->contact->codeId}} {{$user->contact->number}} 
										</label>

										<label class="content-details">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											{{$user->user->email}}
										</label>

										<label class="content-details">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											{{$user->address->street}}, {{$user->address->city}}, {{$user->address->country->getName()}}
										</label>

										<label class="content-details">
											<i class="fa fa-file" aria-hidden="true"></i>
											<a href="{{ url($user->path . $user->certificate)}}">
												Birth Certificate
											</a>
											,
											<a href="{{ url($user->path . $user->records) }}">
												Transcript of Records
											</a>
										</label>
									</div>

									<div class="col-sm-3">
										@foreach($user->documents as $file)
											@if($file->filetype==="profile")
												<img class="content-image" src="{{ url($file->path . $file->filename)}}">
											@endif
										@endforeach
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
	</div>

	

	

	<div id="success-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-for-actions">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box success-label">
						<i class="material-icons fa fa-check"></i>
					</div>				
				</div>

				<div class="modal-body">
					<p class="label-2 f3">
						Successfully Declined
					</p>
				</div>

				<div class="modal-footer align-c">
					<button type="button" class="btn label-button btn-success btn-100 success-button">Okay</button>
				</div>
			</div>
		</div>
	</div>  

	<form method="POST" action="{{ route('school.approve')}}" id="form">
		@csrf
	<input type="hidden" class="course_name" name="course_name">
	<div class="modal" tabindex="-1" role="dialog" id="premium-approve-modal">
		<input type="hidden" class="name-modal" name="name-modal">
		<div class="modal-dialog modal-for-actions modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box bg-primary">
						<i class="material-icons fa fa-check"></i>
					</div>				
				</div>
				<input type="hidden" class="id-modal" name="id-modal">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-8">
							<div class="contents-form">
								<label class="label-select">
									Select template to send (select blank for custom message)
									<br>
									**use [application_name] to include course name**
									<br>
									**use [application_date] to include scheduled date**
									<br>
									**use [application_time] to include scheduled time**
								</label>

								<select class="select" name="subject" id="subject"> 
									<option></option>
									@foreach($templates as $template)
										<option value="{{$template->id}}" desc="{{$template->message}}">{{$template->subject}}</option>
									@endforeach
								</select>

								<div class="error-container">
									<label class="label-error error-subject">Template is required.</label>
								</div>
							</div>

							<div class="contents-form">
								<label class="label-select">
									Subject:
								</label>

								<input class="input" id="asubject" name="asubject">

								<div class="error-container">
									<label class="label-error error-asubject">Subject is required.</label>
								</div>
							</div>

							<div class="contents-form">
								<label class="label-select">
									Message:
								</label>

								<div class="ckeditor-amessage">
									<textarea class="txtarea" id="amessage" name="amessage"></textarea>
								</div>

								<div class="error-container">
									<label class="label-error error-amessage">Message is required.</label>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="contents-form">
								<h1 class="label-select">Datetime Schedule:</h1>

								<div id="select-date"></div>
							
								<div class="error-container">
									<label class="label-error error-date">Datetime is required.</label>
								</div>
							</div>
						</div>
					</div>

					<input type="hidden" class="email-modal" name="email-modal">
				</div>

				<div class="modal-footer">
					<button type="button" class="btn label-button btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn label-button btn-primary premium-approve-applicant">Send</button>
				</div>
				<input type="hidden" id="date" name="date">
			</div>
		</div>
	</div>
	</form>

	<div id="premium-decline-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<input type="hidden" class="course_name" name="course_name">
		<div class="modal-dialog modal-for-actions modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box confirmation-label">
						<i class="material-icons fa fa-remove"></i>
					</div>				
				</div>

				<div class="modal-body">
					<p class="label-2 f3">
						Are you sure you want to decline this student?
					</p>

					<div class="contents-form">
						<label class="label-select">
							Select template to send (select blank for custom message)
							<br>
							**use [application_name] to include course name**
						</label>

						<select class="select select-size-2" name="template_id" id="template_id"> 
							<option></option>
							@foreach($templates as $template)
								<option value="{{$template->id}}" desc="{{$template->message}}">{{$template->subject}}</option>
							@endforeach
						</select>

						<div class="error-container">
							<label class="label-error error-template">Template is required.</label>
						</div>
					</div>

					<div class="contents-form">
						<label class="label-select">
							Subject:
						</label>

						<input class="input" id="dsubject" name="dsubject">

						<div class="error-container">
							<label class="label-error error-dsubject">Subject is required.</label>
						</div>
					</div>

					<div class="contents-form">
						<label class="label-select">
							Message:
						</label>

						<div class="ckeditor-dmessage">
							<textarea class="txtarea" id="dmessage" name="dmessage"></textarea>
						</div>

						<div class="error-container">
							<label class="label-error error-dmessage">Message is required.</label>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn label-button btn-secondary close-button premium-close-button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div> 

	<!--
	<form method="POST" action="{{ route('school.approve2')}}" id="form">
		@csrf
	<div id="approve-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<input type="hidden" class="email-modal" name="email-modal">
		<input type="hidden" class="id-modal" name="id-modal">
		<input type="hidden" class="name-modal" name="name-modal">
		<input type="hidden" class="course_name" name="course_name">
		<div class="modal-dialog modal-for-actions modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box confirmation-label">
						<i class="material-icons fa fa-check"></i>
					</div>				
				</div>

				<div class="modal-body">
					<p class="label-2 f3">
						Are you sure you want to approve this student?
					</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn label-button btn-secondary close-button" data-dismiss="modal">Close</button>
					<button type="button" class="btn label-button btn-danger approve-button">Yes</button>
				</div>
			</div>
		</div>
	</div>
	</form>

	<div id="decline-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<input type="hidden" class="course_name" name="course_name">
		<div class="modal-dialog modal-for-actions modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box confirmation-label">
						<i class="material-icons fa fa-remove"></i>
					</div>				
				</div>

				<div class="modal-body">
					<p class="label-2 f3">
						Are you sure you want to decline this student?
					</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn label-button btn-secondary close-button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	-->

	<script> 
		$(document).ready(function(){
			$("#student-list").removeClass("sidebar-list-title");
			$("#student-list").addClass("sidebar-list-title-active");
		});
		

		$(".success-button").click(function() {
			$('#success-modal').modal('hide'); 
			window.location.reload();
		});

		$(".close-button").click(function() {
    		$(".premium-decline-button").remove();
    		$(".decline-button").remove();
		});

		

		CKEDITOR.replace("amessage");
		CKEDITOR.replace("dmessage");
		CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
        ];

		$(".schedule-applicant").click(function() {
			var name 		= $(this).attr("name");
				email 		= $(this).attr("email");
				id 			= $(this).attr("id");
				course_name = $(this).attr("course_name");

			$(".name-modal").val(name);
			$(".email-modal").val(email);
			$(".id-modal").val(id);
			$(".course_name").val(course_name);

			$('#premium-approve-modal').modal('show'); 
		});

		$('#select-date').datetimepicker({
			viewMode: 'YMDHMS',
			onDateChange: function() {
				var now 			= new Date();
			    	date_format 	= this.getText("yyyy-MM-dd hh:mm:ss");
			    	proper_format 	= this.getValue();

			    if (proper_format < now) {
			    	$(".error-date").show();
			    	$(".error-date").html("Datetime is passed date.");
			    }
			    else {
			   		$(".error-date").hide();
			    }

			    $("#date").val(date_format);
			},
		});

		$("#asubject").keyup(function() {
			value 		= $(this).val();

	        if(value==="" || value===null) {
	    		$(".error-asubject").show();
				$("#asubject").css('border', '1px solid red');
	        } 
	        else {
	    		$(".error-asubject").hide();
				$("#asubject").css('border', '');
	        }
		});

		$('#subject').change(function() {
	        var length 	= $(this).val();
	         	desc 	= $("#subject option:selected").attr('desc');
				subject = $("#subject option:selected").html();

	    	$("#asubject").val(subject);
	        CKEDITOR.instances.amessage.setData(desc);

	        if(length==="" || length===null) {
	    		$(".error-asubject").show();
				$("#asubject").css('border', '1px solid red');

		    	$(".error-amessage").show();
				$(".ckeditor-amessage").css('border', '1px solid red');
	        }
	        else {
		    	$(".error-asubject").hide();
				$("#asubject").css('border', '');
	        }
	    });

	    CKEDITOR.instances.amessage.on('change', function () { 
			var length 	= CKEDITOR.instances['amessage'].getData().replace(/<[^>]*>/gi, '').length;

			if(!length) {
				$(".error-amessage").show();
				$(".ckeditor-amessage").css('border', '1px solid red');
			}
			else {
				$(".error-amessage").hide();
				$(".ckeditor-amessage").css('border', '');
			}
		});

        $(".premium-approve-applicant").click(function(e) {
			$(".error-label").hide();	

			var subject = $("#subject").val();
			 	asubject = $("#asubject").val();
				amessage	= CKEDITOR.instances['amessage'].getData().replace(/<[^>]*>/gi, '').length;
				name 	= $(".name-modal").val();
				email 	= $(".email-modal").val();
				id 		= $(".id-modal").val();
				date_ 	= $("#date").val();
				now 	= new Date();


			if(!amessage || asubject==="" || asubject===null || name===null || name==="" || email===null || email==="" || id===null || id==="" || date_ < now) {

				e.preventDefault();
				if(asubject==="" || asubject==="") {
					$(".error-asubject").show();				
					$("#asubject").css("border", "1px solid red");
				}

				if(!amessage) {
					$(".error-amessage").show();				
					$(".ckeditor-amessage").css("border", "1px solid red");
				}

				if(date_===null || date_==="") {
					$(".error-date").show();				
				}

				if (date_ < now) {
			    	$(".error-date").show();
			    	$(".error-date").html("Datetime is passed date.");
			    }
			}
		    else {
		  		document.getElementById("form").submit();
		    }
		});

		$(".premium-decline-applicant").click(function() {
			var name 		= $(this).attr("name");
				email 		= $(this).attr("email");
				id 			= $(this).attr("id");
				course_name = $(this).attr("course_name");
				
			$('#premium-decline-modal').modal('show'); 
			$(".premium-close-button").after(premium_decline_applicant(name, email, id, course_name));
		});

		$("#dsubject").keyup(function() {
			value 		= $(this).val();

	        if(value==="" || value===null) {
	    		$(".error-dsubject").show();
				$("#dsubject").css('border', '1px solid red');
	        } 
	        else {
	    		$(".error-dsubject").hide();
				$("#dsubject").css('border', '');
	        }
		});

		CKEDITOR.instances.dmessage.on('change', function () { 
			var length 	= CKEDITOR.instances['dmessage'].getData().replace(/<[^>]*>/gi, '').length;

			if(!length) {
				$(".error-dmessage").show();
				$(".ckeditor-dmessage").css('border', '1px solid red');
			}
			else {
				$(".error-dmessage").hide();
				$(".ckeditor-dmessage").css('border', '');
			}
		});

		function premium_decline_applicant(name, email, id, course_name) {
		    return $('<button/>', {
		        text: 	'Decline',
		        id: 	'premium-decline-button',
		        class: 	'btn label-button btn-danger premium-decline-button',
		        click: function() {
    		       	dsubject 	= $("#dsubject").val();
		        	template_id = $("#template_id").val();
		        	length		= CKEDITOR.instances['dmessage'].getData().replace(/<[^>]*>/gi, '').length;
		        	dmessage		= CKEDITOR.instances['dmessage'].getData();

		        	if(!length || subject==="") {

		        		if(subject==="") {
		        			$(".error-dsubject").show();
		        			$("#dsubject").css("border", "1px solid red");
		        		}

		        		if(!length) {
		        			$(".error-dmessage").show();
		        			$(".ckeditor-dmessage").css("border", "1px solid red");
		        		}
		        	} 
		        	else {
		        		$(".premium-decline-button").remove();
	    		       	$("#premium-decline-modal").modal('hide');

						basePath = window.location.origin;
			        	$.ajax({
			        		headers: {
			        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
			        		},
			        	    type : "POST",
			        	    url  : `${basePath}/school/reject`,
			        	    dataType : "json",
			        	    data : {
			        	        applicant_name	: 	name,
			        	        applicant_email	: 	email,
			        	        application_id	: 	id,
			        	        template_id		: 	template_id,
			        	        course_name		: 	course_name,
			        	        dmessage		: 	dmessage,
			        	        dsubject		: 	dsubject
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
       		        				msg = response.message;

       								if(msg['dsubject']!==undefined || msg['dmessage']!==undefined) {

	    		       					$(".premium-decline-applicant").click();
       		        					if(msg['dsubject']!==undefined) {
       		        						if(msg['dsubject'][0].match(/required/)) {
       		        							$(".error-dsubject").show();
       		        							$(".error-dsubject").html("{{ $message['ER:00:65'] }}");
       		        							$("#dsubject").css("border", "1px solid red");
       		        						}
       		        						else {
       		        							$(".error-dsubject").show();
       		        							$(".error-dsubject").html("{{ $message['ER:00:66'] }}");
       		        							$("#dsubject").css("border", "1px solid red");
       		        						}
	       		        				}

       		        					if(msg['dmessage']!==undefined) {
       		        						if(msg['dmessage'][0].match(/required/)) {
	       		        						$(".error-dmessage").show();
	       		        						$(".error-dmessage").html("{{ $message['ER:00:67'] }}");
	       		        						$(".ckeditor-dmessage").css("border", "1px solid red");
	       		        					}
       		        					}
       		        				}
       		        				else if(msg['application_id']!==undefined) {
			   		        			if(msg['application_id'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:61'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:62'] }}", 'error')
			   		        			}
			        				}
			        				else if(msg['applicant_name']!==undefined) {
			        					if(msg['applicant_name'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:63'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:64'] }}", 'error')
			   		        			}
			        				}
			        				else if(msg['applicant_email']!==undefined) {
			        					if(msg['applicant_email'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "applicant's {{ $message['ER:00:33'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "applicant's {{ $message['ER:00:34'] }}", 'error')
			   		        			}
			        				}
			        				else if(msg['course_name']!==undefined) {
			        					if(msg['course_name'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "applicant's {{ $message['ER:00:00'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "applicant's {{ $message['ER:00:01'] }}", 'error')
			   		        			}
			        				}
					        		else {
			     						Swal.fire('Ooops', msg, 'error')
			     					}
       		        			}
			        	    }
			        	});
		        	}
		        }
		    });
		}

		$("#template_id").change(function() {
			value 	= $(this).val();
			desc 	= $("#template_id option:selected").attr('desc');
			subject = $("#template_id option:selected").html();

	        CKEDITOR.instances.dmessage.setData(desc);
	    	$("#dsubject").val(subject);

	        if(value==="" || value===null) {
	    		$(".error-dsubject").show();
				$("#dsubject").css('border', '1px solid red');

		    	$(".error-dmessage").show();
				$(".ckeditor-dmessage").css('border', '1px solid red');
	        }
	        else {
	    		$(".error-dsubject").hide();
				$("#dsubject").css('border', '');
	        }
		})

		/*
		$(".approve-applicant").click(function() {
			var name 		= $(this).attr("name");
				email 		= $(this).attr("email");
				id 			= $(this).attr("id");
				course_name = $(this).attr("course_name");

			$(".name-modal").val(name);
			$(".email-modal").val(email);
			$(".id-modal").val(id);
			$(".course_name").val(course_name);

			$('#approve-modal').modal('show'); 
		});

		$(".approve-button").click(function(e) {
			$('#approve-modal').modal('hide'); 
		  	document.getElementById("form").submit();
		});

		$(".decline-applicant").click(function() {
			var name 		= $(this).attr("name");
				email 		= $(this).attr("email");
				id 			= $(this).attr("id");
				course_name = $(this).attr("course_name");
				
			$('#decline-modal').modal('show'); 
			$(".close-button").after(decline_student(name, email, id, course_name));
		});

		function decline_student(name, email, id, course_name) {
		    return $('<button/>', {
		        text: 	'Decline',
		        id: 	'decline-button',
		        class: 	'btn label-button btn-danger decline-button',
		        click: function() {
	        		$(".decline-button").remove();
    		       	$("#decline-modal").modal('hide');

					basePath = window.location.origin;
		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    type : "POST",
		        	    url  : `${basePath}/school/reject2`,
		        	    dataType : "json",
		        	    data : {
		        	        applicant_name		: 	name,
		        	        applicant_email		: 	email,
		        	        application_id		: 	id,
		        	        course_name	: 	course_name
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
   								msg = response.message;
   								
		   		        		if(msg['application_id']!==undefined) {
		   		        			if(msg['application_id'][0].match(/required/)) {
		   		        				Swal.fire('Ooops', "{{ $message['ER:00:61'] }}", 'error')
		   		        			}
		   		        			else {
		   		        				Swal.fire('Ooops', "{{ $message['ER:00:62'] }}", 'error')
		   		        			}
		        				}	
		        				else if(msg['applicant_name']!==undefined) {
		        					if(msg['applicant_name'][0].match(/required/)) {
		   		        				Swal.fire('Ooops', "{{ $message['ER:00:63'] }}", 'error')
		   		        			}
		   		        			else {
		   		        				Swal.fire('Ooops', "{{ $message['ER:00:64'] }}", 'error')
		   		        			}
		        				}
		        				else if(msg['applicant_email']!==undefined) {
		        					if(msg['applicant_email'][0].match(/required/)) {
		   		        				Swal.fire('Ooops', "applicant's {{ $message['ER:00:33'] }}", 'error')
		   		        			}
		   		        			else {
		   		        				Swal.fire('Ooops', "applicant's {{ $message['ER:00:34'] }}", 'error')
		   		        			}
		        				}
		        				else if(msg['course_name']!==undefined) {
		        					if(msg['course_name'][0].match(/required/)) {
		   		        				Swal.fire('Ooops', "applicant's {{ $message['ER:00:00'] }}", 'error')
		   		        			}
		   		        			else {
		   		        				Swal.fire('Ooops', "applicant's {{ $message['ER:00:01'] }}", 'error')
		   		        			}
		        				}
		        				else {
		        					Swal.fire('Ooops', msg, 'error')
		        				}
   		        			}
		        	    }
		        	});
		        }
		    });
		}
		*/










	</script>
@endsection
