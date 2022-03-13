@extends('layouts.header')

@section('title', "Applicant")

@section('content')
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('school.sidebar.profile')
				@include('school.sidebar.index')
			</div>

			<div class="col-sm-9">
				@if(!isset($title))
					<div class="card card-body">
						<form method="POST" action="{{ url('school/summary/search/students') }}">
							@csrf
						<div class="row">
							<div class="col-sm-4 padding">
								<select class="select @if(isset($get_gen)) select-selected @endif" name="gender">
									<option hidden disabled selected> 
										Gender
									</option>
									<option></option>
									@foreach($genders as $gender)
									<option value="{{ $gender->id }}" 
										@if(isset($get_gen))
											@if($get_gen==$gender->id)
												selected
											@endif
										@endif>
										{{ $gender->name }}</option>
									@endforeach
								</select>
							</div>

							<div class="col-sm-4 padding">
								<select class="select @if(isset($get_loc)) select-selected @endif" name="location">
									<option hidden disabled selected> 
										Location
									</option>
									<option></option>
									@foreach($countries as $country)
									<option value="{{ $country->id }}" 
										@if(isset($get_loc))
											@if($get_loc==$country->id)
												selected
											@endif
										@endif>
										{{ $country->nicename }}</option>
									@endforeach
								</select>
							</div>

							<div class="col-sm-4 padding">
								<button class="label-button btn btn-primary" style="width: 100%;">Search</button>
							</div>
						</div>
						</form>
					</div> 
				@else
					<h3 style="color: #444444" class="text-center">
						{{$title->course}}
					</h3>
				@endif

				@php
					$currentDisplay = $applicants->currentPage() * $applicants->perPage();
				@endphp

				<div class="text-right" style="margin-bottom: 10px;">
					<small class="form-text text-muted mb-2">
						{{ App\MaintenanceLocale::getLocale(118) }} (
						<span id="start-page">{{ $currentDisplay - ($applicants->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $applicants->total() ? $currentDisplay : $applicants->total() }}</span>
						{{ App\MaintenanceLocale::getLocale(207) }}
						<span id="total-blog">{{ $applicants->total() }}</span> )
					</small>
				</div>

				@foreach($applicants as $user)
					<div class="card page-contents">
						<div class="card-body page-content-body">
							<div class="content-header-1">
								<label class="content-title"> 
									{{ $user->user->firstName }} {{ $user->user->lastName }}
								</label>
								<a href="{{url("courses/".Crypt::encrypt($user->course->id)) }}" class="content-actions">
										{{ $user->course->course }}
								</a>
							</div>

							<div class="row">
								<div class="col-sm-9">
									<label class="content-details">
										<i class="fa fa-birthday-cake" aria-hidden="true"></i>
										{{date('F d Y', strtotime($user->detail->birthDate))}}
									</label>

									<label class="content-details">
										<i class="fa fa-venus-mars" aria-hidden="true"></i>
										{{$user->detail->genders->getName()}}
									</label>

									<label class="content-details">
										<i class="fa fa-phone-square" aria-hidden="true"></i>
										+{{$user->contact->codeId}} {{$user->contact->number}} 
									</label>

									<label class="content-details">
										<i class="fa fa-envelope" aria-hidden="true"></i>
										{{$user->user->email}}
									</label>

									<label class="content-details">
										<i class="fa fa-map-marker" aria-hidden="true"></i>
										{{$user->address->street}}, {{$user->address->city}}, {{$user->address->country->getName()}}
									</label>

									<label class="content-details">
										<i class="fa fa-file" aria-hidden="true"></i>
										<a href="{{ url($user->path . $user->certificate)}}">
											Birth Certificate
										</a>
										,
										<a href="{{ url($user->path . $user->records) }}">
											Transcript of Records
										</a>
									</label>
								</div>

								<div class="col-sm-3">
									@foreach($user->documents as $file)
										@if($file->filetype==="profile")
											<img class="content-image" src="{{ url($file->path . $file->filename)}}">
										@endif
									@endforeach
								</div>
							</div>
						</div>
					</div>
				@endforeach

				<div class="mt-2">
					{{ $applicants->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#studentsum-list").removeClass("sidebar-list-title");
			$("#studentsum-list").addClass("sidebar-list-title-active");
		});
	</script>
@endsection
