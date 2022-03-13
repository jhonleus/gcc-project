@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(318))

@section('content')
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('employer.sidebar.profile')
				@include('employer.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card page-title">
					<div class="card-header content-header-3">
						<div class="row">
							<div class="col-sm-7">
								<label class="label-information">{{ App\MaintenanceLocale::getLocale(318) }}</label>
							</div>
							<div class="col-sm-5 content-right-actions">
								<a href="{{ url('employer/branches/create') }}" class="label-button">
									<i class="fa fa-plus" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(35) }}
								</a> 
							</div>
						</div>
					</div>
				</div>

				@php
	                $currentDisplay = $branches->currentPage() * $branches->perPage();
				@endphp

				<div class="text-right" style="margin-bottom:10px;">
					<small class="form-text text-muted">
						{{ App\MaintenanceLocale::getLocale(118) }} (
						<span id="start-page">{{ $currentDisplay - ($branches->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $branches->total() ? $currentDisplay : $branches->total() }}</span>
						{{ App\MaintenanceLocale::getLocale(207) }}
						<span id="total-blog">{{ $branches->total() }}</span> )
					</small>
				</div>

				@foreach($branches as $branch)
				<div class="card page-contents">
					<div class="card-body page-content-body">
						<div class="row">
							<div class="col-sm-9">
								<label class="content-title">
									{{$branch->branch_name}}
								</label>
							</div> 
							<div class="col-sm-3">
		                    	<div class="text-right">
    								<p class="content-right">
    		                    		<label class="label-red verify-branch" branchId="{{$branch->id}}">
											<i class="fa fa-trash" aria-hidden="true"></i> 
    		                    			{{ App\MaintenanceLocale::getLocale(37) }}
    		                    		</label>
    		                    	</p>
    		                    	<p class="content-right" style="margin-right:6px;">
    		                    		<a class="label-blue" href="{{ url('employer/branches/'.$branch->id.'/edit') }}">
											<i class="fa fa-edit" aria-hidden="true"></i> 
    		                    			{{ App\MaintenanceLocale::getLocale(36) }}
    		                    		</a>
    		                    	</p>
		                    	</div>
		                    </div>
						</div>

						<div class="row">
							<div class="col-sm-9">
								<label class="content-details">
									<i class="fa fa-phone-square" aria-hidden="true"></i>
		                    		{{ $branch->number }}
								</label>

								<label class="content-details">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
		                    		{{ $branch->street }}, {{ $branch->city }}, {{ $branch->country->nicename }}, {{ $branch->zipcode }}
								</label>
							</div>

							<div class="col-sm-3">
								
							</div>
						</div>
					</div>
				</div>
				@endforeach

				<div class="mt-2 label-button">
					{{ $branches->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#branch-list").removeClass("sidebar-list-title");
			$("#branch-list").addClass("sidebar-list-title-active");
		});

		$(".verify-branch").click(function() {
			var id 			= $(this).attr("branchId");
				basePath 	= window.location.origin;
				
        	$.ajax({
        		headers: {
        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        		},
        	    type : "POST",
        	    url  : `${basePath}/employer/verifyBranch`,
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
						msg = response.message;

   		        		if(msg['id']!==undefined) {
   		        			if(msg['id'][0].match(/required/g)) {
   		        				Swal.fire('Ooops', "{{ $message['ER:00:18'] }}", 'error')
   		        			}
   		        			else {
   		        				Swal.fire('Ooops', "{{ $message['ER:00:83'] }}", 'error')
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
		});
	</script>
@endsection
