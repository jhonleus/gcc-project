@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(16))

@section('content')
<div class="container-fluid">
    <div class="maintenancesection1">
        <div class="row">
           <div class="col-md-12">

            <div class="card shadow-none mt-5">
                <div class="card-header">
                    <a href="{{ url('admin/subscriptions')}}"><i class="fa fa-arrow-left mr-2 mt-1"></i>{{ App\MaintenanceLocale::getLocale(156) }}</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <form method="POST" action="{{ route('admin.subscriptions.update', $subscriptions->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group">
                                    <small class="form-text text-muted">{{ App\MaintenanceLocale::getLocale(31) }}</small>
                                    <input type="text" class="form-control" required name="title" value="{{  $subscriptions->title   }}">

                                    <div class="row container"><small class="form-text text-muted mt-2">{{ App\MaintenanceLocale::getLocale(152) }} </small><small class="form-text text-muted mt-2">($)</small></div>
                                    <input type="number" class="form-control" required name="price" value="{{ $subscriptions->price }}">
                                    
                                    <small class="form-text text-muted mt-2">{{ App\MaintenanceLocale::getLocale(154) }} </small>
                                    <input type="number" class="form-control" required name="limit" id="limit" style="{{ $subscriptions->check_limit == 1 ? 'background-color:#DCDCDC' : '' }}" value="{{ $subscriptions->check_limit == 1 ? '' : $subscriptions->limit}}" {{ $subscriptions->check_limit == 1 ? 'disabled' : '' }}>

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" onclick="myFunction()" id="check_limit" name="check_limit" {{ $subscriptions->check_limit == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label text-muted" for="check_limit">{{ App\MaintenanceLocale::getLocale(525) }}</label>
                                    </div>

                                    <div class="row container"><small class="form-text text-muted mt-2">{{ App\MaintenanceLocale::getLocale(155) }} </small><small class="form-text text-muted mt-2">({{ App\MaintenanceLocale::getLocale(97) }})</small></div>
                                    <input type="number" class="form-control" required name="expiration" value="{{$subscriptions->expiration}}" >
                                    
                                    <div class="form-group form-check mt-3">
                                        <input type="checkbox" class="form-check-input" name="check_reserve" id="check_reserve" {{ $subscriptions->check_reserve == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="check_reserve">{{ App\MaintenanceLocale::getLocale(99) }}</label>
                                    </div>

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" name="check_technical" id="check_technical" {{ $subscriptions->check_technical == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="check_technical">{{ App\MaintenanceLocale::getLocale(95) }}</label>
                                    </div>

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" name="check_email" id="check_email" {{ $subscriptions->check_email == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="check_email">{{ App\MaintenanceLocale::getLocale(96) }}</label>
                                    </div>

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" name="check_applicant" id="check_applicant" {{ $subscriptions->check_applicant == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="check_applicant">{{ App\MaintenanceLocale::getLocale(254) }}</label>
                                    </div>

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" name="check_profile" id="check_profile" {{ $subscriptions->check_profile == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="check_profile">{{ App\MaintenanceLocale::getLocale(527) }}</label>
                                    </div>
                                </div>
                                                         
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mb-5">{{ App\MaintenanceLocale::getLocale(38) }}</button>
                    </form> 
                </div>
            </div>    
            
        </div>
    </div>
</div>
</div>

<script>
        function myFunction() {
			// Get the checkbox
			var checkBox = document.getElementById("check_limit");
			
			// If the checkbox is checked, display the output text
			if (checkBox.checked == true){
				document.getElementById("limit").disabled=true;
				document.getElementById("limit").style.backgroundColor = "#DCDCDC";
			} else {
				document.getElementById("limit").disabled=false;
				document.getElementById("limit").style.backgroundColor = "";
			}
		}
</script>
@endsection