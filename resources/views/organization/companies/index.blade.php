@extends('layouts.header')

@section('title', 'Search Company')

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/search-applicant-page.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/company-profile-page.css') }}">

	<div class="container applicant-container">
		<div class="col-sm-12">
			<form method="POST" action="{{ url('organization/companies/search') }}">
				@csrf
				<div class="card applicant-search-contents">
					<div class="card-header applicant-search-header">
						<label class="applicant-search-title">Search Criteria</label>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-sm-3">
								<div class="applicant-search-forms">
									<select class="select @if(isset($get_loc)) select-selected @endif" name="location">
										<option hidden disabled selected> 
											Location
										</option>
										<option></option>
										@foreach($country as $val)
										<option value="{{ $val->id }}" 
											@if(isset($get_loc))
												@if($get_loc==$val->id)
													selected
												@endif
											@endif>
											{{ $val->nicename }}</option>
										@endforeach
									</select> 
								</div>
							</div>

							<div class="col-sm-3">
								<div class="applicant-search-forms">
									<select class="select @if(isset($get_ind)) select-selected @endif" name="industry">
										<option hidden disabled selected> 
											Industry
										</option>
										<option></option>
										@foreach($industries as $val)
										<option value="{{ $val->id }}" 
											@if(isset($get_loc))
												@if($get_ind==$val->id)
													selected
												@endif
											@endif>
											{{ $val->name }}</option>
										@endforeach
									</select> 
								</div>
							</div>

							<div class="col-sm-3">
								<div class="applicant-search-forms">
									<button class="btn btn-chinese applicant-search-button"> 
										Search
									</button>
								</div>
							</div>

							<div class="col-sm-3">
								<div class="applicant-search-forms">
									<button class="btn btn-default applicant-search-button" name="clear_filter"> 
										Clear Filter
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="col-sm-12">
			@if(count($users) < 1)
				@if($search)
					<div class="row">
						<div class="col-sm-12">
							<div class="card job-contents">
								<div class="card-body job-body">
									<h4 style="margin::0px">Nothing here matches your search</h4>

									<hr>

									<p class="mt-2">Suggestions:</p>
									<ul>
										<li>Make sure all words are spelled correctly</li>
										<li>Try different keywords</li>
										<li>Try more general keywords</li>
									</ul>

								</div>
							</div>
						</div>
					</div>
				@else
					<div class="text-center">
		                <h2>Nothing to display!</h2>
		            </div>
				@endif
			@endif

			@if(count($users) >= 1)
				@php
		            $currentDisplay = $users->currentPage() * $users->perPage();
				@endphp
				
				<div class="text-right" style="margin-bottom: 10px;">
					<small class="form-text text-muted">
						Showing (
						<span id="start-page">{{ $currentDisplay - ($users->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $users->total() ? $currentDisplay : $users->total() }}</span>
						of
						<span id="total-blog">{{ $users->total() }}</span> )
					</small>
				</div>
			@endif
		</div>

		@foreach($users as $key => $user)
			<div class="col-sm-12">
				<div class="card applicant-contents-details">
					<div class="card-body applicant-body">
						<div class="row">
							<div class="col-sm-4">
								@if(!$user->documents->isEmpty())
									@php
										$x = 0;
									@endphp

									@foreach($user->documents as $doc)
										@if($doc->filetype==="profile")
											@php
												$x = 1;
											@endphp
											<img class="applicant-image" src="{{ url($doc->path . $doc->filename)}}">
										@endif	
									@endforeach

									@if($x < 1)
										<img src="{{ asset('images/company.png') }}" class="applicant-image">
									@endif
								@else
									<img src="{{ asset('images/company.png') }}" class="applicant-image">
								@endif

								@if(!is_null($user->employer))
								<div class="text-center" style="color:#FF912C;">
									<i class="fa @if($user->employer->average()>=1 && $user->employer->average()<=5) @if(floor($user->employer->average()<1)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($user->employer->average()>=1.1 && $user->employer->average()<=5) @if(floor($user->employer->average()<2)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($user->employer->average()>=2.1 && $user->employer->average()<=5) @if(floor($user->employer->average()<3)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($user->employer->average()>=3.1 && $user->employer->average()<=5) @if(floor($user->employer->average()<4)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($user->employer->average()>=4.1 && $user->employer->average()<=5) @if(floor($user->employer->average()<5)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
								</div>
								@endif
							</div>

							<div class="col-sm-8">
								<div class="applicant-header">
									<div class="row">
										<div class="col-sm-9">
											<a href="{{ url('company/'.Crypt::encrypt($user->id)) }}" class="applicant-name" target="_blank" title="View Applicant Profile">  
												{{ $user->employer ? $user->employer->company : "" }}
											</a>

											<a class="job-action" href="{{ url('company/'.Crypt::encrypt($user->id)) }}" target="_blank"> 
												View Profile
											</a>
										</div> 
									</div>
								</div>

								<label class="applicant-details">
									<i class="fa fa-phone-square" aria-hidden="true"></i>
									{{$user->employer ? $user->employer->telephone : ""}}
								</label>

								<label class="applicant-details">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									{{$user->employer ? $user->employer->email : ""}}
								</label>

								<label class="applicant-details">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
									{{$user->employer ? $user->employer->address ? $user->employer->address->street : "" : ""}} {{$user->employer ? $user->employer->address ? $user->employer->address->city : "" : ""}} {{$user->employer ? $user->employer->address ? $user->employer->address->province : "" : ""}}  {{$user->employer ? $user->employer->address ? $user->employer->address->country->getName() : "" : ""}} {{$user->employer ? $user->employer->address ? $user->employer->address->zipcode : "" : ""}} 
								</label>

								<ul class="profile-links profile-links-circle">
									<li>
										<a href="https://{{ $user->employer? $user->employer->website : ""}}" class="profile-website" title="Website" target="_blank"><i class="fa fa-globe"></i></a> 
									</li>

									<li>
										<a href="https://{{ $user->employer? $user->employer->website : ""}}" class="profile-facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a> 
									</li>

									<li>
										<a href="https://{{ $user->employer? $user->employer->website : ""}}" class="profile-twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a> 
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@endsection