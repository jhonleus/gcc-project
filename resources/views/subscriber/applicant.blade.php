@extends('layouts.header')

@section('title', 'Search Applicants')

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/search-applicant-page.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/css/custom/modal.css') }}">

	<div class="container applicant-container">
		<div class="row">
			<div class="col-sm-4">
				<form method="POST" action="{{ url('applicants/search') }}">
					@csrf
					<div class="card applicant-search-contents">
						<div class="card-header applicant-search-header">
							<label class="applicant-search-title">Search Criteria</label>
						</div>
						<div class="card-body">
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

							<div class="applicant-search-forms">
								<input type="text" class="input"  name="title" value="@if(isset($get_title)){{$get_title}} @endif" placeholder="Job Title or Keywords">
							</div>


							<div class="applicant-search-forms">
								<div class="row">
									<div class="col-sm-6 applicant-search-currency">
										<select class="select @if(isset($get_curr)) select-selected @endif" name="currency">
											<option hidden disabled selected> 
												Currency
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

									<div class="col-sm-6 applicant-search-salary">
										<input type="text" class="input" name="salary" value="@if(isset($get_salary)){{$get_salary}} @endif" placeholder="Minimum Salary" title="Minimum Salary" min="0">
									</div>
								</div>
							</div>

							<div class="applicant-search-forms">
								<button class="btn btn-primary applicant-search-button"> 
									Search
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="col-sm-8">
				@foreach($users as $user)
					@foreach($user->documents as $doc)
						@if($doc->filetype==="profile")<?php
							$profile_pic = $doc->path . $doc->filename; ?>
						@endif
					@endforeach
				<div class="card applicant-contents-details">
					<div class="card-body applicant-body">
						<div class="applicant-header">
							<div class="row">
								<div class="col-sm-9">
									<label class="applicant-name"> 
										{{ $user->firstName }} {{ $user->lastName }}
									</label>
								</div> 
								@if($savedStatus==1)
								<div class="col-sm-3">
									<p class="applicant-forms-right">
										<label class="@if(in_array($user->id, $saves_)) applicant-buttons-saved @else applicant-buttons @endif saved-applicant"  id="{{$user->id}}">
											<i class="fa fa-bookmark" aria-hidden="true"></i>
										</label>
			                        </p>
								</div> 
								@endif
							</div>
						</div>

						<div class="row">
							<div class="col-sm-9">
								<label class="applicant-details">
									<i class="fa fa-phone-square" aria-hidden="true"></i>
									+{{$user->contacts ? $user->contacts->codeId : ""}} {{$user->contacts ? $user->contacts->number : ""}} 
								</label>

								<label class="applicant-details">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									{{$user->email}}
								</label>

								<label class="applicant-details">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
									{{$user->address ? $user->address->street : ""}}, {{$user->address? $user->address->city : ""}}, {{$user->address ? $user->address->country->getName() : ""}}
								</label>

								@if(!is_null($user->educations))
									@php
									 	$educations="";
									@endphp

									@foreach($user->educations as $educ)
										@php
											$education 	= $educ->attainment . " (".$educ->levels->name.")";
											$educations = $educations . $education . ", ";
										@endphp
									@endforeach
								@endif

								@if(!$user->educations->isEmpty())
								<label class="applicant-details">
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
											{{ $applicant->applicant->firstName }}.{{ $applicant->applicant->lastName }}-RESUME
										</a>
									</label>
									@endif
									@endforeach
								@endif

								@if(!is_null($user))
									@if(!is_null($user->certificates()))
										@php
										 	$certificates="";
										@endphp

										@foreach($user->certificates() as $certificate)
											@php
												$certificate 	= "<a href='".url($certificate->path.$certificate->filename)."'>".$certificate->filename."</a>";
												$certificates 	= $certificates . $certificate . ", ";
											@endphp
										@endforeach
									@endif
								@endif

								@if(!$user->certificates()->isEmpty())
								<label class="applicant-details">
									<i class="fa fa-certificate" aria-hidden="true"></i>
									{!!rtrim($certificates, ', ')!!}
								</label>
								@endif

								@if(!is_null($user))
									@if(!is_null($user->tattoos()))
										@php
										 	$tattoos="";
										@endphp

										@foreach($user->tattoos() as $tattoo)
											@php
												$tattoo 	= "<a href='".url($tattoo->path.$tattoo->filename."'>".$tattoo->filename)."</a>";
												$tattoos 	= $tattoos . $tattoo . ", ";
											@endphp
										@endforeach
									@endif
								@endif

								@if(!$user->tattoos()->isEmpty())
								<label class="applicant-details">
									<i class="fa fa-pencil-square" aria-hidden="true"></i>
									{!!rtrim($tattoos, ', ')!!}
								</label>
								@endif
							</div>

							<div class="col-sm-3">
								@if(isset($profile_pic))
								<img class="applicant-image" src="{{ url($profile_pic)}}">
								@endif
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>

		<div id="warning-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
			<input type="hidden" class="job_name" name="job_name">
			<div class="modal-dialog modal-for-actions">
				<div class="modal-content">
					<div class="modal-header">
						<div class="status-box confirmation-label">
							<i class="material-icons fa fa-remove"></i>
						</div>				
					</div>

					<div class="modal-body">
						<p class="label-2 f3" id="warning-message">
							Are you sure you want to <font class="status">save</font> this applicant?
						</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn applicant-button btn-secondary close-button" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div> 

		<div id="success-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-for-actions">
				<div class="modal-content">
					<div class="modal-header">
						<div class="status-box success-label">
							<i class="material-icons fa fa-check"></i>
						</div>				
					</div>

					<div class="modal-body">
						<p class="label-2 f3" id="success-message">
							Successfully Saved
						</p>
					</div>

					<div class="modal-footer align-c">
						<button type="button" class="btn applicant-button btn-success btn-100 success-button">Okay</button>
					</div>
				</div>
			</div>
		</div>  
	</div>

	<script>
		$(".close-button").click(function() {
    		$("#saved-students").remove();
		});

		$(".success-button").click(function() {
			$('#warning-modal').modal('hide'); 

			window.location.reload();
		})

		$(".saved-applicant").click(function() {
			var id = $(this).attr("id");
				id = $(this).attr("id");

			if($(this).hasClass("applicant-buttons-saved")) {
				status = "unsaved";
			}
			else {
				status = "save";
			}

			basePath = window.location.origin;
        	$.ajax({
        		headers: {
        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        		},
        	    type : "POST",
        	    url  : `${basePath}/saved_applicant`,
        	    dataType : "json",
        	    data : {
        	        id	: 	id
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
    					Swal.fire(
						  	'Ooops',
						  	msg,
						  	'error'
						)
        			}
        	    }
        	});
		});

		function save_applicant(id) {
		    return $('<button/>', {
		        text: 	'Yes',
		        id: 	'saved-students',
		        class: 	'btn applicant-button btn-danger',
		        click: function() {
    		       	$("#warning-modal").modal('hide');
    		       	$("#saved-students").remove();

		        	
		        }
		    });
		}
	</script>
@endsection