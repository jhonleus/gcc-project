@extends('layouts.header')

@section('title', 'School Details')

@section('content')
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('school.sidebar.profile')
				@include('school.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card page-title">
					<div class="card-header card-header-1">
						<div class="row">
							<div class="col-sm-7">
								<label class="label-information">School Details</label>
							</div>
							<div class="col-sm-5 content-right-actions">
								<a href="{{ url('school/details/'.Auth::user()->id.'/edit') }}" class="label-button">
									<i class="fa fa-edit" aria-hidden="true"></i>
									Edit
								</a> 
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-5">
								<label class="label-title">School Name:</label>
							</div>

							<div class="col-sm-7">
								<label class="label-description">{{ $users->school ? $users->school->school : '' }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">Type:</label>
							</div>
							
							<div class="col-sm-7">
								<label class="label-description">{{ $users->school ? $users->school->type ? $users->school->type->name : "" : "" }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">Telephone Number:</label>
							</div>

							<div class="col-sm-7">
								<label class="label-description">{{ $users->school ? $users->school->telephone : '' }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">Email Address:</label>
							</div>

							<div class="col-sm-7">
								<label class="label-description">{{ $users->school ? $users->school->email : '' }}</label>
							</div>
						</div>

						<hr>

						<div>
							<label class="label-title">About Us:</label>
							<label class="label-description">{!! $users->school?$users->school->about_us:'' !!}</label>

							<label class="label-title">Mission and Vision:</label>
							<label class="label-description">{!! $users->school?$users->school->mission_vision:'' !!}</label>

							<label class="label-title">Philosophy:</label>
							<label class="label-description">{!! $users->school?$users->school->philosophy:'' !!}</label>

							<label class="label-title">Why You Choose Us?:</label>
							<label class="label-description">{!! $users->school?$users->school->why_choose:'' !!}</label>
						</div>

						<hr>

						<div class="row">

							<div class="col-sm-5">
								<label class="label-title">Street:</label>
							</div>

							<div class="col-sm-7">
								<label class="label-description">{{ $users->address ? $users->address->street : '' }}</label>
							</div>

							<div class="col-sm-5"> 
								<label class="label-title">City:</label>
							</div>

							<div class="col-sm-7"> 
								<label class="label-description">{{ $users->address ? $users->address->city : '' }}</label>
							</div>

							<div class="col-sm-5">
								<label class="label-title">Country:</label>
							</div>

							<div class="col-sm-7">
								<label class="label-description">{{ $users->address ? $users->address->country ? $users->address->country->getName() : '' : '' }}</label>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-sm-5"> 
								<label class="label-title">Zip Code:</label>
							</div>

							<div class="col-sm-7"> 
								<label class="label-description">{{ $users->address ? $users->address->zipcode : '' }}</label>
							</div>

							<hr>

							<div class="col-sm-5"> 
								<label class="label-title">Website:</label>
							</div>

							<div class="col-sm-7"> 
								<label class="label-description">{{ $users->school ? $users->school->website : '' }}</label>
							</div>

							<div class="col-sm-5"> 
								<label class="label-title">Facebook:</label>
							</div>

							<div class="col-sm-7"> 
								<label class="label-description">{!! $users->school? '<a target="blank" href="'.$users->school->facebook.'">'.$users->school->facebook.'</a>' : '' !!}</label>
							</div>

							<div class="col-sm-5"> 
								<label class="label-title">Twitter:</label>
							</div>

							<div class="col-sm-7"> 
								<label class="label-description">{!! $users->school?'<a target="blank" href="'.$users->school->twitter.'">'.$users->school->twitter.'</a>' : '' !!}</label>
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
