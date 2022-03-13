@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(422))

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
						<label class="profile-information-label">{{ App\MaintenanceLocale::getLocale(422) }}</label>
					</div>
					@if(!isset($education))
						<form method="POST" id="edit_info" action="{{ route('applicant.education.store') }}">
					  		@csrf
					@else
						<form method="POST" id="edit_info" action="{{ route('applicant.education.update', $education->id) }}">
						    @method('PUT')
						    @csrf
					@endif
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(540) }}:</h1>
									
									<select class="select @if($errors->any()) select-selected @else @if(isset($education)) select-selected @endif @endif" name="level" id="level">
										<option disabled hidden selected></option>
										@foreach($levels as $level)
											<option value="{{$level->id}}" @if($errors->any()) @if(old('level') == $level->id) selected @endif @else @if(isset($education)) @if($level->id == $education->levels->id) selected @endif @endif @endif>{{ $level->name }}</option>
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-level">{{ $message['ER:01:08'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(541) }}:</h1>
									
									<input class="input" id="attainment" name="attainment" value="@if($errors->any()){{ old('attainment') }}@else @if(isset($education)){{$education->attainment}}@endif @endif">  

									<div class="error-container">
										<label class="label-error error-attainment">{{ $message['ER:00:00'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(542) }}:</h1>
									
									<input class="input" id="school" name="school" value="@if($errors->any()){{ old('school') }}@else @if(isset($education)){{$education->name}}@endif @endif">  

									<div class="error-container">
										<label class="label-error error-school">{{ $message['ER:00:84'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(332) }}:</h1>
									
									<select class="select @if($errors->any()) select-selected @else @if(isset($education)) select-selected @endif @endif" name="country" id="country">
										<option disabled hidden selected></option>
										@foreach($countries as $country)
											<option value="{{$country->id}}" @if($errors->any()) @if(old('country')==$country->id) selected @endif @else @if(isset($education)) @if($country->id == $education->countryId) selected @endif @endif @endif>{{ $country->nicename }}</option>
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-country">{{ $message['ER:00:23'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(537) }}:</h1>

									<div id="dateStart">
										<input type="text" class="input" name="date_start" id="date_start" value="@if($errors->any()){{ old('school') }}@else @if(isset($education)) {{$education->dateStart}}@endif @endif">
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
										<input type="text" class="input" name="date_year" id="date_year" value="@if($errors->any()){{ old('school') }}@else @if(isset($education)){{$education->dateEnd}}@endif @endif">
									</div>

									<div class="error-container">
										<label class="label-error error-date_year">{{ $message['ER:00:09'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<div class="profile-footer-action">
							<button class="btn profile-button btn-chinese save_button">@if(!isset($education)) {{ App\MaintenanceLocale::getLocale(161) }} @else {{ App\MaintenanceLocale::getLocale(38) }} @endif</button>
           					<a href="{{ url('applicant/education') }}" class="btn btn-secondary profile-button">{{ App\MaintenanceLocale::getLocale(454) }}</a>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			var school 		= $("#school").val($("#school").val().trim());
				date_start 	= $("#date_start").val($("#date_start").val().trim());
				date_year 	= $("#date_year").val($("#date_year").val().trim());
				attainment 	= $("#attainment").val($("#attainment").val().trim());

			$("#educations-list").removeClass("profile-label-settings-content");
			$("#educations-list").addClass("profile-label-settings-content-active");

			@if($errors->any()) 
				@if(isset($errors->messages()['level']))  
					@if(preg_match('/required./', $errors->messages()['level'][0]))
						$("#level").css("border", "1px solid red");
						$(".error-level").show();
						$(".error-level").html("{{ $message['ER:01:08'] }}");
					@else
						$("#level").css("border", "1px solid red");
						$(".error-level").show();
						$(".error-level").html("{{ $message['ER:01:09'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['country']))  
					@if(preg_match('/required./', $errors->messages()['level'][0]))
						$("#country").css("border", "1px solid red");
						$(".error-country").show();
						$(".error-country").html("{{ $message['ER:00:23'] }}");
					@else
						$("#country").css("border", "1px solid red");
						$(".error-country").show();
						$(".error-country").html("{{ $message['ER:00:73'] }}");
					@endif
				@endif 

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

				@if(isset($errors->messages()['attainment']))  
					@if(preg_match('/required./', $errors->messages()['attainment'][0]))
						$("#attainment").css("border", "1px solid red");
						$(".error-attainment").show();
						$(".error-attainment").html("{{ $message['ER:00:00'] }}");
					@else
						$("#attainment").css("border", "1px solid red");
						$(".error-attainment").show();
						$(".error-attainment").html("{{ $message['ER:00:01'] }}");
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
		    maxDate: new Date()
		});
		
		$("#dateStart").on("dp.show", function(e) {
		   $(e.target).data("DateTimePicker").viewMode("months"); 
		});

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
		    maxDate: new Date()
		});
		
		$("#dateEnd").on("dp.show", function(e) {
		   $(e.target).data("DateTimePicker").viewMode("months"); 
		});

		$(".save_button").click(function(e) {
			$(".label-error").hide();

			var school 		= $("#school").val().trim();
				country 	= $("#country").val();
				level 		= $("#level").val();
				date_start 	= $("#date_start").val().trim();
				date_year 	= $("#date_year").val().trim();
				attainment 	= $("#attainment").val().trim();

			if(school==="" || country==="" || country===null || level==="" || level===null || date_start==="" || date_year==="" || attainment==="") {
				e.preventDefault();

				if(school===""){
					$(".error-school").show();
					$(".error-school").html("{{ $message['ER:00:84'] }}");
					$("#school").css("border", "1px solid red");
				}

				if(country==="" || country===null){
					$(".error-country").html("{{ $message['ER:00:23'] }}");
					$(".error-country").show();
					$("#country").css("border", "1px solid red");
				}

				if(level==="" || level===null){
					$(".error-level").html("{{ $message['ER:01:08'] }}");
					$(".error-level").show();
					$("#level").css("border", "1px solid red");
				}

				if(date_start===""){
					$(".error-date_start").show();
					$(".error-date_start").html("{{ $message['ER:00:07'] }}");
					$("#date_start").css("border", "1px solid red");
				}

				if(date_year===""){
					$(".error-date_year").show();
					$(".error-date_year").html("{{ $message['ER:00:09'] }}");
					$("#date_year").css("border", "1px solid red");
				}

				if(attainment===""){
					$(".error-attainment").show();
					$(".error-attainment").html("{{ $message['ER:00:00'] }}");
					$("#attainment").css("border", "1px solid red");
				}
			}
		});

	    $('#school').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-school").show();
				$(".error-school").html("{{ $message['ER:00:84'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-school").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#attainment').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-attainment").show();
				$(".error-attainment").html("{{ $message['ER:00:00'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-attainment").hide();
				$(this).css("border", "");
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
				$(".error-country").html("{{ $message['ER:00:23'] }}");
				$(".error-country").show();
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-country").hide();
				$(this).css("border", "");
	        }
	    });

	  	$('#level').change(function() {
	        var length = $(this).val();

	        if(length===""||length===null) {
				$(".error-level").html("{{ $message['ER:01:08'] }}");
				$(".error-level").show();
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-level").hide();
				$(this).css("border", "");
	        }
	    });
	</script>
@endsection
