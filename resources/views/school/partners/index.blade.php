@extends('layouts.header')

@section('title', 'Partners')

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
								<label class="label-information">Partners</label>
							</div>
							<div class="col-sm-5 content-right-actions">
								<a href="{{ url('school/partners/create') }}" class="label-button">
									<i class="fa fa-plus" aria-hidden="true"></i>
									Add
								</a> 
							</div>
						</div>
					</div>
				</div>

				@php
					$currentDisplay = $partners->currentPage() * $partners->perPage();
				@endphp

				<div class="text-right" style="margin-bottom: 10px;">
					<small class="form-text text-muted mb-2">
						{{ App\MaintenanceLocale::getLocale(118) }} (
						<span id="start-page">{{ $currentDisplay - ($partners->perPage() - 1) }}</span>
						-
						<span id="end-page">{{ $currentDisplay < $partners->total() ? $currentDisplay : $partners->total() }}</span>
						{{ App\MaintenanceLocale::getLocale(207) }}
						<span id="total-blog">{{ $partners->total() }}</span> )
					</small>
				</div>

				@foreach($partners as $partner)
				<div class="card page-contents">
					<div class="card-body page-content-body">
						<div class="row">
		                    @if(Auth::user()->id==$partner->usersId)
							<div class="col-sm-9">
								<a href="{{url("company/".Crypt::encrypt($partner->companyId)) }}" class="content-title">
									{{$partner->co_school ? $partner->co_school->school : ""}}
								</a>
							</div> 
							@else
							<div class="col-sm-9">
								<a href="{{url("company/".Crypt::encrypt($partner->usersId)) }}" class="content-title">
									{{$partner->school ? $partner->school->school : ""}}
								</a>
							</div> 
							@endif
							<div class="col-sm-3">
		                    	<div class="text-right">
		                    		@if(Auth::user()->id==$partner->usersId)
			                    		@if($partner->isActive==0)
			                    		<span class="badge badge-danger" style="font-size:12px;">NOT VERIFIED</span>
			                    		@else 
			                    		<span class="badge badge-success" style="font-size:12px;">VERIFIED</span>
			                    		@endif
			                    	@else
			                    		@if($partner->isActive==1)
			                    		<span class="badge badge-success" style="font-size:12px;">VERIFIED</span>
			                    		@else
        								<p class="content-right">
        		                    		<label class="label-blue verify-partner" partnerId="{{$partner->id}}">
        		                    			<i class="fa fa-check-circle" aria-hidden="true"></i>
        		                    			Verify
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
		                   		 	@if(Auth::user()->id==$partner->usersId)
									{{$partner->co_school ? $partner->co_school->telephone : ""}}
									@else
									{{$partner->school ? $partner->school->telephone : ""}}
									@endif
								</label>

								<label class="content-details">
									<i class="fa fa-envelope" aria-hidden="true"></i>
		                   		 	@if(Auth::user()->id==$partner->usersId)
									{{$partner->co_school ? $partner->co_school->email : ""}}
									@else
									{{$partner->school ? $partner->school->email : ""}}
									@endif
								</label>

								<label class="content-details">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
		                   		 	@if(Auth::user()->id==$partner->usersId)
									{{$partner->co_school ? $partner->co_school->address ? $partner->co_school->address->street : "" : ""}} {{$partner->co_school ? $partner->co_school->address ? $partner->co_school->address->city : "" : ""}} {{$partner->co_school ? $partner->co_school->address ? $partner->co_school->address->province : "" : ""}}  {{$partner->co_school ? $partner->co_school->address ? $partner->co_school->address->country->getName() : "" : ""}}, {{$partner->co_school ? $partner->co_school->address ? $partner->co_school->address->zipcode : "" : ""}} 
									@else
									{{$partner->school ? $partner->school->address ? $partner->school->address->street : "" : ""}} {{$partner->school ? $partner->school->address ? $partner->school->address->city : "" : ""}} {{$partner->school ? $partner->school->address ? $partner->school->address->province : "" : ""}}  {{$partner->school ? $partner->school->address ? $partner->school->address->country->getName() : "" : ""}}, {{$partner->school ? $partner->school->address ? $partner->school->address->zipcode : "" : ""}}   
									@endif
								</label>
							</div>

							<div class="col-sm-3">
								
							</div>
						</div>
					</div>
				</div>
				@endforeach

				<div class="mt-2">
					{{ $partners->appends(request()->except('page'))->onEachSide(1)->links() }}
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#partner-list").removeClass("sidebar-list-title");
			$("#partner-list").addClass("sidebar-list-title-active");
		});
		
		$(".verify-partner").click(function() {
			var id 			= $(this).attr("partnerId");
				basePath 	= window.location.origin;
				
        	$.ajax({
        		headers: {
        			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        		},
        	    type : "POST",
        	    url  : `${basePath}/school/verifypartner`,
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
						  response.message,
						  'error'
						)
        			}
        	    }
        	});
		});
	</script>
@endsection
