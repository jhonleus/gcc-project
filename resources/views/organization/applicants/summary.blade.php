@extends('layouts.header')

@section('title', "Applicant")

@section('content')
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('organization.sidebar.profile')
				@include('organization.sidebar.index')
			</div>

			<div class="col-sm-9">
				@if(!isset($title))
					<div class="card card-body">
						<form method="POST" action="{{ url('organization/summary/applicants/search') }}">
							@csrf
							<div class="row">
								<div class="col-sm-4">
									<div class="applicant-search-forms">
										<select class="select @if(isset($get_spe)) select-selected @endif" name="specialization">
											<option hidden disabled selected> 
												Specialization
											</option>
											<option></option>
											@foreach($specialization as $val)
											<option value="{{ $val->id }}" 
												@if(isset($get_spe))
													@if($get_spe==$val->id)
														selected
													@endif
												@endif>
												{{ $val->name }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-sm-4">
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

								<div class="col-sm-4">
									<div class="applicant-search-forms">
										<div class="row">
											<div class="col-sm-6 padding-right">
												<select class="select @if(isset($get_curr)) select-selected @endif" name="currency">
													<option hidden disabled selected>Currency
													</option>
													<option></option>
													@foreach($currencies as $val)
													<option value="{{ $val->id }}" 
														@if(isset($get_curr))
															@if($get_curr==$val->id)
																selected
															@endif
														@endif>
														{{ $val->name }}</option>
													@endforeach
												</select> 
											</div>
											<div class="col-sm-6 padding-left">
												<input type="text" class="input" name="salary" value="@if(isset($get_salary)){{$get_salary}} @endif" placeholder="Minimum Salary" title="Minimum Salary" min="0">
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="applicant-search-forms">
										<input type="text" class="input"  name="title" value="@if(isset($get_title)){{$get_title}} @endif" placeholder="Job Title or Keywords">
									</div>
								</div>

								<div class="col-sm-4">
									<div class="applicant-search-forms">
										<button class="label-button btn btn-chinese" style="width: 100%;">Search</button>
									</div>
								</div>
							</div>
						</form>
					</div> 
				@else
					<h3 style="color: #444444" class="text-center">
						{{$title->title}}
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

				@foreach($applicants as $applicant)
					<div class="card page-contents">
						<div class="card-body page-content-body">
							<div class="content-header-1">
								@if($canViewProfile > 0)
									<a href="{{url("subscriber/applicants/".$applicant->applicant->id) }}" class="content-title" target="_blank"> 
										{{ $applicant->applicant->firstName }} {{ $applicant->applicant->lastName }}
									</a>
								@else
									<label class="content-title"> 
										{{ $applicant->applicant->firstName }} {{ $applicant->applicant->lastName }}
									</label>
								@endif

								<a href="{{url("jobs/".Crypt::encrypt($applicant->application->id)) }}" class="content-actions" target="_blank">
									{{ $applicant->application->title }}
								</a>
							</div>

							<div class="row">
								<div class="col-sm-9">
									<label class="content-details">
										<i class="fa fa-phone-square" aria-hidden="true"></i>
										+{{$applicant->contacts->country->phonecode}} {{$applicant->contacts->number}} 
									</label>

									<label class="content-details">
										<i class="fa fa-envelope" aria-hidden="true"></i>
										{{$applicant->applicant->email}}
									</label>

									<label class="content-details">
										<i class="fa fa-map-marker" aria-hidden="true"></i>
										{{$applicant->address->street}}, {{$applicant->address->city}}, {{$applicant->address->country->getName()}}
									</label>

									@if(!is_null($applicant->applicant))
										@if(!is_null($applicant->applicant->educations))
											@php
											 	$educations="";
											@endphp

											@foreach($applicant->applicant->educations as $educ)
												@php
													$education 	= $educ->attainment . " (".$educ->levels->name.")";
													$educations = $educations . $education . ", ";
												@endphp
											@endforeach
										@endif
									@endif

									@if(!$applicant->applicant->educations->isEmpty())
									<label class="content-details">
										<i class="fa fa-graduation-cap" aria-hidden="true">
										</i>
										{{rtrim($educations, ', ')}}
									</label>
									@endif

									@if(!is_null($applicant->documents))
										@foreach($applicant->documents as $document)
										@if($document->filetype==="resume")
										<label class="content-details">
											<i class="fa fa-file-text label-black" aria-hidden="true"></i>
											<a href="{{ url($document->path . $document->filename)}}" target="_blank">
												{{ $applicant->applicant->firstName }}.{{ $applicant->applicant->lastName }}-RESUME
											</a>
										</label>
										@endif
										@endforeach
									@endif

									@if(!is_null($applicant->applicant))
										@if(!is_null($applicant->applicant->certificates()))
											@php
											 	$certificates="";
											@endphp

											@foreach($applicant->applicant->certificates() as $certificate)
												@php
													$certificate 	= "<a target='_blank'
													 href='".url($certificate->path.$certificate->filename)."'>".$certificate->filename."</a>";
													$certificates 	= $certificates . $certificate . ", ";
												@endphp
											@endforeach
										@endif
									@endif

									@if(!$applicant->applicant->certificates()->isEmpty())
									<label class="content-details">
										<i class="fa fa-certificate" aria-hidden="true"></i>
										{!!rtrim($certificates, ', ')!!}
									</label>
									@endif

									@if(!is_null($applicant->applicant))
										@if(!is_null($applicant->applicant->tattoos()))
											@php
											 	$tattoos="";
											@endphp

											@foreach($applicant->applicant->tattoos() as $tattoo)
												@php
													$tattoo 	= "<a target='_blank' href='".url($tattoo->path.$tattoo->filename."'>".$tattoo->filename)."</a>";
													$tattoos 	= $tattoos . $tattoo . ", ";
												@endphp
											@endforeach
										@endif
									@endif

									@if(!$applicant->applicant->tattoos()->isEmpty())
									<label class="content-details">
										<i class="fa fa-pencil-square" aria-hidden="true"></i>
										{!!rtrim($tattoos, ', ')!!}
									</label>
									@endif
								</div>

								<div class="col-sm-3">
									@foreach($applicant->documents as $file)
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
			$("#applicantsum-list").removeClass("sidebar-list-title");
			$("#applicantsum-list").addClass("sidebar-list-title-active");
		});
	</script>
@endsection
