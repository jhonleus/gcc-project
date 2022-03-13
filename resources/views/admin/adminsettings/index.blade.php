@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(137))

@section('content')
  	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card shadow-none mt-5">
					<div class="card-header border-bottom-0">
						{{App\MaintenanceLocale::getLocale(137)}}
				</div>
					<div class="card-body">
						<form method="post" action="{{ route('admin.password.store')}}">
              @csrf				
							<div class="form-group">
    						<label>{{App\MaintenanceLocale::getLocale(408)}}</label>
    						<input type="password" name="current_password"  title="qwe" class="form-control" autocomplete="current-password" required>
  						</div>
  						<div class="form-group">
    						<label>{{App\MaintenanceLocale::getLocale(409)}}</label>
    						<input type="password" name="new_password" class="form-control" autocomplete="current-password" required>
  						</div>
  						<div class="form-group">
    						<label>{{App\MaintenanceLocale::getLocale(410)}}</label>
    						<input type="password" name="new_confirm_password" class="form-control" autocomplete="current-password" required>
  						</div>
  							<button type="submit" class="btn btn-primary">{{App\MaintenanceLocale::getLocale(38)}}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
  
@endsection