@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(322))

@section('content')
	<!--CKEDITOR-->
    <script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>	

	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('employer.sidebar.profile')
				@include('employer.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card page-title">
					<div class="nav-tabs-wrapper">
						<ul class="nav nav-tabs" data-tabs="tabs">
							<li class="nav-item">
								<a class="nav-link active" href="#active" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(360) }} <span class="badge badge-light ml-2">{{$jobs->total()}}</span></a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#closed" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(361) }} <span class="badge badge-light ml-2">{{$closes->total()}}</span></a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#archive" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(362) }} <span class="badge badge-light ml-2">{{$archives->total()}}</span></a>
							</li>
						</ul>
					</div>
				</div>

				<div class="tab-content">
					<div class="tab-pane active" id="active">
						@php
							$currentDisplay = $jobs->currentPage() * $jobs->perPage();
						@endphp

						<div style="text-align:right"><small class="form-text text-muted mb-2">
							{{ App\MaintenanceLocale::getLocale(118) }} (
							<span id="start-page">{{ $currentDisplay - ($jobs->perPage() - 1) }}</span>
							-
							<span id="end-page">{{ $currentDisplay < $jobs->total() ? $currentDisplay : $jobs->total() }}</span>
							{{ App\MaintenanceLocale::getLocale(207) }}
							<span id="total-blog">{{ $jobs->total() }}</span> )
						</small></div>

						@foreach($jobs as $job)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="card-header-2">
									<div class="row">
										<div class="col-sm-7">
											<label class="label-title-2">{{ $job->title }}</label>
										</div> 
										<div class="col-sm-5">
											<p class="content-right">
												@if($job->isValidate!=2)
												<a class="label-blue-2" href="{{ url('employer/jobs/'.$job->id.'/edit') }}">
													<i class="fa fa-edit" aria-hidden="true"></i>
													{{ App\MaintenanceLocale::getLocale(36) }}
												</a>
												@endif

												@if($job->isValidate==1)
												<label class="close-job label-orange rowClose{{$job->id}}" data-id="{{$job->id}}" status="{{$job->isActive}}" job_name="{{ $job->title }}" rowClose="{{$job->id}}">
													<i class="fa fa-ban" aria-hidden="true"></i> 
													{{ App\MaintenanceLocale::getLocale(150) }}
												</label>
												@endif

												<label class="delete-job label-red rowDelete{{$job->id}}" status="{{$job->isDeleted}}" data-id="{{$job->id}}" job_name="{{ $job->title }}" rowDelete="{{$job->id}}">
													<i class="fa fa-trash" aria-hidden="true"></i> 
													{{ App\MaintenanceLocale::getLocale(37) }}
												</label>
					                        </p>
										</div> 
									</div>
								</div>

								<label class="content-details">
									<i class="fa fa-user"></i>
									{{ $job->employments->name }}
								</label>

								<label class="content-details">
									<i class="fas fa-map-marker-alt"></i>
									{{$job->locationCity}}, {{ $job->country->nicename }}
								</label>

								<label class="content-details">
									<i class="fa fa-address-book"></i>
									{{ $job->specializations->name }}
								</label>

								<label class="content-details">
									<i class="fa fa-file"></i>
									{{ $job->positions->name }}
								</label>

								<label class="content-details">
									<i class="fa fa-file-text label-black"></i>
									<a href="{{ url('$job->jobOrder') }}">Job Order</a>
								</label>

								<label class="content-details label-green">
									<i class="fas fa-money label-black"></i>
									{{ $job->currency->name }} {{ number_format($job->min,2)  }}-{{ number_format($job->max,2) }}
								</label>

								<label class="label-description-2">
									{!! $job->description !!}
								</label>

								<div class="content-footer">
									@php
										$date_now = new DateTime();
										$date2    = new DateTime($job->last_day);
									@endphp

									@if($date_now > $date2) 
										<span class="badge badge-danger text-uppercase">EXPIRED</span>
									@else
										@if($job->isValidate==1)
											<label class="label-date text-uppercase">{{ App\MaintenanceLocale::getLocale(304) }}: {{ $job->created_at->diffForHumans() }}</label>
										@elseif($job->isValidate==0)
											<span class="badge badge-info text-uppercase">{{ App\MaintenanceLocale::getLocale(378) }}</span>
										@else
											<span class="badge badge-danger text-uppercase">{{ App\MaintenanceLocale::getLocale(274) }}</span>
										@endif
									@endif
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $jobs->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
					<div class="tab-pane" id="closed">
						@php
							$currentDisplay = $closes->currentPage() * $closes->perPage();
						@endphp

						<div style="text-align:right"><small class="form-text text-muted mb-2">
							{{ App\MaintenanceLocale::getLocale(118) }} (
							<span id="start-page">{{ $currentDisplay - ($closes->perPage() - 1) }}</span>
							-
							<span id="end-page">{{ $currentDisplay < $closes->total() ? $currentDisplay : $closes->total() }}</span>
							{{ App\MaintenanceLocale::getLocale(207) }}
							<span id="total-blog">{{ $closes->total() }}</span> )
						</small></div>

						@foreach($closes as $job)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="card-header-2">
									<div class="row">
										<div class="col-sm-7">
											<label class="label-title-2">{{ $job->title }}</label>
										</div> 
										<div class="col-sm-5">
											<p class="content-right">
												<a class="label-blue-2" href="{{ url('employer/jobs/'.$job->id.'/edit') }}">
													<i class="fa fa-edit" aria-hidden="true"></i>
													{{ App\MaintenanceLocale::getLocale(36) }}
												</a>

												<label class="close-job label-orange rowClose{{$job->id}}" data-id="{{$job->id}}" status="{{$job->isActive}}" job_name="{{ $job->title }}" rowClose="{{$job->id}}">
													<i class="fa fa-unlock" aria-hidden="true"></i> 
													{{ App\MaintenanceLocale::getLocale(379) }}
												</label>

												<label class="delete-job label-red rowDelete{{$job->id}}" status="{{$job->isDeleted}}" data-id="{{$job->id}}" job_name="{{ $job->title }}" rowDelete="{{$job->id}}">
													<i class="fa fa-trash" aria-hidden="true"></i> 
													{{ App\MaintenanceLocale::getLocale(37) }}
												</label>
					                        </p>
										</div> 
									</div>
								</div>

								<label class="content-details">
									<i class="fa fa-user"></i>
									{{ $job->employments->name }}
								</label>

								<label class="content-details">
									<i class="fas fa-map-marker-alt"></i>
									{{$job->locationCity}}, {{ $job->country->nicename }}
								</label>

								<label class="content-details">
									<i class="fa fa-address-book"></i>
									{{ $job->specializations->name }}
								</label>

								<label class="content-details">
									<i class="fa fa-file"></i>
									{{ $job->positions->name }}
								</label>

								<label class="content-details">
									<i class="fa fa-file-text label-black"></i>
									<a href="{{ url('$job->jobOrder') }}">Job Order</a>
								</label>

								<label class="content-details label-green-2">
									<i class="fas fa-money label-black"></i>
									{{ $job->currency->name }} {{ number_format($job->min,2)  }}-{{ number_format($job->max,2) }}
								</label>

								<label class="label-description-2">
									{!! $job->description !!}
								</label>
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

						<div style="text-align:right"><small class="form-text text-muted mb-2">
							{{ App\MaintenanceLocale::getLocale(118) }} (
							<span id="start-page">{{ $currentDisplay - ($archives->perPage() - 1) }}</span>
							-
							<span id="end-page">{{ $currentDisplay < $archives->total() ? $currentDisplay : $archives->total() }}</span>
							{{ App\MaintenanceLocale::getLocale(207) }}
							<span id="total-blog">{{ $archives->total() }}</span> )
						</small></div>

						@foreach($archives as $job)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="card-header-2">
									<div class="row">
										<div class="col-sm-7">
											<label class="label-title-2">{{ $job->title }}</label>
										</div> 
										<div class="col-sm-5">
											<p class="content-right">
												<label class="delete-job label-green-2 rowDelete{{$job->id}}" status="{{$job->isDeleted}}" data-id="{{$job->id}}" job_name="{{ $job->title }}" rowDelete="{{$job->id}}">
													<i class="fa fa-undo" aria-hidden="true"></i> 
													{{ App\MaintenanceLocale::getLocale(364) }}
												</label>
					                        </p>
										</div> 
									</div>
								</div>

								<label class="content-details">
									<i class="fa fa-user"></i>
									{{ $job->employments->name }}
								</label>

								<label class="content-details">
									<i class="fas fa-map-marker-alt"></i>
									{{$job->locationCity}}, {{ $job->country->nicename }}
								</label>

								<label class="content-details">
									<i class="fa fa-address-book"></i>
									{{ $job->specializations->name }}
								</label>

								<label class="content-details">
									<i class="fa fa-file"></i>
									{{ $job->positions->name }}
								</label>

								<label class="content-details">
									<i class="fa fa-file-text label-black"></i>
									<a href="{{ url('$job->jobOrder') }}">Job Order</a>
								</label>

								<label class="content-details label-green-2">
									<i class="fas fa-money label-black"></i>
									{{ $job->currency->name }} {{ number_format($job->min,2)  }}-{{ number_format($job->max,2) }}
								</label>

								<label class="label-description-2">
									{!! $job->description !!}
								</label>
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
						<p class="label-confirmation warning-message">
							{{ App\MaintenanceLocale::getLocale(377) }}
						</p>

						<label class="label-select contents-form-1">
							(Use [application_name] to include job name)
						</label>

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

						<div class="contents-form contents-form-2">
							<label class="label-select">
								{{ App\MaintenanceLocale::getLocale(370) }}:
							</label>

							<div class="ckeditor-message">
								<input type="file" class="input" name="jobOrder" id="jobOrder">
							</div>

							<div class="error-container">
								<label class="label-error error-jobOrder">{{ App\MaintenanceLocale::getLocale(371) }}.</label>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn label-button btn-secondary close-button" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
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
						<p class="label-confirmation success-message">
							{{ App\MaintenanceLocale::getLocale(256) }}
						</p>
					</div>

					<div class="modal-footer align-c">
						<button type="button" class="btn label-button btn-success btn-100 success-button">{{ App\MaintenanceLocale::getLocale(372) }}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$("#job-list").removeClass("sidebar-list-title");
			$("#job-list").addClass("sidebar-list-title-active");
		});

		CKEDITOR.replace("message");
		CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
        ];

		$(".close-button").click(function() {
    		$(".delete-job-button").remove();
    		$(".close-job-button").remove();
		});

		$(".success-button").click(function() {
			$('#success-modal').modal('hide'); 
			window.location.reload();
		});
		
		$(".delete-job").click(function() {
			@if($errors->any()) 
			var rowDelete = "{{ old('rowDelete') }}";
			@else
			var rowDelete = $(this).attr("rowDelete");
			@endif

			status 		= $(".rowDelete"+rowDelete).attr("status");
			job_name 	= $(".rowDelete"+rowDelete).attr("job_name");
			id 			= $(".rowDelete"+rowDelete).data('id');
			status 		= parseInt(status);

			$(".contents-form-1").hide();

			if(status==0) {
				$(".contents-form-2").hide();
				$('.warning-message').html('{{ App\MaintenanceLocale::getLocale(374) }}'); 
				text = "Delete";
			}
			else {
				$(".contents-form-2").show();
				$('.warning-message').html('{{ App\MaintenanceLocale::getLocale(373) }}'); 
				text = "Restore";
			}

			$('#warning-modal').modal('show'); 
			$(".close-button").after(delete_job(status, id, text, job_name, rowDelete));
		});

		function delete_job(status, id, text, job_name, rowDelete) {
		    return $('<button/>', {
		        text: 	text,
		        id: 	'delete-job-button',
		        class: 	'btn label-button btn-chinese delete-job-button',
		        click: function() {
			 		var jobOrder 	= $('#jobOrder').get(0).files.length;
			 			form_data = new FormData();

			 		form_data.append("id", id);
			 		form_data.append("status", status);
			 		form_data.append("job_name", job_name);
			 		form_data.append("rowDelete", rowDelete);
			 		form_data.append("job_order", document.getElementById('jobOrder').files[0]);

    		       	if(status > 0 && jobOrder===0) {
    		       		$(".error-jobOrder").show();
    		       		$("#jobOrder").css("border", "1px solid red");
    		       	}	
    		       	else {
    		       		$("#warning-modal").modal('hide');
    					$(".delete-job-button").remove();

						basePath = window.location.origin;
			        	$.ajax({
			        		headers: {
			        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
			        		},
			        	    type : "POST",
			        	    url  : `${basePath}/employer/delete`,
			        	    dataType : "json",
			        	    contentType: false,
		        	        cache: false,
		        	        processData: false,
			        	    data : form_data,
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
			        				else if(msg['job_name']!==undefined) {
			   		        			if(msg['job_name'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:41'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:42'] }}", 'error')
			   		        			}
			        				}
			        				else if(msg['job_order']!==undefined) {
			        					$(".delete-job").click();
	    								$("#jobOrder").css("border", "1px solid red");
	    								$(".error-jobOrder").show();
	    								$(".error-jobOrder").html("{{ $message['ER:00:59'] }}");
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

		$(".close-job").click(function(e) {
			@if($errors->any()) 
			var rowClose = "{{ old('rowClose') }}";
			@else
			var rowClose = $(this).attr("rowClose");
			@endif

			status 		= $(".rowClose"+rowClose).attr("status");
			id 			= $(".rowClose"+rowClose).data('id');
			job_name 	= $(".rowClose"+rowClose).attr('job_name');
			status 		= parseInt(status);

			if(status==0) {
				$(".contents-form-1").hide();
				$(".contents-form-2").show();
				$('.warning-message').html('{{ App\MaintenanceLocale::getLocale(375) }}'); 
				text = "Open";
			}
			else {
				$(".contents-form-1").show();
				$(".contents-form-2").hide();
				$('.warning-message').html('{{ App\MaintenanceLocale::getLocale(376) }}'); 
				text 		= "Yes";
			}

			$('#warning-modal').modal('show'); 
			$(".close-button").after(close_job(status, id, text, job_name, rowClose));
		});

		function close_job(status, id, text, job_name, rowClose) {
		    return $('<button/>', {
		        text: 	text,
		        id: 	'close-job-button',
		        class: 	'btn label-button btn-chinese close-job-button',
		        click: function() {
    		       	subject 	= $("#subject").val();
    		       	length 		= CKEDITOR.instances['message'].getData().replace(/<[^>]*>/gi, '').length;
	    			message 	= CKEDITOR.instances['message'].getData();

	    			var jobOrder 	= $('#jobOrder').get(0).files.length;
	    				form_data = new FormData();

	    			form_data.append("id", id);
	    			form_data.append("status", status);
	    			form_data.append("subject", subject);
	    			form_data.append("message", message);
	    			form_data.append("job_name", job_name);
	    			form_data.append("rowClose", rowClose);
	    			form_data.append("job_order", document.getElementById('jobOrder').files[0]);

	    			if(status < 1 && jobOrder===0) {
	    				$(".error-jobOrder").show();
	    				$("#jobOrder").css("border", "1px solid red");
	    			}
    		       	else if(text==="Yes" && (!length || subject==="")) {
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
	       				$(".close-job-button").remove();
	       		       	$("#warning-modal").modal('hide');

       					basePath = window.location.origin;
       		        	$.ajax({
       		        		headers: {
       		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
       		        		},
       		        	    type : "POST",
       		        	    url  : `${basePath}/employer/close`,
       		        	    dataType : "json",
	    	        	    contentType: false,
	            	        cache: false,
	            	        processData: false,
       		        	    data : form_data,
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

	   								if(msg['subject']!==undefined || msg['message']!==undefined || msg['job_order']!==undefined) {

	    		       					$(".close-job").click();
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

				        				if(msg['job_order']!==undefined) {
				        					$(".close-job").click();
		    								$("#jobOrder").css("border", "1px solid red");
		    								$(".error-jobOrder").show();
		    								$(".error-jobOrder").html("{{ $message['ER:00:59'] }}");
				        				}
       		        				}
			   		        		else if(msg['id']!==undefined) {
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
			        				else if(msg['job_name']!==undefined) {
			   		        			if(msg['job_name'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:41'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:42'] }}", 'error')
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

		$("#jobOrder").change(function() {
	    	$(".error-jobOrder").hide();
			$("#jobOrder").css('border', '');
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
