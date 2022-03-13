@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(565))

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
								<label class="label-information">{{ App\MaintenanceLocale::getLocale(565) }}</label>
							</div>
						</div>
					</div>
				</div>

				@php
	                $currentDisplay = $subscriptions->currentPage() * $subscriptions->perPage();
				@endphp

				<div class="text-right" style="margin-bottom:10px;">
					<small class="form-text text-muted">
						{{ App\MaintenanceLocale::getLocale(118) }} (
						<span id="start-page">{{ $currentDisplay - ($subscriptions->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $subscriptions->total() ? $currentDisplay : $subscriptions->total() }}</span>
						{{ App\MaintenanceLocale::getLocale(207) }}
						<span id="total-blog">{{ $subscriptions->total() }}</span> )
					</small>
				</div>

				@foreach($subscriptions as $subscription)
				<div class="card page-contents">
					<div class="card-body page-content-body">
						<div class="row">
							<div class="col-sm-9">
								<label class="content-title">
									{{ $subscription->subscription ? $subscription->subscription->title : ""}}
								</label>
							</div> 
                        </div>

                        <div class="row">
							<div class="col-sm-9">
                                <label class="content-details">
                                    <i class="fas fa-credit-card" aria-hidden="true"></i>
		                    		{{ $subscription->isPaypal == 1 ? "Paypal" : "Over the counter" }}
                                </label>

                                <label class="content-details">
                                	<i class="fas fa-hourglass-start"></i>
                                	{{ date('F d, Y', strtotime($subscription->first_day)) }}
                                </label>

                                <label class="content-details">
                                	<i class="fa fa-hourglass-end" aria-hidden="true"></i>
                                	{{ $subscription->last_day == null ? "-" : date('F d, Y', strtotime($subscription->last_day)) }} 
                                </label>
							</div>

							<div class="col-sm-3">
								
							</div>
						</div>
                        
					</div>
				</div>
				@endforeach

				<div class="mt-2 label-button">
					{{ $subscriptions->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#subscription-list").removeClass("sidebar-list-title");
			$("#subscription-list").addClass("sidebar-list-title-active");
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
