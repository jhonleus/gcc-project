@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(137))

@section('content')
  	<div class="container">
		<div class="row">
			<div class="col-md-8 mx-auto">
				<div class="card shadow-none mt-2">
					<div class="card-header border-bottom-0">
						<img src="/login-images/gcc-admin-setting-page.png" style="width: 35%; display: block; margin: 0px auto;">
						<br>
						<h3 class="text-center">{{App\MaintenanceLocale::getLocale(137)}}</h3>
					</div>
					<div class="card-body">
						<form method="post" action="{{ route('admin.password.store')}}">
              @csrf				
							<div class="form-group col-lg-8 col-md-8 col-sm-12 mx-auto">
    						<label class="text-muted font-weight-light">{{App\MaintenanceLocale::getLocale(408)}}</label>
    						<input type="password" name="current_password"  title="qwe" class="form-control" autocomplete="current-password" required>
  						</div>
  						<div class="form-group col-lg-8 col-md-8 col-sm-12 mx-auto">
    						<label class="text-muted font-weight-light">{{App\MaintenanceLocale::getLocale(409)}}</label>
    						<input type="password" name="new_password" class="form-control" autocomplete="current-password" required>
  						</div>
  						<div class="form-group col-lg-8 col-md-8 col-sm-12 mx-auto">
    						<label class="text-muted font-weight-light">{{App\MaintenanceLocale::getLocale(410)}}</label>
    						<input type="password" name="new_confirm_password" class="form-control" autocomplete="current-password" required>
    						<br>
  							<button type="submit" class="col-lg-3 col-md-3 col-sm-12 btn btn-primary mx-auto">{{App\MaintenanceLocale::getLocale(38)}}</button>
  						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
  
@endsection