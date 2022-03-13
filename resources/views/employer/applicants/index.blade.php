@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(78))

@section('content')
	<!-- DATETIME PICKER JQUERY -->
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/css/datetime/jquery.datetimepicker.min.css') }}">
	<script src="{{ asset('resources/js/datetime/jquery.datetimepicker.js') }}"></script>
	<!--CKEDITOR-->
    <script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>


	<div class="container page-container">
		@include('flash-message')
		<div class="row">
			<div class="col-sm-3">
				@include('employer.sidebar.profile')
				@include('employer.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card page-title">
					<ul class="nav nav-tabs" data-tabs="tabs">
						<li class="nav-item">
							<a class="nav-link active" href="#pending" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(272) }} <span class="badge badge-light ml-2">{{$users->total()}}</span></a>
						</li>

						<!--<li class="nav-item">
							<a class="nav-link" href="#approves" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(550) }} <span class="badge badge-light ml-2">{{$approves->total()}}</span></a>
						</li>-->

						<li class="nav-item">
							<a class="nav-link" href="#scheduled" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(380) }} <span class="badge badge-light ml-2">{{$schedules->total()}}</span></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="#rejected" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(274) }} <span class="badge badge-light ml-2">{{$rejects->total()}}</span></a>
						</li>
					</ul>
				</div>

				<div class="tab-content">
					<div class="tab-pane active" id="pending">
						@php
							$currentDisplay = $users->currentPage() * $users->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($users->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $users->total() ? $currentDisplay : $users->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $users->total() }}</span> )
							</small>
						</div>

						@foreach($users as $user)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="content-header-1">
									<div class="row">
										<div class="col-sm-8">
											@if($canViewProfile > 0)
												<a href="{{url("subscriber/applicants/".$user->applicant->id) }}" class="content-title" target="_blank"> 
													{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}
												</a>
											@else
												<label class="content-title">{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}</label>
											@endif

											<a href="{{url("jobs/".Crypt::encrypt($user->application->id)) }}" class="content-actions" target="_blank">
												{{ $user->application->title }}
											</a>
										</div> 
										<div class="col-sm-4">
											<p class="content-right">
												<label class="schedule-applicant label-blue rowSchedule{{$user->id}}" name="{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}" email="{{$user->applicant->email}}" id="{{$user->id}}" job_name="{{ $user->application->title }}" rowSchedule="{{$user->id}}">
													<i class="fa fa-check-circle" aria-hidden="true"></i>
													{{ App\MaintenanceLocale::getLocale(76) }}
												</label>

												<label class="premium-decline-applicant label-red rowDecline{{$user->id}}" name="{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}" email="{{$user->applicant->email}}" id="{{$user->id}}" job_name="{{ $user->application->title }}" rowDecline="{{$user->id}}">
													<i class="fa fa-minus-circle" aria-hidden="true"></i>
													{{ App\MaintenanceLocale::getLocale(394) }}
												</label>
					                        </p>
										</div> 
									</div>
								</div>

								<div class="row">
									<div class="col-sm-9">
										<label class="content-details">
											<i class="fa fa-phone-square" aria-hidden="true"></i>
											+{{$user->contacts->country->phonecode}} {{$user->contacts->number}} 
										</label>

										<label class="content-details">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											{{$user->applicant->email}}
										</label>

										<label class="content-details">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											{{$user->address->street}}, {{$user->address->city}}, {{$user->address->country->getName()}}
										</label>

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->educations))
												@php
												 	$educations="";
												@endphp

												@foreach($user->applicant->educations as $educ)
													@php
														$education 	= $educ->attainment . " (".$educ->levels->name.")";
														$educations = $educations . $education . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->educations->isEmpty())
										<label class="content-details">
											<i class="fa fa-graduation-cap" aria-hidden="true">
											</i>
											{{rtrim($educations, ', ')}}
										</label>
										@endif

										@if(!is_null($user->documents))
											@foreach($user->documents as $document)
											@if($document->filetype==="resume")
											<label class="content-details">
												<i class="fa fa-file-text label-black" aria-hidden="true"></i>
												<a href="{{ url($document->path . $document->filename)}}">
													{{ $user->applicant->firstName }}.{{ $user->applicant->lastName }}-{{ App\MaintenanceLocale::getLocale(566) }}
												</a>
											</label>
											@endif
											@endforeach
										@endif

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->certificates()))
												@php
												 	$certificates="";
												@endphp

												@foreach($user->applicant->certificates() as $certificate)
													@php
														$certificate 	= "<a href='".url($certificate->path.$certificate->filename)."'>".$certificate->filename."</a>";
														$certificates 	= $certificates . $certificate . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->certificates()->isEmpty())
										<label class="content-details">
											<i class="fa fa-certificate" aria-hidden="true"></i>
											{!!rtrim($certificates, ', ')!!}
										</label>
										@endif

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->tattoos()))
												@php
												 	$tattoos="";
												@endphp

												@foreach($user->applicant->tattoos() as $tattoo)
													@php
														$tattoo 	= "<a href='".url($tattoo->path.$tattoo->filename."'>".$tattoo->filename)."</a>";
														$tattoos 	= $tattoos . $tattoo . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->tattoos()->isEmpty())
										<label class="content-details">
											<i class="fa fa-pencil-square" aria-hidden="true"></i>
											{!!rtrim($tattoos, ', ')!!}
										</label>
										@endif
									</div>

									<div class="col-sm-3">
										@foreach($user->documents as $file)
											@if($file->filetype==="profile")
												<img class="content-image" src="{{ url($file->path . $file->filename)}}">
											@endif
										@endforeach
									</div>
								</div>


								<div class="content-footer">
									<label class="label-date text-uppercase">{{ App\MaintenanceLocale::getLocale(381) }}: {{ $user->created_at->diffForHumans() }}</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $users->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
					<div class="tab-pane" id="approves">
						@php
							$currentDisplay = $approves->currentPage() * $approves->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($approves->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $approves->total() ? $currentDisplay : $approves->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $approves->total() }}</span> )
							</small>
						</div>

						@foreach($approves as $user)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="content-header-1">
									@if($canViewProfile > 0)
										<a href="{{url("subscriber/applicants/".$user->applicant->id) }}" class="content-title" target="_blank"> 
											{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}
										</a>
									@else
										<label class="content-title">{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}</label>
									@endif

									<a href="{{url("jobs/".Crypt::encrypt($user->application->id)) }}" class="content-actions">
										{{ $user->application->title }}
									</a>
								</div>

								<div class="row">
									<div class="col-sm-9">
										<label class="content-details">
											<i class="fa fa-phone-square" aria-hidden="true"></i>
											+{{$user->contacts->country->phonecode}} {{$user->contacts->number}} 
										</label>

										<label class="content-details">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											{{$user->applicant->email}}
										</label>

										<label class="content-details">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											{{$user->address->street}}, {{$user->address->city}}, {{$user->address->country->getName()}}
										</label>

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->educations))
												@php
												 	$educations="";
												@endphp

												@foreach($user->applicant->educations as $educ)
													@php
														$education 	= $educ->attainment . " (".$educ->levels->name.")";
														$educations = $educations . $education . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->educations->isEmpty())
										<label class="content-details">
											<i class="fa fa-graduation-cap" aria-hidden="true">
											</i>
											{{rtrim($educations, ', ')}}
										</label>
										@endif

										@if(!is_null($user->documents))
											@foreach($user->documents as $document)
											@if($document->filetype==="resume")
											<label class="content-details">
												<i class="fa fa-file-text label-black" aria-hidden="true"></i>
												<a href="{{ url($document->path . $document->filename)}}">
													{{ $user->applicant->firstName }}.{{ $user->applicant->lastName }}-{{ App\MaintenanceLocale::getLocale(566) }}
												</a>
											</label>
											@endif
											@endforeach
										@endif

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->certificates()))
												@php
												 	$certificates="";
												@endphp

												@foreach($user->applicant->certificates() as $certificate)
													@php
														$certificate 	= "<a href='".url($certificate->path.$certificate->filename)."'>".$certificate->filename."</a>";
														$certificates 	= $certificates . $certificate . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->certificates()->isEmpty())
										<label class="content-details">
											<i class="fa fa-certificate" aria-hidden="true"></i>
											{!!rtrim($certificates, ', ')!!}
										</label>
										@endif

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->tattoos()))
												@php
												 	$tattoos="";
												@endphp

												@foreach($user->applicant->tattoos() as $tattoo)
													@php
														$tattoo 	= "<a href='".url($tattoo->path.$tattoo->filename."'>".$tattoo->filename)."</a>";
														$tattoos 	= $tattoos . $tattoo . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->tattoos()->isEmpty())
										<label class="content-details">
											<i class="fa fa-pencil-square" aria-hidden="true"></i>
											{!!rtrim($tattoos, ', ')!!}
										</label>
										@endif
									</div>

									<div class="col-sm-3">
										@foreach($user->documents as $file)
											@if($file->filetype==="profile")
												<img class="content-image" src="{{ url($file->path . $file->filename)}}">
											@endif
										@endforeach
									</div>
								</div>

								@if(!is_null($user->scheduled))
								<div class="content-footer">
									<label class="label-date">{{ App\MaintenanceLocale::getLocale(382) }}: {{Helper::getDate($user->scheduled)}}</label>
								</div>
								@endif
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $approves->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
                    </div>
                    <div class="tab-pane" id="scheduled">
                    	@php
							$currentDisplay = $schedules->currentPage() * $schedules->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($schedules->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $schedules->total() ? $currentDisplay : $schedules->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $schedules->total() }}</span> )
							</small>
						</div>

						@foreach($schedules as $user)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="content-header-1">
									<div class="row">
										<div class="col-sm-8">
											@if($canViewProfile > 0)
												<a href="{{url("subscriber/applicants/".$user->applicant->id) }}" class="content-title" target="_blank"> 
													{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}
												</a>
											@else
												<label class="content-title">{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}</label>
											@endif

											<a href="{{url("jobs/".Crypt::encrypt($user->application->id)) }}" class="content-actions">
												{{ $user->application->title }}
											</a>
										</div>
										<div class="col-sm-4">
											@if(!is_null($user->response))
												@if($user->response->isAccept==2)
													<div class="text-right">
														<span class="badge badge-warning" style="font-size:12px;color:white;">{{Helper::getDate($user->response->availability)}}</span>
													</div>
													<p class="content-right">
														<label class="label-orange schedule-applicant rowSchedule{{$user->id}}" name="{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}" email="{{$user->applicant->email}}" id="{{$user->id}}" job_name="{{ $user->application->title }}" rowSchedule="{{$user->id}}">
															<i class="fa fa-check-circle" aria-hidden="true"></i>
															{{ App\MaintenanceLocale::getLocale(383) }}
														</label>
							                        </p>
							                    @elseif($user->response->isAccept==1)
							                    <div class="text-right">
							                    	<span class="badge badge-success text-uppercase" style="font-size:12px;">{{ App\MaintenanceLocale::getLocale(384) }}</span>
							                    </div>
							                    @elseif($user->response->isAccept==0)
							                    <div class="text-right">
							                    	<span class="badge badge-danger text-uppercase" style="font-size:12px;">{{ App\MaintenanceLocale::getLocale(385) }}</span>
							                    </div>
							                    @else
							                    <div class="text-right">
							                    	<span class="badge badge-primary text-uppercase" style="font-size:12px;">{{ App\MaintenanceLocale::getLocale(386) }}</span>
							                    </div>
							                    @endif
					                        @endif
										</div> 
									</div>
								</div>

								<div class="row">
									<div class="col-sm-9">
										<label class="content-details">
											<i class="fa fa-phone-square" aria-hidden="true"></i>
											+{{$user->contacts->country->phonecode}} {{$user->contacts->number}} 
										</label>

										<label class="content-details">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											{{$user->applicant->email}}
										</label>

										<label class="content-details">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											{{$user->address->street}}, {{$user->address->city}}, {{$user->address->country->getName()}}
										</label>

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->educations))
												@php
												 	$educations="";
												@endphp

												@foreach($user->applicant->educations as $educ)
													@php
														$education 	= $educ->attainment . " (".$educ->levels->name.")";
														$educations = $educations . $education . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->educations->isEmpty())
										<label class="content-details">
											<i class="fa fa-graduation-cap" aria-hidden="true">
											</i>
											{{rtrim($educations, ', ')}}
										</label>
										@endif

										@if(!is_null($user->documents))
											@foreach($user->documents as $document)
											@if($document->filetype==="resume")
											<label class="content-details">
												<i class="fa fa-file-text label-black" aria-hidden="true"></i>
												<a href="{{ url($document->path . $document->filename)}}">
													{{ $user->applicant->firstName }}.{{ $user->applicant->lastName }}-{{ App\MaintenanceLocale::getLocale(566) }}
												</a>
											</label>
											@endif
											@endforeach
										@endif

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->certificates()))
												@php
												 	$certificates="";
												@endphp

												@foreach($user->applicant->certificates() as $certificate)
													@php
														$certificate 	= "<a href='".url($certificate->path.$certificate->filename)."'>".$certificate->filename."</a>";
														$certificates 	= $certificates . $certificate . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->certificates()->isEmpty())
										<label class="content-details">
											<i class="fa fa-certificate" aria-hidden="true"></i>
											{!!rtrim($certificates, ', ')!!}
										</label>
										@endif

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->tattoos()))
												@php
												 	$tattoos="";
												@endphp

												@foreach($user->applicant->tattoos() as $tattoo)
													@php
														$tattoo 	= "<a href='".url($tattoo->path.$tattoo->filename."'>".$tattoo->filename)."</a>";
														$tattoos 	= $tattoos . $tattoo . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->tattoos()->isEmpty())
										<label class="content-details">
											<i class="fa fa-pencil-square" aria-hidden="true"></i>
											{!!rtrim($tattoos, ', ')!!}
										</label>
										@endif
									</div>

									<div class="col-sm-3">
										@foreach($user->documents as $file)
											@if($file->filetype==="profile")
												<img class="content-image" src="{{ url($file->path . $file->filename)}}">
											@endif
										@endforeach
									</div>
								</div>

								@if(!is_null($user->scheduled))
								<div class="content-footer">
									<label class="label-date">{{ App\MaintenanceLocale::getLocale(382) }}: {{Helper::getDate($user->scheduled)}}</label>
								</div>
								@endif
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $schedules->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
                    </div>
                    <div class="tab-pane" id="rejected">
                    	@php
							$currentDisplay = $rejects->currentPage() * $rejects->perPage();
						@endphp

						<div class="text-right" style="margin-bottom: 10px;">
							<small class="form-text text-muted mb-2">
								{{ App\MaintenanceLocale::getLocale(118) }} (
								<span id="start-page">{{ $currentDisplay - ($rejects->perPage() - 1) }}</span>
								-
								<span id="end-page">{{ $currentDisplay < $rejects->total() ? $currentDisplay : $rejects->total() }}</span>
								{{ App\MaintenanceLocale::getLocale(207) }}
								<span id="total-blog">{{ $rejects->total() }}</span> )
							</small>
						</div>

                       @foreach($rejects as $user)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="content-header-1">
									@if($canViewProfile > 0)
										<a href="{{url("subscriber/applicants/".$user->applicant->id) }}" class="content-title" target="_blank"> 
											{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}
										</a>
									@else
										<label class="content-title">{{ $user->applicant->firstName }} {{ $user->applicant->lastName }}</label>
									@endif
									
									<a href="{{url("jobs/".Crypt::encrypt($user->application->id)) }}" class="content-actions">
										{{ $user->application->title }}
									</a>
								</div>

								<div class="row">
									<div class="col-sm-9">
										<label class="content-details">
											<i class="fa fa-phone-square" aria-hidden="true"></i>
											+{{$user->contacts->country->phonecode}} {{$user->contacts->number}} 
										</label>

										<label class="content-details">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											{{$user->applicant->email}}
										</label>

										<label class="content-details">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											{{$user->address->street}}, {{$user->address->city}}, {{$user->address->country->getName()}}
										</label>

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->educations))
												@php
												 	$educations="";
												@endphp

												@foreach($user->applicant->educations as $educ)
													@php
														$education 	= $educ->attainment . " (".$educ->levels->name.")";
														$educations = $educations . $education . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->educations->isEmpty())
										<label class="content-details">
											<i class="fa fa-graduation-cap" aria-hidden="true">
											</i>
											{{rtrim($educations, ', ')}}
										</label>
										@endif

										@if(!is_null($user->documents))
											@foreach($user->documents as $document)
											@if($document->filetype==="resume")
											<label class="content-details">
												<i class="fa fa-file-text label-black" aria-hidden="true"></i>
												<a href="{{ url($document->path . $document->filename)}}">
													{{ $user->applicant->firstName }}.{{ $user->applicant->lastName }}-{{ App\MaintenanceLocale::getLocale(566) }}
												</a>
											</label>
											@endif
											@endforeach
										@endif

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->certificates()))
												@php
												 	$certificates="";
												@endphp

												@foreach($user->applicant->certificates() as $certificate)
													@php
														$certificate 	= "<a href='".url($certificate->path.$certificate->filename)."'>".$certificate->filename."</a>";
														$certificates 	= $certificates . $certificate . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->certificates()->isEmpty())
										<label class="content-details">
											<i class="fa fa-certificate" aria-hidden="true"></i>
											{!!rtrim($certificates, ', ')!!}
										</label>
										@endif

										@if(!is_null($user->applicant))
											@if(!is_null($user->applicant->tattoos()))
												@php
												 	$tattoos="";
												@endphp

												@foreach($user->applicant->tattoos() as $tattoo)
													@php
														$tattoo 	= "<a href='".url($tattoo->path.$tattoo->filename."'>".$tattoo->filename)."</a>";
														$tattoos 	= $tattoos . $tattoo . ", ";
													@endphp
												@endforeach
											@endif
										@endif

										@if(!$user->applicant->tattoos()->isEmpty())
										<label class="content-details">
											<i class="fa fa-pencil-square" aria-hidden="true"></i>
											{!!rtrim($tattoos, ', ')!!}
										</label>
										@endif
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
							{{ $rejects->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
                    </div>
				</div>
			</div>
		</div>
	</div>

	<div id="premium-approve-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-for-actions modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box confirmation-label">
						<i class="material-icons fa fa-check"></i>
					</div>				
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-8">
							<label class="label-select">
								Note: Use [application_name] to include job name.
								<br>
								Use [application_date] to include scheduled date.
								<br>
								Use [application_time] to include scheduled time.
							</label>

							<div class="contents-form">
								<label class="label-select">
									{{ App\MaintenanceLocale::getLocale(368) }}:
								</label>

								<input class="input" id="asubject" name="asubject">

								<div class="error-container">
									<label class="label-error error-asubject">{{ $message['ER:00:65'] }}</label>
								</div>
							</div>

							<div class="contents-form">
								<label class="label-select">
									{{ App\MaintenanceLocale::getLocale(259) }}:
								</label>

								<div class="ckeditor-amessage">
									<textarea class="txtarea" id="amessage" name="amessage"></textarea>
								</div>

								<div class="error-container">
									<label class="label-error error-amessage">{{ $message['ER:00:67'] }}</label>
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="contents-form">
								<h1 class="label-select">{{ App\MaintenanceLocale::getLocale(387) }}:</h1>

								<div id="select-date"></div>
							
								<div class="error-container">
									<label class="label-error error-date">{{ $message['ER:00:70'] }}</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn label-button btn-secondary premium-button" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
				</div>
				
				<input type="hidden" id="date" name="date">
			</div>
		</div>
	</div>

	<div id="premium-decline-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-for-actions">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box confirmation-label">
						<i class="material-icons fa fa-remove"></i>
					</div>				
				</div>

				<div class="modal-body">
					<p class="label-confirmation">
						{{ App\MaintenanceLocale::getLocale(389) }}
					</p>

					<label class="label-select">
						Note: Use [application_name] to include job name.
					</label>
					
					<div class="contents-form">
						<label class="label-select">
							{{ App\MaintenanceLocale::getLocale(368) }}:
						</label>

						<input class="input" id="dsubject" name="dsubject">

						<div class="error-container">
							<label class="label-error error-dsubject">{{ $message['ER:00:65'] }}</label>
						</div>
					</div>

					<div class="contents-form">
						<label class="label-select">
							{{ App\MaintenanceLocale::getLocale(259) }}:
						</label>

						<div class="ckeditor-dmessage">
							<textarea class="txtarea" id="dmessage" name="dmessage"></textarea>
						</div>

						<div class="error-container">
							<label class="label-error error-dmessage">{{ $message['ER:00:67'] }}</label>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn label-button btn-secondary close-button" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
				</div>
			</div>
		</div>
	</div> 
	
	<!--	
	<div id="approve-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-for-actions modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box confirmation-label">
						<i class="material-icons fa fa-check"></i>
					</div>				
				</div>

				<div class="modal-body">
					<p class="label-2 f3">
						{{ App\MaintenanceLocale::getLocale(390) }}
					</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn label-button btn-secondary close-button approve-close" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
				</div>
			</div>
		</div>
	</div>

	<div id="decline-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-for-actions modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box confirmation-label">
						<i class="material-icons fa fa-remove"></i>
					</div>				
				</div>

				<div class="modal-body">
					<p class="label-2 f3">
						{{ App\MaintenanceLocale::getLocale(391) }}
					</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn label-button btn-secondary close-button" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
				</div>
			</div>
		</div>
	</div>
	-->

	<div id="success-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-for-actions">
			<div class="modal-content">
				<div class="modal-header">
					<div class="status-box success-label">
						<i class="material-icons fa fa-check"></i>
					</div>				
				</div>

				<div class="modal-body">
					<p class="label-confirmation">
						{{ App\MaintenanceLocale::getLocale(392) }}
					</p>
				</div>

				<div class="modal-footer align-c">
					<button type="button" class="btn label-button btn-success btn-100 success-button">{{ App\MaintenanceLocale::getLocale(372) }}</button>
				</div>
			</div>
		</div>
	</div>  

	<script> 
		$(document).ready(function(){
			$("#applicant-list").removeClass("sidebar-list-title");
			$("#applicant-list").addClass("sidebar-list-title-active");
		});

		$(".success-button").click(function() {
			$('#success-modal').modal('hide'); 
			window.location.reload();
		});

		$(".close-button").click(function() {
    		$(".approve-button").remove();
    		$(".decline-button").remove();
    		$(".premium-decline-button").remove();
		   	$(".premium-approve-applicant").remove();
		});

		CKEDITOR.replace("amessage");
		CKEDITOR.replace("dmessage");
		CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
        ];

		$(".schedule-applicant").click(function() {
			@if($errors->any()) 
			var rowSchedule = "{{ old('rowSchedule') }}";
			@else
			var rowSchedule = $(this).attr("rowSchedule");
			@endif

			var name 		= $(".rowSchedule"+rowSchedule).attr("name");
				email 		= $(".rowSchedule"+rowSchedule).attr("email");
				id 			= $(".rowSchedule"+rowSchedule).attr("id");
				job_name 	= $(".rowSchedule"+rowSchedule).attr("job_name");

			$('#premium-approve-modal').modal('show'); 
			$(".premium-button").after(premium_approve_applicant(name, email, id, job_name, rowSchedule));
		});

		function premium_approve_applicant(name, email, id, job_name, rowSchedule) {
		    return $('<button/>', {
		        text: 	'Approve',
		        type: 	'button',
		        id: 	'premium-approve-applicant',
		        class: 	'btn label-button btn-chinese premium-approve-applicant',
		        click: function() {
		       	 	asubject 	= $("#asubject").val();
		       		amessage	= CKEDITOR.instances['amessage'].getData().replace(/<[^>]*>/gi, '').length;
		       		date 	= $("#date").val();
		       		now 	= new Date();
		       		date_ 	= new Date(date);

		        	if(!amessage || asubject==="" || asubject===null || date_ < now || date_===null || date_==="") {

		        		if(asubject==="" || asubject==="") {
		        			$(".error-asubject").show();				
		        			$(".error-asubject").html("{{ $message['ER:00:65'] }}");				
		        			$("#asubject").css("border", "1px solid red");
		        		}

		        		if(!amessage) {
		        			$(".error-amessage").show();				
		        			$(".error-amessage").html("{{ $message['ER:00:67'] }}");				
		        			$(".ckeditor-amessage").css("border", "1px solid red");
		        		}

		        		if(date_===null || date_==="" || date_ < now) {
		        			if(date_===null || date_==="") {
		        				$(".error-date").show();				
		        				$(".error-date").html("{{ $message['ER:00:69'] }}");				
		        			}
		        			else {
		        		    	$(".error-date").show();
		        		    	$(".error-date").html("{{ $message['ER:00:70'] }}");
		        		    }
		        		}
		        	}
		        	else {
		        		$(".premium-approve-applicant").remove();
	    		       	$("#premium-approve-modal").modal('hide');

						basePath = window.location.origin;
			        	$.ajax({
			        		headers: {
			        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
			        		},
			        	    type : "POST",
			        	    url  : `${basePath}/employer/approve`,
			        	    dataType : "json",
			        	    data : {
			        	       	job_name 		: 	job_name,
			        	       	applicant_name 	: 	name,
			        	       	applicant_email	: 	email,
			        	       	application_id 	: 	id,
			        	       	asubject 		: 	asubject,
			        	       	amessage 		: 	amessage,
			        	       	date 			: 	date,
			        	       	rowSchedule 	: 	rowSchedule,
			        	    },
			        	    success: function(response) {
			        			if (response.result === true) {
       								Swal.fire(
       								  response.message,
       								  '',
       								  'success'
       								).then(function(){ 
										location.reload();
									});
       		        			}
       		        			else {
       		        				msg = response.message;

       		        				if(msg['asubject']!==undefined || msg['amessage']!==undefined || msg['date']!==undefined) {

	    		       					$(".schedule-applicant").click();
       		        					if(msg['asubject']!==undefined) {
       		        						if(msg['asubject'][0].match(/required/)) {
       		        							$(".error-asubject").show();
       		        							$(".error-asubject").html("{{ $message['ER:00:65'] }}");
       		        							$("#asubject").css("border", "1px solid red");
       		        						}
       		        						else {
       		        							$(".error-asubject").show();
       		        							$(".error-asubject").html("{{ $message['ER:00:66'] }}");
       		        							$("#asubject").css("border", "1px solid red");
       		        						}
	       		        				}

       		        					if(msg['amessage']!==undefined) {
       		        						if(msg['amessage'][0].match(/required/)) {
	       		        						$(".error-amessage").show();
	       		        						$(".error-amessage").html("{{ $message['ER:00:67'] }}");
	       		        						$(".ckeditor-amessage").css("border", "1px solid red");
	       		        					}
       		        					}

       		        					if(msg['date']!==undefined) {
       		        						if(msg['date'][0].match(/required/)) {
	       		        						$(".error-date").show();
		        								$(".error-date").html("{{ $message['ER:00:69'] }}");				
	       		        					}
	       		        					else {
	       		        						$(".error-date").show();
	       		        						$(".error-date").html("{{ $message['ER:00:70'] }}");
	       		        					}
       		        					}
       		        				}
			   		        		else if(msg['application_id']!==undefined) {
			   		        			if(msg['application_id'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:61'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:62'] }}", 'error')
			   		        			}
			        				}	
			        				else if(msg['applicant_name']!==undefined) {
			        					if(msg['applicant_name'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:63'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "{{ $message['ER:00:64'] }}", 'error')
			   		        			}
			        				}
			        				else if(msg['applicant_email']!==undefined) {
			        					if(msg['applicant_email'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "Applicant's {{ $message['ER:00:33'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "Applicant's {{ $message['ER:00:34'] }}", 'error')
			   		        			}
			        				}
			        				else if(msg['job_name']!==undefined) {
			        					if(msg['job_name'][0].match(/required/)) {
			   		        				Swal.fire('Ooops', "Applicant's {{ $message['ER:00:41'] }}", 'error')
			   		        			}
			   		        			else {
			   		        				Swal.fire('Ooops', "Applicant's {{ $message['ER:00:42'] }}", 'error')
			   		        			}
			        				}
			        				else {
			        					Swal.fire('Ooops', msg, 'error')
			        				}
       		        			}
			        	    }
			        	});
		        	}
		        }
		    });
		}

		$(".premium-decline-applicant").click(function() {
			@if($errors->any()) 
			var rowDecline = "{{ old('rowDecline') }}";
			@else
			var rowDecline = $(this).attr("rowDecline");
			@endif

			var name 		= $(".rowDecline"+rowDecline).attr("name");
				email 		= $(".rowDecline"+rowDecline).attr("email");
				id 			= $(".rowDecline"+rowDecline).attr("id");
				job_name 	= $(".rowDecline"+rowDecline).attr("job_name");

			$('#premium-decline-modal').modal('show'); 
			$(".close-button").after(premium_decline_applicant(name, email, id, job_name, rowDecline));
		});

		function premium_decline_applicant(name, email, id, job_name, rowDecline) {
		    return $('<button/>', {
		        text: 	'Decline',
		        id: 	'premium-decline-button',
		        class: 	'btn label-button btn-chinese premium-decline-button',
		        click: function() {
    		       	dsubject 	= $("#dsubject").val();
		        	length			= CKEDITOR.instances['dmessage'].getData().replace(/<[^>]*>/gi, '').length;
		        	dmessage		= CKEDITOR.instances['dmessage'].getData();

		        	if(!length || dsubject==="") {

		        		if(dsubject==="") {
		        			$(".error-dsubject").show();
		        			$(".error-dsubject").html("{{ $message['ER:00:65'] }}");
		        			$("#dsubject").css("border", "1px solid red");
		        		}

		        		if(!length) {
		        			$(".error-dmessage").show();
		        			$(".error-dmessage").html("{{ $message['ER:00:67'] }}");
		        			$(".ckeditor-dmessage").css("border", "1px solid red");
		        		}
		        	}
		        	else {
		        		$(".premium-decline-button").remove();
	    		       	$("#premium-decline-modal").modal('hide');

						basePath = window.location.origin;
			        	$.ajax({
			        		headers: {
			        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
			        		},
			        	    type : "POST",
			        	    url  : `${basePath}/employer/reject`,
			        	    dataType : "json",
			        	    data : {
			        	        applicant_name		: 	name,
			        	        applicant_email		: 	email,
			        	        application_id		: 	id,
			        	        job_name			: 	job_name,
			        	        dmessage			: 	dmessage,
			        	        dsubject			: 	dsubject,
			        	        rowDecline			: 	rowDecline
			        	    },
			        	    success: function(response) {
			        			if (response.result === true) {
       								Swal.fire(
       								  response.message,
       								  '',
       								  'success'
       								).then(function(){ 
										location.reload();
									});
       		        			}
       		        			else {
       		        				msg = response.message;

       		        				if(msg['dsubject']!==undefined || msg['dmessage']!==undefined) {

	    		       					$(".premium-decline-applicant").click();
       		        					if(msg['dsubject']!==undefined) {
       		        						if(msg['dsubject'][0].match(/required/)) {
       		        							$(".error-dsubject").show();
       		        							$(".error-dsubject").html("{{ $message['ER:00:65'] }}");
       		        							$("#dsubject").css("border", "1px solid red");
       		        						}
       		        						else {
       		        							$(".error-dsubject").show();
       		        							$(".error-dsubject").html("{{ $message['ER:00:66'] }}");
       		        							$("#dsubject").css("border", "1px solid red");
       		        						}
	       		        				}

       		        					if(msg['dmessage']!==undefined) {
       		        						if(msg['dmessage'][0].match(/required/)) {
	       		        						$(".error-dmessage").show();
	       		        						$(".error-dmessage").html("{{ $message['ER:00:67'] }}");
	       		        						$(".ckeditor-dmessage").css("border", "1px solid red");
	       		        					}
       		        					}
       		        				}
			   		        		else if(msg['application_id']!==undefined) {
			   		        			if(msg['application_id'][0].match(/required/)) {
			   		        				Swal.fire(
			   		        				  	'Ooops',
			   		        				  	"{{ $message['ER:00:61'] }}",
			   		        				  	'error'
			   		        				)
			   		        			}
			   		        			else {
			   		        				Swal.fire(
			   		        				  	'Ooops',
			   		        				  	"{{ $message['ER:00:62'] }}",
			   		        				  	'error'
			   		        				)
			   		        			}
			        				}	
			        				else if(msg['applicant_name']!==undefined) {
			        					if(msg['applicant_name'][0].match(/required/)) {
			   		        				Swal.fire(
			   		        				  	'Ooops',
			   		        				  	"{{ $message['ER:00:63'] }}",
			   		        				  	'error'
			   		        				)
			   		        			}
			   		        			else {
			   		        				Swal.fire(
			   		        				  	'Ooops',
			   		        				  	"{{ $message['ER:00:64'] }}",
			   		        				  	'error'
			   		        				)
			   		        			}
			        				}
			        				else if(msg['applicant_email']!==undefined) {
			        					if(msg['applicant_email'][0].match(/required/)) {
			   		        				Swal.fire(
			   		        				  	'Ooops',
			   		        				  	"applicant's {{ $message['ER:00:33'] }}",
			   		        				  	'error'
			   		        				)
			   		        			}
			   		        			else {
			   		        				Swal.fire(
			   		        				  	'Ooops',
			   		        				  	"applicant's {{ $message['ER:00:34'] }}",
			   		        				  	'error'
			   		        				)
			   		        			}
			        				}
			        				else if(msg['job_name']!==undefined) {
			        					if(msg['job_name'][0].match(/required/)) {
			   		        				Swal.fire(
			   		        				  	'Ooops',
			   		        				  	"applicant's {{ $message['ER:00:41'] }}",
			   		        				  	'error'
			   		        				)
			   		        			}
			   		        			else {
			   		        				Swal.fire(
			   		        				  	'Ooops',
			   		        				  	"applicant's {{ $message['ER:00:42'] }}",
			   		        				  	'error'
			   		        				)
			   		        			}
			        				}
			        				else {
			        					Swal.fire(
										  	'Ooops',
										  	msg,
										  	'error'
										)
			        				}
       		        			}
			        	    }
			        	});
		        	}
		        }
		    });
		}

		$('#select-date').datetimepicker({
			viewMode: 'YMDHMS',
			onDateChange: function() {
				var now 			= new Date();
			    	date_format 	= this.getText("yyyy-MM-dd hh:mm:ss");
			    	proper_format 	= this.getValue();

			    if (proper_format < now) {
			    	$(".error-date").show();
			    	$(".error-date").html("{{ $message['ER:00:70'] }}");
			    }
			    else {
			   		$(".error-date").hide();
			    }

			    $("#date").val(date_format);
			},
		});

		CKEDITOR.instances.dmessage.on('change', function () { 
	    	var length 	= CKEDITOR.instances['dmessage'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-dmessage").show();
				$(".error-dmessage").html("{{ $message['ER:00:67'] }}");
				$(".ckeditor-dmessage").css('border', '1px solid red');
	        }
	        else {
				$(".error-dmessage").hide();
				$(".ckeditor-dmessage").css('border', '');
	        }
	    });

		CKEDITOR.instances.amessage.on('change', function () { 
	    	var length 	= CKEDITOR.instances['amessage'].getData().replace(/<[^>]*>/gi, '').length;

	        if(!length) {
				$(".error-amessage").show();
				$(".error-amessage").html("{{ $message['ER:00:67'] }}");
				$(".ckeditor-amessage").css('border', '1px solid red');
	        }
	        else {
				$(".error-amessage").hide();
				$(".ckeditor-amessage").css('border', '');
	        }
	    });

	    $("#asubject").keyup(function() {
			value 		= $(this).val();

	        if(value==="" || value===null) {
	    		$(".error-asubject").show();
	    		$(".error-asubject").html("{{ $message['ER:00:65'] }}");
				$("#asubject").css('border', '1px solid red');
	        } 
	        else {
	    		$(".error-asubject").hide();
				$("#asubject").css('border', '');
	        }
		})

		$("#dsubject").keyup(function() {
			value 		= $(this).val();

	        if(value==="" || value===null) {
	    		$(".error-dsubject").show();
	    		$(".error-dsubject").html("{{ $message['ER:00:65'] }}");
				$("#dsubject").css('border', '1px solid red');
	        } 
	        else {
	    		$(".error-dsubject").hide();
				$("#dsubject").css('border', '');
	        }
		})

		/*
		$(".approve-applicant").click(function() {
			var name 		= $(this).attr("name");
				email 		= $(this).attr("email");
				id 			= $(this).attr("id");
				job_name 	= $(this).attr("job_name");

			$('#approve-modal').modal('show'); 
			$(".approve-close").after(approve_applicant(name, email, id, job_name));
		});

		function approve_applicant(name, email, id, job_name) {
		    return $('<button/>', {
		        text: 	'Approve',
		        id: 	'approve-button',
		        class: 	'btn label-button btn-chinese approve-button',
		        click: function() {
	        		$(".approve-button").remove();
    		       	$("#approve-modal").modal('hide');

					basePath = window.location.origin;
		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    type : "POST",
		        	    url  : `${basePath}/employer/approve2`,
		        	    dataType : "json",
		        	    data : {
		        	        applicant_name		: 	name,
		        	        applicant_email		: 	email,
		        	        application_id		: 	id,
		        	        job_name			: 	job_name
		        	    },
		        	    success: function(response) {
		        			if (response.result === true) {
   								Swal.fire(
   								  response.message,
   								  '',
   								  'success'
   								).then(function(){ 
									location.reload();
								});
   		        			}
   		        			else {
   								msg = response.message;
		   		        		if(msg['application_id']!==undefined) {
		   		        			if(msg['application_id'][0].match(/required/)) {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"{{ $message['ER:00:61'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		   		        			else {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"{{ $message['ER:00:62'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		        				}	
		        				else if(msg['applicant_name']!==undefined) {
		        					if(msg['applicant_name'][0].match(/required/)) {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"{{ $message['ER:00:63'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		   		        			else {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"{{ $message['ER:00:64'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		        				}
		        				else if(msg['applicant_email']!==undefined) {
		        					if(msg['applicant_email'][0].match(/required/)) {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"applicant's {{ $message['ER:00:33'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		   		        			else {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"applicant's {{ $message['ER:00:34'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		        				}
		        				else if(msg['job_name']!==undefined) {
		        					if(msg['job_name'][0].match(/required/)) {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"applicant's {{ $message['ER:00:41'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		   		        			else {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"applicant's {{ $message['ER:00:42'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		        				}
		        				else {
		        					Swal.fire(
									  	'Ooops',
									  	msg,
									  	'error'
									)
		        				}
   		        			}
		        	    }
		        	});
		        }
		    });
		}

		$(".decline-applicant").click(function() {
			var name 		= $(this).attr("name");
				email 		= $(this).attr("email");
				id 			= $(this).attr("id");
				job_name 	= $(this).attr("job_name");

			$('#decline-modal').modal('show'); 
			$(".close-button").after(decline_applicant(name, email, id, job_name));
		});

		function decline_applicant(name, email, id, job_name) {
		    return $('<button/>', {
		        text: 	'Decline',
		        id: 	'decline-button',
		        class: 	'btn label-button btn-chinese decline-button',
		        click: function() {
	        		$(".decline-button").remove();
    		       	$("#decline-modal").modal('hide');

					basePath = window.location.origin;
		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    type : "POST",
		        	    url  : `${basePath}/employer/reject2`,
		        	    dataType : "json",
		        	    data : {
		        	        applicant_name		: 	name,
		        	        applicant_email		: 	email,
		        	        application_id		: 	id,
		        	        job_name			: 	job_name
		        	    },
		        	    success: function(response) {
		        			if (response.result === true) {
   								Swal.fire(
   								  response.message,
   								  '',
   								  'success'
   								).then(function(){ 
									location.reload();
								});
   		        			}
   		        			else {
   								msg = response.message;
		   		        		if(msg['application_id']!==undefined) {
		   		        			if(msg['application_id'][0].match(/required/)) {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"{{ $message['ER:00:61'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		   		        			else {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"{{ $message['ER:00:62'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		        				}	
		        				else if(msg['applicant_name']!==undefined) {
		        					if(msg['applicant_name'][0].match(/required/)) {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"{{ $message['ER:00:63'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		   		        			else {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"{{ $message['ER:00:64'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		        				}
		        				else if(msg['applicant_email']!==undefined) {
		        					if(msg['applicant_email'][0].match(/required/)) {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"applicant's {{ $message['ER:00:33'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		   		        			else {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"applicant's {{ $message['ER:00:34'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		        				}
		        				else if(msg['job_name']!==undefined) {
		        					if(msg['job_name'][0].match(/required/)) {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"applicant's {{ $message['ER:00:41'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		   		        			else {
		   		        				Swal.fire(
		   		        				  	'Ooops',
		   		        				  	"applicant's {{ $message['ER:00:42'] }}",
		   		        				  	'error'
		   		        				)
		   		        			}
		        				}
		        				else {
		        					Swal.fire(
									  	'Ooops',
									  	msg,
									  	'error'
									)
		        				}
   		        			}
		        	    }
		        	});
		        }
		    });
		}*/
	</script>
@endsection
