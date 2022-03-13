@extends('layouts.app')
@section('title', 'Company Profile | Jobs Posted')
@section('content')
<style>

td {
	cursor: default;
}

</style>
<div class="aboutsection1">

  <div class="col-lg-12">
    <div class="container">

      <div class="card shadow mb-4">
        <div class="card-header">
          <h6>{{ $users->employer ? $users->employer->company : '' }}</h6>
        </div>
        
        <div class="card-body" style="height:200px">
		  <div class="row">
			
            <div class="col-10">
              <div class="container">
                <div class="row">
                  <h6 style="color:#808080; margin-right:5px;"> Industry: </h6> <h6 style="margin-right:5px;"> {{ $users->employer ? $users->employer->industry->getName() : ''  }} </h6> 
                </div>
                <div class="row">
                  <h6 style="color:#808080; margin-right:5px;"> Address: </h6> <h6 style="margin-right:5px;"> {{ $users->address ? $users->address->street ? $users->address->street : '' : '' }} {{ $users->address ? $users->address->city ? $users->address->city . ',' : '' : '' }} {{ $users->address ? $users->address->zipcode ? $users->address->zipcode : '' : '' }} </h6> 
                </div>
                <div class="row">
                  <h6 style="color:#808080; margin-right:5px"> Telephone Number: </h6> <h6 style="margin-right:5px;"> {{ $users->employer ? $users->employer->telephone : '' }} </h6> 
                </div>
                <div class="row">
                  <h6 style="color:#808080; margin-right:5px"> Email Address: </h6> <h6 style="margin-right:5px;"> {{ $users->employer ? $users->employer->email : '' }} </h6> 
                </div>
                <div class="row">
                  <h6 style="color:#808080; margin-right:5px"> Website: </h6> <h6 style="margin-right:5px;"> <a href="http://{{ $users->employer ? $users->employer->website : '' }}">{{ $users->employer ? $users->employer->website : '' }}</a> </h6> 
                </div>
              </div>
            </div>
            
            <div class="col-1">
				@if ($image)
				<img style="height:100px; width:100px; margin-left:40px" src="{{ asset($image->path ."". $image->filename) }}">
				@endif
			</div>
		  </div>
		  
		  @if ($users->employer->facebook && $users->employer->twitter)
		  <div style="right:0; position:absolute; bottom:0; margin-bottom:1%; margin-right:2%">
			<div class="row">
				<h6 style="margin-right:5px">Connect with us via:</h6>

				@if ($users->employer->facebook)
				<a href="http://facebook.com/"{{ $users->employer->facebook }}><img src="{{  URL::to('/images/facebook.png')   }}"></a>
				@endif

				@if ($users->employer->twitter)
				<a href="http://twitter.com/"{{ $users->employer->twitter }}><img src="{{ URL::to('/images/twitter.png') }}"></a>
				@endif

			</div>
		  </div>
		  @endif
        </div>
      </div>

      <div class="card shadow mb-4">
        <div class="card-body">

            <div class="row">
                <div class="col-sm">
                    <a href="{{ url('jobs/company/'. $encrypt ) }}"><button class="btn btn-default form-control" style="height:100%">OVERVIEW</button></a>
                </div>
                <div class="col-sm">
                    <button class="btn-default form-control" disabled>JOBS POSTED</button>
                </div>
				<div class="col-sm">
					<a href="{{ url('jobs/company/reviews/'. $encrypt ) }}"><button class="btn btn-default form-control">REVIEWS</button></a>
				</div>
                <div class="col-sm">
                  <button class="btn btn-default form-control">CONTACT</button>
                </div>
                </div>
		  
        </div>
	  </div>
	  

	  <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container">

              @foreach($jobs as $job)

              <!-- START -->
              <div class="card-body">
                <h1 style="float:left"><a style="text-decoration: none;" href="{{ url('job/details/'.Crypt::encrypt($job->id)) }}">{{ $job->title }}</a></h1>
              </div>
               
              <hr style="margin-top:5%">

              <div class="card-body" style="margin-top:-20px; margin-bottom:5%">

                <div class="row container">
                <table class="mr-5">
									<tr>
										<td title="Employment Type"><i class="fas fa-user" style="margin-right:5px"></i> </td>
										<td title="Employment Type">{{ $job->employments->name }}</td>
									</tr>

									<tr>
										<td title="Location"><i class="fas fa-map-marker-alt" style="margin-right:5px"></i> </td>
										<td title="Location">{{ $job->country->nicename }}</td>
									</tr>

									<tr>
										<td title="Salary Range"><i class="fas fa-money" style="margin-right:5px"></i> </td>
										<td title="Salary Range">{{ $job->currency->name }} {{ $job->min }}-{{ $job->max }}</td>
                  </tr>
                  
                </table>

                <table>
									<tr>
										<td title="Specialization"><i class="fas fa-address-book" style="margin-right:5px"></i> </td>
										<td title="Specialization">{{ $job->specializations->name }}</td>
									</tr>

									<tr>
										<td title="Position"><i class="fas fa-file" style="margin-right:5px"></i> </td>
										<td title="Position">{{ $job->positions->name }}</td>
                  </tr>
                </table>

                
                </div>

                <div class="row" style="margin-top:2%">
                  <p>{!! strlen($job->description)>50?substr($job->description,0,300)."...":$job->description !!}</p>
                </div>
                
                <p class="card-text" style="float:right">POSTED: {{ $job->created_at->diffForHumans() }} </p>
              </div>
							<!-- END -->



              @endforeach
			
        
            </div>

        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection