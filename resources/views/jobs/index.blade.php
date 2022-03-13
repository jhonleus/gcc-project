@extends('layouts.app')
@section('title', 'Search Jobs')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

<style>

h1 {
	margin:0px;
}

h5 {
	margin:0px;
}

td {
	cursor: default;
}

.select2-selection__rendered {
    line-height: 34px !important;
}
.select2-container .select2-selection--single {
    height: 37px !important;
	margin-bottom: 5%;
}
.select2-selection__arrow {
    height: 34px !important;
}
</style>
<div class="container">
	<div class="aboutsection1">

		<div class="row">

			<div class="col-lg-12">

				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary" style="float:left">Search Criteria</h6>
					</div>
					<div class="card-body">
						<div class="container">
							<form method="POST" action="{{ url('jobs/search') }}">
								@csrf
						
							<div class="row">
							<select name="specialization" id="specialization" style="height:150px" class="form-control js-example-basic-single">
								<option></option>
								@foreach($specialization as $val)
								<option value="{{ $val->id }}" {{ $get_spe == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
								@endforeach
							</select>  
							</div>

							<div class="row">
							<select name="employment" id="employment" style="height:150px" class="form-control js-example-basic-single">
								<option></option>
								@foreach($employment as $val)
								<option value="{{ $val->id }}" {{ $get_emp == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
								@endforeach
							</select>  
							</div>

							<div class="row">
							<select name="location" id="location" class="mb-2 form-control js-example-basic-single">
								<option></option>
								@foreach($country as $val)
								<option value="{{ $val->id }}" {{ $get_loc == $val->id ? 'selected' : '' }}>{{ $val->nicename }}</option>
								@endforeach
							</select> 
							</div> 

							<div class="row">
							<input type="text" name="title" value="{{ $get_title }}" placeholder="Job Title or Keywords" style="margin-bottom:5%" class="form-control"> 
							</div>

							<div class="row">
							<select name="currency" id="currency" class="form-control col-md-6 js-example-basic-single">
								<option></option>
								@foreach($currencies as $val)
								<option value="{{ $val->id }}" {{ $get_curr == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
								@endforeach
							</select> 
					
							<input type="number" name="salary" value="{{ $get_salary }}" placeholder="Minimum Salary" title="Minimum Salary" min="0" class="form-control col-md-6"> 
							</div>

							<div class="row">
								<button type="submit" class="btn btn-primary col-md-12 mt-2">Search</button>
							</div>

						</form>
					</div>

					</div>
				</div>


			</div>

		</div>
		
		<div class="row">

			<div class="col-lg-8">

				@if ($jobs->count() == 0 && !$search)
				<div class="card shadow mb-4">
					<div class="card-body">
						<div class="container">
							<h5>NO CURRENTLY JOB POSTED...</h5>
						</div>
					</div>
				</div>
				@elseif ($jobs->count() == 0 && $search)
				<div class="card shadow mb-4">
					<div class="card-body">
						<div class="container">
							<h5>Sorry, your search did not match any jobs<br>Please try searching again with different keywords...</h5>
						</div>
					</div>
				</div>
				@endif

				@foreach($jobs as $job)
				<div class="card shadow mb-4">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								
								<h1><a style="text-decoration: none;" href="{{ url('job/details/'.Crypt::encrypt($job->id)) }}" target="_blank">{{ $job->title }}</a></h1>
								<h5><a style="text-decoration: none;" href="{{ url('jobs/company/'.Crypt::encrypt($job->usersId)) }}" target="_blank">{{ $job->employers->company }}</a></h5>

							</div>
							@if ($job->documents)
							@if ($job->documents->filetype == 'profile')
							<div class="col-md-2">
								<a href="{{ url('jobs/company/'.Crypt::encrypt($job->usersId)) }}" target="_blank"><img src="{{ asset($job->documents->path ."". $job->documents->filename) }}" style="width:100px; height:80px; float:right"></a>
							</div>
							@endif
							@endif
						</div>

						<div class="col-md-12">

							<div class="container" style="margin-top:5%">
								<table>
									
									<tr>
										<td title="Employment Type"><i class="fas fa-user" style="margin-right:5px"></i> </td>
										<td title="Employment Type">{{ $job->employments->name }}</td>
									</tr>
		
									<tr>
										<td title="Location"><i class="fas fa-map-marker-alt" style="margin-right:5px"></i> </td>
										<td title="Location">{{ $job->country->nicename }}</td>
									</tr>
		
									<tr>
										<td title="Specialization"><i class="fas fa-address-book" style="margin-right:5px"></i> </td>
										<td title="Specialization">{{ $job->specializations->name }}</td>
									</tr>
		
									<tr>
										<td title="Position"><i class="fas fa-file" style="margin-right:5px"></i> </td>
										<td title="Position">{{ $job->positions->name }}</td>
									</tr>
		
									<tr>
										<td title="Salary Range"><i class="fas fa-money" style="margin-right:5px"></i> </td>
										<td title="Salary Range" style="color:green">{{ $job->currency->name }} {{ number_format($job->min,2)  }}-{{ number_format($job->max,2) }}</td>
									</tr>

								</table>
							</div>

							<div class="row" style="margin-top:5%">
								<p>{!! strlen($job->description)>50?substr($job->description,0,300)."...":$job->description !!}</p>
							</div><br>

							<div style="float:right;">
								<sub>{{ $job->updated_at->diffForHumans() }}</sub>
							</div>

							

						</div>
						
					</div>
				</div>
				@endforeach

			</div> <!-- col ends -->
		</div> <!-- row ends -->
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {

		$('.js-example-basic-single').select2();
		$('.js-example-basic-multiple').select2();
		

		$('#specialization').select2({
			placeholder: "Specialization",
    		allowClear: true
		});

		$('#employment').select2({
			placeholder: "Employment Type",
    		allowClear: true
		});

		$('#location').select2({
			placeholder: "Location",
    		allowClear: true
		});

		$('#currency').select2({
			placeholder: "Currency",
    		allowClear: true
		});

		
	});

</script>
@endsection