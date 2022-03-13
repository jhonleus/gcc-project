@extends('layouts.header')

@section('title', 'Search Courses')

@section('content')
	<!-- CSS FOR FRONT SEARCH COURSES-->
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/search-course-page.css') }}">

	<div class="container course-container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card course-search-contents">
					<div class="card-header course-search-header">
						<label class="course-search-title">{{ App\MaintenanceLocale::getLocale(82) }}</label>
					</div>
					<form method="POST" action="{{ url('courses/search') }}">
					@csrf
						<div class="card-body">
							<div class="row">
								<div class="col-sm-4">
									<div class="course-search-forms">
										<select name="country" class="select @if(isset($get_loc)) select-selected @endif" id="country">Select</option>
											<option hidden disabled selected> {{ App\MaintenanceLocale::getLocale(84) }}</option>
											<option></option>
											@foreach($countries as $val)
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
									<div class="course-search-forms">
										<select name="type" class="select @if(isset($get_type)) select-selected @endif" id="type">Select</option>
											<option hidden disabled selected> {{ App\MaintenanceLocale::getLocale(572) }}</option>
											<option></option>
											@foreach($types as $val)
												<option value="{{ $val->id }}"
													@if(isset($get_type))
														@if($get_type==$val->id)
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
									<div class="course-search-forms">
										<div class="row">
											<div class="col-sm-6 course-search-currency">
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
															{{ $val->getName() }} 
														</option>
													@endforeach
												</select> 
											</div>

											<div class="col-sm-6 course-search-salary">
												<input type="number" class="input" name="salary" value="@if(isset($get_salary)){{ $get_salary }}@endif" placeholder="{{ App\MaintenanceLocale::getLocale(573) }}" title="Minimum Tuition Fee" min="0">
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="course-search-forms">
										<input type="text" class="input" placeholder="{{ App\MaintenanceLocale::getLocale(541) }}" name="course" value="@if(isset($get_cour)){{$get_cour}}@endif">
									</div>
								</div>

								<div class="col-sm-4">
									<div class="course-search-forms">
										<input type="text" class="input" placeholder="{{ App\MaintenanceLocale::getLocale(490) }}" name="school" value="@if(isset($get_school)){{$get_school}}@endif">
									</div>
								</div>

								<div class="col-sm-4">
									<div class="course-search-forms">
										<button class="btn btn-chinese course-search-button"> 
										{{ App\MaintenanceLocale::getLocale(89) }}
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		@if(count($courses) < 1)
			@if($search)
				<div class="row">
					<div class="col-sm-12">
						<div class="card job-contents">
							<div class="card-body job-body">
								 <img src="/login-images/no-search-found.png" style="width: 40%; display: block; margin: 0px auto;"> 
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
	                <h2>{{ App\MaintenanceLocale::getLocale(574) }}</h2>
	            </div>
			@endif
		@endif

		@if(count($courses) >= 1)
			@php
	            $currentDisplay = $courses->currentPage() * $courses->perPage();
			@endphp
			
			<div class="text-right">
				<small class="form-text text-muted">
					Showing (
					<span id="start-page">{{ $currentDisplay - ($courses->perPage() - 1) }}</span>
					-
					<span id="end-page">{{ $currentDisplay < $courses->total() ? $currentDisplay : $courses->total() }}</span>
					of
					<span id="total-blog">{{ $courses->total() }}</span> )
				</small>
			</div>
		@endif

		<div class="row mt-2">
			@foreach($courses as $key => $course)
			<div class="col-sm-12">
			@if(!is_null($course->employers))
				<div class="card course-contents">
					<div class="card-body course-body">
						<div class="row">
							<div class="col-sm-4">
								@if(!is_null($course->documents))
									@if(!$course->documents->isEmpty())
										@php
											$x = 0;
										@endphp

										@foreach($course->documents as $file)
											@if($file->filetype==="profile")
												@php 
													$x = 1;
												@endphp

												<img class="course-image" src="{{ url($file->path . $file->filename)}}">
											@endif
										@endforeach

										@if($x < 1)
											<img src="{{ URL::to('/') }}/images/company.png" class="company-logo img-fluid">
										@endif
									@else
										<img class="course-image" src="{{ url("images/school.png")}}">
									@endif
								@else
									<img class="course-image" src="{{ url("images/school.png")}}">
								@endif

								<div class="text-center" style="color:#FF912C;">
									<i class="fa @if($course->average()>=1 && $course->average()<=5) @if(floor($course->average()<1)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($course->average()>=1.1 && $course->average()<=5) @if(floor($course->average()<2)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($course->average()>=2.1 && $course->average()<=5) @if(floor($course->average()<3)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($course->average()>=3.1 && $course->average()<=5) @if(floor($course->average()<4)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
									<i class="fa @if($course->average()>=4.1 && $course->average()<=5) @if(floor($course->average()<5)) fa-star-half-o @else fa-star @endif @else fa-star-o @endif" aria-hidden="true"></i>
								</div>
							</div>

							<div class="col-sm-8">
								<div class="course-header">
									<div class="row">
										<div class="col-sm-9">
											<a href="{{ url('courses/'.Crypt::encrypt($course->id)) }}" class="course-title" title="View Course Details" target="_blank">
												{{ $course->course }}
											</a>
											<a href="{{ url('school/'.Crypt::encrypt($course->usersId)) }}" class="course-school" title="View School Details" target="_blank">
												{{ $course->employers->school }}
											</a>
										</div>
										@if(Auth::check() && Auth::user()->rolesId==1)
										<div class="col-sm-3">
											<p class="applicant-forms-right">
												<label class="@if(in_array($course->id, $saves_)) applicant-buttons-saved @else applicant-buttons @endif saved-applicant row{{$key}}" id="{{Crypt::encrypt($course->id)}}" row="{{$key}}">
													<i class="fa fa-bookmark" aria-hidden="true"></i>
												</label>
					                        </p>
										</div> 
										@endif
									</div>
								</div>

								<label class="course-label">
									<i class="fas fa-hourglass-start"></i>
									{{ date('F d, Y', strtotime($course->class_start)) }}
								</label>

								<label class="course-label">
									<i class="fa fa-hourglass-end" aria-hidden="true"></i>
									{{ date('F d, Y', strtotime($course->class_end)) }} 
								</label>

								<label class="course-label">
									<i class="fas fa-map-marker-alt"></i>
									{{ $course->country->nicename }}
								</label>

								<label class="course-label course-label-money">
									<i class="fas fa-money course-label-black"></i>
									{{ $course->currency->name }}
									{{ $course->fee }}
								</label>

								<label class="course-label">
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

								<label class="course-label-description">
									 {!! $course->details !!}
								</label>

								<label class="course-label-description">
									{!! strlen($course->details) > 200 ? str_limit($course->details, 200) : '' !!} @if(strlen($course->details) > 200) <a href="{{ url('courses/'.Crypt::encrypt($course->id)) }}" target="_blank">Read more...</a> @endif
								</label>
							</div>
						</div>

						<div class="course-footer">
							<label class="course-label-posted">POSTED: {{ $course->created_at->diffForHumans() }}</label>
						</div>
					</div>
				</div>
			@endif
			</div>
			@endforeach
		</div>

		<div class="mt-2">
			{{ $courses->appends(request()->except('page'))->onEachSide(1)->links() }}
		</div>
	</div>

	<script>
		$(".saved-applicant").click(function() {
			var courseId 	= $(this).attr("id");
				key 		= $(this).attr("row");

			if($(this).hasClass("applicant-buttons-saved")) {
				status = "unsaved";
			}
			else {
				status = "save";
			}

			Swal.fire({
				title: "Do want to " + status + " this course?",
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
		        	    url  : `${basePath}/applicant/saved_course`,
		        	    dataType : "json",
		        	    data : {
		        	        courseId	: 	courseId,
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
									if($(".row"+response.courseId).hasClass("applicant-buttons-saved")) {
										$(".row"+response.courseId).addClass('applicant-buttons')
										$(".row"+response.courseId).removeClass('applicant-buttons-saved')
									}
									else {
										$(".row"+response.courseId).addClass('applicant-buttons-saved')
										$(".row"+response.courseId).removeClass('applicant-buttons')
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