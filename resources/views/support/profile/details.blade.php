@extends('layouts.header')

@section('title', "Organization Details")

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
						<div class="row">
							<div class="col-sm-7">
								<label class="label-information">Organization Details</label>
							</div>
							<div class="col-sm-5 content-right-actions">
								<a href="{{ url('organization/details/'.Auth::user()->id.'/edit') }}" class="label-button">
									<i class="fa fa-edit" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(36) }}
								</a> 
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(145) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{{ $users->employer ? $users->employer->company : ucfirst(Auth::user()->firstName) }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">Category:</label>
							</div>

							<div class="col-sm-7">
								<label class="label-description">{{ $users->employer ? $users->employer->industryId ? $users->employer->industry->getName() : '' : '' }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(188) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{{ $users->employer ? $users->employer->telephone : '' }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(41) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{{ $users->employer ? $users->employer->email : '' }}</label>
							</div>
						</div>

						<hr>

						<div>
							<label class="label-title">{{ App\MaintenanceLocale::getLocale(51) }}:</label>
							<label class="label-description">{!! $users->employer?$users->employer->about_us:'' !!}</label>

							<label class="label-title">{{ App\MaintenanceLocale::getLocale(310) }}:</label>
							<label class="label-description">{!! $users->employer?$users->employer->mission_vision:'' !!}</label>

							<label class="label-title">{{ App\MaintenanceLocale::getLocale(311) }}:</label>
							<label class="label-description">{!! $users->employer?$users->employer->philosophy:'' !!}</label>

							<label class="label-title">{{ App\MaintenanceLocale::getLocale(312) }}:</label>
							<label class="label-description">{!! $users->employer?$users->employer->why_choose:'' !!}</label>
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(330) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{{ $users->address ? $users->address->street : '' }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(331) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{{ $users->address ? $users->address->city : '' }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(332) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{{ $users->address ? $users->address->country ? $users->address->country->getName() : '' : '' }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(333) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{{ $users->address ? $users->address->zipcode : '' }}</label>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(334) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{{ $users->employer ? $users->employer->website : '' }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(335) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{!! $users->employer? '<a target="blank" href="'.$users->employer->facebook.'">'.$users->employer->facebook.'</a>' : '' !!}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">{{ App\MaintenanceLocale::getLocale(336) }}:</label>
							</div>
							<div class="col-sm-7">
								<label class="label-description">{!! $users->employer?'<a target="blank" href="'.$users->employer->twitter.'">'.$users->employer->twitter.'</a>' : '' !!}</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#detail-list").removeClass("sidebar-list-title");
			$("#detail-list").addClass("sidebar-list-title-active");
		});
	</script>
@endsection
