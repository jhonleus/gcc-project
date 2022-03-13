@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(414))

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/chosen/choices.min.css') }}">
	<script src="{{ asset("resources/js/chosen/choices.min.js") }}"></script>

	<div class="container profile-container">
				@include('flash-message')
		<div class="row">
			<div class="col-sm-3">
				@include('applicant.sidebar.profile')
				@include('applicant.sidebar.index')
			</div>

			<div class="col-sm-9">
				<form method="POST" action="{{ route('applicant.personal.update', $users->id) }}">
				  @method('PUT')
				  @csrf
				<div class="card profile-contents">
					<div class="card-header profile-information-header">
						<label class="profile-information-label">{{ App\MaintenanceLocale::getLocale(414) }}</label>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(39) }}:</h1>
									<input type="text" class="input" name="firstname" value="@if($errors->any()){{old('firstname')}}@else{{ $users->firstName }}@endif" id="firstname">

									<div class="error-container">
										<label class="label-error error-firstname">{{ $message['ER:01:24'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(40) }}:</h1>
									<input type="text" class="input" value="@if($errors->any()){{old('lastname')}}@else{{ $users->lastName }}@endif" name="lastname" id="lastname">

									<div class="error-container">
										<label class="label-error error-lastname">{{ $message['ER:01:26'] }}</label>
									</div>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-6">
										<div class="profile-forms">
											<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(419) }}:</h1>
											
											<input type="date" class="input" value="@if($errors->any()){{old('birthdate')}}@else{{ $users->details ? $users->details->birthDate : '' }}@endif" id="birthdate" name="birthdate" onchange="getAge()" >
                    						<input hidden type="text" id="age" name="age" value="@if($errors->any()){{old('age')}}@else{{ $users->details ? $users->details->age : '' }}@endif"> 

											<div class="error-container">
												<label class="label-error error-birthdate">{{ $message['ER:01:33'] }}</label>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="profile-forms">
											<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(436) }}:</h1>
											
											<select class="select select-selected" name="gender" id="gender"> 
												<option hidden></option>
												@foreach($genders as $val)
							                     	<option value="{{ $val->id }}" @if($errors->any()) @if(old('gender')==$val->id) selected @endif @else{{ $users->details ? $users->details->genders ? $val->id == $users->details->genders->id ? 'selected' : '' : '' : '' }}@endif>{{ $val->name }}</option>
							                    @endforeach
											</select>

											<div class="error-container">
												<label class="label-error error-gender">{{ $message['ER:01:35'] }}</label>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-6">
										<div class="profile-forms">
											<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(19) }}:</h1>
											
											<select class="select select-selected" name="civil" id="civil"> 
												<option hidden></option>
												@foreach($civils as $val)
													<option value="{{ $val->id }}" @if($errors->any()) @if(old('civil')==$val->id) selected @endif @else{{ $users->details ? $users->details->civils ? $val->id == $users->details->civils->id ? 'selected' : '' : '' : '' }}@endif>{{ $val->name }}</option>
												@endforeach
											</select>

											<div class="error-container">
												<label class="label-error error-civil">{{ App\MaintenanceLocale::getLocale(443) }}.</label>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="profile-forms">
											<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(27) }}:</h1>
											
											<select class="select select-selected" name="religion" id="religion"> 
												<option hidden></option>
												@foreach($religions as $val)
													<option value="{{ $val->id }}" @if($errors->any()) @if(old('religion')==$val->id) selected @endif @else{{ $users->details ? $users->details->religions ? $val->id == $users->details->religions->id ? 'selected' : '' : '' : '' }}@endif>{{ $val->name }}</option>
												@endforeach
											</select>

											<div class="error-container">
												<label class="label-error error-religion">{{ $message['ER:01:39'] }}</label>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(529) }}:</h1>
									<select class="select {{ $users->details ? "select-selected" : "" }}" name="type_visa" id="type_visa">
										@foreach($types as $type)
											<option value="{{$type->id}}" @if($errors->any()) @if(old('type_visa')==$type->id) selected @endif @else{{ $users->details ? $type->id == $users->details->typeId ? 'selected' : '' : '' }}@endif>{{$type->name}}</option>
										@endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-type">{{ $message['ER:01:43'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6 result-div" style="@if($errors->any()) @if(old('type_visa')==10) @endif @else{{ $users->details ? $users->details->typeId==14 ? : "display:none" : "" }}@endif">
								<div class="profile-forms"> 
									<h1 class="profile-details-input">Type of Skill Evaluation:</h1>

									<select class="select {{ $users->details ? "select-selected" : "" }}" name="result" id="result">
										@foreach($results as $result)
											<option value="{{$result->id}}" @if($errors->any()) @if(old('result')==$type->id) selected @endif @else{{ $users->details ? $result->id == $users->details->result ? 'selected' : '' : '' }}@endif>{{$result->name}}</option>
										@endforeach
									</select>


									<div class="error-container">
										<label class="label-error error-result">{{ $message['ER:01:45'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(74) }}:</h1>
									<input type="text" class="input" value="@if($errors->any()){{old('username')}}@else{{ $users->username }}@endif" name="username" id="username">

									<div class="error-container">
										<label class="label-error error-username">{{ $message['ER:01:28'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(41) }}:</h1>
									<input type="text" class="input" name="email" id="email" value="@if($errors->any()){{old('email')}}@else{{ $users->email }}@endif">

									<div class="error-container">
										<label class="label-error error-email">{{ $message['ER:00:33'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(187) }}:</h1>
								<div class="row">
									<div class="col-sm-4">
										<div class="profile-forms">
											<select class="select select-selected" name="countycode" name="countycode">
												@foreach($countries as $val)
												  <option value="{{ $val->id }}" @if($errors->any()) @if(old('countycode')==$val->id) selected @endif@else{{ $users->contacts ? $val->id == $users->contacts->codeId ? 'selected' : '' : '' }}@endif>{{$val->iso}} +{{$val->phonecode}}</option>
												@endforeach 
											</select>

											<div class="error-container">
												<label class="label-error error-countycode">{{ App\MaintenanceLocale::getLocale(445) }}.</label>
											</div>
										</div>
									</div>
									<div class="col-sm-8">
										<div class="profile-forms">
											<input class="input" id="number" name="number" value="@if($errors->any()){{old('number')}}@else{{ $users->contacts ? $users->contacts->number : '' }}@endif">

											<div class="error-container">
												<label class="label-error error-number">{{ App\MaintenanceLocale::getLocale(446) }}.</label>
											</div>
										</div>
									</div>
								</div>

								
							</div>
						</div>

						<hr>

						<div class="row">

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(330) }}:</h1>
                   		 			<input type="text" name="street" id="street" class="input" value="@if($errors->any()){{old('street')}}@else{{ $users->address ? $users->address->street : '' }}@endif"> 

									<div class="error-container">
										<label class="label-error error-street">{{ $message['ER:00:26'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(331) }}:</h1>
									<input name="city" type="text" class="input" value="@if($errors->any()){{old('city')}}@else{{ $users->address ? $users->address->city : '' }}@endif" id="city"> 

									<div class="error-container">
										<label class="label-error error-city">{{ $message['ER:00:24'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(332) }}:</h1>
									
									<select class="select select-selected" name="country" id="country"> 
										@foreach($countries as $val)
				                        <option value="{{ $val->id }}" @if($errors->any()) @if(old('country')==$val->id) selected @endif @else{{ $users->address ? $val->id == $users->address->countryId ? 'selected' : '' : '' }}@endif>{{ $val->nicename }}</option>
				                        @endforeach
									</select>

									<div class="error-container">
										<label class="label-error error-country">{{ $message['ER:00:23'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(333) }}:</h1>
									
									<input type="number" name="zip" id="zip" class="input" value="@if($errors->any()){{old('zip')}}@else{{ $users->address ? $users->address->zipcode : '' }}@endif"> 

									<div class="error-container">
										<label class="label-error error-zip">{{ $message['ER:00:28'] }}</label>
									</div>
								</div>
							</div>
							
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(23) }}:</h1>
									
									<select id="hobbies" placeholder="{{ App\MaintenanceLocale::getLocale(455) }}" multiple name="hobbies[]">
										@foreach($hobbies as $hobby)
										<option {{ $users->hobbies ? in_array($hobby->id, $hobbiesTags) ? 'selected' : '' : '' }} value="{{$hobby->id}}">{{$hobby->name}}</option>
										@endforeach
									</select>	

									<div class="error-container">
										<label class="label-error error-hobbies">{{ $message['ER:01:48'] }}</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(437) }}:</h1>
									
									<select id="location" placeholder="{{ App\MaintenanceLocale::getLocale(456) }}" multiple name="location[]">
										@foreach($countries as $country)
										<option {{ $users->location ? in_array($country->id, $locationTags) ? 'selected' : '' : '' }} value="{{$country->id}}">{{$country->nicename}}</option>
										@endforeach
									</select>	

									<div class="error-container">
										<label class="label-error error-location">{{ App\MaintenanceLocale::getLocale(448) }}.</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="profile-forms">
									<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(438) }}:</h1>
									
									<select id="specialization" placeholder="{{ App\MaintenanceLocale::getLocale(457) }}" multiple name="specialization[]">
										@foreach($specializations as $specialization)
										<option {{ $users->specialization ? in_array($specialization->id, $specializationTags) ? 'selected' : '' : '' }} value="{{$specialization->id}}">{{$specialization->name}}</option>
										@endforeach
									</select>	

									<div class="error-container">
										<label class="label-error error-hobbies">{{ App\MaintenanceLocale::getLocale(449) }}.</label>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<h1 class="profile-details-input">{{ App\MaintenanceLocale::getLocale(439) }}:</h1>
								<div class="row">
									<div class="col-sm-4">
										<div class="profile-forms">
											<select class="select select-selected" name="currency" id="currency">
												@foreach($currencies as $val)
												 	<option value="{{ $val->id }}" @if($errors->any()) @if(old('currency')==$val->id) selected @endif @else{{ $users->details ? $users->details->currency ? $val->id == $users->details->currencyId ? 'selected' : '' : '' : '' }}@endif>{{ $val->name }}</option>
												@endforeach 
											</select>

											<div class="error-container">
												<label class="label-error error-currency">{{ $message['ER:00:03'] }}</label>
											</div>
										</div>
									</div>
									<div class="col-sm-8">
										<div class="profile-forms">
											<input class="input" id="numbers" name="numbers" value="@if($errors->any()){{old('numbers')}}@else{{ $users->details ? $users->details->number : '' }}@endif">

											<div class="error-container">
												<label class="label-error error-numbers">{{ $message['ER:00:21'] }}</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="profile-footer-action">
							<button class="btn profile-button btn-primary save_button">{{ App\MaintenanceLocale::getLocale(161) }}</button>
           					<a href="{{ url('applicant/personal') }}" class="btn btn-secondary profile-button">{{ App\MaintenanceLocale::getLocale(454) }}</a>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#personal-list").removeClass("profile-label-settings-content");
			$("#personal-list").addClass("profile-label-settings-content-active");

			var multipleCancelButton = new Choices('#hobbies', {
				removeItemButton: true
			});

			var multipleCancelButton = new Choices('#location', {
				removeItemButton: true
			});

			var multipleCancelButton = new Choices('#specialization', {
				removeItemButton: true
			});

			@if($errors->any()) 
				@if(isset($errors->messages()['firstname']))  
					@if(preg_match('/required./', $errors->messages()['firstname'][0]))
						$("#firstname").css("border", "1px solid red");
						$(".error-firstname").show();
						$(".error-firstname").html("{{ $message['ER:01:24'] }}");
					@else
						$("#firstname").css("border", "1px solid red");
						$(".error-firstname").show();
						$(".error-firstname").html("{{ $message['ER:01:25'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['lastname']))  
					@if(preg_match('/required./', $errors->messages()['lastname'][0]))
						$("#lastname").css("border", "1px solid red");
						$(".error-lastname").show();
						$(".error-lastname").html("{{ $message['ER:01:26'] }}");
					@else
						$("#lastname").css("border", "1px solid red");
						$(".error-lastname").show();
						$(".error-lastname").html("{{ $message['ER:01:27'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['username']))  
					@if(preg_match('/required./', $errors->messages()['username'][0]))
						$("#username").css("border", "1px solid red");
						$(".error-username").show();
						$(".error-username").html("{{ $message['ER:01:28'] }}");
					@elseif(preg_match('/taken./', $errors->messages()['username'][0]))
						$("#username").css("border", "1px solid red");
						$(".error-username").show();
						$(".error-username").html("{{ $message['ER:01:30'] }}");
					@else
						$("#username").css("border", "1px solid red");
						$(".error-username").show();
						$(".error-username").html("{{ $message['ER:01:29'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['email']))  
					@if(preg_match('/required./', $errors->messages()['email'][0]))
						$("#email").css("border", "1px solid red");
						$(".error-email").show();
						$(".error-email").html("{{ $message['ER:00:33'] }}");
					@elseif(preg_match('/taken./', $errors->messages()['email'][0]))
						$("#email").css("border", "1px solid red");
						$(".error-email").show();
						$(".error-email").html("{{ $message['ER:01:31'] }}");
					@elseif(preg_match('/taken./', $errors->messages()['email'][0]))
						$("#email").css("border", "1px solid red");
						$(".error-email").show();
						$(".error-email").html("{{ $message['ER:01:32'] }}");
					@else
						$("#email").css("border", "1px solid red");
						$(".error-email").show();
						$(".error-email").html("{{ $message['ER:00:34'] }}");
					@endif
				@endif 

				@if(isset($errors->messages()['birthdate']))  
					@if(preg_match('/required./', $errors->messages()['birthdate'][0]))
						$("#birthdate").css("border", "1px solid red");
						$(".error-birthdate").show();
						$(".error-birthdate").html("{{ $message['ER:01:33'] }}");
					@else
						$("#birthdate").css("border", "1px solid red");
						$(".error-birthdate").show();
						$(".error-birthdate").html("{{ $message['ER:01:34'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['gender']))  
					@if(preg_match('/required./', $errors->messages()['gender'][0]))
						$("#gender").css("border", "1px solid red");
						$(".error-gender").show();
						$(".error-gender").html("{{ $message['ER:01:35'] }}");
					@else
						$("#gender").css("border", "1px solid red");
						$(".error-gender").show();
						$(".error-gender").html("{{ $message['ER:01:36'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['civil']))  
					@if(preg_match('/required./', $errors->messages()['civil'][0]))
						$("#civil").css("border", "1px solid red");
						$(".error-civil").show();
						$(".error-civil").html("{{ $message['ER:01:37'] }}");
					@else
						$("#civil").css("border", "1px solid red");
						$(".error-civil").show();
						$(".error-civil").html("{{ $message['ER:01:38'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['religion']))  
					@if(preg_match('/required./', $errors->messages()['religion'][0]))
						$("#religion").css("border", "1px solid red");
						$(".error-religion").show();
						$(".error-religion").html("{{ $message['ER:01:39'] }}");
					@else
						$("#religion").css("border", "1px solid red");
						$(".error-religion").show();
						$(".error-religion").html("{{ $message['ER:01:40'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['currency']))  
					@if(preg_match('/required./', $errors->messages()['currency'][0]))
						$("#currency").css("border", "1px solid red");
						$(".error-currency").show();
						$(".error-currency").html("{{ $message['ER:00:03'] }}");
					@else
						$("#currency").css("border", "1px solid red");
						$(".error-currency").show();
						$(".error-currency").html("{{ $message['ER:00:77'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['numbers']))  
					@if(preg_match('/required./', $errors->messages()['numbers'][0]))
						$("#numbers").css("border", "1px solid red");
						$(".error-numbers").show();
						$(".error-numbers").html("{{ $message['ER:00:21'] }}");
					@elseif(preg_match('/number./', $errors->messages()['numbers'][0]))
						$("#numbers").css("border", "1px solid red");
						$(".error-numbers").show();
						$(".error-numbers").html("{{ $message['ER:01:41'] }}");
					@else
						$("#numbers").css("border", "1px solid red");
						$(".error-numbers").show();
						$(".error-numbers").html("{{ $message['ER:01:42'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['type_visa']))  
					@if(preg_match('/required./', $errors->messages()['type_visa'][0]))
						$("#type_visa").css("border", "1px solid red");
						$(".error-type").show();
						$(".error-type").html("{{ $message['ER:01:43'] }}");
					@else
						$("#type_visa").css("border", "1px solid red");
						$(".error-type").show();
						$(".error-type").html("{{ $message['ER:01:44'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['result']))  
					@if(preg_match('/required./', $errors->messages()['result'][0]))
						$("#result").css("border", "1px solid red");
						$(".error-result").show();
						$(".error-result").html("{{ $message['ER:01:45'] }}");
					@elseif(preg_match('/number./', $errors->messages()['result'][0]))
						$("#result").css("border", "1px solid red");
						$(".error-result").show();
						$(".error-result").html("{{ $message['ER:01:46'] }}");
					@else
						$("#result").css("border", "1px solid red");
						$(".error-result").show();
						$(".error-result").html("{{ $message['ER:01:47'] }}");
					@endif
				@endif

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
						$(".error-zip").show();
						$(".error-zip").html("{{ $message['ER:00:28'] }}");
					@elseif(preg_match('/number./', $errors->messages()['zip'][0]))
						$("#zip").css("border", "1px solid red");
						$(".error-zip").show();
						$(".error-zip").html("{{ $message['ER:00:30'] }}");
					@else
						$("#zip").css("border", "1px solid red");
						$(".error-zip").show();
						$(".error-zip").html("{{ $message['ER:00:29'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['hobbies']))  
					@if(preg_match('/invalid./', $errors->messages()['hobbies'][0]))
						$(".choices:first").css("border", "1px solid red");
						$(".error-hobbies").show();
						$(".error-hobbies").html("{{ $message['ER:01:48'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['location']))  
					@if(preg_match('/invalid./', $errors->messages()['location'][0]))
						$(".choices:eq(1)").css("border", "1px solid red");
						$(".error-location").show();
						$(".error-location").html("{{ $message['ER:00:86'] }}");
					@endif
				@endif

				@if(isset($errors->messages()['specialization']))  
					@if(preg_match('/invalid./', $errors->messages()['specialization'][0]))
						$(".choices:last").css("border", "1px solid red");
						$(".error-specialization").show();
						$(".error-specialization").html("{{ $message['ER:00:76'] }}");
					@endif
				@endif
			@endif
		});

		function getAge() {
			var dateString = document.getElementById('birthdate').value;
			var today = new Date();
			var birthDate = new Date(dateString);
			var age = today.getFullYear() - birthDate.getFullYear();
			var m = today.getMonth() - birthDate.getMonth();
			if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
				age--;
			}

			document.getElementById('age').value = age;
		}

		$(".save_button").click(function(e) {
			var firstname 	= $("#firstname").val();
				lastname 	= $("#lastname").val();
				birthdate 	= $("#birthdate").val();
				username 	= $("#username").val();
				email 		= $("#email").val();
				number 		= $("#number").val();
				zip 		= $("#zip").val();
				street 		= $("#street").val();
				city 		= $("#city").val();
				hobbies 	= $("#hobbies").val();
				type 		= $("#type_visa").val();

				now 	= new Date();
				bday 	= new Date(birthdate);
                filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;


			if(firstname==="" || lastname==="" || !birthdate || bday > now || username==="" || email==="" || !filter.test(email) || number==="" || !number.match(/^\d+$/) || zip==="" || !zip.match(/^\d+$/) || street==="" || city==="" || type===null || type==="") {
				//e.preventDefault();
				if(firstname==="") {
					$(".error-firstname").show();
					$(".error-firstname").html("{{ $message['ER:01:24'] }}");
					$("#firstname").css("border", "1px solid red");
				}

				if(lastname==="") {
					$(".error-lastname").show();
					$(".error-lastname").html("{{ $message['ER:01:26'] }}");
					$("#lastname").css("border", "1px solid red");
				}

				if(!birthdate==="" || bday > now) {
					if(!birthdate) {
						$(".error-birthdate").show();
						$(".error-birthdate").html("{{ $message['ER:01:33'] }}");
						$("#birthdate").css("border", "1px solid red");
					}
					else {
						$(".error-birthdate").show();
						$(".error-birthdate").html("{{ $message['ER:01:34'] }}");
						$("#birthdate").css("border", "1px solid red");
					}
				}

				if(username==="") {
					$(".error-username").show();
					$("#username").css("border", "1px solid red");
				}

				if(email==="" || !filter.test(email)) {
					if(email==="") {
						$(".error-email").show();
						$(".error-email").html("{{ $message['ER:00:33'] }}");
						$("#email").css("border", "1px solid red");
					}
					else {
						$(".error-email").show();
						$(".error-email").html("{{ $message['ER:01:32'] }}");
						$("#email").css("border", "1px solid red");
					}
				}

				if(number==="" || !number.match(/^\d+$/)) {
					if(number==="") {
						$(".error-number").show();
						$(".error-number").html("{{ App\MaintenanceLocale::getLocale(446) }}");
						$("#number").css("border", "1px solid red");
					}
					else {
						$(".error-number").show();
						$(".error-number").html("{{ App\MaintenanceLocale::getLocale(453) }}");
						$("#number").css("border", "1px solid red");
					}
				}

				if(zip==="" || !zip.match(/^\d+$/)) {
					if(zip==="") {
						$(".error-zip").show();
						$(".error-zip").html("{{ $message['ER:00:28'] }}");
						$("#zip").css("border", "1px solid red");
					}
					else {
						$(".error-zip").show();
						$(".error-zip").html("{{ $message['ER:00:30'] }}");
						$("#zip").css("border", "1px solid red");
					}
				}

				if(street==="") {
					$(".error-street").show();
					$(".error-street").html("{{ $message['ER:00:26'] }}");
					$("#street").css("border", "1px solid red");
				}

				if(city==="") {
					$(".error-city").show();
					$(".error-city").html("{{ $message['ER:00:24'] }}");
					$("#city").css("border", "1px solid red");
				}

				if(type==="" || type===null) {
					$(".error-type").show();
					$(".error-type").html("{{ $message['ER:01:43'] }}");
					$("#type_visa").css("border", "1px solid red");
				}
			}
		});

		$('#firstname').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-firstname").show();
				$(".error-firstname").html("{{ $message['ER:01:24'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-firstname").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#result').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-result").show();
				$(".error-result").html("{{ $message['ER:01:45'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-result").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#numbers').keyup(function() {
			$(".error-numbers").hide();
			$(this).css("border", "");
	    });

	    $('#currency').change(function() {
	    	$(".error-currency").hide();
			$(this).css("border", "");
	    });

		$("#specialization").change(function() {
	    	$(".error-specialization").hide();
			$(".choices:last").css("border", "");
	    });

	    $("#hobbies").change(function() {
	    	$(".error-hobbies").hide();
			$(".choices:first").css("border", "");
	    });

	    $('#type_visa').change(function() {
	    	var value = $(this).val();

	    	$(".error-type").hide();
	    	$(this).css("border", "");

	    	if(value==14) {
	    		$(".result-div").show();
	    	}
	    	else {
	    		$(".result-div").hide();
	    	}
	    });

	    $('#lastname').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-lastname").show();
				$(".error-lastname").html("{{ $message['ER:01:26'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-lastname").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#birthdate').change(function() {
	        var length = $(this).val();
	        	now 	= new Date();
	        	bday 	= new Date(length);

	        if(!length) {
				$(".error-birthdate").html("{{ $message['ER:01:33'] }}");
				$(".error-birthdate").show();
				$(this).css("border", "1px solid red");
	        }
	        else if(now < bday) {
				$(".error-birthdate").html("{{ $message['ER:01:34'] }}");
	        	$(".error-birthdate").show();
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-birthdate").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#username').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-username").show();
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-username").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#email').keyup(function() {
	        var length = $(this).val().length;
	        	email 	= $(this).val();
                filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	        if(length < 1) {
				$(".error-email").show();
				$(".error-email").html("{{ $message['ER:00:33'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else if(!filter.test(email)){
	        	$(".error-email").show();
				$(".error-email").html("{{ $message['ER:01:32'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-email").hide();
				$(this).css("border", "");
	        }
	    });

	    $('#number').keyup(function() {
	        var length = $(this).val().length;
	        	number = $(this).val();

	        if(length < 1) {
				$(".error-number").show();
				$(".error-number").html("{{ App\MaintenanceLocale::getLocale(446) }}");
				$(this).css("border", "1px solid red");
	        }
	        else if(!number.match(/^\d+$/)){
	        	$(".error-number").show();
				$(".error-number").html("{{ App\MaintenanceLocale::getLocale(453) }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-number").hide();
				$(this).css("border", "");
	        }
	    });
		
		$('#zip').keyup(function() {
	        var length = $(this).val().length;
	        	number = $(this).val();

	        if(length < 1) {
				$(".error-zip").show();
				$(".error-zip").html("{{ $message['ER:00:28'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else if(!number.match(/^\d+$/)){
	        	$(".error-zip").show();
				$(".error-zip").html("{{ $message['ER:00:30'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-zip").hide();
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

	    $('#city').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-city").show();
				$(".error-city").html("{{ $message['ER:00:24'] }}");
				$(this).css("border", "1px solid red");
	        }
	        else {
				$(".error-city").hide();
				$(this).css("border", "");
	        }
	    });
	</script>
@endsection
