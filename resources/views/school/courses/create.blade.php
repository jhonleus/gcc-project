@extends('layouts.header')

@section('title', 'Post Course')

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/create-page.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/css/schedule/main.css') }}">
  	<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<!--CKEDITOR-->
    <script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>

	<div class="container create-container">
		@if(isset($completeDetails))
			@if(!$completeDetails)
				<div class="alert alerts alert-warning" role="alert">
					Please complete your details <a href="{{ url('school/details/'.Auth::user()->id) }}">here</a> before posting a job!
				</div>
			@else
				@if(!$subscriptionCheck)
					<div class="alert alerts alert-warning" role="alert">
						You don't have a subscripton yet, please choose your subscription <a href="{{ url('pricing') }}">here</a>!
					</div>
				@else
					@if($subscriptionEnded)
						<div class="alert alerts alert-warning" role="alert">
							Your subscription has been ended, renew your subscription <a href="{{ url('pricing') }}">here</a>!
						</div>
					@else
						@if($subscriptionLimit)
							<div class="alert alerts alert-warning" role="alert">
								Your job posting reached its limit, you can upgrade your subscription <a href="{{ url('pricing') }}">here</a>!
							</div>
						@endif
					@endif
				@endif
			@endif
		@endif

		
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="card create-contents">
					<div class="card-header create-header">
						<label class="create-title">Course Details</label>
					</div>
					<div class="card-body">
						<div class="create-forms">
							<h1 class="create-label">Course Title:</h1>

							<input type="text" class="input" name="course" id="course" value="@if(isset($courses)){{$courses->course}}@endif" {{ $disabled ? 'disabled' : '' }}>

							<div class="error-container">
								<label class="label-error error-course"></label>
							</div>
						</div>

						<div class="create-forms">
							<div class="row">
								<div class="col-sm-4">
									<h1 class="create-label">Course Location:</h1>

									<select class="select @if(isset($courses)) select-selected @endif" name="location" id="course_location" {{ $disabled ? 'disabled' : '' }}> 
										<option hidden disabled selected></option>
										@foreach($countries as $country)
											<option value="{{$country->id}}"
												<?php if(isset($courses)) { if($country->id === $courses->locationId) { echo "selected"; }} ?>>
												{{$country->nicename}}
											</option>
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-location"></label>
									</div>
								</div>

								<div class="col-sm-4">
									<h1 class="create-label">Currency:</h1>

									<select class="select @if(isset($courses)) select-selected @endif" name="currency" id="currency" {{ $disabled ? 'disabled' : '' }}> 
										<option hidden disabled selected></option>
										@foreach($currencies as $currency)
											<option value="{{$currency->id}}"
												<?php if(isset($courses)) { if($currency->id === $courses->currencyId) { echo "selected"; }} ?>>
												{{$currency->name}}
											</option>
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-currency"></label>
									</div>
								</div>

								<div class="col-sm-4">
									<h1 class="create-label">Tuition Fee:</h1>

									<input type="text" class="input" placeholder="Tuition Fee" id="fee" name="fee" value="@if(isset($courses)){{$courses->fee}}@endif" {{ $disabled ? 'disabled' : '' }}>

									<div class="error-container">
										<label class="label-error error-fee"></label>
									</div>
								</div>
							</div>
						</div>


						<div class="create-forms">
							<div class="row">
								<div class="col-sm-4">
									<h1 class="create-label">Class Start:</h1>

									<input type="date" class="input" id="start" name="start" value="@if(isset($courses)){{date("Y-m-d", strtotime($courses->class_start))}}@endif" {{ $disabled ? 'disabled' : '' }}>

									<div class="error-container">
										<label class="label-error error-start"></label>
									</div>
								</div>

								<div class="col-sm-4">
									<h1 class="create-label">Class End:</h1>

									<input type="date" class="input" id="end" name="end" value="@if(isset($courses)){{date("Y-m-d", strtotime($courses->class_end))}}@endif" {{ $disabled ? 'disabled' : '' }}>

									<div class="error-container">
										<label class="label-error error-end"></label>
									</div>
								</div>

								<div class="col-sm-4">
									<h1 class="create-label">Registration End:</h1>

									<input type="date" class="input" id="registration" name="registration" value="@if(isset($courses)){{date("Y-m-d", strtotime($courses->registration_end))}}@endif" {{ $disabled ? 'disabled' : '' }}>

									<div class="error-container">
										<label class="label-error error-registration"></label>
									</div>
								</div>
							</div>
						</div>

						<div class="create-forms">
							<h1 class="create-label">Course Details:</h1>

							<div id="ckeditor-details">
								<textarea class="txtarea" name="details" id="details" {{ $disabled ? 'disabled' : '' }}>@if(isset($courses)){{$courses->details}}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-details"></label>
							</div>
						</div>

						<div id="day-schedule" name="day-schedule"></div>

						<div class="error-container">
							<label class="label-error error-schedule"></label>
						</div>

						<div class="create-footer">
							<button type="button" class="btn create-button btn-primary" id="save_button">Save</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>

 	<script src="{{ asset('resources/js/schedule/main.js') }}"></script>

	<script>
		CKEDITOR.replace("details");

		$("#day-schedule").dayScheduleSelector({
		  	startTime	: '07:00',
       	 	interval	: 60,
		  	endTime 	: '23:00'
		});

		$("#save_button").click(function(e) {
			$(".label-error").hide();

			var course 			= $("#course").val();
				course_location = $("#course_location").val();
				currency 		= $("#currency").val();
				fee 			= $("#fee").val();
				start 			= $("#start").val();
				end 			= $("#end").val();
				registration 	= $("#registration").val();

				startTime 	 	= new Date(start);
				endTime 	 	= new Date(end);
				now 			= new Date();

				registrationTime 	= new Date(registration);

				disabled = @if($disabled) "true" @else "false" @endif;

				dateSchedule = $("#day-schedule").data('artsy.dayScheduleSelector').serialize();
				details = CKEDITOR.instances['details'].getData().replace(/<[^>]*>/gi, '').length;
				data 	= CKEDITOR.instances.details.getData();

				count = 0;
				for(var key in dateSchedule) {
				    if (dateSchedule.hasOwnProperty(key)) {
				        if(Object.keys(dateSchedule[key]).length > 0) {
				        	count++;
				        }
				    }
				}

				console.log(dateSchedule)

			if(disabled==="true") {

			}
			else {
				if(course===null || course==="" || course_location===null || course_location==="" || currency===null || currency==="" || fee===null || fee==="" || !fee.match(/^\d+$/) || start==="" || start===null || end==="" || end===null || registration==="" || registration===null || startTime < now || endTime < now || endTime < startTime || registrationTime < now || count < 1 || !details) {
					e.preventDefault();

					if(course===null || course==="") {
						$(".error-course").show();
						$(".error-course").html("{{ $message['ER:00:00'] }}");
						$("#course").css('border', '1px solid red');
					}

					if(course_location===null || course_location==="") {
						$(".error-location").show();
						$(".error-location").html("{{ $message['ER:00:02'] }}");
						$("#course_location").css('border', '1px solid red');
					}

					if(currency===null || currency==="") {
						$(".error-currency").show();
						$(".error-currency").html("{{ $message['ER:00:03'] }}");
						$("#currency").css('border', '1px solid red');
					}

					if(fee===null || fee==="" || !fee.match(/^\d+$/)) {
						if(fee===null || fee==="") {
							$(".error-fee").show();
							$(".error-fee").html("{{ $message['ER:00:04'] }}");
							$("#fee").css('border', '1px solid red');
						}
						else {
							$(".error-fee").show();
							$(".error-fee").html("{{ $message['ER:00:05'] }}");
							$("#fee").css('border', '1px solid red');
						}
					}

					if(start===null || start==="" || startTime < now) {
						if(start===null || start==="") {
							$(".error-start").show();
							$(".error-start").html("{{ $message['ER:00:07'] }}");
							$("#start").css('border', '1px solid red');
						}
						else {
							$(".error-start").show();
							$(".error-start").html("{{ $message['ER:00:08'] }}");
							$("#start").css('border', '1px solid red');
						}
					}

					if(end===null || end==="" || endTime < now || endTime < startTime) {
						if(start===null || start==="") {
							$(".error-end").show();
							$(".error-end").html("{{ $message['ER:00:09'] }}");
							$("#end").css('border', '1px solid red');
						}
						else if(endTime < now) {
							$(".error-end").show();
							$(".error-end").html("{{ $message['ER:00:10'] }}");
							$("#end").css('border', '1px solid red');
						}
						else {
							$(".error-end").show();
							$(".error-end").html("{{ $message['ER:00:11'] }}");
							$("#end").css('border', '1px solid red');
						}
					}

					if(registration===null || registration==="" || registrationTime < now) {
						if(registration===null || registration==="") {
							$(".error-registration").show();
							$(".error-registration").html("{{ $message['ER:00:12'] }}");
							$("#registration").css('border', '1px solid red');
						}
						else {
							$(".error-registration").show();
							$(".error-registration").html("{{ $message['ER:00:13'] }}");
							$("#registration").css('border', '1px solid red');
						}
					}

					if(count < 1) {
						$("#day-schedule").css("border", "1px solid red");
						$(".error-schedule").show();
						$(".error-schedule").html("{{ $message['ER:00:14'] }}");
					}

					if(!details) {
						$("#ckeditor-details").css("border", "1px solid red");
						$(".error-details").show();
						$(".error-details").html("{{ $message['ER:00:15'] }}");
					}
				}
				else {
		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    @if(!isset($courses))
		        	    type : "POST",
		        	    url  : "{{ route('school.course.store') }}",
		        	    @else
		        	    type 	: "POST",
		        	    url  	: "{{ route('school.update') }}",
		        	    @endif
		        	    dataType : "json",
		        	    data : {
		        	    	@if(isset($courses))
		        	    	courseId		: 	"{{$courses->id}}",
		        	    	@endif
		        	        course 			: 	course,
		        	        location 		: 	course_location,
		        	        currency		: 	currency,
		        	        fee 			: 	fee,
		        	        start 			: 	start,
		        	        end 			: 	end,
		        	        dateSchedule 	: 	dateSchedule,
		        	        registration 	: 	registration,
		        	        details 		: 	data
		        	    },
		        	    success: function(response) {
		        			if (response.result === true) {
   								Swal.fire(
   								  response.message,
   								  '',
   								  'success'
   								).then(function(){ 
									window.location.href="{{ url('school/course') }}"
								});
   		        			}
   		        			else {
   		        				cars = response.message;

   		        				if(cars['location']!==undefined) {
   		        					if(cars['location'][0].match(/required/)) {
   		        						$(".error-location").show();
   		        						$(".error-location").html("{{ $message['ER:00:02'] }}");
   		        						$("#course_location").css('border', '1px solid red');
   		        					}
   		        					else {
   		        						$(".error-location").show();
   		        						$(".error-location").html("{{ $message['ER:00:86'] }}");
   		        						$("#course_location").css('border', '1px solid red');
   		        					}
   		        				}

   		        				if(cars['details']!==undefined) {
									$(".error-details").show();
									$(".error-details").html("{{ $message['ER:00:15'] }}");
									$("#ckeditor-details").css('border', '1px solid red');
   		        				}

   		        				if(cars['currency']!==undefined) {
   		        					if(cars['currency'][0].match(/required/)) {
   		        						$(".error-currency").show();
										$(".error-currency").html("{{ $message['ER:00:03'] }}");
										$("#currency").css('border', '1px solid red');
   		        					}
   		        					else {
   		        						$(".error-currency").show();
										$(".error-currency").html("{{ $message['ER:00:77'] }}");
										$("#currency").css('border', '1px solid red');
   		        					}
   		        				}

   		        				if(cars['course']!==undefined) {
									if(cars['course'][0].match(/required/)) {
   		        						$(".error-course").show();
										$(".error-course").html("{{ $message['ER:00:00'] }}");
										$("#course").css('border', '1px solid red');
   		        					}
   		        					else {
   		        						$(".error-course").show();
										$(".error-course").html("Course may not be greater than 255 characters.");
										$("#course").css('border', '1px solid red');
   		        					}
   		        				}

   		        				if(cars['fee']!==undefined) {
									if(cars['fee'][0].match(/required/)) {
   		        						$(".error-fee").show();
										$(".error-fee").html("{{ $message['ER:00:04'] }}");
										$("#fee").css('border', '1px solid red');
   		        					}
   		        					else {
   		        						$(".error-fee").show();
										$(".error-fee").html("{{ $message['ER:00:06'] }}");
										$("#fee").css('border', '1px solid red');
   		        					}
   		        				}

   		        				if(cars['start']!==undefined) {
									if(cars['start'][0].match(/required/)) {
   		        						$(".error-start").show();
										$(".error-start").html("{{ $message['ER:00:07'] }}");
										$("#start").css('border', '1px solid red');
   		        					}
   		        					else {
   		        						$(".error-start").show();
										$(".error-start").html("{{ $message['ER:00:08'] }}");
										$("#start").css('border', '1px solid red');
   		        					}
   		        				}

   		        				if(cars['end']!==undefined) {
									if(cars['end'][0].match(/required/)) {
   		        						$(".error-end").show();
										$(".error-end").html("{{ $message['ER:00:09'] }}");
										$("#end").css('border', '1px solid red');
   		        					}
   		        					else if(cars['end'][0].match(/start/)) {
   		        						$(".error-end").show();
										$(".error-end").html("{{ $message['ER:00:11'] }}");
										$("#end").css('border', '1px solid red');
   		        					}
   		        					else {
   		        						$(".error-end").show();
										$(".error-end").html("{{ $message['ER:00:10'] }}");
										$("#end").css('border', '1px solid red');
   		        					}
   		        				}

   		        				if(cars['registration']!==undefined) {
									if(cars['registration'][0].match(/required/)) {
   		        						$(".error-registration").show();
										$(".error-registration").html("{{ $message['ER:00:12'] }}");
										$("#registration").css('border', '1px solid red');
   		        					}
   		        					else {
   		        						$(".error-registration").show();
										$(".error-registration").html("{{ $message['ER:00:13'] }}");
										$("#registration").css('border', '1px solid red');
   		        					}
   		        				}

   		        				if(cars['dateSchedule']!==undefined) {
									$(".error-schedule").show();
									$(".error-schedule").html("{{ $message['ER:00:14'] }}");
									$("#day-schedule").css('border', '1px solid red');
   		        				}

   		        				if(cars['courseId']!==undefined) {
									if(cars['registration'][0].match(/required/)) {
										Swal.fire('Ooops', "{{ $message['ER:00:87'] }}", 'error' )
									}
									else {
										Swal.fire('Ooops', "{{ $message['ER:00:88'] }}", 'error' )
									}
								}
   		        			}
		        	    }
		        	});
				}
			}
		});

		$('#course').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-course").show();
				$(".error-course").html("{{ $message['ER:00:00'] }}");
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-course").hide();
				$(this).css('border', '');
	        }
	    });

	    $('#course_location').change(function() {
			$(".error-location").hide();
			$(this).css('border', '');
	    });

	    $('#currency').change(function() {
			$(".error-currency").hide();
			$(this).css('border', '');
	    });

	    $('#fee').keyup(function(e) {
	        var fee 	= $(this).val();
	        	length 	= $(this).val().length;

	        if (!((e.keyCode>=48&&e.keyCode<= 57)||(e.keyCode>=65&&e.keyCode<=90))) {
		        return false;
		    }
		    else {
    	        if(length < 1) {
    				$(".error-fee").show();
    	        	$(".error-fee").html("{{ $message['ER:00:04'] }}");
    				$(this).css('border', '1px solid red');
    	        }
    	        else if(!fee.match(/^\d+$/)) {
    	        	$(".error-fee").show();
    	        	$(".error-fee").html("{{ $message['ER:00:05'] }}");
    	        	$("#min").css('border', '1px solid red');
    	        }
    	        else {
    				$(".error-fee").hide();
    				$(this).css('border', '');
    	        }
		    }
	    });

	    $("#fee").keypress(function(e) {
		    if (!((e.keyCode>=48&&e.keyCode<= 57)||(e.keyCode>=65&&e.keyCode<=90))) {
		        return false;
		    }
		});

		$('#start').change(function() {
			var start 		= $(this).val();
				startTime 	= new Date(start);
				now 		= new Date();

			if(start===null || start==="") {
				$(".error-start").show();
				$(".error-start").html("{{ $message['ER:00:07'] }}");
				$("#start").css('border', '1px solid red');
			}
			else if(startTime < now) {
				$(".error-start").show();
				$(".error-start").html("{{ $message['ER:00:08'] }}");
				$("#start").css('border', '1px solid red');
			}
			else {
				$(".error-start").hide();
				$(this).css('border', '');
			}
	    });

	    $('#end').change(function() {
	    	var end 		= $(this).val();
	    		start 		= $("#start").val();
	    		endTime 	= new Date(end);
	    		startTime	= new Date(start);
	    		now 		= new Date();

			if(end===null || end==="") {
				$(".error-end").show();
				$(".error-end").html("{{ $message['ER:00:09'] }}");
				$("#end").css('border', '1px solid red');
			}
			else if(endTime < now) {
				$(".error-end").show();
				$(".error-end").html("{{ $message['ER:00:10'] }}");
				$("#end").css('border', '1px solid red');
			}
			else if(endTime < startTime) {
				$(".error-end").show();
				$(".error-end").html("{{ $message['ER:00:11'] }}");
				$("#end").css('border', '1px solid red');
			}
			else {
				$(".error-end").hide();
				$(this).css('border', '');
			}
	    });

	    $('#registration').change(function() {
			var registration 		= $(this).val();
				registrationTime 	= new Date(registration);
				now 		= new Date();

			if(registration===null || registration==="") {
				$(".error-registration").show();
				$(".error-registration").html("{{ $message['ER:00:12'] }}");
				$("#registration").css('border', '1px solid red');
			}
			else if(registrationTime < now) {
				$(".error-registration").show();
				$(".error-registration").html("{{ $message['ER:00:13'] }}");
				$("#registration").css('border', '1px solid red');
			}
			else {
				$(".error-registration").hide();
				$(this).css('border', '');
			}
	    });

	    $("#day-schedule").on('selected.artsy.dayScheduleSelector', function (e, selected) {
			$(this).css('border', '');
			$(".error-schedule").hide();
	    })

	    CKEDITOR.instances.details.on('change', function () { 
	    	var length = CKEDITOR.instances['details'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-details").html("{{ $message['ER:00:15'] }}");
				$(".error-details").show();
				$("#ckeditor-details").css('border', '1px solid red');
	        }
	        else {
				$(".error-details").hide();
				$("#ckeditor-details").css('border', '');
	        }
	    });

		@if(isset($courses))
	    $("#day-schedule").data('artsy.dayScheduleSelector').deserialize({
	      	@foreach(unserialize($courses->schedules[0]->array) as $key => $schedules)
	      	'{{$key}}': 
	      		[
	      			@foreach($schedules as $schedule)
	      				['{{$schedule[0]}}', '{{$schedule[1]}}'],
	      			@endforeach
	      		]
	      	@endforeach
	    });
	    @endif
	</script>
@endsection
