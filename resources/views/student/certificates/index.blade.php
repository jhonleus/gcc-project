@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(425))

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
								<label class="profile-information-label">{{ App\MaintenanceLocale::getLocale(425) }}</label>
							</div>
							<div class="col-sm-5 profile-header-action">
								<a href="{{ url('applicant/certificate/create') }}" class="profile-button">
									<i class="fa fa-plus" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(35) }}
								</a> 
							</div>
						</div>
					</div>
				</div>

				@php
	                $currentDisplay = $documents->currentPage() * $documents->perPage();
				@endphp

				<div class="text-right" style="margin-bottom:10px;">
					<small class="form-text text-muted">
						{{ App\MaintenanceLocale::getLocale(118) }} (
						<span id="start-page">{{ $currentDisplay - ($documents->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $documents->total() ? $currentDisplay : $documents->total() }}</span>
						{{ App\MaintenanceLocale::getLocale(207) }}
						<span id="total-blog">{{ $documents->total() }}</span> )
					</small>
				</div>

       			@foreach($documents as $document)
				<div class="card profile-work-list">
					<div class="card-body profile-work-body">
						<div class="row">
							<div class="col-sm-9">
								<label class="profile-work-label">
									{{ $document->number }} ({{$document->type}})
								</label>
								<label class="profile-work-sublabel">
									{{ $document->accreditor }}
								</label>
							</div>
							<div class="col-sm-3">
								<p class="profile-actions">
									<label class="profile-red delete-work" workId="{{$document->id}}">
										<i class="fa fa-trash" aria-hidden="true"></i>
										{{ App\MaintenanceLocale::getLocale(37) }}
									</label>
		                        </p>
							</div> 
						</div>

						<br>

						<div class="applicant-form">
							<div class="profile-content-description">
								<label class="profile-work-sublabel2">
									{{ App\MaintenanceLocale::getLocale(202) }}:
								</label>

								<a style="font-size:12px;" class="label-chinese" href="{{ url($document->path.$document->filename) }}">{{ $document->filename }}</a>
							</div>
						</div>
					</div>
					
					<div class="card-footer" style="padding: 10px 20px 10px 20px">
						<div class="text-right">
							<label class="profile-work-description">{{ App\MaintenanceLocale::getLocale(549) }}: {{ Helper::getDate($document->updated_at)}}</label>
						</div>
					</div>
				</div>
				@endforeach

				<div class="mt-2 label-button">
					{{ $documents->appends(request()->except('page'))->onEachSide(1)->links() }}
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
							{{ App\MaintenanceLocale::getLocale(548) }}
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
			$("#certificates-list").removeClass("profile-label-settings-content");
			$("#certificates-list").addClass("profile-label-settings-content-active");
		});

		$("#download").click(function() {
			var basePath = window.location.origin;
			var id = $(this).data('id');

			window.location = `${basePath}/applicant/certificate/download/${id}`;
		})

		$(".close-button").click(function() {
			$("#delete-work-button").remove();
		});

		$(".delete-work").click(function() {
			var id = $(this).attr("workId");
			$('#delete-modal').modal('show'); 
			$(".close-button").after(delete_work(id));
		});

		function delete_work(id) {
			return $('<button/>', {
		        text: 	'Delete',
		        id: 	'delete-work-button',
		        class: 	'btn profile-button btn-danger',
		        click: function() {
					basePath = window.location.origin;
					$("#delete-work-button").remove();
					$('#delete-modal').modal('hide'); 

		        	$.ajax({
		        		headers: {
		        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
		        		},
		        	    type : "DELETE",
		        	    url  : `${basePath}/applicant/certificate/${id}`,
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
