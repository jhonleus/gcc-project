@extends('layouts.header')

@section('title', 'Posted Course')

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/posted-courses-page.css') }}">
	<!--CKEDITOR-->
    <script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>
	
	<div class="container course-container">
		<div class="row">
			<div class="col-sm-3">
				@include('school.sidebar.profile')
				@include('school.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card course-contents">
					<div class="nav-tabs-wrapper">
						<ul class="nav nav-tabs" data-tabs="tabs">
							<li class="nav-item">
								<a class="nav-link active" href="#active" data-toggle="tab">Active<span class="badge badge-light ml-2">{{$courses->total()}}</span></a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#closed" data-toggle="tab">Closed<span class="badge badge-light ml-2">{{$closes->total()}}</span></a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#archive" data-toggle="tab">Archive<span class="badge badge-light ml-2">{{$archives->total()}}</span></a>
							</li>
						</ul>
					</div>
				</div>

				<div class="tab-content">
					<div class="tab-pane active" id="active">
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
						<div class="card course-content">
							<div class="card-body course-body">
								<div class="course-header">
									<div class="row">
										<div class="col-sm-7">
											<label class="course-title">{{$course->course}}</label>
										</div> 
										<div class="col-sm-5">
											<p class="course-actions">
												<a class="course-blue" href="{{ url('school/course/'.$course->id.'/edit') }}">
													<i class="fa fa-edit" aria-hidden="true"></i>
													Edit
												</a>

												<label class="close-course course-orange" data-id="{{$course->id}}" status="{{$course->isActive}}" course_name="{{$course->course}}">
													<i class="fa fa-ban" aria-hidden="true"></i> 
													Close
												</label>

												<label class="delete-course course-red" status="{{$course->isDeleted}}" data-id="{{$course->id}}">
													<i class="fa fa-trash" aria-hidden="true"></i> 
													Delete
												</label>
					                        </p>
										</div> 
									</div>
								</div>

								<label class="course-details">
									<i class="fas fa-clock-o"></i>
									{{ date('F d, Y', strtotime($course->class_start)) }} - {{ date('F d, Y', strtotime($course->class_end)) }} 
								</label>

								<label class="course-details">
									<i class="fas fa-map-marker-alt"></i>
									{{ $course->country->nicename }}
								</label>

								<label class="course-details course-money">
									<i class="fas fa-money course-black"></i>
									{{ $course->currency->name }}
									{{ $course->fee }}
								</label>

								<label class="course-details">
									<i class="fa fa-hourglass-end" aria-hidden="true"></i>
									{{ date('F d, Y', strtotime($course->registration_end)) }}
								</label>

								<label class="course-details">
									@if(!is_null($course->schedules))
									<i class="fa fa-calendar" aria-hidden="true"></i>
										@php
										 	$sheds="";
										@endphp
										@foreach($course->schedules as $schedule)
											@php
												$scheds = $schedule->day . " - " . $schedule->time;

												$sheds = $sheds . $scheds . ", ";
											@endphp
										@endforeach
									@endif
									{{rtrim($sheds, ', ')}}
								</label>

								<label class="course-description">
									{!! $course->details !!}
								</label>

								<div class="course-footer">
									@php
										$date_now = new DateTime();
										$date2    = new DateTime($course->last_day);
									@endphp

									@if($date_now > $date2) 
										<span class="badge badge-danger text-uppercase">EXPIRED</span>
									@else
										<label class="course-posted">POSTED: {{ $course->created_at->diffForHumans() }}</label>
									@endif
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $courses->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
					<div class="tab-pane" id="closed">
						@php
							$currentDisplay = $closes->currentPage() * $closes->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($closes->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $closes->total() ? $currentDisplay : $closes->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $closes->total() }}</span> )
							</small>
						</div>

						@foreach($closes as $course)
						<div class="card course-content">
							<div class="card-body course-body">
								<div class="course-header">
									<div class="row">
										<div class="col-sm-7">
											<label class="course-title">{{$course->course}}</label>
										</div> 
										<div class="col-sm-5">
											<p class="course-actions">
												<a class="course-blue" href="{{ url('school/course/'.$course->id.'/edit') }}">
													<i class="fa fa-edit" aria-hidden="true"></i>
													Edit
												</a>

												<label class="close-course course-orange" data-id="{{$course->id}}" status="{{$course->isActive}}" course_name="{{$course->course}}">
													<i class="fa fa-unlock" aria-hidden="true"></i> 
													Open
												</label>

												<label class="delete-course course-red" status="{{$course->isDeleted}}" data-id="{{$course->id}}">
													<i class="fa fa-trash" aria-hidden="true"></i> 
													Delete
												</label>
					                        </p>
										</div> 
									</div>
								</div>

								<label class="course-details">
									<i class="fas fa-clock-o"></i>
									{{ date('F d, Y', strtotime($course->class_start)) }} - {{ date('F d, Y', strtotime($course->class_end)) }} 
								</label>

								<label class="course-details">
									<i class="fas fa-map-marker-alt"></i>
									{{ $course->country->nicename }}
								</label>

								<label class="course-details course-money">
									<i class="fas fa-money course-black"></i>
									{{ $course->currency->name }}
									{{ $course->fee }}
								</label>

								<label class="course-details">
									<i class="fa fa-hourglass-end" aria-hidden="true"></i>
									{{ date('F d, Y', strtotime($course->registration_end)) }}
								</label>

								<label class="course-details">
									@if(!is_null($course->schedules))
									<i class="fa fa-calendar" aria-hidden="true"></i>
										@php
										 	$sheds="";
										@endphp
										@foreach($course->schedules as $schedule)
											@php
												$scheds = $schedule->day . " - " . $schedule->time;

												$sheds = $sheds . $scheds . ", ";
											@endphp
										@endforeach
									@endif
									{{rtrim($sheds, ', ')}}
								</label>

								<label class="course-description">
									{!! $course->details !!}
								</label>

								<div class="course-footer">
									<label class="course-posted">POSTED: {{ $course->created_at->diffForHumans() }}</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $closes->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
					<div class="tab-pane" id="archive">
						@php
							$currentDisplay = $archives->currentPage() * $archives->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($archives->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $archives->total() ? $currentDisplay : $archives->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $archives->total() }}</span> )
							</small>
						</div>

						@foreach($archives as $course)
						<div class="card course-content">
							<div class="card-body course-body">
								<div class="course-header">
									<div class="row">
										<div class="col-sm-7">
											<label class="course-title">{{$course->course}}</label>
										</div> 
										<div class="col-sm-5">
											<p class="course-actions">
												<label class="delete-course course-green" status="{{$course->isDeleted}}" data-id="{{$course->id}}">
													<i class="fa fa-undo" aria-hidden="true"></i>
													Restore
												</label>
					                        </p>
										</div> 
									</div>
								</div>

								<label class="course-details">
									<i class="fas fa-clock-o"></i>
									{{ date('F d, Y', strtotime($course->class_start)) }} - {{ date('F d, Y', strtotime($course->class_end)) }} 
								</label>

								<label class="course-details">
									<i class="fas fa-map-marker-alt"></i>
									{{ $course->country->nicename }}
								</label>

								<label class="course-details course-money">
									<i class="fas fa-money course-black"></i>
									{{ $course->currency->name }}
									{{ $course->fee }}
								</label>

								<label class="course-details">
									<i class="fa fa-hourglass-end" aria-hidden="true"></i>
									{{ date('F d, Y', strtotime($course->registration_end)) }}
								</label>

								<label class="course-details">
									@if(!is_null($course->schedules))
									<i class="fa fa-calendar" aria-hidden="true"></i>
										@php
										 	$sheds="";
										@endphp
										@foreach($course->schedules as $schedule)
											@php
												$scheds = $schedule->day . " - " . $schedule->time;

												$sheds = $sheds . $scheds . ", ";
											@endphp
										@endforeach
									@endif
									{{rtrim($sheds, ', ')}}
								</label>

								<label class="course-description">
									{!! $course->details !!}
								</label>

								<div class="course-footer">
									<label class="course-posted">POSTED: {{ $course->created_at->diffForHumans() }}</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $archives->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="warning-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-for-actions">
				<div class="modal-content">
					<div class="modal-header">
						<div class="status-box confirmation-label">
							<i class="material-icons fa fa-remove"></i>
						</div>				
					</div>

					<div class="modal-body">
						<p class="course-note warning-message">
							Are you sure you want to delete this course?
						</p>

						<div class="course-forms">
							<label class="course-label">
								Select template to send (select blank for custom message) 
								<br>
								**use [application_name] to include course name**
							</label>

							<select class="select" name="template_id" id="template_id"> 
								<option> </option>
								@foreach($templates as $template)
									<option value="{{$template->id}}" desc="{{$template->message}}">{{$template->subject}}</option>
								@endforeach
							</select>

							<div class="error-container">
								<label class="label-error error-template">Template is required.</label>
							</div>
						</div>

						<div class="course-forms">
							<label class="applicant-label-select">
								Subject:
							</label>

							<input class="input" id="subject" name="subject">

							<div class="error-container">
								<label class="label-error error-subject">Subject is required.</label>
							</div>
						</div>

						<div class="course-forms">
							<label class="applicant-label-select">
								Message:
							</label>

							<div class="ckeditor-message">
								<textarea class="txtarea" id="message" name="message"></textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-message">Message is required.</label>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn course-button btn-secondary close-button" data-dismiss="modal">Close</button>
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
						<p class="label-2 f3 success-message">
							Successfully Deleted
						</p>
					</div>

					<div class="modal-footer align-c">
						<button type="button" class="btn course-button btn-success btn-100 success-button">Okay</button>
					</div>
				</div>
			</div>
		</div>  
	</div>

	<script>
		$(document).ready(function(){
			$("#course-list").removeClass("sidebar-list-title");
			$("#course-list").addClass("sidebar-list-title-active");
		});

		CKEDITOR.replace("message");
		CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
        ];

		$(".close-button").click(function() {
    		$("#delete-course").remove();
    		$("#close-course").remove();
		});

		$(".success-button").click(function() {
			$('#success-modal').modal('hide'); 
			window.location.reload();
		});
		
		$(".delete-course").click(function() {
			status 	= $(this).attr("status");
			id 		= $(this).data('id');
			status 	= parseInt(status);
			$(".course-forms").hide();

			if(status==0) {
				$('.warning-message').html('Are you sure you want to delete this course?'); 
				text = "Delete";
			}
			else {
				$('.warning-message').html('Are you sure you want to restore this course?'); 
				text = "Restore";
			}

			$('#warning-modal').modal('show'); 
			$(".close-button").after(delete_course(status, id, text));
		});

		function delete_course(status, id, text) {
		    return $('<button/>', {
		        text: 	text,
		        id: 	'delete-course',
		        class: 	'btn course-button btn-danger',
		        click: function() {
    				$("#delete-course").remove();
    		       	$("#warning-modal").modal('hide');

					basePath = window.location.origin;
		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    type : "POST",
		        	    url  : `${basePath}/school/delete`,
		        	    dataType : "json",
		        	    data : {
		        	    	id 		: id,
		        	    	status 	: status 
		        	    },
		        	    success: function(response) {
		        			if (response.result === true) {
   								Swal.fire(
   								  response.message,
   								  "",
   								  'success'
   								).then(function(){ 
									location.reload();
								});
   		        			}
   		        			else {
   								msg = response.message;

			   		        	if(msg['id']!==undefined) {
		   		        			if(msg['id'][0].match(/required/)) {
		   		        				Swal.fire('Ooops', "{{ $message['ER:00:78'] }}", 'error')
		   		        			}
		   		        			else {
		   		        				Swal.fire('Ooops', "{{ $message['ER:00:79'] }}", 'error')
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
			        				Swal.fire('Ooops', msg, 'error')
		        				}
   		        			}
		        	    }
		        	});
		        }
		    });
		}

		$(".close-course").click(function(e) {
			status 			= $(this).attr("status");
			course_name 	= $(this).attr("course_name");
			id 				= $(this).data('id');
			status 			= parseInt(status);

			if(status==0) {
				$(".course-forms").hide();
				$('.warning-message').html('Are you sure you want to open this course?'); 
				text = "Open";
			}
			else {
				$('.warning-message').html('Are you sure you want to close this course?'); 
				text 		= "Yes";
			}

			$('#warning-modal').modal('show'); 
			$(".close-button").after(close_course(status, id, text, course_name));
		});

		function close_course(status, id, text, course_name) {
		    return $('<button/>', {
		        text: 	text,
		        id: 	'close-course',
		        class: 	'btn course-button btn-danger',
		        click: function() {
    		       	template_id = $("#template_id").val();
    		       	subject 	= $("#subject").val();
	    			length 		= CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;
	    			message 	= CKEDITOR.instances['message'].getData();

    		       	if(text==="Yes" && (!length || subject==="")) {
    		       		if(subject==="") {
    		       			$(".error-subject").show();
							$("#subject").css('border', '1px solid red');
    		       		}

    		       		if(!length) {
    		       			$(".error-message").show();
							$(".ckeditor-message").css('border', '1px solid red');
    		       		}
    		       	}
    		       	else {
	       				$("#close-course").remove();
	       		       	$("#warning-modal").modal('hide');

       					basePath = window.location.origin;
       		        	$.ajax({
       		        		headers: {
       		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
       		        		},
       		        	    type : "POST",
       		        	    url  : `${basePath}/school/close`,
       		        	    dataType : "json",
       		        	    data : {
       		        	    	id 			: id,
       		        	    	status 		: status,
       		        	    	template_id : template_id, 
       		        	    	course_name : course_name,
       		        	    	message 	: message,
       		        	    	subject 	: subject,
       		        	    },
       		        	    success: function(response) {
       		        			if (response.result === true) {
       								Swal.fire(
       								  response.message,
       								  "",
       								  'success'
       								).then(function(){ 
										location.reload();
									});
       		        			}
       		        			else {
       								msg = response.message;

			   		        		if(msg['id']!==undefined) {
			   		        			if(msg['id'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:78'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:79'] }}", 'error')
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
			        				else if(msg['course_name']!==undefined) {
			   		        			if(msg['course_name'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:00'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:01'] }}", 'error')
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
			value 		= $(this).val();
			desc 		= $("#template_id option:selected").attr('desc');
			subject 	= $("#template_id option:selected").html();

        	CKEDITOR.instances.message.setData(desc);
	    	$("#subject").val(subject);

	        if(value==="" || value===null) {
	    		$(".error-subject").show();
				$("#subject").css('border', '1px solid red');
	    		$(".error-message").show();
				$(".ckeditor-message").css('border', '1px solid red');
	        } 
	        else {
	        	$(".error-subject").hide();
				$("#subject").css('border', '');
	        }
		})

		$("#subject").keyup(function() {
			value 		= $(this).val();

	        if(value==="" || value===null) {
	    		$(".error-subject").show();
				$("#subject").css('border', '1px solid red');
	        } 
	        else {
	    		$(".error-subject").hide();
				$("#subject").css('border', '');
	        }
		})

		CKEDITOR.instances.message.on('change', function () { 
	    	var length 	= CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-message").show();
				$(".ckeditor-message").css('border', '1px solid red');
	        }
	        else {
				$(".error-message").hide();
				$(".ckeditor-message").css('border', '');
	        }
	    });
	</script>
@endsection
