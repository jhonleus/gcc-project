@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(317))

@section('content')
	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('school.sidebar.profile')
				@include('school.sidebar.index')
			</div>
			
			<div class="col-sm-9">
				<div class="card page-title">
					<div class="card-header content-header-3">
						<div class="row">
							<div class="col-sm-7">
								<label class="label-information">{{ App\MaintenanceLocale::getLocale(317) }}</label>
							</div>
							<div class="col-sm-5 content-right-actions">
								<a href="{{ url('school/affilations/create') }}" class="label-button">
									<i class="fa fa-plus" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(35) }}
								</a> 
							</div>
						</div>
					</div>
				</div>

				@php
	                $currentDisplay = $affilations->currentPage() * $affilations->perPage();
				@endphp

				<div class="text-right" style="margin-bottom:10px;">
					<small class="form-text text-muted">
						Showing (
						<span id="start-page">{{ $currentDisplay - ($affilations->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $affilations->total() ? $currentDisplay : $affilations->total() }}</span>
						of
						<span id="total-blog">{{ $affilations->total() }}</span> )
					</small>
				</div>

				@foreach($affilations as $affilation)
				<div class="card page-contents">
					<div class="card-body page-content-body">
						<div class="row">
							<div class="col-sm-9">
		                    	@if(Auth::user()->id==$affilation->usersId)
		                    		@if($affilation->co_user->rolesId==4)
		                    			<a href="{{url("schools/".Crypt::encrypt($affilation->companyId)) }}" class="content-title">
											{{$affilation->co_school ? $affilation->co_school->school : ""}}
										</a>
		                    		@else
										<a href="{{url("company/".Crypt::encrypt($affilation->companyId)) }}" class="content-title">
											{{$affilation->co_affilation ? $affilation->co_affilation->company : ""}}
										</a>
									@endif
								@else
		                    		@if($affilation->user->rolesId==4)
		                    			<a href="{{url("schools/".Crypt::encrypt($affilation->usersId)) }}" class="content-title">
											{{$affilation->school ? $affilation->school->school : ""}}
										</a>
		                    		@else
										<a href="{{url("company/".Crypt::encrypt($affilation->usersId)) }}" class="content-title">
											{{$affilation->affilation ? $affilation->affilation->company : ""}}
										</a>
									@endif
								@endif
							</div> 
							<div class="col-sm-3">
		                    	<div class="text-right">
		                    		@if(Auth::user()->id==$affilation->usersId)
			                    		@if($affilation->isActive==0)
			                    		<span class="badge badge-danger" style="font-size:12px;">{{ App\MaintenanceLocale::getLocale(352) }}</span>
			                    		@else 
			                    		<span class="badge badge-success" style="font-size:12px;">{{ App\MaintenanceLocale::getLocale(351) }}</span>
			                    		@endif
			                    	@else
			                    		@if($affilation->isActive==1)
			                    		<span class="badge badge-success" style="font-size:12px;">{{ App\MaintenanceLocale::getLocale(351) }}</span>
			                    		@else
        								<p class="content-right">
        		                    		<label class="label-blue verify-affilation" affilationId="{{$affilation->id}}">
        		                    			<i class="fa fa-check-circle" aria-hidden="true"></i>
        		                    			{{ App\MaintenanceLocale::getLocale(353) }}
        		                    		</label>
        		                    	</p>
        		                    	@endif
		                    		@endif
		                    	</div>
		                    </div>
						</div>

						<div class="row">
							<div class="col-sm-9">
								<label class="content-details">
									<i class="fa fa-phone-square" aria-hidden="true"></i>
		                    		@if(Auth::user()->id==$affilation->usersId)
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

								<label class="content-details">
									<i class="fa fa-envelope" aria-hidden="true"></i>
		                    		@if(Auth::user()->id==$affilation->usersId)
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

								<label class="content-details">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
		                    		@if(Auth::user()->id==$affilation->usersId)
		                    			@if($affilation->co_user->rolesId==4)
											{{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->street : "" : ""}} {{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->city : "" : ""}} {{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->province : "" : ""}}  {{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->country->getName() : "" : ""}}, {{$affilation->co_school ? $affilation->co_school->address ? $affilation->co_school->address->zipcode : "" : ""}}   
		                    			@else
											{{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->street : "" : ""}} {{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->city : "" : ""}} {{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->province : "" : ""}}  {{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->country->getName() : "" : ""}}, {{$affilation->co_affilation ? $affilation->co_affilation->address ? $affilation->co_affilation->address->zipcode : "" : ""}}   
										@endif
									@else
		                    			@if($affilation->user->rolesId==4)
											{{$affilation->school ? $affilation->school->address ? $affilation->school->address->street : "" : ""}} {{$affilation->school ? $affilation->school->address ? $affilation->school->address->city : "" : ""}} {{$affilation->school ? $affilation->school->address ? $affilation->school->address->province : "" : ""}}  {{$affilation->school ? $affilation->school->address ? $affilation->school->address->country->getName() : "" : ""}}, {{$affilation->school ? $affilation->school->address ? $affilation->school->address->zipcode : "" : ""}}   
		                    			@else
											{{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->street : "" : ""}} {{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->city : "" : ""}} {{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->province : "" : ""}}  {{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->country->getName() : "" : ""}}, {{$affilation->affilation ? $affilation->affilation->address ? $affilation->affilation->address->zipcode : "" : ""}}
										@endif
									@endif
								</label>
							</div>

							<div class="col-sm-3">
								
							</div>
						</div>
					</div>
				</div>
				@endforeach

				<div class="mt-2 label-button">
					{{ $affilations->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#affilations-list").removeClass("sidebar-list-title");
			$("#affilations-list").addClass("sidebar-list-title-active");
		});

		$(".verify-affilation").click(function() {
			var id 			= $(this).attr("affilationId");
				basePath 	= window.location.origin;
				
        	$.ajax({
        		headers: {
        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        		},
        	    type : "POST",
        	    url  : `${basePath}/school/verifyAffilation`,
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
   		        				Swal.fire(
   		        				  	'Ooops',
   		        				  	"{{ $message['ER:00:18'] }}",
   		        				  	'error'
   		        				)
   		        			}
   		        			else {
   		        				Swal.fire(
   		        				  	'Ooops',
   		        				  	"{{ $message['ER:00:60'] }}",
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
		});
	</script>
@endsection
