@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(15))

@section('content')
{{-- container-start --}}
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card mt-5 shadow-none">
				<div class="card-header border-bottom-0">{{  App\MaintenanceLocale::getLocale(15) }}</div>
				<div class="card-body ">
					<div class="bg-primary p-0">
						<div class="row p-3"  style="background-image: url('/login-images/ggc-admin-notification-illustration.png'); background-size: 450px 150px; background-repeat: no-repeat; background-position:500px 5px;">
							<strong><img src="/images/Info_100px.png" style="width:20px; height:20px; margin-left: 10px;"> {{  App\MaintenanceLocale::getLocale(292) }}
								<div class="row ">
								<ul>
									<li class="font-weight-light">{{  App\MaintenanceLocale::getLocale(293) }}</li> 
									<li class="font-weight-light">{{  App\MaintenanceLocale::getLocale(294) }}</li>
									<li class="font-weight-light">{{  App\MaintenanceLocale::getLocale(295) }}</li>
								</ul>
								<ul>
									<li class="font-weight-light">{{  App\MaintenanceLocale::getLocale(296) }}</li>
									<li class="font-weight-light">{{  App\MaintenanceLocale::getLocale(297) }}</li>
								</ul>
								</div>
							</strong>
						</div>
						
					</div>
					<form method="POST" action="{{ route('admin.systemupdate.store')}}">
             	 		@csrf	
						<div class="form-group">
    						<small id="emailHelp" class="form-text text-muted">{{  App\MaintenanceLocale::getLocale(259) }}:</small>
    						<textarea class="form-control mt-2" rows="10" name="message" required></textarea>
  						</div>
  						<button type="submit" class="btn btn-primary col-lg-2 col-md-2 col-sm-12">{{  App\MaintenanceLocale::getLocale(128) }}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
{{-- container-end --}}
@endsection