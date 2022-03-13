@extends('layouts.header')

@section('title', 'Partner Details')

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/chosen/choices.min.css') }}">
	<script src="{{ asset("resources/js/chosen/choices.min.js") }}"></script>

	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('school.sidebar.profile')
				@include('school.sidebar.index')
			</div>
			<div class="col-sm-9">
				<div class="card page-title">
					<div class="card-header card-header-1">
						<label class="label-information"> 
							Partner Details
						</label>
					</div>
					<form method="POST" action="{{ route('school.partners.store') }}" id="form">
					@csrf
					<div class="card-body">
						<div class="contents-form">
							<label class="label-select">Partners:</label>

							<select id="partners" placeholder="Search your partners" multiple name="partners[]">
								@foreach($users as $user)
								@if(!is_null($user->school))
					            <option value="{{$user->id}}">{{$user->school->school}}</option>
					            @endif
					            @endforeach
					        </select>

							<div class="error-container">
								<label class="label-error error-partners">{{ $message['ER:00:17'] }}</label>
							</div>
						</div>

						<div class="content-footer-2">
							<button class="btn label-button btn-primary" id="save_button">Save</button>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			var multipleCancelButton = new Choices('#partners', {
				removeItemButton: true
			});

			$("#partner-list").removeClass("sidebar-list-title");
			$("#partner-list").addClass("sidebar-list-title-active");

			@if($errors->any()) 
				@if(isset($errors->messages()['partners']))  
					@if(preg_match('/required./', $errors->messages()['partners'][0]))
						$(".choices").css("border", "1px solid red");
						$(".error-partners").show();
						$(".error-partners").html("{{ $message['ER:00:17'] }}");
					@else
						$(".choices").css("border", "1px solid red");
						$(".error-partners").show();
						$(".error-partners").html("{{ $message['ER:00:80'] }}");
					@endif
				@endif 
			@endif
		});

		$("#save_button").click(function(e) {
			var partners = $("#partners").val();

			if(partners.length < 1) {
				$(".error-partners").show();
				$(".error-partners").html("{{ $message['ER:00:17'] }}");
				$(".choices").css("border", "1px solid red");
				e.preventDefault();
			}
		});

		$("#partners").change(function() {
			var branches = $("#partners").val();

			if(branches.length < 1) {
				$(".error-partners").show();
				$(".error-partners").html("{{ $message['ER:00:17'] }}");
				$(".choices").css("border", "1px solid red");
			}
			else {
				$(".error-partners").hide();
				$(".choices").css("border", "");
			}
		});
	</script>
@endsection
