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
						<div class="row">
							<div class="col-sm-7">
								<label class="profile-information-label">{{ App\MaintenanceLocale::getLocale(424) }}</label>
							</div>
							<div class="col-sm-5 profile-header-action">
                				@if ($user->skills)
									<a href="skills/{{ $user->skills ? $user->skills->id : ''}}/edit" class="profile-button">
										<i class="fa fa-edit" aria-hidden="true"></i>
										{{ App\MaintenanceLocale::getLocale(36) }}
									</a> 
								@else
									<a href="{{ url('applicant/skills/create') }}" class="profile-button">
										<i class="fa fa-plus" aria-hidden="true"></i>
										{{ App\MaintenanceLocale::getLocale(35) }}
									</a> 
								@endif
							</div>
						</div>
					</div>
				</div>

				<div class="card profile-work-list">
					<div class="card-body profile-work-body">
						<label class="profile-skills-label text-uppercase">
							{{ App\MaintenanceLocale::getLocale(530) }}
						</label>

						<div class="applicant-form">
							<div class="profile-content-description">
								<label class="profile-description">{{$user->skills ? $user->skills->strongPoints : ''}}</label>
							</div>
						</div>
					</div>
				</div>

				<div class="card profile-work-list">
					<div class="card-body profile-work-body">
						<label class="profile-skills-label text-uppercase">
							{{ App\MaintenanceLocale::getLocale(531) }}
						</label>

						<div class="applicant-form">
							<div class="profile-content-description">
								<label class="profile-description">{{$user->skills ? $user->skills->weakPoints : ''}}</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#skills-list").removeClass("profile-label-settings-content");
			$("#skills-list").addClass("profile-label-settings-content-active");
		});
	</script>
@endsection
