@extends('layouts.header')

@section('title', 'Search Applicants')

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/search-applicant-page.css') }}">
	<!--CKEDITOR-->
	<script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>
	@if($canSendEmail > 0)
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/css/datetime/jquery.datetimepicker.min.css') }}">
	<script src="{{ asset('resources/js/datetime/jquery.datetimepicker.js') }}"></script>
	@endif

	<div class="container applicant-container">
		<div class="col-sm-12">
			<form method="POST" action="{{ url('subscriber/applicants/search') }}">
				@csrf
				<div class="card applicant-search-contents">
					<div class="card-header applicant-search-header">
						<label class="applicant-search-title">Search Criteria</label>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-sm-4">
								<div class="applicant-search-forms">
									<select class="select @if(isset($get_spe)) select-selected @endif" name="specialization">
										<option hidden disabled selected> 
											Specialization
										</option>
										<option></option>
										@foreach($specialization as $val)
										<option value="{{ $val->id }}" 
											@if(isset($get_spe))
												@if($get_spe==$val->id)
													selected
												@endif
											@endif>
											{{ $val->name }}</option>
										@endforeach
									</select> 
								</div>
							</div>

							<div class="col-sm-4">
								<div class="applicant-search-forms">
									<select class="select @if(isset($get_loc)) select-selected @endif" name="location">
										<option hidden disabled selected> 
											Location
										</option>
										<option></option>
										@foreach($country as $val)
										<option value="{{ $val->id }}" 
											@if(isset($get_loc))
												@if($get_loc==$val->id)
													selected
												@endif
											@endif>
											{{ $val->nicename }}</option>
										@endforeach
									</select> 
								</div>
							</div>

							<div class="col-sm-4">
								<div class="applicant-search-forms">
									<select class="select @if(isset($get_level)) select-selected @endif" name="level">
										<option hidden disabled selected> 
											Japanese Language Level 
										</option>
										<option></option>
										<option value="N1" 
											@if(isset($get_level))
												@if($get_level=="N1")
													selected
												@endif
											@endif>
											N1
										</option>
										<option value="N2" 
											@if(isset($get_level))
												@if($get_level=="N2")
													selected
												@endif
											@endif>
											N2
										</option>
										<option value="N3" 
											@if(isset($get_level))
												@if($get_level=="N3")
													selected
												@endif
											@endif>
											N3
										</option>
										<option value="N4" 
											@if(isset($get_level))
												@if($get_level=="N4")
													selected
												@endif
											@endif>
											N4
										</option>
										<option value="N5" 
											@if(isset($get_level))
												@if($get_level=="N5")
													selected
												@endif
											@endif>
											N5
										</option>
										<option value="Others" 
											@if(isset($get_level))
												@if($get_level=="Others")
													selected
												@endif
											@endif>
											Others
										</option>
									</select> 
								</div>
							</div>

							<div class="col-sm-4">
								<div class="applicant-search-forms">
									<select class="select @if(isset($get_title)) select-selected @endif" name="title">
										<option hidden disabled selected> 
											Type of Employment
										</option>
										<option></option>
										@foreach($types as $val)
										<option value="{{ $val->id }}" 
											@if(isset($get_title))
												@if($get_title==$val->id)
													selected
												@endif
											@endif>
											{{ $val->name }}</option>
										@endforeach
									</select> 
								</div>
							</div>

							<div class="col-sm-4">
								<div class="applicant-search-forms">
									<button class="btn btn-chinese applicant-search-button"> 
										Search
									</button>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="applicant-search-forms">
								    <a href="{{ url('subscriber/applicants') }}">
									<button type="button" class="btn btn-default applicant-search-button" name="clear_filter"> 
										Clear Filter
									</button>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="col-sm-12">
			@if(count($users) < 1)
				@if($search)
					<div class="row">
						<div class="col-sm-12">
							<div class="card job-contents">
								<div class="card-body job-body">
									<h4 style="margin::0px">Nothing here matches your search</h4>

									<hr>

									<p class="mt-2">Suggestions:</p>
									<ul>
										<li>Make sure all words are spelled correctly</li>
										<li>Try different keywords</li>
										<li>Try more general keywords</li>
									</ul>

								</div>
							</div>
						</div>
					</div>
				@else
					<div class="text-center">
		                <h2>Nothing to display!</h2>
		            </div>
				@endif
			@endif

			@if(count($users) >= 1)
				@php
		            $currentDisplay = $users->currentPage() * $users->perPage();
				@endphp
				
				<div class="text-right" style="margin-bottom: 10px;">
					<small class="form-text text-muted">
						Showing (
						<span id="start-page">{{ $currentDisplay - ($users->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $users->total() ? $currentDisplay : $users->total() }}</span>
						of
						<span id="total-blog">{{ $users->total() }}</span> )
					</small>
				</div>
			@endif
		</div>

		@foreach($users as $key => $user)
			<div class="col-sm-12">
				<div class="card applicant-contents-details">
					<div class="card-body applicant-body">
						<div class="row">
							<div class="col-sm-4">
								@if(!$user->documents->isEmpty())
									@foreach($user->documents as $doc)
										@if($doc->filetype==="profile")
											@php
												$x = 1;
											@endphp
											<img class="applicant-image" src="{{ url($doc->path . $doc->filename)}}">
										@endif	
									@endforeach
								@else
									<img class="applicant-image" src="{{ url('images/user_img.png')}}">
								@endif
							</div>

							<div class="col-sm-8">
								<div class="applicant-header">
									<div class="row">
										<div class="col-sm-9">
											@if($canViewProfile > 0)
												<a href="{{url("subscriber/applicants/".$user->id) }}" class="applicant-name" target="_blank" title="View Applicant Profile">  
													{{ $user->firstName }}
												</a>
											@else
												<a class="applicant-name clickbutton" id=""> 
													{{ $user->firstName }}
												</a>
											@endif


											@if($canViewProfile > 0)
												<a class="job-action" id="" href="{{url("subscriber/applicants/".$user->id) }}" target="_blank"> 
													View Profile
												</a>
											@else
												<a class="job-action clickbutton" id="" href=""> 
													View Profile
												</a>
											@endif

											@if($canSendEmail > 0)
												<label class="job-action send-invitation-button rowEmail{{$key}}" name="{{ $user->firstName }} {{ $user->lastName }}" email="{{ $user->email }}" rowEmail="{{$key}}" id="{{ $user->id }}">
													| Send Email
												</label>
											@endif
										</div> 
										@if($canSavedApplicant > 0)
											<div class="col-sm-3">
												<p class="applicant-forms-right">
													<label class="@if(in_array($user->id, $saves_)) applicant-buttons-saved @else applicant-buttons @endif saved-applicant rowSaved{{$key}}"  id="{{$user->id}}" rowSaved="{{$key}}">
														<i class="fa fa-bookmark" aria-hidden="true"></i>
													</label>
						                        </p>
											</div> 
										@else
											<div class="col-sm-3">
												<p class="applicant-forms-right">
													<label class="applicant-buttons saved-applicant2 rowSaved{{$key}}"  id="{{$user->id}}" rowSaved="{{$key}}">
														<i class="fa fa-bookmark" aria-hidden="true"></i>
													</label>
						                        </p>
											</div> 
										@endif
									</div>
								</div>

								<label class="applicant-details">
									<img src="{{ asset('images/age.png') }}" width="12" height="12" style="margin-right: 5px">
									{{$user->details ? date_diff(date_create($user->details->birthDate), date_create('now'))->y : ""}}
								</label>

								<label class="applicant-details">
									<i class="fa fa-transgender" aria-hidden="true"></i>
									{{$user->details ? $user->details->genders ? $user->details->genders->name : "" : ""}}
								</label>

								<label class="applicant-details">
									<img src="{{ asset('images/civil.png') }}" width="12" height="12" style="margin-right: 5px">
									{{$user->details ? $user->details->civils ? $user->details->civils->name : "" : ""}}
								</label>

								<label class="applicant-details">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
									{{ $user->address ? $user->address->country ? $user->address->country->nicename : "" : "" }}
								</label>

								@if(!is_null($user))
									@if(!is_null($user->certificates()))
										@php
										 	$certificates="";
										@endphp

										@foreach($user->certificates() as $certificate)
											@php
												$certificate 	= $certificate->type;
												$certificates 	= $certificates . $certificate . ", ";
											@endphp
										@endforeach
									@endif
								@endif

								@if(!$user->certificates()->isEmpty())
								<label class="applicant-details">
									<i class="fa fa-certificate" aria-hidden="true"></i>
									{!!rtrim($certificates, ', ')!!}
								</label>
								@else 
								<label class="applicant-details">
									<i class="fa fa-certificate" aria-hidden="true"></i>
									N/A
								</label>
								@endif

								@if(!is_null($user))
									@if(!is_null($user->specialization))
										@php
										 	$specializations="";
										@endphp

										@foreach($user->specialization as $specialization)
											@if(!is_null($specialization->specialization))
												@php
													$special = $specialization->specialization->name;
													$specializations 	= $specializations . $special . ", ";
												@endphp
											@endif
										@endforeach
									@endif
								@endif

								<label class="applicant-details">
									<i class="fa fa-briefcase" aria-hidden="true"></i>
									{!!rtrim($specializations, ', ')!!}
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach

		@if(!empty($users))
		<div class="mt-2">
			{{ $users->appends(request()->except('page'))->onEachSide(1)->links() }}
		</div>
		@endif

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
		@else
			$(".saved-applicant2").click(function() {
				Swal.fire('Ooops', "You can't saved this applicant, please upgrade to premium account!", 'error')
			});
		@endif

		$(".clickbutton").click(function(e) {
			Swal.fire('Ooops', "You can't view this profile, please upgrade to premium account!", 'error')
			e.preventDefault();
		});
	</script>
@endsection