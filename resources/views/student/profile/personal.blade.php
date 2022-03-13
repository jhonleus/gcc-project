@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(414))

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
						<div class="row">
							<div class="col-sm-7">
								<label class="profile-information-label">{{ App\MaintenanceLocale::getLocale(414) }}</label>
							</div>
							<div class="col-sm-5 profile-header-action">
								<a href="{{ url('applicant/personal/'.Auth::user()->id.'/edit') }}" class="profile-button">
									<i class="fa fa-edit" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(36) }}
								</a> 
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(34) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->firstName }} {{ $user->lastName }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(418) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{  $user->details ? $user->details->age : ''  }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(419) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{  $user->details ? date('F d, Y', strtotime($user->details->birthDate)) : ''  }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(436) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{  $user->details ? $user->details->genders ? $user->details->genders->getName() : '' : '' }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(19) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->details ? $user->details->civils ? $user->details->civils->getName() : '' : '' }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(27) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->details ? $user->details->religions ? $user->details->religions->getName() : '' : '' }}
									</label>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(529) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->details ? $user->details->type ? $user->details->type->name : '' : '' }}
									</label>
								</div>
							</div>

							@if(isset($user->details))
								@if($user->details->typeId==14)
								<div class="col-sm-4">
									<label class="profile-details-title">Type of Skill Evaluation:</label>
								</div>
								<div class="col-sm-8">
									<div class="profile-content-description">
										<label class="profile-profile-description">
											{{ $user->details ? $user->details->results ? $user->details->results->name : "" : '' }}
										</label>
									</div>
								</div>
								@endif
							@endif
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(74) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->username }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(187) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->contacts ? $user->contacts->country ? '+' . $user->contacts->country->getCode() : '' : '' }} {{ $user->contacts ? $user->contacts->number : '' }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(41) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->email }}
									</label>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(330) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->address ? $user->address->street : '' }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(331) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->address ? $user->address->city : '' }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(332) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->address ? $user->address->country ? $user->address->country->getName() : '' : '' }}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(333) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-details-description">
									<label class="profile-profile-description">
										{{ $user->address ? $user->address->zipcode : '' }}
									</label>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(23) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										@php
						               		$hobby = array();
						               	@endphp
										@foreach($hobbies as $hobbys)
						               		@php
						               			array_push($hobby, $hobbys->hobby->name)
						               		@endphp
						                @endforeach
						                {{implode(", ", $hobby)}}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(437) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										@php
						               		$location = array();
						               	@endphp
										@foreach($locations as $loc)
						               		@php
						               			array_push($location, $loc->location->nicename)
						               		@endphp
						                @endforeach
						                {{implode(", ", $location)}}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(438) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										@php
						               		$specialization = array();
						               	@endphp
										@foreach($specializations as $spe)
							               		@php
							               			array_push($specialization, $spe->specialization->name)
							               		@endphp
						                @endforeach
						                {{implode(", ", $specialization)}}
									</label>
								</div>
							</div>

							<div class="col-sm-4">
								<label class="profile-details-title">{{ App\MaintenanceLocale::getLocale(439) }}:</label>
							</div>
							<div class="col-sm-8">
								<div class="profile-content-description">
									<label class="profile-profile-description">
										{{ $user->details ? $user->details->currency ? $user->details->currency->getName() : '' : '' }} {{ $user->details ? $user->details->number ? number_format($user->details->number, 2)  : '' : '' }}
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$("#personal-list").removeClass("profile-label-settings-content");
			$("#personal-list").addClass("profile-label-settings-content-active");
		});
	</script>
@endsection
