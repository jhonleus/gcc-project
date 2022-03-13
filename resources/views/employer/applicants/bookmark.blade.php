@extends('layouts.header')

@section('title', 'Saved Applicant')

@section('content')
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/css/datetime/jquery.datetimepicker.min.css') }}">
	<script src="{{ asset('resources/js/datetime/jquery.datetimepicker.js') }}"></script>
	<!--CKEDITOR-->
    <script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>

	<div class="container page-container">
		@if(!$isSubscriptionEnded) 
			<div class="alert alerts alert-warning" role="alert">
				Your subscription has been ended, renew your subscription <a href="{{ url('pricing') }}">here</a>!
			</div>
		@else
			@if($canSavedApplicant < 1)
				<div class="alert alerts alert-warning" role="alert">
					Your subscription has no saved applicant features, upgrade your subscription <a href="{{ url('pricing') }}">here</a>!
				</div>
			@endif
		@endif
		
		<div class="row">
			<div class="col-sm-3">
				@include('employer.sidebar.profile')
				@include('employer.sidebar.index')
			</div>

			<div class="col-sm-9">
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

				@foreach($users as $key => $user)
				<div class="card page-contents">
					<div class="card-body page-content-body">
						<div class="content-header-2">
							<div class="row">
								<div class="col-sm-9">
									@if($canViewProfile > 0)
										<a href="{{url("subscriber/applicants/".$user->applicant->id) }}" class="content-title" target="_blank"> 
											{{ $user->applicant ? $user->applicant->firstName : ""}} {{ $user->applicant ? $user->applicant->lastName : "" }}
										</a>
									@else
										<label class="content-title"> 
											{{ $user->applicant ? $user->applicant->firstName : ""}} {{ $user->applicant ? $user->applicant->lastName : "" }}
										</label>
									@endif

									@if($canSendEmail > 0)
										<label class="job-action send-invitation-button rowEmail{{$key}}" name="{{ $user->applicant ? $user->applicant->firstName : ""}} {{ $user->applicant ? $user->applicant->lastName : "" }}" email="{{ $user->applicant ? $user->applicant->email : ""}}" rowEmail="{{$key}}" id="{{ $user->applicant->id }}">
											Send Email
										</label>
									@endif
								</div>

								@if($canSavedApplicant > 0)
									<div class="col-sm-3">
										<p class="applicant-forms-right">
											<label class="applicant-buttons-saved rowSaved{{$key}} saved-applicant"  id="{{$user->applicantId}}" rowSaved="{{$key}}">
												<i class="fa fa-bookmark" aria-hidden="true"></i>
											</label>
				                        </p>
									</div> 
								@endif
							</div>
						</div>

						<div class="row">
							<div class="col-sm-9">
								<label class="content-details">
									<i class="fa fa-phone-square" aria-hidden="true"></i>
									+{{$user->contact ? $user->contacts->country->phonecode : ""}} {{$user->contacts ? $user->contacts->number : ""}} 
								</label>

								<label class="content-details">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									{{$user->applicant ? $user->applicant->email : ""}}
								</label>

								<label class="content-details">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
									{{$user->address ? $user->address->street : ""}}, {{$user->address ? $user->address->city : ""}}, {{$user->address ? $user->address->country->getName() : ""}}
								</label>

								@if(!is_null($user->applicant))
									@if(!is_null($user->applicant->educations))
										@php
										 	$educations="";
										@endphp

										@foreach($user->applicant->educations as $educ)
											@php
												$education 	= $educ->attainment . " (".$educ->levels->name.")";
												$educations = $educations . $education . ", ";
											@endphp
										@endforeach
									@endif
								@endif

								@if(!$user->applicant->educations->isEmpty())
								<label class="content-details">
									<i class="fa fa-graduation-cap" aria-hidden="true">
									</i>
									{{rtrim($educations, ', ')}}
								</label>
								@endif

								@if(!is_null($user->documents))
									@foreach($user->documents as $document)
									@if($document->filetype==="resume")
									<label class="content-details">
										<i class="fa fa-file-text label-black" aria-hidden="true"></i>
										<a href="{{ url($document->path . $document->filename)}}">
											{{ $user->applicant->firstName }}.{{ $user->applicant->lastName }}-RESUME
										</a>
									</label>
									@endif
									@endforeach
								@endif

								@if(!is_null($user->applicant))
									@if(!is_null($user->applicant->certificates()))
										@php
										 	$certificates="";
										@endphp

										@foreach($user->applicant->certificates() as $certificate)
											@php
												$certificate 	= "<a href='".url($certificate->path.$certificate->filename)."'>".$certificate->filename."</a>";
												$certificates 	= $certificates . $certificate . ", ";
											@endphp
										@endforeach
									@endif
								@endif

								@if(!$user->applicant->certificates()->isEmpty())
								<label class="content-details">
									<i class="fa fa-certificate" aria-hidden="true"></i>
									{!!rtrim($certificates, ', ')!!}
								</label>
								@endif

								@if(!is_null($user->applicant))
									@if(!is_null($user->applicant->tattoos()))
										@php
										 	$tattoos="";
										@endphp

										@foreach($user->applicant->tattoos() as $tattoo)
											@php
												$tattoo 	= "<a href='".url($tattoo->path.$tattoo->filename."'>".$tattoo->filename)."</a>";
												$tattoos 	= $tattoos . $tattoo . ", ";
											@endphp
										@endforeach
									@endif
								@endif

								@if(!$user->applicant->tattoos()->isEmpty())
								<label class="content-details">
									<i class="fa fa-pencil-square" aria-hidden="true"></i>
									{!!rtrim($tattoos, ', ')!!}
								</label>
								@endif
							</div>

							<div class="col-sm-3">
								@foreach($user->documents as $document)
									@if($document->filetype==="profile")
										<img class="content-image" src="{{ url($document->path . $document->filename)}}">
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
				@endforeach

				<div class="mt-2">
					{{ $users->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>

		@if($canSendEmail > 0)
			<div id="warning-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-for-actions modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<div class="status-box confirmation-label">
								<i class="material-icons fa fa-envelope"></i>
							</div>				
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-sm-8">
									<label class="label-select">
										Note: Use [application_name] to include job name.
										<br>
										Use [application_date] to include scheduled date.
										<br>
										Use [application_time] to include scheduled time.
									</label>

									<div class="contents-form">
										<label class="label-select">
											Job Name
										</label>

										<select class="select" name="job_id" id="job_id">
											<option selected hidden disabled></option>
											@foreach($jobs as $job)
											<option value="{{$job->id}}">{{ $job->title }}</option>
											@endforeach
										</select>

										<div class="error-container">
											<label class="label-error error-job_id"></label>
										</div>
									</div>

									<div class="contents-form contents-form-1">
										<label class="label-select">
											{{ App\MaintenanceLocale::getLocale(368) }}:
										</label>

										<input class="input" id="subject" name="subject">

										<div class="error-container">
											<label class="label-error error-subject">{{ App\MaintenanceLocale::getLocale(356) }}.</label>
										</div>
									</div>

									<div class="contents-form contents-form-1">
										<label class="label-select">
											{{ App\MaintenanceLocale::getLocale(259) }}:
										</label>

										<div class="ckeditor-message">
											<textarea class="txtarea" id="message" name="message"></textarea>
										</div>

										<div class="error-container">
											<label class="label-error error-message">{{ App\MaintenanceLocale::getLocale(369) }}.</label>
										</div>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="contents-form">
										<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(387) }}:</h1>

										<div id="select-date"></div>
									
										<div class="error-container">
											<label class="label-error error-date">{{ $message['ER:00:70'] }}</label>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn label-button btn-secondary close-button" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
						</div>
					</div>
				</div>
			</div>
		@endif
		<input type="hidden" name="date" id="date">
	</div>

	<script>
		$(document).ready(function(){
			$("#saved-list").removeClass("sidebar-list-title");
			$("#saved-list").addClass("sidebar-list-title-active");
		});

		@if($canSendEmail > 0)
			CKEDITOR.replace("message");
			CKEDITOR.config.toolbar = [
	            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
	        ];

			$(".send-invitation-button").click(function() {
				@if($errors->any()) 
				var rowEmail = "{{ old('rowEmail') }}";
				@else
				var rowEmail = $(this).attr("rowEmail");
				@endif
					id 			= $(".rowEmail"+rowEmail).attr("id");
					name 		= $(".rowEmail"+rowEmail).attr("name");
					email 		= $(".rowEmail"+rowEmail).attr("email");

				$("#warning-modal").modal('show');
				$(".close-button").after(send_invitation(id, name, email, rowEmail));
			});

			function send_invitation(id, name, email, rowEmail) {
			    return $('<button/>', {
			        text: 	'Send',
			        type: 	'button',
			        id: 	'send-email-button',
			        class: 	'btn label-button btn-chinese send-email-button',
			        click: function() {
			       	 	subject = $("#subject").val();
			       		message	= CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;

			       		date 	= $("#date").val();
			       		now 	= new Date();
			       		date_ 	= new Date(date);

						job_id 	= $("#job_id").val();

			        	if(!message || subject==="" || subject===null || date_ < now || date_===null || date_==="" || job_id===null || job_id==="") {

			        		if(subject==="" || subject==="") {
			        			$(".error-subject").show();				
			        			$(".error-subject").html("{{ $message['ER:00:65'] }}");				
			        			$("#subject").css("border", "1px solid red");
			        		}

			        		if(job_id==="" || job_id===null) {
			        			$(".error-job_id").show();				
			        			$(".error-job_id").html("{{ $message['ER:00:78'] }}");				
			        			$("#job_id").css("border", "1px solid red");
			        		}

			        		if(!message) {
			        			$(".error-message").show();				
			        			$(".error-message").html("{{ $message['ER:00:67'] }}");				
			        			$(".ckeditor-message").css("border", "1px solid red");
			        		}

		        			if(date_===null || date_==="" || date_ < now) {
			        			if(date_===null || date_==="") {
			        				$(".error-date").show();				
			        				$(".error-date").html("{{ $message['ER:00:69'] }}");				
			        			}
			        			else {
			        		    	$(".error-date").show();
			        		    	$(".error-date").html("{{ $message['ER:00:70'] }}");
			        		    }
			        		}
			        	}
			        	else {
			        		$(".send-email-button").remove();
		    		       	$("#warning-modal").modal('hide');

							basePath = window.location.origin;
				        	$.ajax({
				        		headers: {
				        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
				        		},
				        	    type : "POST",
				        	    url  : `${basePath}/subscriber/send_invitation`,
				        	    dataType : "json",
				        	    data : {
				        	       	applicant_id 	: 	id,
				        	       	applicant_name 	: 	name,
				        	       	applicant_email	: 	email,
				        	       	subject 		: 	subject,
				        	       	message 		: 	message,
				        	       	rowEmail 		: 	rowEmail,
				        	       	date 			: 	date,
				        	       	job_id 			: 	job_id,
				        	    },
				        	    success: function(response) {
				        			if (response.result === true) {
	       								Swal.fire(response.message, '', 'success')
	       		        			}
	       		        			else {
	       		        				msg = response.message;

	       		        				if(msg['subject']!==undefined || msg['message']!==undefined || msg['date']!==undefined || msg['job_id']!==undefined) {
	       		        					$(".send-invitation-button").click();

	       		        					if(msg['subject']!==undefined) {
	       		        						if(msg['subject'][0].match(/required/)) {
	       		        							$(".error-subject").show();
	       		        							$(".error-subject").html("{{ $message['ER:00:65'] }}");
	       		        							$("#subject").css("border", "1px solid red");
	       		        						}
	       		        						else {
	       		        							$(".error-subject").show();
	       		        							$(".error-subject").html("{{ $message['ER:00:66'] }}");
	       		        							$("#subject").css("border", "1px solid red");
	       		        						}
		       		        				}

	       		        					if(msg['message']!==undefined) {
	       		        						if(msg['message'][0].match(/required/)) {
		       		        						$(".error-message").show();
		       		        						$(".error-message").html("{{ $message['ER:00:67'] }}");
		       		        						$(".ckeditor-message").css("border", "1px solid red");
		       		        					}
	       		        					}

	       		        					if(msg['date']!==undefined) {
	       		        						if(msg['date'][0].match(/required/)) {
		       		        						$(".error-date").show();
			        								$(".error-date").html("{{ $message['ER:00:69'] }}");				
		       		        					}
		       		        					else {
		       		        						$(".error-date").show();
		       		        						$(".error-date").html("{{ $message['ER:00:70'] }}");
		       		        					}
	       		        					}

	       		        					if(msg['job_id']!==undefined) {
	       		        						if(msg['job_id'][0].match(/required/)) {
	       		        							$(".error-job_id").show();
	       		        							$(".error-job_id").html("{{ $message['ER:00:78'] }}");
	       		        							$("#job_id").css("border", "1px solid red");
	       		        						}
	       		        						else {
	       		        							$(".error-job_id").show();
	       		        							$(".error-job_id").html("{{ $message['ER:00:79'] }}");
	       		        							$("#job_id").css("border", "1px solid red");
	       		        						}
		       		        				}
	       		        				}
	       		        				else if(msg['applicant_id']!==undefined) {
				        					if(msg['applicant_id'][0].match(/required/)) {
				   		        				Swal.fire('Ooops', "{{ $message['ER:00:97'] }}", 'error')
				   		        			}
				   		        			else {
				   		        				Swal.fire('Ooops', "{{ $message['ER:00:98'] }}", 'error')
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
				   		        				Swal.fire('Ooops', "Applicant's {{ $message['ER:00:33'] }}", 'error')
				   		        			}
				   		        			else {
				   		        				Swal.fire('Ooops', "Applicant's {{ $message['ER:00:34'] }}", 'error')
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

			CKEDITOR.instances.message.on('change', function () { 
		    	var length 	= CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;

		        if(!length) {
					$(".error-message").show();
					$(".error-message").html("{{ $message['ER:00:67'] }}");
					$(".ckeditor-message").css('border', '1px solid red');
		        }
		        else {
					$(".error-message").hide();
					$(".ckeditor-message").css('border', '');
		        }
		    });

		    $("#subject").keyup(function() {
				value 		= $(this).val();

		        if(value==="" || value===null) {
		    		$(".error-subject").show();
		    		$(".error-subject").html("{{ $message['ER:00:65'] }}");
					$("#subject").css('border', '1px solid red');
		        } 
		        else {
		    		$(".error-subject").hide();
					$("#subject").css('border', '');
		        }
			})

			$("#job_id").change(function() {
				value 		= $(this).val();

	    		$(".error-job_id").hide();
				$(this).css('border', '');
			});

			$('#select-date').datetimepicker({
				viewMode: 'YMDHMS',
				onDateChange: function() {
					var now 			= new Date();
				    	date_format 	= this.getText("yyyy-MM-dd hh:mm:ss");
				    	proper_format 	= this.getValue();

				    if (proper_format < now) {
				    	$(".error-date").show();
				    	$(".error-date").html("{{ $message['ER:00:70'] }}");
				    }
				    else {
				   		$(".error-date").hide();
				    }

				    $("#date").val(date_format);
				},
			});
		@endif

		@if($canSavedApplicant > 0)
			$(".saved-applicant").click(function() {
				var id 			= $(this).attr("id");
					rowSaved 	= $(this).attr("rowSaved");

				if($(this).hasClass("applicant-buttons-saved")) {
					status = "unsaved";
				}
				else {
					status = "save";
				}

				Swal.fire({
					title: "Do want to " + status + " this applicant?",
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
	    	        	    url  : `${basePath}/subscriber/saved_applicant`,
	    	        	    dataType : "json",
	    	        	    data : {
	    	        	        id			: id,
	    	        	        rowSaved 	: rowSaved
	    	        	    },
	    	        	    success: function(response) {
	    	        			if (response.result === true) {
	    	        				Swal.fire(
	    								  response.message,
	    								  '',
	    								  'success'
	    								).then(function(){ 
	    								if($(".rowSaved"+response.applicantId).hasClass("applicant-buttons-saved")) {
	    									$(".rowSaved"+response.applicantId).addClass('applicant-buttons')
	    									$(".rowSaved"+response.applicantId).removeClass('applicant-buttons-saved')
	    								}
	    								else {
	    									$(".rowSaved"+response.applicantId).addClass('applicant-buttons-saved')
	    									$(".rowSaved"+response.applicantId).removeClass('applicant-buttons')
	    								}
	    							});
	    	        			}
	    	        			else {
	    	    					Swal.fire(
	    							  	'Ooops',
	    							  	msg,
	    							  	'error'
	    							)
	    	        			}
	    	        	    }
	    	        	});
					}
				})
			});
		@endif
	</script>
@endsection
