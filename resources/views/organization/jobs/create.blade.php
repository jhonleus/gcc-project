@extends('layouts.header')

@section('title', 'Post Job')

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/create-page.css') }}">
	<!--CKEDITOR-->
    <script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>

	<div class="container create-container">
		@if(isset($completeDetails))
			@if(!$completeDetails)
				<div class="alert alerts alert-warning" role="alert">
					Please complete your details <a href="{{ url('organization/details/'.Auth::user()->id.'/edit') }}">here</a> before posting a job!
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
		@else
			@if($subscriptionEnded)
				<div class="alert alerts alert-warning" role="alert">
					Your subscription has been ended, renew your subscription <a href="{{ url('/pricing') }}">here</a>!
				</div>
			@endif
		@endif

		@if(isset($jobs))
		<form method="POST" action="{{ route('organization.jobs.update', $jobs->id) }}" id="form">
            @method('PUT')
		    @csrf
		@else
		<form action="{{ route('organization.jobs.store') }}" method="POST" id="form" enctype="multipart/form-data">
		    @csrf
		@endif
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="card create-contents">
					<div class="card-header create-header">
						<div class="row">
							<div class="col-sm-7">
								<label class="create-title">Job Details</label>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="create-forms">
							<h1 class="create-label">Job Title:</h1>

							<input type="text" class="input" name="job_title" id="job_title" value="@if(isset($jobs)){{$jobs->title}}@endif" {{ $disabled ? 'disabled' : '' }}>

							<div class="error-container">
								<label class="label-error error-title">{{ $message['ER:00:41'] }}</label>
							</div>
						</div>

						<div class="create-forms">
							<h1 class="create-label">Specialization:</h1>

							<select class="select @if(isset($jobs)) select-selected @endif" name="specialization" id="specialization" {{ $disabled ? 'disabled' : '' }}> 
								<option hidden disabled selected></option>
								@foreach($specializations as $specialization)
									<option value="{{$specialization->id}}" <?php if(isset($jobs)) { if($specialization->id === $jobs->specializationId) { echo "selected"; }} ?>>
										{{$specialization->name}}
									</option>
								@endforeach
							</select>

							<div class="error-container">
								<label class="label-error error-specialization">{{ $message['ER:00:48'] }}</label>
							</div>
						</div>

						<div class="create-forms">
							<h1 class="create-label">Employment Type:</h1>

							<select class="select @if(isset($jobs)) select-selected @endif" name="employment" id="employment" {{ $disabled ? 'disabled' : '' }}> 
								<option hidden disabled selected></option>
								@foreach($types as $type)
									<option value="{{$type->id}}" <?php if(isset($jobs)) { if($type->id === $jobs->employmentId) { echo "selected"; }} ?>>
										{{$type->name}}
									</option>
								@endforeach
							</select>

							<div class="error-container">
								<label class="label-error error-type">{{ $message['ER:00:43'] }}</label>
							</div>
						</div>

						<div class="create-forms">
							<h1 class="create-label">Position Level:</h1>

							<select class="select @if(isset($jobs)) select-selected @endif" name="position" id="position" {{ $disabled ? 'disabled' : '' }}> 
								<option hidden disabled selected></option>
								@foreach($positions as $position)
									<option value="{{$position->id}}" <?php if(isset($jobs)) { if($position->id === $jobs->positionId) { echo "selected"; }} ?>>
										{{$position->name}}
									</option>
								@endforeach
							</select>

							<div class="error-container">
								<label class="label-error error-position">{{ $message['ER:00:44'] }}</label>
							</div>
						</div>

						<div class="row">

							<div class="col-sm-6">
								<div class="create-forms">
									<h1 class="create-label">Job Location:</h1>

									<select class="select @if(isset($jobs)) select-selected @endif" name="location" id="locations_jobs" {{ $disabled ? 'disabled' : '' }}> 
										<option hidden disabled selected></option>
										@foreach($countries as $country)
											<option value="{{$country->id}}"
												<?php if(isset($jobs)) { if($country->id === $jobs->locationId) { echo "selected"; }} ?>>
												{{$country->nicename}}
											</option>
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-location">{{ $message['ER:00:45'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="create-forms">
									<h1 class="create-label">City / Region:</h1>

									<input type="text" class="input" name="city" id="city" value="@if(isset($jobs)){{$jobs->locationCity}}@endif" {{ $disabled ? 'disabled' : '' }}>

									<div class="error-container">
										<label class="label-error error-city">{{ $message['ER:00:46'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<div class="create-forms">
							<h1 class="create-label">Monthly Salary:</h1>

							<div class="row">
								<div class="col-sm-4">
									<select class="select @if(isset($jobs)) select-selected @endif" name="currency" id="currency" {{ $disabled ? 'disabled' : '' }}> 
										<option hidden disabled selected></option>
										@foreach($currencies as $currency)
											<option value="{{$currency->id}}"
												<?php if(isset($jobs)) { if($currency->id === $jobs->currencyId) { echo "selected"; }} ?>>
												{{$currency->name}}
											</option>
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-currency">{{ $message['ER:00:49'] }}</label>
									</div>
								</div>

								<div class="col-sm-4">
									<input type="text" class="input" placeholder="Minimum" id="min" name="min" value="@if(isset($jobs)){{$jobs->min}}@endif">

									<div class="error-container">
										<label class="label-error error-minimum">{{ $message['ER:00:50'] }}</label>
									</div>
								</div>

								<div class="col-sm-4">
									<input type="text" class="input" placeholder="Maximum" id="max" name="max" value="@if(isset($jobs)){{$jobs->max}}@endif">

									<div class="error-container">
										<label class="label-error error-maximum">{{ $message['ER:00:53'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<div class="create-forms">
							<h1 class="create-label">Job Description:</h1>

							<div class="ckeditor-description">
								<textarea class="txtarea" name="description" id="description" {{ $disabled ? 'disabled' : '' }}>@if(isset($jobs)){{$jobs->description}}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-description">{{ $message['ER:00:58'] }}</label>
							</div>
						</div>

						<div class="create-forms">
							<h1 class="create-label">Responsibilities:</h1>

							<div class="ckeditor-responsibility">
								<textarea class="txtarea" name="responsibility" id="responsibility" {{ $disabled ? 'disabled' : '' }}>@if(isset($jobs)){{$jobs->responsibilities}}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-responsibility">{{ $message['ER:00:56'] }}</label>
							</div>
						</div>

						<div class="create-forms">
							<h1 class="create-label">Qualification:</h1>

							<div class="ckeditor-qualification">
								<textarea class="txtarea" name="qualification" id="qualification" {{ $disabled ? 'disabled' : '' }}>@if(isset($jobs)){{$jobs->qualification}}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-qualification">{{ $message['ER:00:57'] }}</label>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="create-forms">
									<h1 class="create-label">Job Order:</h1>

									@if(!isset($jobs))
										<input type="file" class="input" name="job_order" id="job_order">
									@else
										<div style="padding:20px">
											<b>File:</b>
											<br>
											<a href="{{ url($jobs->jobOrder) }}">Job Order for {{$jobs->title}}</a>
											<br>
											<br>

											@if(is_null($jobs->updated_at))
												<b>Uploaded:</b>

												<br>

												{{ Helper::getDate($jobs->created_at) }}

												<br>
											@else
												<b>Uploaded:</b>

												<br>

												{{ Helper::getDate($jobs->updated_at) }}
											@endif
										</div>
									@endif

									<div class="error-container">
										<label class="label-error error-order">{{ $message['ER:00:59'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="create-forms">
									<h1 class="create-label">Affilations:</h1>

									<select class="select @if(isset($jobs)) select-selected @endif" name="partners" id="partners" {{ $disabled ? 'disabled' : '' }}>
										<option hidden disabled selected></option>
										@foreach($partners as $partner)
											@if($partner->isActive==1)
											<option value="@if(Auth::user()->id==$partner->usersId) {{$partner->companyId}} @else {{$partner->usersId}} @endif" 
												@if(isset($jobs))
												@if(Auth::user()->id==$partner->usersId) 
													@if($jobs->order)
													@if($partner->companyId==$jobs->order->partnersId) 
														selected 
													@endif 
													@endif 
												@else
													@if($jobs->order)
													@if($partner->usersId==$jobs->order->partnersId) 
														selected 
													@endif 
													@endif 
												@endif
												@endif>
		                    					@if(Auth::user()->id==$partner->usersId)
													@if($partner->co_user->rolesId==4)
													{{ $partner->co_school ? $partner->co_school->school : "" }}
													@else
													{{$partner->co_affilation ? $partner->co_affilation->company : ""}}
													@endif
												@else
													@if($partner->user->rolesId==4)
													{{$partner->school ? $partner->school->school : ""}}
													@else
													{{$partner->affilation ? $partner->affilation->company : ""}}
													@endif
												@endif
											</option>
											@endif
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-partners">{{ $message['ER:00:17'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<div class="create-footer">
							<button type="button" class="btn create-button btn-primary" id="save_button">Save</button>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="id" value="@if(isset($jobs)){{$jobs->id}}@endif">
			<div class="col-sm-2"></div>
		</div>
		</form>
	</div>

	<script>
		$(document).ready(function(){
			@if($errors->any()) 
				@if(isset($errors->messages()['id']))  
					@if(preg_match('/required./', $errors->messages()['id'][0]))
						Swal.fire(
        				  	'Ooops',
        				  	"{{ $message['ER:00:78'] }}",
        				  	'error'
        				)
					@else
						Swal.fire(
        				  	'Ooops',
        				  	"{{ $message['ER:00:79'] }}",
        				  	'error'
        				)
					@endif
				@endif

				@if(isset($errors->messages()['job_title']))  
					@if(preg_match('/required./', $errors->messages()['job_title'][0]))
						$("#job_title").css("border", "1px solid red");
						$(".error-title").html("{{ $message['ER:00:41'] }}");
						$(".error-title").show();
					@else
						$("#job_title").css("border", "1px solid red");
						$(".error-title").html("{{ $message['ER:00:42'] }}");
						$(".error-title").show();
					@endif
				@endif 

				@if(isset($errors->messages()['partners']))  
					@if(preg_match('/required./', $errors->messages()['partners'][0]))
						$("#partners").css("border", "1px solid red");
						$(".error-partners").html("{{ $message['ER:00:17'] }}");
						$(".error-partners").show();
					@else
						$("#partners").css("border", "1px solid red");
						$(".error-partners").html("{{ $message['ER:00:80'] }}");
						$(".error-partners").show();
					@endif
				@endif

				@if(isset($errors->messages()['employment']))  
					@if(preg_match('/required./', $errors->messages()['employment'][0]))
						$("#employment").css("border", "1px solid red");
						$(".error-type").html("{{ $message['ER:00:43'] }}");
						$(".error-type").show();
					@else
						$("#employment").css("border", "1px solid red");
						$(".error-type").html("{{ $message['ER:00:74'] }}");
						$(".error-type").show();
					@endif
				@endif

				@if(isset($errors->messages()['position']))  
					@if(preg_match('/required./', $errors->messages()['position'][0]))
						$("#position").css("border", "1px solid red");
						$(".error-position").html("{{ $message['ER:00:44'] }}");
						$(".error-position").show();
					@else
						$("#position").css("border", "1px solid red");
						$(".error-position").html("{{ $message['ER:00:75'] }}");
						$(".error-position").show();
					@endif
				@endif

				@if(isset($errors->messages()['location']))  
					@if(preg_match('/required./', $errors->messages()['location'][0]))
						$("#locations_jobs").css("border", "1px solid red");
						$(".error-location").html("{{ $message['ER:00:45'] }}");
						$(".error-location").show();
					@else
						$("#locations_jobs").css("border", "1px solid red");
						$(".error-location").html("{{ $message['ER:00:73'] }}");
						$(".error-location").show();
					@endif
				@endif

				@if(isset($errors->messages()['city']))  
					@if(preg_match('/required./', $errors->messages()['city'][0]))
						$("#city").css("border", "1px solid red");
						$(".error-city").html("{{ $message['ER:00:46'] }}");
						$(".error-city").show();
					@else
						$("#city").css("border", "1px solid red");
						$(".error-city").html("{{ $message['ER:00:47'] }}");
						$(".error-city").show();
					@endif
				@endif

				@if(isset($errors->messages()['specialization']))  
					@if(preg_match('/required./', $errors->messages()['specialization'][0]))
						$("#specialization").css("border", "1px solid red");
						$(".error-specialization").html("{{ $message['ER:00:48'] }}");
						$(".error-specialization").show();
					@else
						$("#specialization").css("border", "1px solid red");
						$(".error-specialization").html("{{ $message['ER:00:76'] }}");
						$(".error-specialization").show();
					@endif
				@endif

				@if(isset($errors->messages()['currency']))  
					@if(preg_match('/required./', $errors->messages()['currency'][0]))
						$("#currency").css("border", "1px solid red");
						$(".error-currency").html("{{ $message['ER:00:49'] }}");
						$(".error-currency").show();
					@else
						$("#currency").css("border", "1px solid red");
						$(".error-currency").html("{{ $message['ER:00:77'] }}");
						$(".error-currency").show();
					@endif
				@endif

				@if(isset($errors->messages()['min']))  
					@if(preg_match('/required./', $errors->messages()['min'][0]))
						$("#min").css("border", "1px solid red");
						$(".error-minimum").html("{{ $message['ER:00:50'] }}");
						$(".error-minimum").show();
					@else
						$("#min").css("border", "1px solid red");
						$(".error-minimum").html("{{ $message['ER:00:52'] }}");
						$(".error-minimum").show();
					@endif
				@endif

				@if(isset($errors->messages()['max']))  
					@if(preg_match('/required./', $errors->messages()['max'][0]))
						$("#max").css("border", "1px solid red");
						$(".error-maximum").html("{{ $message['ER:00:53'] }}");
						$(".error-maximum").show();
					@else
						$("#max").css("border", "1px solid red");
						$(".error-maximum").html("{{ $message['ER:00:55'] }}");
						$(".error-maximum").show();
					@endif
				@endif

				@if(isset($errors->messages()['responsibility']))  
					@if(preg_match('/required./', $errors->messages()['responsibility'][0]))
						$("#responsibility").css("border", "1px solid red");
						$(".error-responsibility").html("{{ $message['ER:00:56'] }}");
						$(".error-responsibility").show();
					@endif
				@endif

				@if(isset($errors->messages()['qualification']))  
					@if(preg_match('/required./', $errors->messages()['qualification'][0]))
						$("#qualification").css("border", "1px solid red");
						$(".error-qualification").html("{{ $message['ER:00:57'] }}");
						$(".error-qualification").show();
					@endif
				@endif

				@if(isset($errors->messages()['description']))  
					@if(preg_match('/required./', $errors->messages()['description'][0]))
						$("#description").css("border", "1px solid red");
						$(".error-description").html("{{ $message['ER:00:58'] }}");
						$(".error-description").show();
					@endif
				@endif

				@if(isset($errors->messages()['job_order']))  
					@if(preg_match('/required./', $errors->messages()['job_order'][0]))
						$("#job_order").css("border", "1px solid red");
						$(".error-order").html("{{ $message['ER:00:59'] }}");
						$(".error-order").show();
					@endif
				@endif
			@endif
		});

		CKEDITOR.replace("description");
		CKEDITOR.replace("responsibility");
		CKEDITOR.replace("qualification");

		$("#save_button").click(function(e) {
			$(".label-error").hide();

			var job_title 		= $("#job_title").val();
				specialization 	= $("#specialization").val();
				type 			= $("#employment").val();
				position 		= $("#position").val();
				ewankoba 		= $("#locations_jobs").val();
				max 			= $("#max").val();
				min 			= $("#min").val();
				currency 		= $("#currency").val();
				city 			= $("#city").val();
				
				description 	= CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;
				responsibility 	= CKEDITOR.instances['responsibility'].getData().replace(/<[^>]*>/gi, '').length;
				qualification 	= CKEDITOR.instances['qualification'].getData().replace(/<[^>]*>/gi, '').length;

				disabled 	= @if($disabled) "true" @else "false" @endif;

				if($('#job_order').length) {
			 		job_order 	= $('#job_order').get(0).files.length;
				}
				else {
					job_order 	= 1;
				}

			if(disabled==="true") {

			}
			else {
				if(job_title===null || job_title==="" || type===null || type==="" || specialization===null || specialization==="" || ewankoba===null || ewankoba==="" || !description || position===null || position==="" || !responsibility || !qualification || max===null || max==="" || min===null || min==="" || currency===null || currency==="" || !min.match(/^\d+$/) ||!max.match(/^\d+$/) || job_order===0 || partners==="" || partners===null || city===null || city==="") {
					e.preventDefault();

					if(job_title===null || job_title==="") {
						$(".error-title").show();
						$(".error-title").html("{{ $message['ER:00:41'] }}");
						$("#job_title").css('border', '1px solid red');
					}

					if(city===null || city==="") {
						$(".error-city").show();
						$(".error-city").html("{{ $message['ER:00:46'] }}");
						$("#city").css('border', '1px solid red');
					}

					if(type===null || type==="") {
						$(".error-type").show();
						$(".error-type").html("{{ $message['ER:00:43'] }}");
						$("#employment").css('border', '1px solid red');
					}

					if(specialization===null || specialization==="") {
						$(".error-specialization").show();
						$(".error-specialization").html("{{ $message['ER:00:48'] }}");
						$("#specialization").css('border', '1px solid red');
					}

					if(ewankoba===null || ewankoba==="") {
						$(".error-location").show();
						$(".error-location").html("{{ $message['ER:00:45'] }}");
						$("#locations_jobs").css('border', '1px solid red');
					}

					if(!description) {
						$(".error-description").show();
						$(".error-description").html("{{ $message['ER:00:58'] }}");
						$(".ckeditor-description").css('border', '1px solid red');
					}

					if(position===null || position==="") {
						$(".error-position").show();
						$(".error-position").html("{{ $message['ER:00:44'] }}");
						$("#position").css('border', '1px solid red');
					}

					if(!responsibility) {
						$(".error-responsibility").show();
						$(".error-responsibility").html("{{ $message['ER:00:56'] }}");
						$(".ckeditor-responsibility").css('border', '1px solid red');
					}

					if(!qualification) {
						$(".error-qualification").show();
						$(".error-qualification").html("{{ $message['ER:00:57'] }}");
						$(".ckeditor-qualification").css('border', '1px solid red');
					}

					if(max===null || max==="" || !max.match(/^\d+$/)) {
						if(max===null || max==="") {
							$(".error-maximum").show();
							$(".error-maximum").html("{{ $message['ER:00:53'] }}");
							$("#max").css('border', '1px solid red');
						}
						else {
							$(".error-maximum").show();
							$(".error-maximum").html("{{ $message['ER:00:54'] }}");
							$("#max").css('border', '1px solid red');
						}
					}

					if(min===null || min==="" || !min.match(/^\d+$/)) {
						if(min===null || min==="") {
							$(".error-minimum").show();
							$(".error-minimum").html("{{ $message['ER:00:50'] }}");
							$("#min").css('border', '1px solid red');
						}
						else {
							$(".error-minimum").show();
							$(".error-minimum").html("{{ $message['ER:00:51'] }}");
							$("#min").css('border', '1px solid red');
						}
					}

					if(currency===null || currency==="") {
						$(".error-currency").show();
						$(".error-currency").html("{{ $message['ER:00:49'] }}");
						$("#currency").css('border', '1px solid red');
					}

					if(job_order===0) {
						$(".error-order").show();
						$(".error-order").html("{{ $message['ER:00:56'] }}");
						$("#job_order").css('border', '1px solid red');
					}

					if(partners==="" || partners===null) {
						$(".error-partners").show();
						$(".error-partners").html("{{ $message['ER:00:17'] }}");
						$("#partners").css('border', '1px solid red');
					}
				}
				else {
		  			document.getElementById("form").submit();
				}
			}
		});

		$('#job_title').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-title").show();
				$(".error-title").html("{{ $message['ER:00:41'] }}");
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-title").hide();
				$(this).css('border', '');
	        }
	    });

	    $('#city').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-city").show();
				$(".error-city").html("{{ $message['ER:00:46'] }}");
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-city").hide();
				$(this).css('border', '');
	        }
	    });

	    $('#max').keyup(function(e) {
	        var max 	= $(this).val();
	        	length 	= $(this).val().length;

            if (!((e.keyCode>=48&&e.keyCode<= 57)||(e.keyCode>=65&&e.keyCode<=90))) {
    	        return false;
    	    }
    	    else {
		        if(length < 1) {
					$(".error-maximum").show();
    	        	$(".error-maximum").html("{{ $message['ER:00:53'] }}");
					$(this).css('border', '1px solid red');
		        }
		        else if(!max.match(/^\d+$/)) {
    	        	$(".error-maximum").show();
    	        	$(".error-maximum").html("{{ $message['ER:00:54'] }}");
    	        	$(this).css('border', '1px solid red');
    	        }
		        else {
					$(".error-maximum").hide();
					$(this).css('border', '');
		        }
    	    }
	    });

	    $("#max").keypress(function(e) {
		    if (!((e.keyCode>=48&&e.keyCode<= 57)||(e.keyCode>=65&&e.keyCode<=90))) {
		        return false;
		    }
		});

	    $('#min').keyup(function(e) {
	        var min   	= $(this).val();
	        	length 	= $(this).val().length;

	        if (!((e.keyCode>=48&&e.keyCode<= 57)||(e.keyCode>=65&&e.keyCode<=90))) {
		        return false;
		    }
		    else {
		    	if(length < 1) {
					$(".error-minimum").show();
    	        	$(".error-minimum").html("{{ $message['ER:00:50'] }}");
    	        	$(this).css('border', '1px solid red');
		        }
		        else if(!min.match(/^\d+$/)) {
    	        	$(".error-minimum").show();
    	        	$(".error-minimum").html("{{ $message['ER:00:51'] }}");
    	        	$(this).css('border', '1px solid red');
    	        }
		        else {
					$(".error-minimum").hide();
    				$(this).css('border', '');
		        }
		    }
	    });

	    $("#min").keypress(function(e) {
		    if (!((e.keyCode>=48&&e.keyCode<= 57)||(e.keyCode>=65&&e.keyCode<=90))) {
		        return false;
		    }
		});

		$('#currency').change(function() {
			$(".error-currency").hide();
			$(this).css('border', '');
	    });

	    $('#partners').change(function() {
			$(".error-partners").hide();
			$(this).css('border', '');
	    });

	    $('#employment').change(function() {
			$(".error-type").hide();
			$(this).css('border', '');
	    });

	    $('#specialization').change(function() {
			$(".error-specialization").hide();
			$(this).css('border', '');
	    });

	    $('#locations_jobs').change(function() {
			$(".error-location").hide();
			$(this).css('border', '');
	    });

	     $('#position').change(function() {
			$(".error-position").hide();
			$(this).css('border', '');
	    });

	    CKEDITOR.instances.description.on('change', function () { 
	    	var length = CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-description").show();
				$(".error-description").html("{{ $message['ER:00:58'] }}");
				$(".ckeditor-description").css('border', '1px solid red');
	        }
	        else {
				$(".error-description").hide();
				$(".ckeditor-description").css('border', '');
	        }
	    });

	    CKEDITOR.instances.responsibility.on('change', function () { 
	    	var length = CKEDITOR.instances['responsibility'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-responsibility").html("{{ $message['ER:00:56'] }}");
				$(".error-responsibility").show();
				$(".ckeditor-responsibility").css('border', '1px solid red');
	        }
	        else {
				$(".error-responsibility").hide();
				$(".ckeditor-responsibility").css('border', '');
	        }
	    });

	    CKEDITOR.instances.qualification.on('change', function () { 
	    	var length = CKEDITOR.instances['qualification'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-qualification").html("{{ $message['ER:00:57'] }}");
				$(".error-qualification").show();
				$(".ckeditor-qualification").css('border', '1px solid red');
	        }
	        else {
				$(".error-qualification").hide();
				$(".ckeditor-qualification").css('border', '');
	        }
	    });

	    $('#job_order').change(function() {
			$(".error-order").hide();
			$(this).css('border', '');
	    });
	</script>
@endsection
