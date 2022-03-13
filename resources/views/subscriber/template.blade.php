@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(323))

@section('content')
	<!--CKEDITOR-->
	<script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>
	
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
			@if(Auth::user()->rolesId==2)
			@include('employer.sidebar.profile')
			@include('employer.sidebar.index')
			@else
			@include('organization.sidebar.profile')
			@include('organization.sidebar.index')
			@endif
			</div>

			<div class="col-sm-9">
				<div class="card page-contents">
					<div class="card-header card-header-1">
						<label class="label-information"> 
							{{ App\MaintenanceLocale::getLocale(323) }}
						</label>
					</div>
					<div class="card-body">
						<div class="contents-form">
							<label class="label-select">
								
							</label>

							<label class="label-select">
								{{ App\MaintenanceLocale::getLocale(400) }}: <font class="label-small">({{ App\MaintenanceLocale::getLocale(399) }})</font>
							</label>

							<select class="select" name="template_name" id="template_name"> 
								<option value="0"></option>
								@foreach($templates as $template)
									<option value="{{$template->id}}" subject="{{$template->subject}}"  message="{{$template->message}}">{{$template->subject}}</option>
								@endforeach
							</select>

							<div class="error-container">
								<label class="label-error error-template_name">{{ App\MaintenanceLocale::getLocale(401) }}.</label>
							</div>
						</div>

						<div class="contents-form">
							<label class="label-select">{{ App\MaintenanceLocale::getLocale(368) }}:</label>

							<input class="input" name="subject" id="subject"> 

							<div class="error-container">
								<label class="label-error error-subject">{{ App\MaintenanceLocale::getLocale(356) }}.</label>
							</div>
						</div>

						<div class="contents-form">
							<label class="label-select">{{ App\MaintenanceLocale::getLocale(259) }}:</label>

							@if(Auth::user()->rolesId == 4)
							<label class="label-notes">{{ App\MaintenanceLocale::getLocale(402) }} - {coursename}</label>
							@else
							<label class="label-notes">{{ App\MaintenanceLocale::getLocale(403) }} - {jobname}</label>
							@endif

							<label class="label-notes">{{ App\MaintenanceLocale::getLocale(404) }} - {schedule-date}</label>

							<label class="label-notes">{{ App\MaintenanceLocale::getLocale(405) }} - {schedule-time}</label>

							<div class="ckeditor-message">
								<textarea class="txtarea" id="message" name="message"></textarea> 
							</div>

							<div class="error-container">
								<label class="label-error error-message">{{ App\MaintenanceLocale::getLocale(369) }}.</label>
							</div>
						</div>

						<div class="content-footer-2">
							<button type="button" class="btn label-button btn-primary" id="save_button">{{ App\MaintenanceLocale::getLocale(161) }}</button>
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
						<p class="label-2 f3 warning-message">
							{{ App\MaintenanceLocale::getLocale(389) }}
						</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btns btn-secondary close-button" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
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
							{{ App\MaintenanceLocale::getLocale(392) }}
						</p>
					</div>

					<div class="modal-footer align-c">
						<button type="button" class="btn btns btn-success btn-100 success-button" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#template-list").removeClass("sidebar-list-title");
			$("#template-list").addClass("sidebar-list-title-active");
		});

		CKEDITOR.replace("message");

		$("#save_button").click(function(e) {
			var name 	= $("#template_name").val();
				subject = $("#subject").val();
				length = CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;
				message = CKEDITOR.instances['message'].getData();
				basePath = window.location.origin;

			if(subject==="" || !length) {
				if(subject==="") {
					$(".error-subject").show();				
					$("#subject").css("border", "1px solid red");
				}

				if(!message) {
					$(".error-message").show();				
					$(".ckeditor-message").css("border", "1px solid red");
				}
			}
			else if(parseInt(name)==0) {
	        	$.ajax({
	        		headers: {
	        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
	        		},
	        	    type : "POST",
	        	    url  : `${basePath}/templates/store`,
	        	    dataType : "json",
	        	    data : {
	        	    	subject 	: subject,
	        	    	message 	: message 
	        	    },
	        	    success: function(response) {
	        			if (response.result === true) {
							$('#success-modal').modal('show'); 
							$('.success-message').html('{{ App\MaintenanceLocale::getLocale(257) }}'); 
	        			}
	        			else {
							$('#warning-modal').modal('show'); 
							$('.warning-message').html(response.result); 
	        			}
	        	    }
	        	});
			}
			else {
	        	$.ajax({
	        		headers: {
	        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
	        		},
	        	    type : "POST",
	        	    url  : `${basePath}/templates/update`,
	        	    dataType : "json",
	        	    data : {
	        	    	subject 	: subject,
	        	    	message 	: message,
	        	    	id 			: name
	        	    },
	        	    success: function(response) {
	        			if (response.result === true) {
							$('#success-modal').modal('show'); 
							$('.success-message').html('{{ App\MaintenanceLocale::getLocale(258) }}'); 
	        			}
	        			else {
							$('#warning-modal').modal('show'); 
							$('.warning-message').html(response.result); 
	        			}
	        	    }
	        	});
			}
		});

		$("#template_name").change(function() {
			var subject = $("#template_name option:selected").attr("subject");
				message = $("#template_name option:selected").attr("message");

			$("#subject").val(subject);
			CKEDITOR.instances['message'].setData(message)
		});

		$('#subject').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-subject").show();
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-subject").hide();
				$(this).css('border', '');
	        }
	    });

	    CKEDITOR.instances.message.on('change', function () { 
	    	var length = CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;

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
