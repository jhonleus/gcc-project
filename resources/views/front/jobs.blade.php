@extends('layouts.header')

@section('title', 'Search Jobs')

@section('content')
	<!-- CSS FOR FRONT SEARCH JOBS-->
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/search-job-page.css') }}">

	<div class="container job-container">
		<div class="row">

			<div class="col-lg-12">
				<form method="POST" action="{{ url('jobs/search') }}">
					@csrf
					<div class="card job-search-contents" >
						<div class="card-header job-search-header">
							<label class="job-search-title">{{ App\MaintenanceLocale::getLocale(82) }}</label>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-4">
									<div class="job-search-forms">
										<select class="select @if(isset($get_spe)) select-selected @endif" name="specialization">
											<option hidden disabled selected>{{ App\MaintenanceLocale::getLocale(28) }}</option>
											<option></option>
											@foreach($specialization as $val)
												<option value="{{ $val->id }}" 
													@if(isset($get_spe))
														@if($get_spe==$val->id)
															selected
														@endif
													@endif>
													{{ $val->name }}
												</option>
											@endforeach
										</select> 
									</div>

								</div>

								<div class="col-sm-4">
									<div class="job-search-forms">
										<select class="select @if(isset($get_emp)) select-selected @endif" name="employment">
											<option hidden disabled selected>{{ App\MaintenanceLocale::getLocale(83) }}</option>
											<option></option>
											@foreach($employment as $val)
												<option value="{{ $val->id }}"
													@if(isset($get_emp))
														@if($get_emp==$val->id)
															selected
														@endif
													@endif>
													{{ $val->name }}
												</option>
											@endforeach
										</select> 
									</div>
								</div>

								<div class="col-sm-4">
									<div class="job-search-forms">
										<select class="select @if(isset($get_loc)) select-selected @endif" name="location">
											<option hidden disabled selected>{{ App\MaintenanceLocale::getLocale(84) }}</option>
											<option></option>
											@foreach($country as $val)
												<option value="{{ $val->id }}"
													@if(isset($get_loc))
														@if($get_loc==$val->id)
															selected
														@endif
													@endif>
													{{ $val->nicename }}
												</option>
											@endforeach
										</select> 
									</div>

								</div>
								
								<div class="col-sm-4">
									<div class="job-search-forms">
										<input type="text" class="input" name="title" value="@if(isset($get_title)){{ $get_title }}@endif" placeholder="{{ App\MaintenanceLocale::getLocale(85) }}">
									</div>
								</div>

								<div class="col-sm-4">
									<div class="job-search-forms">
										<div class="row">
											<div class="col-sm-6 job-search-currency">
												<select class="select @if(isset($get_curr)) select-selected @endif" name="currency">
													<option hidden disabled selected> {{ App\MaintenanceLocale::getLocale(86) }}</option>
													<option></option>
													@foreach($currencies as $val)
														<option value="{{ $val->id }}"
															@if(isset($get_curr))
																@if($get_curr==$val->id)
																	selected
																@endif
															@endif>
															{{ $val->name }}
														</option>
													@endforeach
												</select> 
											</div>

											<div class="col-sm-6 job-search-salary">
												<input type="number" class="input" name="salary" value="@if(isset($get_salary)){{ $get_salary }}@endif" placeholder="{{ App\MaintenanceLocale::getLocale(87) }}" title="Minimum Salary" min="0">
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="job-search-forms">
										<button class="btn btn-chinese job-search-button"> 
										{{ App\MaintenanceLocale::getLocale(89) }}
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		@if(count($jobs) < 1)
			@if ($search)
				<div class="row">
					<div class="col-sm-12">
						<div class="card job-contents">
							<div class="card-body job-body">
								 <img src="/login-images/no-jobs-found.png" style="width: 40%; display: block; margin: 0px auto;"> 
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
	                <h2>{{ App\MaintenanceLocale::getLocale(571) }}</h2>
	            </div>
	       	@endif
        @else
			@php
                $currentDisplay = $jobs->currentPage() * $jobs->perPage();
			@endphp

			<div style="text-align:right"><small class="form-text text-muted">
				Showing (
				<span id="start-page">{{ $currentDisplay - ($jobs->perPage() - 1) }}</span>
				-
				<span id="end-page">{{ $currentDisplay < $jobs->total() ? $currentDisplay : $jobs->total() }}</span>
				of
				<span id="total-blog">{{ $jobs->total() }}</span> )
			</small></div>
		@endif

		<div class="row mt-2">
			@foreach($jobs as $key => $job)
			<div class="col-sm-12">
				<div class="card job-contents">
					<div class="card-body job-body">
						<div class="row">
							<div class="col-sm-4">
								@if(!is_null($job->documents))
									@if(!$job->documents->isEmpty())
										@php
											$x = 0;
										@endphp

										@foreach($job->documents as $file)
											@if($file->filetype==="profile")
												@php 
													$x = 1;
												@endphp
												<img class="job-image" src="{{ url($file->path . $file->filename)}}">
											@endif
										@endforeach

										@if($x < 1)
											<img src="{{ URL::to('/') }}/images/company.png" class="company-logo img-fluid">
										@endif
									@else
										<img src="{{ URL::to('/') }}/images/company.png" class="company-logo img-fluid">
									@endif
								@else
									<img class="job-image" src="{{ url('/images/company.png') }}">
								@endif

								<div class="text-center" style="color:#FF912C;">
									<i class="fa @if($job->average()>=1 && $job->average()<=5) @if(floor($job->average()<1)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($job->average()>=1.1 && $job->average()<=5) @if(floor($job->average()<2)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($job->average()>=2.1 && $job->average()<=5) @if(floor($job->average()<3)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($job->average()>=3.1 && $job->average()<=5) @if(floor($job->average()<4)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($job->average()>=4.1 && $job->average()<=5) @if(floor($job->average()<5)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
								</div>
							</div>

							<div class="col-sm-8">
								<div class="card-body job-body">
									<div class="job-header">
										<div class="row">
											<div class="col-sm-9">
												<a href="{{ url('jobs/'.Crypt::encrypt($job->id)) }}" class="job-title" target="_blank" title="Check Job Details">
													{{ $job->title }}
												</a>

												<a href="{{ url('company/'.Crypt::encrypt($job->usersId)) }}" class="job-company" target="_blank" title="Check Company Details">
												{{ $job->employers->company }}
												{{ $job->info ? $job->info->rolesId == 3 ? "(Organization)" : "" : "" }}
												</a>
											</div>
											@if(Auth::check() && Auth::user()->rolesId==1)
											<div class="col-sm-3">
												<p class="applicant-forms-right">
													<label class="@if(in_array($job->id, $saves_)) applicant-buttons-saved @else applicant-buttons @endif saved-applicant row{{$key}}" id="{{Crypt::encrypt($job->id)}}" row="{{$key}}">
														<i class="fa fa-bookmark" aria-hidden="true"></i>
													</label>
						                        </p>
											</div> 
											@endif
										</div>
									</div>

									<label class="job-label">
										<i class="fa fa-user"></i>
										{{ $job->employments->name }}
									</label>

									<label class="job-label">
										<i class="fas fa-map-marker-alt"></i>
										{{ $job->locationCity }}, {{ $job->country->nicename }}
									</label>

									<label class="job-label">
										<i class="fa fa-address-book"></i>
										{{ $job->specializations->name }}
									</label>

									<label class="job-label">
										<i class="fa fa-file"></i>
										{{ $job->positions->name }}
									</label>

									<label class="job-label job-label-money">
										<i class="fas fa-money job-label-black"></i>
										@if(!Auth::check())
											<a href="{{ url('login') }}" target="_blank" class="label-chinese">{{ App\MaintenanceLocale::getLocale(606) }}</a>
										@else
										{{ $job->currency->name }} {{ number_format($job->min,2)  }} - {{ number_format($job->max,2) }}
										@endif
									</label>

									<label class="job-label-description">
										 {!! strlen($job->description) > 200 ? str_limit($job->description, 200) : '' !!} @if(strlen($job->description) > 200) <a href="{{ url('jobs/'.Crypt::encrypt($job->id)) }}" target="_blank">Read more...</a> @endif
									</label>

									<div class="job-footer">
										<label class="job-label-posted">{{ App\MaintenanceLocale::getLocale(304) }}: {{ $job->created_at->diffForHumans() }}</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>

		<div class="mt-2">
			{{ $jobs->appends(request()->except('page'))->onEachSide(1)->links() }}
		</div>
	</div>

	<script>
		$(".saved-applicant").click(function() {
			var jobId 	= $(this).attr("id");
			 	key 	= $(this).attr("row");

			if($(this).hasClass("applicant-buttons-saved")) {
				status = "unsaved";
			}
			else {
				status = "save";
			}

			Swal.fire({
				title: "Do want to " + status + " this job?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#6c757d',
				confirmButtonText: 'Yes',
				cancelButtonText: 'No'
			}).then((result) => {
				if (result.value) {
    		       	ajax = true;

					basePath = window.location.origin;
		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    type : "POST",
		        	    url  : `${basePath}/applicant/saved_job`,
		        	    dataType : "json",
		        	    data : {
		        	        jobId		: 	jobId,
		        	        ajax 		: 	ajax,
		        	        key 		: 	key
		        	    },
		        	    success: function(response) {
		        			if (response.result === true) {
   								Swal.fire(
   								  response.message,
   								  '',
   								  'success'
   								).then(function(){ 
									if($(".row"+response.jobId).hasClass("applicant-buttons-saved")) {
										$(".row"+response.jobId).addClass('applicant-buttons')
										$(".row"+response.jobId).removeClass('applicant-buttons-saved')
									}
									else {
										$(".row"+response.jobId).addClass('applicant-buttons-saved')
										$(".row"+response.jobId).removeClass('applicant-buttons')
									}
								});
   		        			}
   		        			else {
   								Swal.fire(
   								  'Ooops',
   								  response.message,
   								  'error'
   								)
   		        			}
		        	    }
		        	});
				}
			})
		});
	</script>
@endsection