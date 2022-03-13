@extends('layouts.header')

@section('title', 'School Details')

@section('content')
	<!--CKEDITOR-->
	<script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('school.sidebar.profile')
				@include('school.sidebar.index')
			</div>

			<div class="col-sm-9">
				<form method="POST" action="{{ route('school.details.update', $users->id) }}" id="form">
				@method('PUT')
				@csrf
				<div class="card page-title">
					<div class="card-header card-header-1">
						<label class="label-information">School Details</label>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">School Name:</h1>

									<input type="text" class="input" name="school" id="school" value="@if($errors->any()){{ old('school') }}@else{{ $users->school ? $users->school->school : old('school') }}@endif">

									<div class="error-container">
										<label class="label-error error-school">{{ $message['ER:00:84'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="contents-form">
									<h1 class="label-select">Company Type:</h1>

									<select name="type" class="select select-selected" tabindex="2" id="type">
									  <option hidden disabled selected></option>
									  @foreach($types as $val)
									  <option value="{{ $val->id }}" {{ $users->school ? $val->id == $users->school->typeId ? 'selected' : '' : '' }}>{{ $val->name }}</option>
									  @endforeach
									</select> 

									<div class="error-container">
										<label class="label-error error-type">{{ $message['ER:00:36'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">Telephone Number:</h1>

									<input type="text" class="input" name="phone" id="phone" value="@if($errors->any()){{ old('phone') }}@else{{ $users->school ? $users->school->telephone : '' }}@endif">

									<div class="error-container">
										<label class="label-error error-phone">{{ $message['ER:00:21'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">Email Address:</h1>

									<input type="text" class="input" name="email" id="email" value="@if($errors->any()){{ old('email') }}@else{{ $users->school ? $users->school->email : '' }}@endif">
									<input type="checkbox" onclick="myFunction()" id="check_any" name="check_any" style="margin-top:5px; margin-right:5px" tabindex="2"><label for="check_any">Use my current Email Address</label>
									
									<div class="error-container">
										<label class="label-error error-email">Email Address is required.</label>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="contents-form">
							<h1 class="label-select">About Us:</h1>

							<div class="ckeditor-about">
								<textarea class="txtarea" name="about" id="about">@if($errors->any()){{ old('about') }}@else{{ $users->school?$users->school->about_us:'' }}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-about">{{ $message['ER:00:37'] }}</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">Mission and Vision:</h1>

							<div class="ckeditor-mission">
								<textarea class="txtarea" name="mission" id="mission">@if($errors->any()){{ old('mission') }}@else{{ $users->school?$users->school->mission_vision:'' }}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-mission">{{ $message['ER:00:38'] }}</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">Philosophy:</h1>

							<div class="ckeditor-philosophy">
								<textarea class="txtarea" name="philosophy" id="philosophy">@if($errors->any()){{ old('philosophy') }}@else{{ $users->school?$users->school->philosophy:'' }}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-philosophy">{{ $message['ER:00:39'] }}</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">Why You Choose Us?</h1>

							<div class="ckeditor-why">
								<textarea class="txtarea" name="whys" id="whys">@if($errors->any()){{ old('whys') }}@else{{ $users->school?$users->school->why_choose:'' }}@endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-why">{{ $message['ER:00:40'] }}</label>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">Country:</h1>

									<select name="country" class="select select-selected" id="country">Select</option>
									  @foreach($countries as $val)
									  <option value="{{ $val->id }}" {{ $users->address ? $val->id == $users->address->countryId ? 'selected' : '' : '' }}>{{ $val->nicename }}</option>
									  @endforeach
									</select> 

									<div class="error-container">
										<label class="label-error error-country">{{ $message['ER:00:23'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">City:</h1>

									<input class="input" name="city" id="city" value="@if($errors->any()){{ old('city') }}@else{{ $users->address ? $users->address->city : '' }}@endif">

									<div class="error-container">
										<label class="label-error error-city">{{ $message['ER:00:24'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">Street:</h1>
									
									<input class="input" name="street" id="street"value="@if($errors->any()){{ old('street') }}@else{{ $users->address ? $users->address->street : '' }}@endif">

									<div class="error-container">
										<label class="label-error error-street">{{ $message['ER:00:26'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="contents-form">
									<h1 class="label-select">Zip Code:</h1>

									<input class="input" name="zip" id="zip" value="@if($errors->any()){{ old('zip') }}@else{{ $users->address ? $users->address->zipcode : '' }}@endif">

									<div class="error-container">
										<label class="label-error error-code">{{ $message['ER:00:28'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="contents-form">
							<h1 class="label-select">Website:</h1>

							<input type="text" class="input" name="website" id="website" value="{{ $users->school ? $users->school->website : '' }}">

							<div class="error-container">
								<label class="label-error error-website">Website is required</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">Facebook:</h1>

							<input type="text" class="input" name="facebook" id="facebook" value="{{ $users->school ? $users->school->facebook : '' }}">

							<div class="error-container">
								<label class="label-error error-facebook">Facebook is required</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">Twitter:</h1>

							<input type="text" class="input" name="twitter" id="twitter" value="{{ $users->school ? $users->school->twitter : '' }}">

							<div class="error-container">
								<label class="label-error error-twitter">Twitter is required</label>
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
		$(document).ready(function(){
			$("#detail-list").removeClass("sidebar-list-title");
			$("#detail-list").addClass("sidebar-list-title-active");

			@if($errors->any()) 
				@if(isset($errors->messages()['school']))  
					@if(preg_match('/required./', $errors->messages()['school'][0]))
						$("#school").css("border", "1px solid red");
						$(".error-school").show();
						$(".error-school").html("{{ $message['ER:00:84'] }}");
					@else
						$("#school").css("border", "1px solid red");
						$(".error-school").show();
						$(".error-school").html("{{ $message['ER:00:85'] }}");
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

		$(".save_button").click(function(e){
			$(".error-email").empty();
			$(".label-error").hide();
			var school_name 	= $("#school").val();
				phone_number 	= $("#phone").val();
				type 			= $("#type").val();
                filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				about			= CKEDITOR.instances['about'].getData().replace(/<[^>]*>/gi, '').length;
				mission			= CKEDITOR.instances['mission'].getData().replace(/<[^>]*>/gi, '').length;
				philosophy		= CKEDITOR.instances['philosophy'].getData().replace(/<[^>]*>/gi, '').length;
				whys			= CKEDITOR.instances['whys'].getData().replace(/<[^>]*>/gi, '').length;
				country 		= $("#country").val();
				city 			= $("#city").val();
				street 			= $("#street").val();
				code 			= $("#zip").val();

			if(school_name===null || school_name==="" || phone_number===null || phone_number==="" || !about || !mission || !philosophy || !whys || country===null || country==="" || city===null || city==="" || street===null || street==="" || code===null || code==="" || !code.match(/^\d+$/) || type===null || type==="") {
				//e.preventDefault();

				if(school_name===null || school_name==="") {
					$(".error-school").html("{{ $message['ER:00:84'] }}");
					$(".error-school").show();
					$("#school").css('border', '1px solid red');
				}

				if(type===null || type==="") {
					$(".error-type").html("{{ $message['ER:00:36'] }}");
					$(".error-type").show();
					$("#type").css('border', '1px solid red');
				}

				if(phone_number===null || phone_number==="") {
					$(".error-phone").show();
					$(".error-phone").html("{{ $message['ER:00:21'] }}");
					$("#phone").css('border', '1px solid red');
				}

				if(!about) {
					$(".error-about").show();
					$(".error-about").html("{{ $message['ER:00:37'] }}");
					$(".ckeditor-about").css('border', '1px solid red');
				}

				if(!mission) {
					$(".error-mission").show();
					$(".error-mission").html("{{ $message['ER:00:38'] }}");
					$(".ckeditor-mission").css('border', '1px solid red');
				}

				if(!philosophy) {
					$(".error-philosophy").show();
					$(".error-philosophy").html("{{ $message['ER:00:39'] }}");
					$(".ckeditor-philosophy").css('border', '1px solid red');
				}

				if(!whys) {
					$(".error-why").show();
					$(".error-why").html("{{ $message['ER:00:40'] }}");
					$(".ckeditor-why").css('border', '1px solid red');
				}

				if(country===null || country==="") {
					$(".error-country").show();
					$(".error-country").html("{{ $message['ER:00:23'] }}");
					$(".country").css('border', '1px solid red');
				}

				if(city===null || city==="") {
					$(".error-city").show();
					$(".error-city").html("{{ $message['ER:00:24'] }}");
					$("#city").css('border', '1px solid red');
				}

				if(street===null || street==="") {
					$(".error-street").show();
					$(".error-street").html("{{ $message['ER:00:26'] }}");
					$("#street").css('border', '1px solid red');
				}

				if(!code.match(/^\d+$/) || code===null || code==="") {
					if(code===null || code==="") {
						$(".error-code").show();
						$(".error-code").html("{{ $message['ER:00:28'] }}");
						$("#code").css('border', '1px solid red');
					}
			        else {
						$(".error-code").show();
						$(".error-code").html("{{ $message['ER:00:29'] }}");
						$("#code").css('border', '1px solid red');
			        }
			    }
			}
			else {
		  		document.getElementById("form").submit();
			}
		})

		$('#school').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-school").html("{{ $message['ER:00:84'] }}");
				$(".error-school").show();
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-school").hide();
				$(this).css('border', '');
	        }
	    });

	    $('#phone').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-phone").show();
				$(".error-phone").html("{{ $message['ER:00:21'] }}");
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-phone").hide();
				$(this).css('border', '');
	        }
	    });

	    CKEDITOR.instances.about.on('change', function () { 
	    	var length = CKEDITOR.instances['about'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-about").show();
				$(".error-about").html("{{ $message['ER:00:37'] }}");
				$(".ckeditor-about").css('border', '1px solid red');
	        }
	        else {
				$(".error-about").hide();
				$(".ckeditor-about").css('border', '');
	        }
	    });

	    CKEDITOR.instances.mission.on('change', function () { 
	    	var length = CKEDITOR.instances['mission'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-mission").show();
				$(".error-mission").html("{{ $message['ER:00:38'] }}");
				$(".ckeditor-mission").css('border', '1px solid red');
	        }
	        else {
				$(".error-mission").hide();
				$(".ckeditor-mission").css('border', '');
	        }
	    });

	    CKEDITOR.instances.philosophy.on('change', function () { 
	    	var length = CKEDITOR.instances['philosophy'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-philosophy").show();
				$(".error-philosophy").html("{{ $message['ER:00:39'] }}");
				$(".ckeditor-philosophy").css('border', '1px solid red');
	        }
	        else {
				$(".error-philosophy").hide();
				$(".ckeditor-philosophy").css('border', '');
	        }
	    });

	    CKEDITOR.instances.whys.on('change', function () { 
	    	var length = CKEDITOR.instances['whys'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-why").show();
				$(".error-why").html("{{ $message['ER:00:40'] }}");
				$(".ckeditor-why").css('border', '1px solid red');
	        }
	        else {
				$(".error-why").hide();
				$(".ckeditor-why").css('border', '');
	        }
	    });

	    $('#country').change(function() {
			$(".error-country").hide();
			$(this).css('border', '');
	    });

	    $('#type').change(function() {
			$(".error-type").hide();
			$(this).css('border', '');
	    });

	    $('#city').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-city").show();
				$(".error-city").html("{{ $message['ER:00:24'] }}");
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-city").hide();
				$(this).css('border', '');
	        }
	    });

	    $('#street').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-street").show();
				$(".error-street").html("{{ $message['ER:00:26'] }}");
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-street").hide();
				$(this).css('border', '');
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
    				$(".error-code").html("{{ $message['ER:00:29'] }}");
    				$(this).css('border', '1px solid red');
    	        }
    	        else {
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
