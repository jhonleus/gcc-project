@extends('layouts.app')
@section('title', 'Company Profile | Overview')
@section('content')
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
				<a href="http://facebook.com/{{ $users->employer->facebook }}" target="_blank"><img src="{{ URL::to('/images/facebook.png') }}"></a>
				@endif

				@if ($users->employer->twitter)
				<a href="http://twitter.com/{{ $users->employer->twitter }}" target="_blank"><img src="{{ URL::to('/images/twitter.png') }}"></a>
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
                <button class="btn-default form-control" style="height:100%" disabled>OVERVIEW</button>
              </div>
              <div class="col-sm">
			  <a href="{{ url('jobs/company/posted/'. $encrypt ) }}"><button class="btn btn-default form-control">JOBS POSTED</button></a>
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
				<div class="row">
				  <h6 class="font-weight-bold" style="color:#000; text-align:left;float:left;"><i class="fas fa-building" style="margin-right:10px"></i>ABOUT US</h6>
				</div>
				<div><p>{!! $users->employer?$users->employer->about_us:'' !!}</p></div>
				<div class="row">
				  <h6 class="font-weight-bold" style="color:#000; text-align:left;float:left;"><i class="fas fa-globe" style="margin-right:10px"></i>MISSION and VISION</h6>
				</div>
				<div><p>{!! $users->employer?$users->employer->mission_vision:'' !!}</p></div>
				<div class="row">
				  <h6 class="font-weight-bold" style="color:#000; text-align:left;float:left;"><i class="fas fa-trophy" style="margin-right:10px"></i>PHILOSOPHY</h6>
				</div>
				<div><p>{!! $users->employer?$users->employer->philosophy:'' !!}</p></div>
			  <div class="row">
				<h6 class="font-weight-bold" style="color:#000; text-align:left;float:left;"><i class="fas fa-exclamation-circle" style="margin-right:10px"></i>WHY YOU CHOOSE US?</h6>
			  </div>
			  <div><p>{!! $users->employer?$users->employer->why_choose:'' !!}</p></div>
			  </div>

        </div>
      </div>
      


    </div>
  </div>
</div>
@endsection