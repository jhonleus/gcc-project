@extends('layouts.header')

@section('title', "Organization Details")

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/chosen/choices.min.css') }}">
	<script src="{{ asset("resources/js/chosen/choices.min.js") }}"></script>
	<!--CKEDITOR-->
    <script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>

	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('support.sidebar.profile')
				@include('support.sidebar.index')
			</div>

			<div class="col-sm-9">
				<form method="POST" action="{{ route('support.details.update', $users->id) }}" id="form">
				@method('PUT')
				@csrf
				<div class="card page-title">
					<div class="card-header card-header-1">
						<label class="label-information">Organization Details</label>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(145) }}:</h1>

									<input type="text" class="input input-size-2" name="company" id="company" value="@if($errors->any()){{ old('company') }}@else{{ $users->employer ? $users->employer->company : ucfirst(Auth::user()->firstName) }}@endif" tabindex="1">

									<div class="error-container">
										<label class="label-error error-company">{{ $message['ER:00:31'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="contents-form">
									<h1 class="label-select">Category:</h1>

									<select name="industry" class="select select-size-2 select-selected" tabindex="2" id="industry">
									  <option hidden disabled selected></option>
									  @foreach($industry as $val)
									  <option value="{{ $val->id }}" {{ $users->employer ? $val->id == $users->employer->industryId ? 'selected' : '' : '' }}>{{ $val->name }}</option>
									  @endforeach
									</select> 

									<div class="error-container">
										<label class="label-error error-industry">{{ $message['ER:00:35'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="contents-form">
									<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(188) }}:</h1>

									<input type="text" class="input input-size-2" name="phone" id="phone" value="@if($errors->any()){{ old('phone') }}@else{{ $users->employer ? $users->employer->telephone : '' }}@endif" tabindex="3">

									<div class="error-container">
										<label class="label-error error-phone">{{ $message['ER:00:21'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(41) }}:</h1>

									<input type="text" class="input input-size-2" name="email" id="email" value="{{ $users->employer ? $users->employer->email : '' }}" tabindex="4">
									<input type="checkbox" onclick="myFunction()" id="check_any" name="check_any" style="margin-left:4%; margin-top:5px; margin-right:5px" tabindex="5"><label for="check_any">{{ App\MaintenanceLocale::getLocale(309) }}</label>
									<div class="error-container">
										<label class="label-error error-email">{{ App\MaintenanceLocale::getLocale(105) }}.</label>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="contents-form">
							<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(51) }}:</h1>

							<div id="ckeditor-about">
								<textarea class="txtarea-size-2" name="about" id="about" tabindex="6">@if($errors->any()){{ old('about') }}@else{{ $users->employer? $users->employer->about_us:'' }}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-about">{{ $message['ER:00:37'] }}</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(310) }}:</h1>

							<div id="ckeditor-mission">
								<textarea class="txtarea-size-2" name="mission" id="mission" tabindex="7">@if($errors->any()){{ old('mission') }}@else{{ $users->employer?$users->employer->mission_vision:'' }}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-mission">{{ $message['ER:00:38'] }}</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(311) }}:</h1>

							<div id="ckeditor-philosophy">
								<textarea class="txtarea-size-2" name="philosophy" id="philosophy" tabindex="8">@if($errors->any()){{ old('philosophy') }}@else{{ $users->employer?$users->employer->philosophy:'' }}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-philosophy">{{ $message['ER:00:39'] }}</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(312) }}</h1>

							<div id="ckeditor-why">
								<textarea class="txtarea-size-2" name="whys" id="whys" tabindex="9">@if($errors->any()){{ old('whys') }}@else{{ $users->employer?$users->employer->why_choose:'' }}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-why">{{ $message['ER:00:40'] }}</label>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(332) }}:</h1>

									<select name="country" class="select select-size-2 select-selected" id="country" tabindex="10">
										<option hidden disabled selected></option>
									  @foreach($countries as $val)
									  <option value="{{ $val->id }}" {{ $users->address ? $val->id == $users->address->countryId ? 'selected' : '' : '' }}>{{ $val->nicename }}</option>
									  @endforeach
									</select> 

									<div class="error-container">
										<label class="label-error error-country">{{ $message['ER:00:23'] }}</label>
									</div>
								</div>

								<div class="contents-form">
									<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(330) }}:</h1>
									
									<input class="input input-size-2" name="street" id="street" value="@if($errors->any()){{ old('street') }}@else{{ $users->address ? $users->address->street : '' }}@endif" tabindex="12">

									<div class="error-container">
										<label class="label-error error-street">{{ $message['ER:00:26'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(331) }}:</h1>

									<input class="input input-size-2" name="city" id="city" value="@if($errors->any()){{ old('city') }}@else{{ $users->address ? $users->address->city : '' }}@endif" tabindex="11">

									<div class="error-container">
										<label class="label-error error-city">{{ $message['ER:00:24'] }}</label>
									</div>
								</div>

								<div class="contents-form">
									<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(333) }}:</h1>

									<input class="input input-size-2" name="zip" id="zip" value="@if($errors->any()){{ old('zip') }}@else{{ $users->address ? $users->address->zipcode : '' }}@endif" tabindex="13">

									<div class="error-container">
										<label class="label-error error-code"></label>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="contents-form">
							<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(334) }}:</h1>

							<input type="text" class="input input-size-2" name="website" id="website" value="{{ $users->employer ? $users->employer->website : '' }}" tabindex="14">

							<div class="error-container">
								<label class="label-error error-website">{{ App\MaintenanceLocale::getLocale(347) }}</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(335) }}:</h1>

							<input type="text" class="input input-size-2" name="facebook" id="facebook" value="{{ $users->employer ? $users->employer->facebook : '' }}" tabindex="15">

							<div class="error-container">
								<label class="label-error error-facebook">{{ App\MaintenanceLocale::getLocale(348) }}</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(336) }}:</h1>

							<input type="text" class="input input-size-2" name="twitter" id="twitter" value="{{ $users->employer ? $users->employer->twitter : '' }}" tabindex="16">

							<div class="error-container">
								<label class="label-error error-twitter">{{ App\MaintenanceLocale::getLocale(349) }}</label>
							</div>
						</div>

						<div class="content-footer-2">
							<button type="button" class="btn label-button btn-primary btn-size-1 save_button" tabindex="18">{{ App\MaintenanceLocale::getLocale(38) }}</button>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<script>
		function myFunction() {
			// Get the checkbox
			var checkBox = document.getElementById("check_any");
			
			// If the checkbox is checked, display the output text
			if (checkBox.checked == true){
				document.getElementById("email").disabled=true;
				document.getElementById("email").style.backgroundColor = "#DCDCDC";
			} else {
				document.getElementById("email").disabled=false;
				document.getElementById("email").style.backgroundColor = "";
			}
		}

		CKEDITOR.replace("about");
		CKEDITOR.replace("mission");
		CKEDITOR.replace("philosophy");
		CKEDITOR.replace("whys");

		$(document).ready(function(){
			var multipleCancelButton = new Choices('#affilated-agency', {
				removeItemButton: true
			});

			$("#detail-list").removeClass("sidebar-list-title");
			$("#detail-list").addClass("sidebar-list-title-active");

			@if($errors->any()) 
				@if(isset($errors->messages()['company']))  
					@if(preg_match('/required./', $errors->messages()['company'][0]))
						$("#company").css("border", "1px solid red");
						$(".error-company").show();
						$(".error-company").html("{{ $message['ER:00:31'] }}");
					@else
						$("#company").css("border", "1px solid red");
						$(".error-company").show();
						$(".error-company").html("{{ $message['ER:00:32'] }}");
					@endif
				@endif 

				@if(isset($errors->messages()['industry']))  
					@if(preg_match('/required./', $errors->messages()['industry'][0]))
						$("#industry").css("border", "1px solid red");
						$(".error-industry").show();
						$(".error-industry").html("{{ $message['ER:00:35'] }}");
					@else
						$("#industry").css("border", "1px solid red");
						$(".error-industry").show();
						$(".error-industry").html("{{ $message['ER:00:71'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['type']))  
					@if(preg_match('/required./', $errors->messages()['type'][0]))
						$("#type").css("border", "1px solid red");
						$(".error-type").show();
						$(".error-type").html("{{ $message['ER:00:36'] }}");
					@else
						$("#type").css("border", "1px solid red");
						$(".error-type").show();
						$(".error-type").html("{{ $message['ER:00:72'] }}");
					@endif
				@endif 

				@if(isset($errors->messages()['phone']))  
					@if(preg_match('/required./', $errors->messages()['phone'][0]))
						$("#phone").css("border", "1px solid red");
						$(".error-phone").show();
						$(".error-phone").html("{{ $message['ER:00:21'] }}");
					@else
						$("#company").css("border", "1px solid red");
						$(".error-phone").show();
						$(".error-phone").html("{{ $message['ER:00:22'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['about']))  
					$("#ckeditor-about").css('border', '1px solid red');
					$(".error-about").show();
					$(".error-about").html("{{ $message['ER:00:37'] }}");
				@endif 

				@if(isset($errors->messages()['mission']))  
					$("#ckeditor-mission").css('border', '1px solid red');
					$(".error-mission").show();
					$(".error-mission").html("{{ $message['ER:00:38'] }}");
				@endif 

				@if(isset($errors->messages()['philosophy']))  
					$("#ckeditor-philosophy").css('border', '1px solid red');
					$(".error-philosophy").show();
					$(".error-philosophy").html("{{ $message['ER:00:39'] }}");
				@endif 

				@if(isset($errors->messages()['whys']))  
					$("#ckeditor-whys").css('border', '1px solid red');
					$(".error-why").show();
					$(".error-why").html("{{ $message['ER:00:40'] }}");
				@endif

				@if(isset($errors->messages()['country']))  
					@if(preg_match('/required./', $errors->messages()['country'][0]))
						$("#country").css('border', '1px solid red');
						$(".error-country").show();
						$(".error-country").html("{{ $message['ER:00:23'] }}");
					@else
						$("#country").css('border', '1px solid red');
						$(".error-country").show();
						$(".error-country").html("{{ $message['ER:00:73'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['city']))  
					@if(preg_match('/required./', $errors->messages()['city'][0]))
						$("#city").css("border", "1px solid red");
						$(".error-city").show();
						$(".error-city").html("{{ $message['ER:00:24'] }}");
					@else
						$("#city").css("border", "1px solid red");
						$(".error-city").show();
						$(".error-city").html("{{ $message['ER:00:25'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['street']))  
					@if(preg_match('/required./', $errors->messages()['street'][0]))
						$("#street").css("border", "1px solid red");
						$(".error-street").show();
						$(".error-street").html("{{ $message['ER:00:26'] }}");
					@else
						$("#street").css("border", "1px solid red");
						$(".error-street").show();
						$(".error-street").html("{{ $message['ER:00:27'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['zip']))  
					@if(preg_match('/required./', $errors->messages()['zip'][0]))
						$("#zip").css("border", "1px solid red");
						$(".error-code").show();
						$(".error-code").html("{{ $message['ER:00:28'] }}");
					@elseif(preg_match('/required./', $errors->messages()['zip'][0]))
						$("#zip").css("border", "1px solid red");
						$(".error-code").show();
						$(".error-code").html("{{ $message['ER:00:30'] }}");
					@else
						$("#zip").css("border", "1px solid red");
						$(".error-code").show();
						$(".error-code").html("{{ $message['ER:00:29'] }}");
					@endif
				@endif 
			@endif
		});

		$(".save_button").click(function(e){
			$(".error-email").empty();
			$(".label-error").hide();
			var company_name 	= $("#company").val();
				company_name 	= company_name.trim();
				phone_number 	= $("#phone").val();
				phone_number 	= phone_number.trim();
                filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				about			= CKEDITOR.instances['about'].getData().replace(/<[^>]*>/gi, '').length;
				mission			= CKEDITOR.instances['mission'].getData().replace(/<[^>]*>/gi, '').length;
				philosophy		= CKEDITOR.instances['philosophy'].getData().replace(/<[^>]*>/gi, '').length;
				whys			= CKEDITOR.instances['whys'].getData().replace(/<[^>]*>/gi, '').length;
				industry 		= $("#industry").val();
				type 			= $("#type").val();
				country 		= $("#country").val();
				city 			= $("#city").val();
				city 			= city.trim();
				street 			= $("#street").val();
				street 			= street.trim();
				code 			= $("#zip").val();
				code 			= code.trim();

		  		document.getElementById("form").submit();
			if(company_name===null || company_name==="" || phone_number===null || phone_number==="" || !about || !mission || !philosophy || !whys || country===null || country==="" || city===null || city==="" || street===null || street==="" || code===null || code==="" || !code.match(/^\d+$/) || industry===null || industry==="" || type===null || type==="") {
				e.preventDefault();

				if(company_name===null || company_name==="") {
					$(".error-company").show();
					$(".error-company").html("{{ $message['ER:00:31'] }}");
					$("#company").css('border', '1px solid red');
				}

				if(phone_number===null || phone_number==="") {
					$(".error-phone").show();
					$(".error-phone").html("{{ $message['ER:00:21'] }}");
					$("#phone").css('border', '1px solid red');
				}

				if(!about) {
					$(".error-about").show();
					$(".error-about").html("{{ $message['ER:00:37'] }}");
					$("#ckeditor-about").css('border', '1px solid red');
				}

				if(!mission) {
					$(".error-mission").show();
					$(".error-mission").html("{{ $message['ER:00:38'] }}");
					$("#ckeditor-mission").css('border', '1px solid red');
				}

				if(!philosophy) {
					$(".error-philosophy").show();
					$(".error-philosophy").html("{{ $message['ER:00:39'] }}");
					$("#ckeditor-philosophy").css('border', '1px solid red');
				}

				if(!whys) {
					$(".error-why").show();
					$(".error-why").html("{{ $message['ER:00:40'] }}");
					$("#ckeditor-why").css('border', '1px solid red');
				}

				if(industry===null || industry==="") {
					$(".error-industry").show();
					$(".error-industry").html("{{ $message['ER:00:35'] }}");
					$("#industry").css('border', '1px solid red');
				}

				if(type===null || type==="") {
					$(".error-type").show();
					$(".error-type").html("{{ $message['ER:00:36'] }}");
					$("#type").css('border', '1px solid red');
				}

				if(country===null || country==="") {
					$(".error-country").show();
					$(".error-country").html("{{ $message['ER:00:23'] }}");
					$("#country").css('border', '1px solid red');
				}

				if(city===null || city==="") {
					$(".error-city").show();
					$(".error-city").html("{{ $message['ER:00:24'] }}");
					$("#city").css('border', '1px solid red');
				}

				if(street===null || street==="") {
					$(".error-street").html("{{ $message['ER:00:26'] }}");
					$(".error-street").show();
					$("#street").css('border', '1px solid red');
				}

				if(code===null || code==="" || !code.match(/^\d+$/)) {
					if(code===null || code==="") {
						$(".error-code").show();
						$(".error-code").html("{{ $message['ER:00:28'] }}");
						$("#zip").css('border', '1px solid red');
					}
					else {
						$(".error-code").show();
						$(".error-code").html("{{ $message['ER:00:30'] }}");
						$("#zip").css('border', '1px solid red');
			        }
			    }
			}
			else {
		  		document.getElementById("form").submit();
			}
		})

		$('#industry').change(function() {
	        $(".error-industry").hide();
			$(this).css("border", "");
	    });

	    $('#country').change(function() {
	        $(".error-country").hide();
			$(this).css("border", "");
	    });

	    $('#type').change(function() {
	        $(".error-type").hide();
			$(this).css("border", "");
	    });

		$('#company').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-company").show();
				$(".error-company").html("{{ $message['ER:00:31'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-company").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#phone').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-phone").show();
				$(".error-phone").html("{{ $message['ER:00:21'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-phone").hide();
				$(this).css("border", "");
	        }
	    });

	    CKEDITOR.instances.about.on('change', function () { 
	    	var length = CKEDITOR.instances['about'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-about").show();
				$(".error-about").html("{{ $message['ER:00:37'] }}");
				$("#ckeditor-about").css('border', '1px solid red');
	        }
	        else {
				$(".error-about").hide();
				$("#ckeditor-about").css('border', '');
	        }
	    });

	    CKEDITOR.instances.mission.on('change', function () { 
	    	var length = CKEDITOR.instances['mission'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-mission").show();
				$(".error-mission").html("{{ $message['ER:00:38'] }}");
				$("#ckeditor-mission").css('border', '1px solid red');
	        }
	        else {
				$(".error-mission").hide();
				$("#ckeditor-mission").css('border', '');
	        }
	    });

	    CKEDITOR.instances.philosophy.on('change', function () { 
	    	var length = CKEDITOR.instances['philosophy'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-philosophy").show();
				$(".error-philosophy").html("{{ $message['ER:00:39'] }}");
				$("#ckeditor-philosophy").css('border', '1px solid red');
	        }
	        else {
				$(".error-philosophy").hide();
				$("#ckeditor-philosophy").css('border', '');
	        }
	    });

	    CKEDITOR.instances.whys.on('change', function () { 
	    	var length = CKEDITOR.instances['whys'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-why").show();
				$(".error-why").html("{{ $message['ER:00:40'] }}");
				$("#ckeditor-why").css('border', '1px solid red');
	        }
	        else {
				$(".error-why").hide();
				$("#ckeditor-why").css('border', '');
	        }
	    });

	    $('#city').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-city").html("{{ $message['ER:00:24'] }}");
				$(".error-city").show();
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-city").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#street').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-street").show();
				$(".error-street").html("{{ $message['ER:00:26'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-street").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#zip').keyup(function(e) {
	        var zip 	= $(this).val();
	        	length 	= $(this).val().length;

	        if (!((e.keyCode>=48&&e.keyCode<= 57)||(e.keyCode>=65&&e.keyCode<=90))) {
		        return false;
		    }
		    else {
    	        if(length < 1) {
    				$(".error-code").show();
    				$(".error-code").html("{{ $message['ER:00:28'] }}");
    				$(this).css('border', '1px solid red');
    	        }
    	        else if(!zip.match(/^\d+$/)) {
    				$(".error-code").show();
    				$(".error-code").html("{{ $message['ER:00:30'] }}");
    				$(this).css('border', '1px solid red');
    	        }
    	        else {
    				$(".error-zip").hide();
					$(".error-code").hide();
    				$(this).css('border', '');
    	        }
		    }
	    });

	    $("#zip").keypress(function(e) {
		    if (!((e.keyCode>=48&&e.keyCode<= 57)||(e.keyCode>=65&&e.keyCode<=90))) {
		        return false;
		    }
		});
	</script>
@endsection
