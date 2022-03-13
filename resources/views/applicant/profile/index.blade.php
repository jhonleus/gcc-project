@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(113))

@section('content')
	<link href="{{ asset('resources/css/progressbar.css') }}" rel="stylesheet">

	<div class="container profile-container">
		<div class="row">
			<div class="col-sm-3">
				@include('applicant.sidebar.index')

				<div class="card profile-contents">
					<div class="card-body profile-settings">
						<h1 class="profile-label-settings">
							<i class="fa fa-upload" aria-hidden="true"></i>
							{{ App\MaintenanceLocale::getLocale(430) }}
						</h1>
						<li class="profile-settings-content">
							@if ($resume)
							<div class="card-body profile-form-body">
								<div class="profile-settings-form">
									<b>{{ App\MaintenanceLocale::getLocale(202) }}:</b><br>{{ $resume->filename }}<br><br>
									<b>{{ App\MaintenanceLocale::getLocale(238) }}:</b><br>{{ $resume->updated_at }}<br>
								</div>
							</div>
							<div class="profile-settings-form profile-center">
								<a type="button" class="btn btn-default profile-button" href="{{url($resume->path.$resume->filename)}}">{{ App\MaintenanceLocale::getLocale(200) }}</a>

								<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-default profile-button">{{ App\MaintenanceLocale::getLocale(239) }}</button>
							</div>
							@else
							<form action="{{ route('applicant.profile.store') }}" method="POST" enctype="multipart/form-data">
							    @csrf
								<div class="profile-settings-form">
									<input type="file" id="resume" name="resume" accept="application/msword, application/pdf" onchange="resumeURL(this);" required hidden>
									<label for="resume" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
									<label id="resumeName" style="display:none;"></label>
								</div>
								<div class="error-container">
									<label class="label-error profile-label-error" id="textResume">*{{ App\MaintenanceLocale::getLocale(432) }}</label>
									<button type="submit" id="btnResume" name="btnResume" value="btnResume" class="btn btn-default profile-button profile-setting-button">{{ App\MaintenanceLocale::getLocale(161) }}</button>
								</div>
							</form>
							@endif
						</li>
					</div>
				</div>

				<div class="card profile-contents">
					<div class="card-body profile-settings">
						<h1 class="profile-label-settings">
							<i class="fa fa-upload" aria-hidden="true"></i>
							{{ App\MaintenanceLocale::getLocale(431) }}
						</h1>
						<li class="profile-settings-content">
							<form action="{{ route('applicant.profile.store') }}" method="POST" enctype="multipart/form-data">
							  @csrf
							<div class="profile-settings-form">
								  <input type="file" id="tattoo" name="tattoo[]" accept="image/jpeg" multiple onchange="tattooURL(this);" required hidden>
								  <label for="tattoo" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
								  <label id="tattooName" style="display:none;"></label>
							</div>
							<div class="profile-settings-form" style="text-align:center">
              					<button type="submit" id="btnTattoo" name="btnTattoo" value="btnTattoo" class="btn btn-default profile-button profile-setting-button">{{ App\MaintenanceLocale::getLocale(161) }}</button>
							</div>
							</form>
							@if ($tattoos->count() > 0)
								<p class="profile-label-settings-content">{{ App\MaintenanceLocale::getLocale(434) }} {{ $tattoos->count() }} <font class="text-lowercase">{{ App\MaintenanceLocale::getLocale(238) }}.</font></p>
								<button type="button" class="btn btn-default profile-button profile-setting-button-w" data-toggle="modal" data-target="#myTattoo">{{ App\MaintenanceLocale::getLocale(200) }}</button>
							@else
							<div class="error-container">
								<label class="label-error error-company" id="textTattoo" style="display:block">*{{ App\MaintenanceLocale::getLocale(433) }}</label>
							</div>
							@endif
						</li>
					</div>
				</div>
			</div>
			
			<div class="col-sm-9">
				@if($count!=0)
				<div class="container">
					<ul class="progressbar row mx-auto col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<li class="@if($user_count > 0) active @endif">{{ App\MaintenanceLocale::getLocale(414) }}</li>
						<li class="@if($img_count > 0) active @endif">{{ App\MaintenanceLocale::getLocale(415) }}</li>
						<li class="@if($resume_count > 0) active @endif">{{ App\MaintenanceLocale::getLocale(416) }}</li>
						<li class="@if($count == 0) active @endif">{{ App\MaintenanceLocale::getLocale(417) }}</li>
					</ul>
				</div>
				@endif
				
				<div class="card profile-contents">
					<div class="card-header profile-profile-header">
						<label class="profile-label-header">{{ App\MaintenanceLocale::getLocale(328) }}: {{ Auth::user()->updated_at->diffForHumans() }}</label>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-4 show-image">
								@if ($image)
									<div class="profile-containter profile-logo" style=" height: 180px; width: 180px; display: block; border-radius: 50%; display: block; margin: 0px auto; background-image: url({{ asset($image->path ."". $image->filename) }}); background-repeat: no-repeat; background-size: cover;   background-position:50% 50%;"></div>
									
									<p class="profile-label-logo" onclick="changePicture();" style="border-radius: 50%; height: 50px; width: 50px; position: absolute;
									left: 180px;"><i class="fa fa-camera" style="position: relative; top: 15px;"></i></p>
									<form id="savepic" action="{{ route('applicant.profile.store') }}" method="POST" style="display: none;" enctype="multipart/form-data">
							  		@csrf
						  		  		<input accept="image/*" type="file" id="upload" name="upload" onchange="readURL(this);"style="visibility: hidden;" />
						  			</form>
                				@else
									<img src="{{ URL::to('/images/user_img.png') }}" class="profile-logo">
									<p class="profile-label-logo" onclick="changePicture();">{{ App\MaintenanceLocale::getLocale(325) }}</p>
									<form id="savepic" action="{{ route('applicant.profile.store') }}" method="POST" style="display: none;" enctype="multipart/form-data">
									  @csrf
									  	<input accept="image/*" type="file" id="upload" name="upload" onchange="readURL(this);"style="visibility: hidden;" />
									</form>
								@endif
							</div>

							<div class="col-sm-8">
								<h3 class="profile-name">
									{{$user->firstName}} {{$user->lastName}}
								</h3>

								<div class="row">
									<div class="col-sm-5"> 
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(185) }}:</label>
									</div>

									<div class="col-sm-7"> 
										<label class="profile-profile-description">{{ $user->address ? $user->address->street : '' }} {{ $user->address ? $user->address->city : '' }} {{ $user->address ? $user->address->province : '' }} {{ $user->address ? $user->address->country ? $user->address->country->getName() : '' : '' }} {{ $user->address ? $user->address->zipcode : '' }}</label>
									</div>

									<div class="col-sm-5"> 
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(418) }}:</label>
									</div>

									<div class="col-sm-7"> 
										<label class="profile-profile-description">{{  $user->details ? $user->details->age : ''  }}</label>
									</div>

									<div class="col-sm-5"> 
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(419) }}:</label>
									</div>

									<div class="col-sm-7"> 
										<label class="profile-profile-description">{{ $user->details ? $user->details->birthDate ? date('F d, Y', strtotime($user->details->birthDate)) : '' : '' }}</label>
									</div>
								</div>
							</div>
						</div>

						<div class="contents mt-2">
							<div class="content-title">
								<h1 class="profile-title-label">
									<i class="fa fa-address-book" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(420) }}
								</h1>
							</div>

							<div class="profile-content-group">
								<div class="row">
									<div class="col-sm-5">
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(187) }}:</label>
									</div>

									<div class="col-sm-7">
										<div class="profile-content-description">
											<label class="profile-profile-description">
												{{ $user->contacts ? $user->contacts->country ? '+' . $user->contacts->country->getCode() : '' : '' }} {{ $user->contacts ? $user->contacts->number : '' }}
											</label>
										</div>
									</div>
									<div class="col-sm-5">
										<label class="profile-label">{{ App\MaintenanceLocale::getLocale(41) }}:</label>
									</div>

									<div class="col-sm-7">
										<div class="profile-content-description">
											<label class="profile-profile-description">
												{{ Auth::user()->email }}
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="contents mt-2">
							<div class="content-title">
								<h1 class="profile-title-label">
									<i class="fa fa-briefcase" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(421) }}
								</h1>
							</div>

							<div class="profile-content-group">
            					@foreach($works as $work)
								<div class="row">
									<div class="col-sm-12">
										<label class="profile-profile-description">
											{{ $work->company }}
										</label>
										<label class="profile-label">
											{{ $work->position }}
										</label>
									</div>

									<br>
								
									<div class="col-sm-6">
										<label class="profile-sublabel">
											{{ $work->dateStart }} - {{ $work->dateEnd }}
										</label>
									</div>

									<div class="col-sm-6">
										<label class="profile-sublabel">
											{{ $work->country ? $work->country->getName() : '' }}
										</label>
									</div>
								</div>
								@endforeach
							</div>
						</div>

						<div class="contents mt-2">
							<div class="content-title">
								<h1 class="profile-title-label">
									<i class="fa fa-graduation-cap" aria-hidden="true"></i>
									{{ App\MaintenanceLocale::getLocale(422) }}
								</h1>
							</div>

							<div class="profile-content-group">
          						@foreach($educations as $education)
								<div class="row">
									<div class="col-sm-12">
										<label class="profile-profile-description">
											{{ $education->name }}
										</label>
										<label class="profile-label">
											{{ $education->levels ? $education->levels->getName() : '' }}
										</label>
									</div>

									<br>
								
									<div class="col-sm-6">
										<label class="profile-sublabel">
												{{ $education->dateStart }} - {{ $education->dateEnd }}
										</label>
									</div>

									<div class="col-sm-6">
										<label class="profile-sublabel">
												{{ $education->country ? $education->country->getName() : '' }}
										</label>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('applicant.profile.modal')

	<script>
		function changePicture() {
			$('#upload').click();
		}

		function resumeURL(input) {
			if (input.files && input.files[0])
			{
				var name = document.getElementById('resume').files.item(0).name;
				document.getElementById('resumeName').style.display = "block";
				document.getElementById('resumeName').innerHTML = "{{ App\MaintenanceLocale::getLocale(202) }}: " + name;
			}
		}

		function resumesURL(input) {
			if (input.files && input.files[0])
			{
				var name = document.getElementById('resumes').files.item(0).name;
				document.getElementById('resumesName').style.display = "block";
				document.getElementById('resumesName').innerHTML = "{{ App\MaintenanceLocale::getLocale(202) }}: " + name;
			}
		}

		function tattooURL(input) {
			if (input.files && input.files[0])
			{
				var length = document.getElementById('tattoo').files.length;
				var name = document.getElementById('tattoo').files.item(0).name;
				document.getElementById('tattooName').style.display = "block";
				if (length > 1) {
					document.getElementById('tattooName').innerHTML = length + " {{ App\MaintenanceLocale::getLocale(440) }}";
				} else {
					document.getElementById('tattooName').innerHTML = "{{ App\MaintenanceLocale::getLocale(202) }}: " + name;
				}
				
			}
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

		

		$(document).on('click', '#download', function () {
		    
		    var basePath = window.location.origin;
		    var id = $(this).data('id');

		    window.location = `${basePath}/applicant/profile/download/${id}`;
		});

		if($('#btnTattoo').length) {
			document.getElementById('btnTattoo').style.display = "none";
			$(document).on('change', '#tattoo', function () {
			    document.getElementById('btnTattoo').style.display = "";
			    if($('#textTattoo').length) {
			    	document.getElementById('textTattoo').style.display = "none";
			    }
			});
		}

		if($('#btnResume').length) {
			document.getElementById('btnResume').style.display = "none";
			$(document).on('change', '#resume', function () {
			    document.getElementById('btnResume').style.display = "";
			    if($('#textResume').length) {
			    	document.getElementById('textResume').style.display = "none";
			    }
			});
		}
	</script>
@endsection
