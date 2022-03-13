@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(424))

@section('content')
	<div class="container profile-container">
		<div class="row">
			<div class="col-sm-3">
				@include('applicant.sidebar.profile')
				@include('applicant.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card profile-contents">
					<div class="card-header profile-information-header">
						<label class="profile-information-label">{{ App\MaintenanceLocale::getLocale(424) }}</label>
					</div>
					@if(empty($skills))
						<form method="POST" id="edit_info" action="{{ route('applicant.skills.store') }}">
						    @csrf
					@else
						<form method="POST" id="edit_info" action="{{ route('applicant.skills.update', $skills->id) }}">
						    @method('PUT')
						    @csrf
					@endif
					<div class="card-body">
						<div class="profile-forms">
							<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(530) }}:</h1>

							<textarea class="txtarea" name="strong" id="strong">@if($errors->any()) {{ old('strong') }} @else @if(!empty($skills)){{$skills->strongPoints}}@endif @endif</textarea>

							<div class="error-container">
								<label class="label-error error-strong">{{ $message['ER:01:12'] }}</label>
							</div>
						</div>

						<div class="profile-forms">
							<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(531) }}:</h1>

							<textarea class="txtarea" name="weak" id="weak">@if($errors->any()) {{ old('weak') }} @else @if(!empty($skills)){{$skills->weakPoints}}@endif @endif</textarea>

							<div class="error-container">
								<label class="label-error error-weak">{{ $message['ER:01:13'] }}</label>
							</div>
						</div>

						<div class="profile-footer-action">
							<button class="btn profile-button btn-chinese save_button">@if(empty($skills)) {{ App\MaintenanceLocale::getLocale(161) }} @else {{ App\MaintenanceLocale::getLocale(38) }} @endif</button>
           					<a href="{{ url('applicant/skills') }}" class="btn btn-secondary profile-button">{{ App\MaintenanceLocale::getLocale(454) }}</a>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			var strong  = $("#strong").val($("#strong").val().trim());
				weak  	= $("#weak").val($("#weak").val().trim());

			$("#skills-list").removeClass("profile-label-settings-content");
			$("#skills-list").addClass("profile-label-settings-content-active");

			@if($errors->any()) 
				@if(isset($errors->messages()['strong']))  
					@if(preg_match('/required./', $errors->messages()['strong'][0]))
						$("#strong").css("border", "1px solid red");
						$(".error-strong").show();
						$(".error-strong").html("{{ $message['ER:01:12'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['weak']))  
					@if(preg_match('/required./', $errors->messages()['weak'][0]))
						$("#weak").css("border", "1px solid red");
						$(".error-weak").show();
						$(".error-weak").html("{{ $message['ER:01:13'] }}");
					@endif
				@endif
			@endif
		});

		$('#strong').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-strong").show();
				$(".error-strong").html("{{ $message['ER:01:12'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-strong").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#weak').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-weak").show();
				$(".error-weak").html("{{ $message['ER:01:13'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-weak").hide();
				$(this).css("border", "");
	        }
	    });

	    $(".save_button").click(function(e) {
	    	var strong  = $("#strong").val().trim();
	    		weak  	= $("#weak").val().trim();

	    	if(strong==="" || weak==="") {
	    		e.preventDefault();
	    		
		        if(weak==="") {
					$(".error-weak").show();
					$(".error-weak").html("{{ $message['ER:01:13'] }}");
					$("#weak").css("border", "1px solid red");
		        }
                if(strong==="") {
        			$(".error-strong").show();
        			$(".error-strong").html("{{ $message['ER:01:12'] }}");
        			$("#strong").css("border", "1px solid red");
                }
	    	}
	    });
	</script>
@endsection
