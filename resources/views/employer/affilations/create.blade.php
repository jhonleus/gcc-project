@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(317))

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/chosen/choices.min.css') }}">
	<script src="{{ asset("resources/js/chosen/choices.min.js") }}"></script>

	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('employer.sidebar.profile')
				@include('employer.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card page-title">
					<div class="card-header card-header-1">
						<label class="label-information"> 
							{{ App\MaintenanceLocale::getLocale(317) }}
						</label>
					</div>
					<form method="POST" action="{{ route('employer.affilations.store') }}" id="form">
					@csrf
					<div class="card-body">
						<div class="contents-form">

							<select id="affilations" placeholder="{{ App\MaintenanceLocale::getLocale(355) }}" multiple name="affilations[]">
								@foreach($users as $user)
									@if($user->rolesId==4)
										@if(!is_null($user->school))
							            <option value="{{$user->id}}">{{$user->school->school}}</option>
							            @endif
									@else
										@if(!is_null($user->employer))
							            <option value="{{$user->id}}">{{$user->employer->company}}</option>
							            @endif
							        @endif
					            @endforeach
					        </select>

							<div class="error-container">
								<label class="label-error error-affilations">{{ $message['ER:00:16'] }}</label>
							</div>
						</div>

						<div class="content-footer-2">
							<button class="btn label-button btn-primary" id="save_button">{{ App\MaintenanceLocale::getLocale(35) }}</button>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			var multipleCancelButton = new Choices('#affilations', {
				removeItemButton: true,
				noResultsText: '{{ App\MaintenanceLocale::getLocale(120) }}',
				noChoicesText: '{{ App\MaintenanceLocale::getLocale(357) }}',
				loadingText: '{{ App\MaintenanceLocale::getLocale(212) }}'
			});

			$("#affilations-list").removeClass("sidebar-list-title");
			$("#affilations-list").addClass("sidebar-list-title-active");

			@if($errors->any()) 
				@if(isset($errors->messages()['affilations']))  
					@if(preg_match('/required./', $errors->messages()['affilations'][0]))
						$(".choices").css("border", "1px solid red");
						$(".error-affilations").show();
						$(".error-affilations").html("{{ $message['ER:00:16'] }}");
					@else
						$(".choices").css("border", "1px solid red");
						$(".error-affilations").show();
						$(".error-affilations").html("{{ $message['ER:00:60'] }}");
					@endif
				@endif 
			@endif
		});

		$("#save_button").click(function(e) {
			var affilations = $("#affilations").val();

			if(affilations.length < 1) {
				$(".error-affilations").show();
				$(".error-affilations").html("{{ $message['ER:00:16'] }}");
				$(".choices").css("border", "1px solid red");
				e.preventDefault();
			}
		});

		$("#affilations").change(function() {
			var affilations = $("#affilations").val();

			if(affilations.length < 1) {
				$(".error-affilations").show();
				$(".error-affilations").html("{{ $message['ER:00:16'] }}");
				$(".choices").css("border", "1px solid red");
			}
			else {
				$(".error-affilations").hide();
				$(".choices").css("border", "");
			}
		});
	</script>
@endsection
