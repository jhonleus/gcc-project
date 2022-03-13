@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(318))

@section('content')
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('support.sidebar.profile')
				@include('support.sidebar.index')
			</div>
			
			<div class="col-sm-9">
				<div class="card page-title">
					<div class="card-header card-header-1">
						<label class="label-information"> 
							Branch Details
						</label>
					</div>
					@if(isset($branch))
					<form method="POST" action="{{ route('support.branches.update', $branch->id) }}" id="form">
			            @method('PUT')
					    @csrf
					@else
					<form method="POST" action="{{ route('support.branches.store') }}" id="form">
					@csrf
					@endif
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="contents-form">
									<label class="label-select">Branch Name:</label>
								
									<input class="input" id="branch_name" name="branch_name" value="@if($errors->any()){{ old('branch_name') }}@else @if(isset($branch)){{$branch->branch_name}}@endif @endif">

									<div class="error-container">
										<label class="label-error error-branch_name">Branch Name is required.</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="contents-form">
									<label class="label-select">Contact Number:</label>
								
									<input class="input" id="contact_number" name="contact_number" value="@if($errors->any()){{ old('contact_number') }}@else @if(isset($branch)){{$branch->number}}@endif @endif">

									<div class="error-container">
										<label class="label-error error-contact_number">Contact Number is required.</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="contents-form">
									<label class="label-select">Country:</label>
									
									<select class="select @if($errors->any()) select-selected @else @if(isset($branch)) select-selected @endif @endif" id="country" name="country" >
										<option hidden selected disabled></option>
										@foreach($countries as $country)
											<option value="{{ $country->id }}"	@if($errors->any()) @if(old('country')==$country->id) {{"selected"}} @endif @else @if(isset($branch))@if($branch->countryId==$country->id) selected @endif @endif @endif>
												{{ $country->nicename }}
											</option>
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-country">Country is required.</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="contents-form">
									<label class="label-select">City:</label>
								
									<input class="input" id="city" name="city" value="@if($errors->any()){{ old('city') }}@else @if(isset($branch)){{$branch->city}}@endif @endif">

									<div class="error-container">
										<label class="label-error error-city">City is required.</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="contents-form">
									<label class="label-select">Steet:</label>
								
									<input class="input" id="street" name="street" value="@if($errors->any()){{ old('street') }}@else @if(isset($branch)){{$branch->street}}@endif @endif">

									<div class="error-container">
										<label class="label-error error-street">Steet is required.</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="contents-form">
									<label class="label-select">Zip Code:</label>
								
									<input class="input" id="code" name="code" value="@if($errors->any()){{ old('code') }}@else @if(isset($branch)){{$branch->zipcode}}@endif @endif">

									<div class="error-container">
										<label class="label-error error-code">Zip Code is required.</label>
									</div>
								</div>
							</div>
						</div>

						<div class="content-footer-2">
							<button class="btn label-button btn-primary" id="save_button">@if(isset($branch)) Update @else{{ App\MaintenanceLocale::getLocale(35) }} @endif</button>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			@if($errors->any()) 
				@if(isset($errors->messages()['branch_name']))  
					@if(preg_match('/required./', $errors->messages()['branch_name'][0]))
						$("#branch_name").css("border", "1px solid red");
						$(".error-branch_name").html("{{ $message['ER:00:19'] }}");
						$(".error-branch_name").show();
					@else
						$("#branch_name").css("border", "1px solid red");
						$(".error-branch_name").html("{{ $message['ER:00:20'] }}");
						$(".error-branch_name").show();
					@endif
				@endif 

				@if(isset($errors->messages()['contact_number']))  
					@if(preg_match('/required./', $errors->messages()['contact_number'][0]))
						$("#contact_number").css("border", "1px solid red");
						$(".error-contact_number").html("{{ $message['ER:00:21'] }}");
						$(".error-contact_number").show();
					@else
						$("#branch_name").css("border", "1px solid red");
						$(".error-contact_number").html("{{ $message['ER:00:22'] }}");
						$(".error-contact_number").show();
					@endif
				@endif

				@if(isset($errors->messages()['country']))  
					@if(preg_match('/required./', $errors->messages()['country'][0]))
						$("#country").css("border", "1px solid red");
						$(".error-country").html("{{ $message['ER:00:23'] }}");
						$(".error-country").show();
					@else
						$("#country").css("border", "1px solid red");
						$(".error-country").html("{{ $message['ER:00:73'] }}");
						$(".error-country").show();
					@endif
				@endif

				@if(isset($errors->messages()['city']))  
					@if(preg_match('/required./', $errors->messages()['city'][0]))
						$("#city").css("border", "1px solid red");
						$(".error-city").html("{{ $message['ER:00:24'] }}");
						$(".error-city").show();
					@else
						$("#city").css("border", "1px solid red");
						$(".error-city").html("{{ $message['ER:00:25'] }}");
						$(".error-city").show();
					@endif
				@endif

				@if(isset($errors->messages()['street']))  
					@if(preg_match('/required./', $errors->messages()['street'][0]))
						$("#street").css("border", "1px solid red");
						$(".error-street").html("{{ $message['ER:00:26'] }}");
						$(".error-street").show();
					@else
						$("#street").css("border", "1px solid red");
						$(".error-street").html("{{ $message['ER:00:27'] }}");
						$(".error-street").show();
					@endif
				@endif

				@if(isset($errors->messages()['code']))  
					@if(preg_match('/required./', $errors->messages()['code'][0]))
						$("#code").css("border", "1px solid red");
						$(".error-code").html("{{ $message['ER:00:28'] }}");
						$(".error-code").show();
					@elseif(preg_match('/characters./', $errors->messages()['code'][0]))
						$("#code").css("border", "1px solid red");
						$(".error-code").html("{{ $message['ER:00:29'] }}");
						$(".error-code").show();
					@else
						$("#code").css("border", "1px solid red");
						$(".error-code").html("{{ $message['ER:00:30'] }}");
						$(".error-code").show();
					@endif
				@endif
			@endif
		});

		$(document).ready(function(){
			$("#branch-list").removeClass("sidebar-list-title");
			$("#branch-list").addClass("sidebar-list-title-active");
		});
		
		$("#save_button").click(function(e) {
			var branch_name 	= $("#branch_name").val();
				branch_name 	= branch_name.trim();
				country 		= $("#country").val();
				city 			= $("#city").val();
				city 			= city.trim();
				street 			= $("#street").val();
				street 			= street.trim();
				code 			= $("#code").val();
				code 			= code.trim();
				contact_number 	= $("#contact_number").val();
				contact_number 	= contact_number.trim();

			if(branch_name==="" || country==="" || country===null || city==="" || street==="" || code==="" || contact_number==="" || !code.match(/^\d+$/)) {
				e.preventDefault();

				if(branch_name==="") {
					$(".error-branch_name").show();
					$(".error-branch_name").html("{{ $message['ER:00:19'] }}");
					$("#branch_name").css("border", "1px solid red");
				}

				if(country==="" || country===null) {
					$(".error-country").show();
					$(".error-country").html("{{ $message['ER:00:23'] }}");
					$("#country").css("border", "1px solid red");
				}

				if(city==="") {
					$(".error-city").show();
					$(".error-city").html("{{ $message['ER:00:24'] }}");
					$("#city").css("border", "1px solid red");
				}

				if(street==="") {
					$(".error-street").show();
					$(".error-street").html("{{ $message['ER:00:26'] }}");
					$("#street").css("border", "1px solid red");
				}

				if(code==="" || !code.match(/^\d+$/)) {
					if(code==="") {
						$(".error-code").show();
						$(".error-code").html("{{ $message['ER:00:28'] }}");
						$("#code").css('border', '1px solid red');
					}
					else {
						$(".error-code").show();
						$(".error-code").html("{{ $message['ER:00:30'] }}");
						$("#code").css('border', '1px solid red');
			        }
			    }

				if(contact_number==="") {
					$(".error-contact_number").show();
					$(".error-contact_number").html("{{ $message['ER:00:21'] }}");
					$("#contact_number").css("border", "1px solid red");
				}
			}
		})

		$("#country").change(function() {
			$(".error-country").hide();
			$(this).css("border", "");
		});

		$('#branch_name').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-branch_name").show();
				$(".error-branch_name").html("{{ $message['ER:00:19'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-branch_name").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#contact_number').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-contact_number").show();
				$(".error-contact_number").html("{{ $message['ER:00:21'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-contact_number").hide();
				$(this).css("border", "");
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
				$(".error-street").html("{{ $message['ER:00:26'] }}");
				$(".error-street").show();
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-street").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#code').keyup(function(e) {
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
					$(".error-code").hide();
    				$(this).css('border', '');
    	        }
		    }
	    });

	    $("#code").keypress(function(e) {
		    if (!((e.keyCode>=48&&e.keyCode<= 57)||(e.keyCode>=65&&e.keyCode<=90))) {
		        return false;
		    }
		});
	</script>
@endsection
