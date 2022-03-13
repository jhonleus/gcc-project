@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(113))

@section('content')
	<div class="container page-container">
		@if(!$completeProfile) 
		<div class="alert alerts alert-warning" role="alert">
			{{ App\MaintenanceLocale::getLocale(313) }} <a href="{{ url('employer/details/'.Auth::user()->id.'/edit') }}">{{ App\MaintenanceLocale::getLocale(314) }}</a>!
		</div>
		@endif
		<div class="row">
			<div class="col-sm-3">
				@include('employer.sidebar.index')
			</div>

			<div class="col-sm-9">
				<div class="card profile-contents">
					<div class="card-header profile-header">
						<label class="profile-label-updated">{{ $users->employer ? App\MaintenanceLocale::getLocale(328).": ".$users->employer->updated_at->diffForHumans() : '' }}</label>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-4 show-image">
								@if ($image)
									<div class="profile-containter profile-logo" style="height: 180px; width: 180px; display: block; border-radius: 50%; display: block; margin: 0px auto; background-image: url({{ asset($image->path ."". $image->filename) }}); background-repeat: no-repeat; background-size: cover;   background-position:50% 50%;"></div>
									
									<p class="profile-label-logo" onclick="changePicture();" style="border-radius: 50%; height: 50px; width: 50px; position: absolute;
									left: 180px; top: 125px;"><i class="fa fa-camera" style="position: relative; top: 15px;"></i></p>
									<form id="savepic" action="{{ route('employer.details.store') }}" method="POST" style="display: none;" enctype="multipart/form-data">
							  		@csrf
						  		  		<input accept="image/*" type="file" id="upload" name="upload" onchange="readURL(this);"style="visibility: hidden;" />
						  			</form>
                				@else
									<img src="{{ URL::to('/images/user_img.png') }}" class="profile-logo">
									<p class="profile-label-logo" onclick="changePicture();">{{ App\MaintenanceLocale::getLocale(325) }}</p>
									<form id="savepic" action="{{ route('employer.details.store') }}" method="POST" style="display: none;" enctype="multipart/form-data">
									  @csrf
									  	<input accept="image/*" type="file" id="upload" name="upload" onchange="readURL(this);"style="visibility: hidden;" />
									</form>
								@endif
							</div>

							<div class="col-sm-8">
								<h3 class="profile-name">
									{{ $users->employer ? $users->employer->company : ucfirst(Auth::user()->firstName) }}
								</h3>

								<div class="row">
									<div class="col-sm-5">
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(146) }}:</label>
									</div>
									<div class="col-sm-7">
										<label class="profile-description">{{ $users->employer ? $users->employer->industryId ? $users->employer->industry->getName() : '' : '' }}</label>
									</div>

									<div class="col-sm-5">
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(185) }}:</label>
									</div>
									<div class="col-sm-7">
										<label class="profile-description">{{ $users->address ? $users->address->street ? $users->address->street : '' : '' }} {{ $users->address ? $users->address->city ? $users->address->city . ',' : '' : '' }} {{ $users->address ? $users->address->zipcode ? $users->address->zipcode : '' : '' }}</label>
									</div>

									<div class="col-sm-5">
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(188) }}:</label>
									</div>
									<div class="col-sm-7">
										<label class="profile-description">{{ $users->employer ? $users->employer->telephone : '' }}</label>
									</div>

									<div class="col-sm-5">
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(41) }}:</label>
									</div>
									<div class="col-sm-7">
										<label class="profile-description">{{ $users->employer ? $users->employer->email : '' }}</label>
									</div>

									<div class="col-sm-5">
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(147) }}:</label>
									</div>
									<div class="col-sm-7">
										@if ($subscription)
										<label class="profile-description">{{ $subscription ? $subscription->subscription? $subscription->subscription->title : "-" : "-"}}</label>
										@else 
										<label class="profile-description">{{ $otc ? $otc->subscriptions ? $otc->subscriptions->title : "-" : "-"}}</label>
										@endif
									</div>

									<div class="col-sm-5">
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(308) }}:</label>
									</div>
									<div class="col-sm-7">
										@if ($subscription)
										<label class="profile-description">{{ $subscription ? $subscription->last_day !== null ? Helper::getDiff($subscription->last_day) : "-" : "-"}}</label>
										@else 
										<label class="profile-description">
											@if ($otc)
											@if ($otc->isActive == 0) PENDING 
											@elseif ($otc->isActive == 1) APPROVED 
											@elseif ($otc->isActive == 2) REJECTED 
											@endif @endif
										</label>
										@endif
									</div>
								</div>
							</div>
						</div>

						<div class="contents">
							<div class="content-title">
								<h1 class="profile-details-label">
									<i class="fa fa-building" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(51) }}
								</h1>
							</div>

							<div class="profile-content-description">
								<label class="profile-details-description">
									{!! $users->employer?$users->employer->about_us:'' !!}
								</label>
							</div>

							<div class="content-title">
								<h1 class="profile-details-label">
									<i class="fa fa-globe" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(310) }}
								</h1>
							</div>

							<div class="profile-content-description">
								<label class="profile-details-description">
									{!! $users->employer?$users->employer->mission_vision:'' !!}
								</label>
							</div>

							<div class="content-title">
								<h1 class="profile-details-label">
									<i class="fa fa-trophy" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(311) }}
								</h1>
							</div>

							<div class="profile-content-description">
								<label class="profile-details-description">
									{!! $users->employer?$users->employer->philosophy:'' !!}
								</label>
							</div>

							<div class="content-title">
								<h1 class="profile-details-label">
									<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(312) }}
								</h1>
							</div>

							<div class="profile-content-description">
								<label class="profile-details-description">
									{!! $users->employer?$users->employer->why_choose:'' !!}
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<script type="text/javascript">
		function changePicture() {
			$('#upload').click();
		}

		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
				  $('#image').attr('src',e.target.result);
				  document.getElementById('savepic').submit()
				};
				reader.readAsDataURL(input.files[0]);
			}
		}

		$( ".show-image" ).show(function() {
			$(".profile-label-logo").show();
		});

		
	</script>
@endsection
