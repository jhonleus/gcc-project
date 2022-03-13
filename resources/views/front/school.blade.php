@extends('layouts.header')

@section('title', 'School Details')

@section('content')
	<!-- CSS FOR FRONT COMPANY DETAILS-->
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/company-profile-page.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/css/custom/stars.css') }}">

	<div class="container profile-container">
		<div class="row">
			<div class="col-sm-4">
				<div class="card profile-contents">
					<div class="card-header profile-header">
						<h3 class="profile-company">{{$school? $school->school : ""}}</h3>
					</div>
					<div class="card-body profile-body">
						<div class="profile-center"> 
							@if(!$school->files->isEmpty())
								@php
									$x = 0;
								@endphp

								@foreach($school->files as $file)
									@if($file->filetype==="profile")
										@php
											$x = 1;
										@endphp
										<img src="{{ asset($file->path ."/". $file->filename) }}" class="profile-details-logo">
									@endif
								@endforeach

								@if($x < 1)
									<img src="{{ asset('images/school.png') }}" class="profile-details-logo">
								@endif
							@else
								<img src="{{ asset('images/school.png') }}" class="profile-details-logo">
							@endif

							<div class="profile-details">

								<label class="profile-details-label">Address:</label>
								<label class="profile-details-description">
									{{ $school->address ? $school->address->street ? $school->address->street : '' : '' }} {{ $school->address ? $school->address->city ? $school->address->city . ',' : '' : '' }} {{ $school->address ? $school->address->zipcode ? $school->address->zipcode : '' : '' }}
								</label>

								<label class="profile-details-label">Contact Number:</label>
								<label class="profile-details-description">
									{{$school? $school->telephone : ""}}
								</label>

								<label class="profile-details-label">Email Address:</label>
								<label class="profile-details-description">
									{{$school? $school->email : ""}}
								</label>
							</div>

							<ul class="profile-links profile-links-circle">
								<li>
									<a href="{{$school? $school->website : ""}}" class="profile-website" title="Website" target="_blank"><i class="fa fa-globe"></i></a> 
								</li>
								<li>
									<a href="{{$school? $school->facebook : ""}}" class="profile-facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a> 
								</li>
								<li>
									<a href="{{$school? $school->twitter : ""}}" class="profile-twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a> 
								</li>
							</ul>	
							
							@if(Auth::check())
							<a href="{{ url('rate/'.Crypt::encrypt($school->usersId)) }}">
								<button class="btn btn-chinese" style="font-size:12px;width:100%">
									Rate this School
								</button>
							</a>
							@endif
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
								<a class="nav-link" href="#course_post" data-toggle="tab">Courses</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#rewiews" data-toggle="tab">Reviews</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#affilations" data-toggle="tab">Affilations</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#blogs" data-toggle="tab">blogs</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="tab-content tab-space">
					<div class="tab-pane active" id="overview">
						@if ($ratings)
						<div class="card profile-contents">
							<div class="card-body profile-body">
								<div class="row">
									<div class="col-sm-6"> 
										<span class="badge profile-badge">
											Ratings
										</span>
									</div>
								</div>
								<div class="profile-description">
									@if($ratings)
									<div class="row mb-3">
										<div class="col-sm-5 profile-center">
											<label class="profile-ratings-label">
												{{number_format($ratings->overall, 2, '.', '')}}
											</label>

											<label class="profile-rating-title"> 
												Overall Rating
											</label>

											<div class='overall-ratings'>
												<ul style="text-align:center">
													<li class='star <?php if((int)$ratings->overall <= 5 && (int)$ratings->overall !==0) { echo "selected"; } ?>' title='Poor' data-value='1'>
														<i class='fa fa-star fa-fw'></i>
													</li>

													<li class='star <?php if((int)$ratings->overall <= 5 && (int)$ratings->overall >= 2) { echo "selected"; } ?>' title='Fair' data-value='2'>
														<i class='fa fa-star fa-fw'></i>
													</li>

													<li class='star <?php if((int)$ratings->overall <= 5 && (int)$ratings->overall >= 3) { echo "selected"; } ?>' title='Good' data-value='3'>
														<i class='fa fa-star fa-fw'></i>
													</li>

													<li class='star <?php if((int)$ratings->overall <= 5 && (int)$ratings->overall >= 4) { echo "selected"; } ?>' title='Excellent' data-value='4'>
														<i class='fa fa-star fa-fw'></i>
													</li>

													<li class='star <?php if((int)$ratings->overall <= 5 && (int)$ratings->overall >= 5) { echo "selected"; } ?>' title='WOW!!!' data-value='5'>
														<i class='fa fa-star fa-fw'></i>
													</li>
												</ul>
											</div>
										</div>

										<div class="col-sm-5">
											<label class="profile-rating-title"> 
												Ratings by category
											</label>

											<label class="profile-rating-description">
												{{$ratings->fees}}
												<i class='fa fa-star fa-fw star-color-2'></i>
												Tuition Fee
											</label>

											<label class="profile-rating-description">
												{{$ratings->environment}}
												<i class='fa fa-star fa-fw star-color-2'></i>
												School Environment
											</label>

											<label class="profile-rating-description">
												{{$ratings->career_growth}}
												<i class='fa fa-star fa-fw star-color-2'></i>
												Career Growth Development 
											</label>
											<label class="profile-rating-description">
												{{$ratings->security}}
												<i class='fa fa-star fa-fw star-color-2'></i>
												School Security
											</label>
											<label class="profile-rating-description">
												{{$ratings->relation}}
												<i class='fa fa-star fa-fw star-color-2'></i>
												Professor's Teaching
											</label>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
						@endif

						<div class="card profile-contents">
							<div class="card-body profile-body">
								<span class="badge profile-badge">
									ABOUT
								</span>

								<div class="profile-description">
									{!!$school? $school->about_us : ""!!}
								</div>
							</div>
						</div>

						<div class="card profile-contents">
							<div class="card-body profile-body">
								<span class="badge profile-badge">
									MISSION & VISION
								</span>

								<div class="profile-description">
									{!!$school? $school->mission_vision : ""!!}
								</div>
							</div>
						</div>

						<div class="card profile-contents">
							<div class="card-body profile-body">
								<span class="badge profile-badge">
									PHILOSOPHY
								</span>

								<div class="profile-description">
									{!!$school? $school->philosophy : ""!!}
								</div>
							</div>
						</div>

						<div class="card profile-contents">
							<div class="card-body profile-body">
								<span class="badge profile-badge">
									WHY YOU CHOOSE US?
								</span>

								<div class="profile-description">
									{!!$school? $school->philosophy : ""!!}
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="course_post">
						@php
							$currentDisplay = $courses->currentPage() * $courses->perPage();
						@endphp

						<div style="text-align:right">
							<small class="form-text text-muted mb-2">
								Showing (
								<span id="start-page">{{ $currentDisplay - ($courses->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $courses->total() ? $currentDisplay : $courses->total() }}</span>
								of
								<span id="total-blog">{{ $courses->total() }}</span> )
							</small>
						</div>

						@foreach($courses as $course)
						<div class="card profile-contents-jobs">
							<div class="card-body profile-job-content">
								<div class="profile-job-header">
									<a href="{{ url('courses/'.Crypt::encrypt($course->id)) }}" class="profile-job-title"> 
										{{$course->course}}
									</a>
								</div>

								<label class="profile-job-details">
									<i class="fas fa-hourglass-start"></i>
									{{ date('F d, Y', strtotime($course->class_start)) }}
								</label>

								<label class="profile-job-details">
									<i class="fa fa-hourglass-end" aria-hidden="true"></i>
									{{ date('F d, Y', strtotime($course->class_end)) }} 
								</label>

								<label class="profile-job-details">
									<i class="fas fa-map-marker-alt"></i>
									{{ $course->country->nicename }}
								</label>

								<label class="profile-job-details profile-job-money">
									<i class="fas fa-money profile-job-currency"></i>
									{{ $course->currency->name }}
									{{ $course->fee }}
								</label>

								<label class="profile-job-details">
									@if(!is_null($course->schedules))
									<i class="fa fa-calendar" aria-hidden="true"></i>
										@php
										 	$sheds="";
										@endphp
										@foreach($course->schedules as $schedule)
											@php
												$scheds = $schedule->day . " - " . $schedule->time;

												$sheds = $sheds . $scheds . ", ";
											@endphp
										@endforeach
									@endif
									{{rtrim($sheds, ', ')}}
								</label>


								<label class="profile-job-details">
									 {!! strlen($course->details) > 200 ? str_limit($course->details, 200) : '' !!} @if(strlen($course->details) > 200) <a href="{{ url('courses/'.Crypt::encrypt($course->id)) }}" target="_blank">Read more...</a> @endif
								</label>

								<div class="profile-job-footer">
									<label class="profile-job-posted">
										POSTED: {{ $course->created_at->diffForHumans() }}
									</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $courses->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
					<div class="tab-pane" id="rewiews">
						<div class="card profile-contents">
							<div class="card-body profile-review-content">
								<div class="row">
									<div class="col-sm-6"> 
										<span class="badge profile-badge">
											Reviews
										</span>
									</div>
									@if(Auth::check())
									<div class="col-sm-6 profile-content-button"> 
										<a class="profile-button btn btn-chinese" href="{{ url('review/'.Crypt::encrypt($school->usersId)) }}">
											Create Review
										</a>
									</div>
									@endif
								</div>
								
								<hr>
								@foreach($reviews as $review)
								<div class="row profile-review-body">
									<div class="col-sm-3 profile-center">
										<img src="{{ asset("images/icon/profile-icon.svg") }}" class="profile-review-icon">
										<label class="profile-review-date"> 
											{{$review->created_at->format('F j Y')}}
										</label>

										<div class='overall-ratings'>
											<ul style="text-align:center">
												<li class='star <?php if((int)$review->rating <= 5 && (int)$review->rating !==0) { echo "selected"; } ?>' title='Poor' data-value='1'>
													<i class='fa fa-star fa-fw'></i>
												</li>

												<li class='star <?php if((int)$review->rating <= 5 && (int)$review->rating >= 2) { echo "selected"; } ?>' title='Fair' data-value='2'>
													<i class='fa fa-star fa-fw'></i>
												</li>

												<li class='star <?php if((int)$review->rating <= 5 && (int)$review->rating >= 3) { echo "selected"; } ?>' title='Good' data-value='3'>
													<i class='fa fa-star fa-fw'></i>
												</li>

												<li class='star <?php if((int)$review->rating <= 5 && (int)$review->rating >= 4) { echo "selected"; } ?>' title='Excellent' data-value='4'>
													<i class='fa fa-star fa-fw'></i>
												</li>

												<li class='star <?php if((int)$review->rating <= 5 && (int)$review->rating >= 5) { echo "selected"; } ?>' title='WOW!!!' data-value='5'>
													<i class='fa fa-star fa-fw'></i>
												</li>
											</ul>
										</div>

										<label class="profile-review-date"> 
											@if($review->recommend==1)
												I recommend this school.
											@else
												I do not recommend this school.
											@endif
										</label>
									</div>

									<div class="col-sm-9">
										<label class="profile-review-title"> 
											{{$review->summary}}
										</label>

										<p class="profile-review">
											{{$review->review}}
										</p>

										<label class="profile-review-desc">Pros</label>
										<p class="profile-review-descrip">
											{{$review->pros}}
										</p>

										<label class="profile-review-desc">Cons</label>
										<p class="profile-review-descrip">
											{{$review->cons}}
										</p>
									</div>
								</div>
								<hr>
								@endforeach
							</div>
						</div>
					</div>
					<div class="tab-pane" id="affilations">
						@php
							$currentDisplay = $affilations->currentPage() * $affilations->perPage();
						@endphp

						<div style="text-align:right">
							<small class="form-text text-muted mb-2">
								Showing (
								<span id="start-page">{{ $currentDisplay - ($affilations->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $affilations->total() ? $currentDisplay : $affilations->total() }}</span>
								of
								<span id="total-blog">{{ $affilations->total() }}</span> )
							</small>
						</div>

						@foreach($affilations as $affilation)
						<div class="card profile-contents-jobs">
							<div class="card-body profile-job-content">
								<div class="row">
									<div class="col-sm-3">
										<label class="profile-job-details">
										@if($companyId==$affilation->usersId)
											@if(!is_null($affilation->co_documents))
												@foreach($affilation->co_documents as $file)
													@if($file->filetype==="profile")
														<img class="job-image" src="{{ url($file->path . $file->filename)}}">
													@endif
												@endforeach
											@else
												<img class="job-image" src="{{ url('/images/user_img.png') }}">
											@endif
										@else
											@if(!is_null($affilation->documents))
												@foreach($affilation->documents as $file)
													@if($file->filetype==="profile")
														<img class="job-image" src="{{ url($file->path . $file->filename)}}">
													@endif
												@endforeach
											@else
												<img class="job-image" src="{{ url('/images/user_img.png') }}">
											@endif
										@endif
										</label>
									</div>

									<div class="col-sm-9 text-center">
										@if($companyId==$affilation->usersId)
				                    		@if($affilation->co_user->rolesId==4)
				                    			<a href="{{url("schools/".Crypt::encrypt($affilation->companyId)) }}" class="profile-job-title">
													{{ $affilation->co_school ? substr($affilation->co_school->school, 0, 60) : "" }}
												</a>
				                    		@else
												<a href="{{url("company/".Crypt::encrypt($affilation->companyId)) }}" class="profile-job-title">
													{{ $affilation->co_affilation ? substr($affilation->co_affilation->company, 0, 60) : "" }}
												</a>
											@endif
										@else
				                    		@if($affilation->user->rolesId==4)
				                    			<a href="{{url("schools/".Crypt::encrypt($affilation->usersId)) }}" class="profile-job-title">
													{{ $affilation->school ? substr($affilation->school->school, 0, 60) : "" }}
												</a>
				                    		@else
												<a href="{{url("company/".Crypt::encrypt($affilation->usersId)) }}" class="profile-job-title">
													{{ $affilation->affilation ? substr($affilation->affilation->company, 0, 60) : "" }}
												</a>
											@endif
										@endif
										
										@if($companyId==$affilation->usersId)
											<div class="text-center" style="color:#FF912C;">
												<i class="fa @if($affilation->average()>=1 && $affilation->average()<=5) @if(floor($affilation->average()<1)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
												<i class="fa @if($affilation->average()>=1.1 && $affilation->average()<=5) @if(floor($affilation->average()<2)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
												<i class="fa @if($affilation->average()>=2.1 && $affilation->average()<=5) @if(floor($affilation->average()<3)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
												<i class="fa @if($affilation->average()>=3.1 && $affilation->average()<=5) @if(floor($affilation->average()<4)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
												<i class="fa @if($affilation->average()>=4.1 && $affilation->average()<=5) @if(floor($affilation->average()<5)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
											</div>
										@else
											<div class="text-center" style="color:#FF912C;">
												<i class="fa @if($affilation->co_average()>=1 && $affilation->co_average()<=5) @if(floor($affilation->co_average()<1)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
												<i class="fa @if($affilation->co_average()>=1.1 && $affilation->co_average()<=5) @if(floor($affilation->co_average()<2)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
												<i class="fa @if($affilation->co_average()>=2.1 && $affilation->co_average()<=5) @if(floor($affilation->co_average()<3)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
												<i class="fa @if($affilation->co_average()>=3.1 && $affilation->co_average()<=5) @if(floor($affilation->co_average()<4)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
												<i class="fa @if($affilation->co_average()>=4.1 && $affilation->co_average()<=5) @if(floor($affilation->co_average()<5)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
											</div>
										@endif
										

										<label class="profile-job-details text-left">
											<i class="fa fa-phone-square" aria-hidden="true"></i>
											@if($companyId==$affilation->usersId)
				                    			@if($affilation->co_user->rolesId==4)
													{{$affilation->co_school ? $affilation->co_school->telephone : ""}}
				                    			@else
													{{$affilation->co_affilation ? $affilation->co_affilation->telephone : ""}}
												@endif
											@else
				                    			@if($affilation->user->rolesId==4)
													{{$affilation->school ? $affilation->school->telephone : ""}}
				                    			@else
													{{$affilation->affilation ? $affilation->affilation->telephone : ""}}
												@endif
											@endif
										</label>

										<label class="profile-job-details text-left">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											@if($companyId==$affilation->usersId)
				                    			@if($affilation->co_user->rolesId==4)
													{{$affilation->co_school ? $affilation->co_school->email : ""}}
				                    			@else
													{{$affilation->co_affilation ? $affilation->co_affilation->email : ""}}
												@endif
											@else
				                    			@if($affilation->user->rolesId==4)
													{{$affilation->school ? $affilation->school->email : ""}}
				                    			@else
													{{$affilation->affilation ? $affilation->affilation->email : ""}}
												@endif
											@endif
										</label>

										<label class="profile-job-details text-left">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											@if($companyId==$affilation->usersId)
				                    			@if($affilation->co_user->rolesId==4)
													{{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->street : "" : ""}} {{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->city : "" : ""}} {{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->province : "" : ""}}  {{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->country->getName() : "" : ""}} {{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->zipcode : "" : ""}}   
				                    			@else
													{{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->street : "" : ""}} {{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->city : "" : ""}} {{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->province : "" : ""}}  {{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->country->getName() : "" : ""}} {{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->zipcode : "" : ""}}   
												@endif
											@else
				                    			@if($affilation->user->rolesId==4)
													{{$affilation->school ? $affilation->school->address ? $affilation->school->address->street : "" : ""}} {{$affilation->school ? $affilation->school->address ? $affilation->school->address->city : "" : ""}} {{$affilation->school ? $affilation->school->address ? $affilation->school->address->province : "" : ""}}  {{$affilation->school ? $affilation->school->address ? $affilation->school->address->country->getName() : "" : ""}} {{$affilation->school ? $affilation->school->address ? $affilation->school->address->zipcode : "" : ""}}   
				                    			@else
													{{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->street : "" : ""}} {{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->city : "" : ""}} {{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->province : "" : ""}}  {{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->country->getName() : "" : ""}} {{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->zipcode : "" : ""}}
												@endif
											@endif
										</label>

										<ul class="profile-links profile-links-circle">
											<li>
												@if($companyId==$affilation->usersId)
						                    		@if($affilation->co_user->rolesId==4)
														<a href="{{ $affilation->co_school? $affilation->co_school->website : ""}}" class="profile-website" title="Website" target="_blank"><i class="fa fa-globe"></i></a> 
						                    		@else
														<a href="{{ $affilation->co_affilation? $affilation->co_affilation->website : ""}}" class="profile-website" title="Website" target="_blank"><i class="fa fa-globe"></i></a> 
													@endif
												@else
						                    		@if($affilation->user->rolesId==4)
														<a href="{{ $affilation->school? $affilation->school->website : ""}}" class="profile-website" title="Website" target="_blank"><i class="fa fa-globe"></i></a> 
						                    		@else
														<a href="{{ $affilation->affilation? $affilation->affilation->website : ""}}" class="profile-website" title="Website" target="_blank"><i class="fa fa-globe"></i></a> 
													@endif
												@endif
											</li>

											<li>
												@if($companyId==$affilation->usersId)
						                    		@if($affilation->co_user->rolesId==4)
														<a href="{{ $affilation->co_school? $affilation->co_school->website : ""}}" class="profile-facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a> 
						                    		@else
														<a href="{{ $affilation->co_affilation? $affilation->co_affilation->website : ""}}" class="profile-facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a> 
													@endif
												@else
						                    		@if($affilation->user->rolesId==4)
														<a href="{{ $affilation->school? $affilation->school->website : ""}}" class="profile-facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a> 
						                    		@else
														<a href="{{ $affilation->affilation? $affilation->affilation->website : ""}}" class="profile-facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a> 
													@endif
												@endif
											</li>

											<li>
												@if($companyId==$affilation->usersId)
						                    		@if($affilation->co_user->rolesId==4)
														<a href="{{ $affilation->co_school? $affilation->co_school->website : ""}}" class="profile-twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a> 
						                    		@else
														<a href="{{ $affilation->co_affilation? $affilation->co_affilation->website : ""}}" class="profile-twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a> 
													@endif
												@else
						                    		@if($affilation->user->rolesId==4)
														<a href="{{ $affilation->school? $affilation->school->website : ""}}" class="profile-twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a> 
						                    		@else
														<a href="{{ $affilation->affilation? $affilation->affilation->website : ""}}" class="profile-twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a> 
													@endif
												@endif
											</li>
										</ul>
									</div>
								</div>
								
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $affilations->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
					<div class="tab-pane" id="blogs">
						@php
							$currentDisplay = $blogs->currentPage() * $blogs->perPage();
						@endphp

						<div style="text-align:right">
							<small class="form-text text-muted mb-2">
								Showing (
								<span id="start-page">{{ $currentDisplay - ($blogs->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $blogs->total() ? $currentDisplay : $blogs->total() }}</span>
								of
								<span id="total-blog">{{ $blogs->total() }}</span> )
							</small>
						</div>
						
						@foreach($blogs as $blog)
						<div class="card profile-contents-jobs">
							<div class="card-body profile-job-content text-center">
								<img class="job-image" src="{{ url('blogs/'.$blog->filename) }}">

								<br>
								<br>

								<div class="text-center">
									<label class="profile-note">{{Helper::getDate($blog->created_at)}}</label>

									<label class="profile-job-title">{{ $blog->title }}</label>

									<div class="profile-description">
										{{ $blog->subtitle }}
									</div>

									<a class="profile-underline" href="{{ url('blog/'.$blog->id) }}">Read More</a>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $blogs->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection