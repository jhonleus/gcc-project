@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(421))

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/bootstrap/datetimepicker.min.css') }}" />
	<script src="{{ asset('resources/js/bootstrap/moment.min.js') }}"></script>
	<script src="{{ asset('resources/js/bootstrap/jquery.min.js') }}"></script>
	<script src="{{ asset('resources/js/bootstrap/datetimepicker.min.js') }}"></script>

	<div class="container profile-container">
		<div class="row">
			<div class="col-sm-3">
				@include('applicant.sidebar.profile')
				@include('applicant.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card profile-contents">
					<div class="card-header profile-information-header">
						<label class="profile-information-label">{{ App\MaintenanceLocale::getLocale(421) }}</label>
					</div>
					@if(!isset($work))
						<form method="POST" id="edit_info" action="{{ route('applicant.work_experience.store') }}">
					  		@csrf
					@else
						<form method="POST" id="edit_info" action="{{ route('applicant.work_experience.update', $work->id) }}">
						    @method('PUT')
						    @csrf
					@endif
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(145) }}:</h1>
									<input type="text" class="input" name="company" id="company" value="@if($errors->any()){{ old('company') }}@else @if(isset($work)){{$work->company}}@endif @endif">

									<div class="error-container">
										<label class="label-error error-company">{{ $message['ER:00:31'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(536) }}:</h1>
									<input type="text" class="input" name="position" id="position" value="@if($errors->any()){{ old('position') }}@else @if(isset($work)){{$work->position}}@endif @endif">

									<div class="error-container">
										<label class="label-error error-position">{{ $message['ER:01:14'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(537) }}:</h1>

									<div id="dateStart">
										<input type="text" class="input" name="date_start" id="date_start" value="@if($errors->any()){{ old('date_start') }}@else @if(isset($work)){{$work->dateStart}}@endif @endif">
									</div>

									<div class="error-container">
										<label class="label-error error-date_start">{{ $message['ER:00:07'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(538) }}:</h1>

									<div id="dateEnd">
										<input type="text" class="input" name="date_year" id="date_year" value="@if($errors->any()){{ old('date_year') }}@else @if(isset($work)){{$work->dateEnd}}@endif @endif">
									</div>
									<input type="checkbox" id="date_year2" name="date_year2" style="margin-top:5px; margin-right:5px" @if($errors->any()){{ old('date_year2') }}@else @if(isset($work)){{$work->dateEnd == null ? "checked" : ""}}@endif @endif><label for="check_any">Present</label>

									<div class="error-container">
										<label class="label-error error-date_year">{{ $message['ER:00:09'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(332) }}:</h1>

									<select class="select @if($errors->any()) select-selected @else @if(isset($work)) select-selected @endif @endif" name="country" id="country">
										<option disabled hidden selected></option>
										@foreach($countries as $country)
											<option value="{{$country->id}}" @if($errors->any()) @if(old('country')==$country->id) selected @endif @else @if(isset($work)) @if($country->id == $work->countryId) selected @endif @endif @endif>{{ $country->nicename }}</option>
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-country">{{ $message['ER:00:23'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<div class="profile-forms">
							<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(534) }}:</h1>

							<textarea class="txtarea" name="responsibly" id="responsibly">@if($errors->any()){{ old('responsibly') }}@else @if(isset($work)){{$work->jobResponsibly}}@endif @endif</textarea>

							<div class="error-container">
								<label class="label-error error-responsibly">{{ $message['ER:00:56'] }}</label>
							</div>
						</div>

						<div class="profile-footer-action">
							<button class="btn profile-button btn-chinese save_button">@if(!isset($work)) {{ App\MaintenanceLocale::getLocale(161) }} @else {{ App\MaintenanceLocale::getLocale(38) }} @endif</button>
           					<a href="{{ url('applicant/work_experience') }}" class="btn btn-secondary profile-button">{{ App\MaintenanceLocale::getLocale(454) }}</a>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			var company 	= $("#company").val($("#company").val().trim());
				date_start 	= $("#date_start").val($("#date_start").val().trim());
				date_year 	= $("#date_year").val($("#date_year").val().trim());
				position 	= $("#position").val($("#position").val().trim());
				responsibly = $("#responsibly").val($("#responsibly").val().trim());

			$("#works-list").removeClass("profile-label-settings-content");
			$("#works-list").addClass("profile-label-settings-content-active");

			@if($errors->any()) 
				@if(isset($errors->messages()['country']))  
					@if(preg_match('/required./', $errors->messages()['country'][0]))
						$("#country").css("border", "1px solid red");
						$(".error-country").show();
						$(".error-country").html("{{ $message['ER:00:23'] }}");
					@else
						$("#country").css("border", "1px solid red");
						$(".error-country").show();
						$(".error-country").html("{{ $message['ER:00:73'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['company']))  
					@if(preg_match('/required./', $errors->messages()['company'][0]))
						$("#company").css("border", "1px solid red");
						$(".error-company").show();
						$(".error-company").html("{{ $message['ER:00:23'] }}");
					@else
						$("#company").css("border", "1px solid red");
						$(".error-company").show();
						$(".error-company").html("{{ $message['ER:00:73'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['date_start']))  
					@if(preg_match('/required./', $errors->messages()['date_start'][0]))
						$("#date_start").css("border", "1px solid red");
						$(".error-date_start").show();
						$(".error-date_start").html("{{ $message['ER:00:07'] }}");
					@else
						$("#date_start").css("border", "1px solid red");
						$(".error-date_start").show();
						$(".error-date_start").html("{{ $message['ER:01:10'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['date_year']))  
					@if(preg_match('/required./', $errors->messages()['date_year'][0]))
						$("#date_year").css("border", "1px solid red");
						$(".error-date_year").show();
						$(".error-date_year").html("{{ $message['ER:00:09'] }}");
					@else
						$("#date_year").css("border", "1px solid red");
						$(".error-date_year").show();
						$(".error-date_year").html("{{ $message['ER:01:11'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['position']))  
					@if(preg_match('/required./', $errors->messages()['position'][0]))
						$("#position").css("border", "1px solid red");
						$(".error-position").show();
						$(".error-position").html("{{ $message['ER:01:14'] }}");
					@else
						$("#position").css("border", "1px solid red");
						$(".error-position").show();
						$(".error-position").html("{{ $message['ER:01:15'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['responsibly']))  
					@if(preg_match('/required./', $errors->messages()['responsibly'][0]))
						$("#responsibly").css("border", "1px solid red");
						$(".error-responsibly").show();
						$(".error-responsibly").html("{{ $message['ER:00:56'] }}");
					@endif
				@endif
			@endif
		});

		$('#dateStart').datetimepicker({
		    viewMode : 'months',
		    format : 'MMM YYYY',
		    toolbarPlacement: "top",
		    allowInputToggle: true,
		    icons: {
		        time: 'fa fa-time',
		        date: 'fa fa-calendar',
		        up: 'fa fa-chevron-up',
		        down: 'fa fa-chevron-down',
		        previous: 'fa fa-chevron-left',
		        next: 'fa fa-chevron-right',
		        today: 'fa fa-screenshot',
		        clear: 'fa fa-trash',
		        close: 'fa fa-remove'
		    },
		    //maxDate: new Date()
		});
		
		$("#dateStart").on("dp.show", function(e) {
		   $(e.target).data("DateTimePicker").viewMode("months"); 
		});

		if($("#date_year2").prop("checked") === false) {

			$('#dateEnd').datetimepicker({
			    viewMode : 'months',
			    format : 'MMM YYYY',
			    toolbarPlacement: "top",
			    allowInputToggle: true,
			    icons: {
			        time: 'fa fa-time',
			        date: 'fa fa-calendar',
			        up: 'fa fa-chevron-up',
			        down: 'fa fa-chevron-down',
			        previous: 'fa fa-chevron-left',
			        next: 'fa fa-chevron-right',
			        today: 'fa fa-screenshot',
			        clear: 'fa fa-trash',
			        close: 'fa fa-remove'
			    },
			    //maxDate: new Date()
			});

		}
		
		$("#dateEnd").on("dp.show", function(e) {

			if($("#date_year2").prop("checked")) {

				$("#date_year").val(' ')
				$('#dateEnd').data("DateTimePicker").disable();
			}

			else {

		   		$(e.target).data("DateTimePicker").viewMode("months"); 

			}

		});

		$("#dateStart").click(function() {
	    	$(".error-date_start").hide();
	    	$("#date_start").css("border", "");
	    });

	     $("#dateEnd").click(function() {
	    	$(".error-date_year").hide();
	    	$("#date_year").css("border", "");
	    });

	    $("#date_year2").change(function() {
	    	$(".error-date_year").hide();
	    	$("#date_year").css("border", "");
	    });

		$(".save_button").click(function(e) {
			$(".label-error").hide();

			var company 	= $("#company").val().trim();
				country 	= $("#country").val();
				date_start 	= $("#date_start").val().trim();
				date_year 	= $("#date_year").val().trim();
				position 	= $("#position").val().trim();
				responsibly = $("#responsibly").val().trim();
				date_year2 	= $("#date_year2").prop("checked");

				if(date_year2) {

					date_end = true;

				}

				else {

					if(date_year==="") {
						date_end = false;
					}
					else {
						date_end = true;
					}

				}

			if(company==="" || country==="" || country===null || date_start==="" || position==="" || responsibly==="" || !date_end) {
				e.preventDefault();
				if(company===""){
					$(".error-company").html("{{ $message['ER:00:31'] }}");
					$(".error-company").show();
					$("#company").css("border", "1px solid red");
				}

				if(country==="" || country===null){
					$(".error-country").show();
					$(".error-country").html("{{ $message['ER:00:23'] }}");
					$("#country").css("border", "1px solid red");
				}

				if(date_start===""){
					$(".error-date_start").show();
					$(".error-date_start").html("{{ $message['ER:00:07'] }}");
					$("#date_start").css("border", "1px solid red");
				}

				if(!date_end){
					$(".error-date_year").show();
					$(".error-date_year").html("{{ $message['ER:00:09'] }}");
					$("#date_year").css("border", "1px solid red");
				}

				if(position===""){
					$(".error-position").show();
					$(".error-position").html("{{ $message['ER:01:14'] }}");
					$("#position").css("border", "1px solid red");
				}

				if(responsibly===""){
					$(".error-responsibly").show();
					$(".error-responsibly").html("{{ $message['ER:00:56'] }}");
					$("#responsibly").css("border", "1px solid red");
				}
			}
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

	    $('#position').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-position").show();
				$(".error-position").html("{{ $message['ER:01:14'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-position").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#date_start').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-date_start").show();
				$(".error-date_start").html("{{ $message['ER:00:07'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-date_start").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#date_year').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-date_year").show();
				$(".error-date_year").html("{{ $message['ER:00:09'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-date_year").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#country').change(function() {
	        var length = $(this).val();

	        if(length===""||length===null) {
				$(".error-country").show();
				$(".error-country").html("{{ $message['ER:00:23'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-country").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#responsibly').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-responsibly").show();
				$(".error-responsibly").html("{{ $message['ER:00:56'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-responsibly").hide();
				$(this).css("border", "");
	        }
	    });
	</script>
@endsection
