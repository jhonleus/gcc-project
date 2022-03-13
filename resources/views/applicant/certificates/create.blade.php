@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(425))

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
						<label class="profile-information-label">{{ App\MaintenanceLocale::getLocale(425) }}</label>
					</div>
					<form method="POST" action="{{ route('applicant.certificate.store') }}" enctype="multipart/form-data">
					  @csrf
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6"> 
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(543) }}:</h1>
									
		                    		<select class="select @if($errors->any()) select-selected @endif" id="type" name="type">
		                    			<option selected hidden disabled></option>
		                    			<option value="N1" @if($errors->any()) @if(old('type')==="N1") selected @endif @endif>N1</option>
		                    			<option value="N2" @if($errors->any()) @if(old('type')==="N2") selected @endif @endif>N2</option> 
		                    			<option value="N3" @if($errors->any()) @if(old('type')==="N3") selected @endif @endif>N3</option> 
		                    			<option value="N4" @if($errors->any()) @if(old('type')==="N4") selected @endif @endif>N4</option> 
		                    			<option value="N5" @if($errors->any()) @if(old('type')==="N5") selected @endif @endif>N5</option> 
		                    			<option value="Others" @if($errors->any()) @if(old('type')==="Others") selected @endif @endif>Others</option> 
		                    		</select>

									<div class="error-container">
										<label class="label-error error-type">{{ $message['ER:00:99'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(544) }}:</h1>
									
		                    		<input class="input" name="number" id="number" value="@if($errors->any()){{ old('number') }}@endif">

									<div class="error-container">
										<label class="label-error error-number">{{ $message['ER:01:02'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(545) }}:</h1>
									
		                    		<input class="input" name="accreditor" id="accreditor" value="@if($errors->any()){{ old('accreditor') }}@endif">

									<div class="error-container">
										<label class="label-error error-accreditor">{{ $message['ER:01:04'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6"> 
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(546) }}:</h1>
									
		                    		<input type="date" class="input" name="date_issued" id="date_issued" value="@if($errors->any()){{ old('date_issued') }}@endif">

									<div class="error-container">
										<label class="label-error error-date_issued">{{ $message['ER:01:06'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<div class="profile-forms">
							<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(547) }}:</h1>
							
							<input type="file" name="certificate" id="certificate" onchange="certiURL(this);" accept=".doc, .docx, .pdf" id="certificate" class="input" hidden>
							<label for="certificate" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
							<label id="certiName" style="display:none;"></label>

							<div class="error-container">
								<label class="label-error error-certificate">{{ $message['ER:01:01'] }}</label>
							</div>
						</div>

						<div class="profile-footer-action">
							<button class="btn profile-button btn-chinese save_button">{{ App\MaintenanceLocale::getLocale(161) }}</button>
           					<a href="{{ url('applicant/certificates') }}" class="btn btn-secondary profile-button">{{ App\MaintenanceLocale::getLocale(454) }}</a>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>

function certiURL(input) {
  
  if (input.files && input.files[0])
  {
    var name = document.getElementById('certificate').files.item(0).name;
    document.getElementById('certiName').style.display = "block";
    document.getElementById('certiName').innerHTML = "{{ App\MaintenanceLocale::getLocale(202) }}: " + name;
  }
}

		$(document).ready(function(){
			$("#certificates-list").removeClass("profile-label-settings-content");
			$("#certificates-list").addClass("profile-label-settings-content-active");

			@if($errors->any()) 
				@if(isset($errors->messages()['certificate']))  
					@if(preg_match('/required./', $errors->messages()['certificate'][0]))
						$("#certificate").css("border", "1px solid red");
						$(".error-certificate").show();
						$(".error-certificate").html("{{ $message['ER:01:01'] }}");
					@endif
				@endif 

				@if(isset($errors->messages()['type']))  
					@if(preg_match('/required./', $errors->messages()['type'][0]))
						$("#type").css("border", "1px solid red");
						$(".error-type").show();
						$(".error-type").html("{{ $message['ER:00:99'] }}");
					@else
						$("#type").css("border", "1px solid red");
						$(".error-type").show();
						$(".error-type").html("{{ $message['ER:01:00'] }}");
					@endif
				@endif 

				@if(isset($errors->messages()['number']))  
					@if(preg_match('/required./', $errors->messages()['number'][0]))
						$("#number").css("border", "1px solid red");
						$(".error-number").show();
						$(".error-number").html("{{ $message['ER:01:02'] }}");
					@else
						$("#number").css("border", "1px solid red");
						$(".error-number").show();
						$(".error-number").html("{{ $message['ER:01:03'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['accreditor']))  
					@if(preg_match('/required./', $errors->messages()['accreditor'][0]))
						$("#accreditor").css("border", "1px solid red");
						$(".error-accreditor").show();
						$(".error-accreditor").html("{{ $message['ER:01:04'] }}");
					@else
						$("#accreditor").css("border", "1px solid red");
						$(".error-accreditor").show();
						$(".error-accreditor").html("{{ $message['ER:01:05'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['date_issued']))  
					@if(preg_match('/required./', $errors->messages()['date_issued'][0]))
						$("#date_issued").css("border", "1px solid red");
						$(".error-date_issued").show();
						$(".error-date_issued").html("{{ $message['ER:01:06'] }}");
					@else
						$("#date_issued").css("border", "1px solid red");
						$(".error-date_issued").show();
						$(".error-date_issued").html("{{ $message['ER:01:07'] }}");
					@endif
				@endif
			@endif
		});

		$(".save_button").click(function(e) {
			$(".label-error").hide();

			var certificate = $('#certificate').get(0).files.length;
				type 		= $("#type").val();
				number 		= $("#number").val();
				accreditor 	= $("#accreditor").val();
				date_issued = $("#date_issued").val();

				now 	= new Date();
				date 	= new Date(date_issued);

			if(certificate===0 || type==="" || type===null || number==="" || accreditor==="" || !date_issued || date > now) {
				e.preventDefault();

				if(certificate===0){
					$(".error-certificate").html("{{ $message['ER:01:01'] }}");
					$(".error-certificate").show();
				}

				if(type==="" || type===null){
					$(".error-type").html("{{ $message['ER:00:99'] }}");
					$(".error-type").show();
					$("#type").css("border", "1px solid red");
				}

		        if(number==="") {
					$(".error-number").show();
					$(".error-number").html("{{ $message['ER:01:02'] }}");
					$("#number").css("border", "1px solid red");
		        }

                if(accreditor==="") {
        			$(".error-accreditor").show();
        			$(".error-accreditor").html("{{ $message['ER:01:04'] }}");
					$("#accreditor").css("border", "1px solid red");
                }

                if(!date_issued || date > now) {
	                if(!date_issued) {
	        			$(".error-date_issued").show();
	        			$(".error-date_issued").html("{{ $message['ER:01:06'] }}");
						$("#date_issued").css("border", "1px solid red");
	                }
	                else if(date > now) {
	                	$(".error-date_issued").show();
	        			$(".error-date_issued").html("{{ $message['ER:01:07'] }}");
						$("#date_issued").css("border", "1px solid red");
	                }
	            }
			}
		});

		$('#certificate').change(function() {
			var certificate = $('#certificate').get(0).files.length;

	        if(certificate===0) {
				$(".error-certificate").html("{{ $message['ER:01:01'] }}");
				$(".error-certificate").show();
	        }
	        else {
				$(".error-certificate").hide();
	        }
	    });

	  	$('#type').change(function() {
	        var length = $(this).val();

	        if(length===""||length===null) {
				$(".error-type").show();
				$(".error-type").html("{{ $message['ER:00:99'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-type").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#number').keyup(function() {
	        var length = $(this).val();

	        if(length==="") {
				$(".error-number").show();
				$(".error-number").html("{{ $message['ER:01:02'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-number").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#accreditor').keyup(function() {
	        var length = $(this).val();

	        if(length==="") {
				$(".error-accreditor").show();
				$(".error-accreditor").html("{{ $message['ER:01:04'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-accreditor").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#date_issued').change(function() {
	        var length = $(this).val();

	        now 	= new Date();
	        date 	= new Date(length);

	        if(!length) {
				$(".error-date_issued").show();
				$(".error-date_issued").html("{{ $message['ER:01:06'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else if(date > now) {
	        	$(".error-date_issued").show();
				$(".error-date_issued").html("{{ $message['ER:01:07'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-date_issued").hide();
				$(this).css("border", "");
	        }
	    });

	    $("#certificate").change(function() {
			var file = $(this).get(0).files.length;

			if(file===0) {
			    $(".error-certificate").show();
			    $(".error-certificate").html("{{ $message['ER:01:01'] }}");
				$("#certificate").css("border", "1px solid red");
			}
			else {
			    $(".error-certificate").hide();
				$("#certificate").css("border", "");
			}
		});
	</script>
@endsection
