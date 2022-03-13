@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(422))

@section('content')
	<div class="container profile-container">
		<div class="row">
			<div class="col-sm-3">
				@include('applicant.sidebar.profile')
				@include('applicant.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card profile-contents">
					<div class="card-header profile-information-header">
						<div class="row">
							<div class="col-sm-7">
								<label class="profile-information-label">{{ App\MaintenanceLocale::getLocale(422) }}</label>
							</div>
							<div class="col-sm-5 profile-header-action">
								<a href="{{ url('applicant/education/create') }}" class="profile-button">
									<i class="fa fa-plus" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(35) }}
								</a> 
							</div>
						</div>
					</div>
				</div>

				@php
	                $currentDisplay = $educations->currentPage() * $educations->perPage();
				@endphp

				<div class="text-right" style="margin-bottom:10px;">
					<small class="form-text text-muted">
						{{ App\MaintenanceLocale::getLocale(118) }} (
						<span id="start-page">{{ $currentDisplay - ($educations->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $educations->total() ? $currentDisplay : $educations->total() }}</span>
						{{ App\MaintenanceLocale::getLocale(207) }}
						<span id="total-blog">{{ $educations->total() }}</span> )
					</small>
				</div>

       			@foreach($educations as $education)
				<div class="card profile-work-list">
					<div class="card-body profile-work-body">
						<div class="row profile-work-header">
							<div class="col-sm-9">
								<label class="profile-work-label">
									{{ $education->attainment }}
								</label>
								<label class="profile-work-sublabel">
									{{ $education->levels ? $education->levels->getName() : '' }}
								</label>
							</div>
							<div class="col-sm-3">
								<p class="profile-actions">
									<a href="{{url("applicant/education/".$education->id."/edit")}}" class="profile-blue">
										<i class="fa fa-edit" aria-hidden="true"></i>
										{{ App\MaintenanceLocale::getLocale(36) }}
									</a>

									<label class="profile-red delete-education" workId="{{$education->id}}">
										<i class="fa fa-trash" aria-hidden="true"></i>
										{{ App\MaintenanceLocale::getLocale(37) }}
									</label>
		                        </p>
							</div> 
						</div>

						<div class="applicant-form">
							<div class="profile-content-description">
								<label class="profile-description">
									{{ $education->name }}
								</label>
							</div>
						</div>
					</div>
					<div class="card-footer" style="padding: 10px 20px 10px 20px">
						<div class="row">
							<div class="col-sm-6">
								<label class="profile-work-description">{{ $education->dateStart }} - {{ $education->dateEnd }}</label>
							</div>
							<div class="col-sm-6 text-right">
								<label class="profile-work-description">{{ $education->country ? $education->country->getName() : '' }}</label>
							</div>
						</div>
					</div>
				</div>
				@endforeach

				<div class="mt-2 label-button">
					{{ $educations->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>

		<div id="delete-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-for-actions modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<div class="status-box confirmation-label">
							<i class="material-icons fa fa-remove"></i>
						</div>				
					</div>

					<div class="modal-body">
						<p class="label-2 f3">
							{{ App\MaintenanceLocale::getLocale(539) }}
						</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn profile-button btn-secondary close-button" data-dismiss="modal">{{ App\MaintenanceLocale::getLocale(150) }}</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#educations-list").removeClass("profile-label-settings-content");
			$("#educations-list").addClass("profile-label-settings-content-active");
		});

		$(".close-button").click(function() {
			$("#delete-education-button").remove();
		});

		$(".delete-education").click(function() {
			var id = $(this).attr("workId");
			$('#delete-modal').modal('show'); 
			$(".close-button").after(delete_education(id));
		});

		function delete_education(id) {
			return $('<button/>', {
		        text: 	'Delete',
		        id: 	'delete-education-button',
		        class: 	'btn profile-button btn-danger',
		        click: function() {
					basePath = window.location.origin;
					$("#delete-education-button").remove();
					$('#delete-modal').modal('hide'); 

		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    type : "POST",
		        	    url  : `${basePath}/applicant/delete_education/${id}`,
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
								  response.message,
								  'error'
								)
		        			}
		        	    }
		        	});
		        }
		    });
		}
	</script>
@endsection
