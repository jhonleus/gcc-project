@extends('layouts.header')

@section('title', 'Applicant Details')

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/company-profile-page.css') }}">

	<div class="container profile-container">
		<div class="row">
			<div class="col-sm-4">
				<div class="card profile-contents">
					<div class="card-header profile-header">
						<h3 class="profile-company">
							{{$user ? $user->firstName : ""}} {{$user ? $user->lastName : ""}}
						</h3>
					</div>
					<div class="card-body profile-body">
						<div class="profile-center">
							@if(isset($user)) 
							@if(!is_null($user->documents))
								@foreach($user->documents as $file)
									@if($file->filetype==="profile")
										<img src="{{ asset($file->path ."/". $file->filename) }}" class="profile-details-logo">
									@endif
								@endforeach
							@endif
							@endif

							<div class="profile-details">
								<label class="profile-details-label">Address:</label>
								@if(Auth::check() && Auth::user()->rolesId == 3)
								<label class="profile-details-description">
									{{ $user ? $user->address ? $user->address->street : '' : "" }} {{ $user ? $user->address ? $user->address->city : '' : "" }} {{ $user ? $user->address ? $user->address->province : '' : "" }} {{ $user ? $user->address ? $user->address->country ? $user->address->country->getName() : '' : '' : "" }} {{ $user ? $user->address ? $user->address->zipcode : '' : "" }}
								</label>
								@else
								<label class="profile-details-description">
									{{ $user ? $user->address ? $user->address->country ? $user->address->country->getName() : '' : '' : "" }}
								</label>
								@endif

								<label class="profile-details-label">Age:</label>
								<label class="profile-details-description">
									{{  $user ? $user->details ? $user->details->age : '' : "" }}
								</label>

								<label class="profile-details-label">Date of Birth:</label>
								<label class="profile-details-description">
									{{ $user ? $user->details ? $user->details->birthDate ? date('F d, Y', strtotime($user->details->birthDate)) : '' : '' : "" }}
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-8">
				<div class="card profile-contents">
					<div class="card-header profile-navbar-head">
						<ul class="nav nav-tabs" data-tabs="tabs">
							<li class="nav-item">
								<a class="nav-link active" href="#overview" data-toggle="tab">Overview</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#certificates" data-toggle="tab">Certificates</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#tattoos" data-toggle="tab">Tattoos</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="tab-content tab-space">
					<div class="tab-pane active" id="overview">
						<div class="card profile-contents">
							<div class="card-body">
								@if(Auth::check() && Auth::user()->rolesId == 3)
								<div class="contents mt-2">
									<div class="content-title">
										<h1 class="profile-title-label">
											<i class="fa fa-address-book" aria-hidden="true"></i>
											CONTACT INFORMATION
										</h1>
									</div>

									<div class="profile-content-group">
										<div class="row">
											<div class="col-sm-5">
												<label class="profile-details-label">Mobile Number:</label>
											</div>

											<div class="col-sm-7">
												<div class="profile-content-description">
													<label class="profile-details-description">
														{{ $user ? $user->contacts ? $user->contacts->country ? '+' . $user->contacts->country->getCode() : '' : '' : "" }} {{ $user ? $user->contacts ? $user->contacts->number : '' : "" }}
													</label>
												</div>
											</div>
											<div class="col-sm-5">
												<label class="profile-details-label">Email Address:</label>
											</div>

											<div class="col-sm-7">
												<div class="profile-content-description">
													<label class="profile-details-description">
														{{ $user ? $user->email : "" }}
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								@endif

								@if(isset($user))
								@if(!is_null($user->works))
								@if(!$user->works->isEmpty())
								<div class="contents mt-2">
									<div class="content-title">
										<h1 class="profile-title-label">
											<i class="fa fa-briefcase" aria-hidden="true"></i>
											WORK EXPERIENCE
										</h1>
									</div>

									<div class="profile-content-group">
		            					@foreach($user->works as $work)
										<div class="row hr">
											<div class="col-sm-12">
												<label class="profile-details-description">
													{{ $work->position }}
												</label>
												<label class="profile-details-label">
													{{ $work->company }}
												</label>
											</div>

											<br>

											<div class="col-sm-6">
												<label class="profile-sublabel">
													{{ $work->dateStart }} - {{ $work->dateEnd == null ? "Present" : $work->dateEnd }}
												</label>
											</div>

											<div class="col-sm-6">
												<label class="profile-sublabel">
													{{ $work->country ? $work->country->getName() : '' }}
												</label>
											</div>
										</div>
										@endforeach
									</div>
								</div>
								@endif
								@endif
								@endif

								@if(isset($user))
								@if(!is_null($user->educations))
								@if(!$user->educations->isEmpty())
								<div class="contents mt-2">
									<div class="content-title">
										<h1 class="profile-title-label">
											<i class="fa fa-graduation-cap" aria-hidden="true"></i>
											EDUCATION
										</h1>
									</div>

									<div class="profile-content-group">
		          						@foreach($user->educations as $education)
										<div class="row hr">
											<div class="col-sm-12">
												<label class="profile-details-description">
													{{ $education->attainment }}
												</label>
												<label class="profile-details-label">
													{{ $education->levels ? $education->levels->getName() : '' }}
												</label>
												<label class="profile-details-label">
													{{ $education->name }}
												</label>
											</div>

											<br>
										
											<div class="col-sm-6">
												<label class="profile-sublabel">
														{{ $education->dateStart }} - {{ $education->dateEnd }}
												</label>
											</div>

											<div class="col-sm-6">
												<label class="profile-sublabel">
														{{ $education->country ? $education->country->getName() : '' }}
												</label>
											</div>
										</div>
										@endforeach
									</div>
								</div>
								@endif
								@endif
								@endif
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tattoos">
						@php
							$currentDisplay = $tattoos->currentPage() * $tattoos->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($tattoos->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $tattoos->total() ? $currentDisplay : $tattoos->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $tattoos->total() }}</span> )
							</small>
						</div>

						@foreach($tattoos as $tat)
						<div class="card profile-contents">
							<div class="card-body">
								<img style="height:auto;width:100%;" src="{{ url($tat->path.$tat->filename) }}">
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $tattoos->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>

					<div class="tab-pane" id="certificates">
						@php
							$currentDisplay = $certificates->currentPage() * $certificates->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($certificates->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $certificates->total() ? $currentDisplay : $certificates->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $certificates->total() }}</span> )
							</small>
						</div>

						@if(!$certificates->isEmpty())
						<div class="card profile-contents">
							<div class="card-body">
								<div class="contents mt-2">
									<div class="content-title">
										<h1 class="profile-title-label">
											<i class="fa fa-graduation-cap" aria-hidden="true"></i>
											CERTIFICATES
										</h1>
									</div>

									<div class="profile-content-group">
		          						@foreach($certificates as $certificate)
											<a href="{{ url($certificate->path.$certificate->filename) }}" class="profile-links">{{$certificate->filename}}</a>
										@endforeach
									</div>
								</div>
							</div>
						</div>
						@endif

						<div class="mt-2">
							{{ $certificates->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
