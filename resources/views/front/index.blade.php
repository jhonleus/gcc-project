@if (Auth::check() && Auth::user() && Auth::user()->rolesId == 0)
<script>window.location =  "{{Auth::user()->roles->getPrefix()}}";</script>
@endif

@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(63))

@section('content')

{{-- home-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/home-page.css') }}">
<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/pricing-page.css') }}">
<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/company-profile-page.css') }}">
<link rel="stylesheet" href="{{ asset('resources/css/custom/stars.css') }}">

{{-- container-start --}}
<div class="container-fluid px-0 home-page-hidden">

<div class="row home-page-section1" style="background-image: url('/login-images/{{ $pagecontents->head }}');"><div class="col-lg-12 col-md-12 col-xs-12 home-page-section1-content">
  @include('flash-message')
  <div class="col-auto col-xs-12 home-page-content1">
    <h2 class="home-page-title1 font-weight-bold position-relative text-center text-white">{{ App\MaintenanceLocale::getLocale(473) }}</h2>
    <br> 
    <p class="home-page-section1-p  text-center mx-auto text-white font-weight-light">{{ App\MaintenanceLocale::getLocale(474) }}</p>
    <p class=" mt-5 text-center mx-auto text-white font-weight-light"> <a href="/privacy">{{ App\MaintenanceLocale::getLocale(602) }} </a>      <a href="/terms">{{ App\MaintenanceLocale::getLocale(603) }} </a></p>
    <a class="p-3 btn home-page-get-started-btn col-lg-2 col-4" href="/register">{{ App\MaintenanceLocale::getLocale(508) }}</a> 
  </div>    
</div>
</div>

@if ($pagecontents->users == 1)
<div class="row  mt-5">
 <div class="col-lg-12 p-2 mx-auto">
  <h4 class="text-center text-muted home-padding home-page-users-count">{{ App\MaintenanceLocale::getLocale(166) }}</h4>
  <div class="row  mb-5 rounded mx-auto">
   <div class="col-lg-3 p-3">
    <div class="row  mx-auto">
     <div class="col-3 mx-auto  pt-3">
      <i class="fa fa-user fa-3x text-white" ></i>
    </div>
    <div class="col-6 pt-3 px-0 text-muted">
      <h3 class="text-center  Count">{{$users1}}</h3>
      <p class="text-muted text-center font-weight-lighter">{{ App\MaintenanceLocale::getLocale(132) }}</p>
    </div>
  </div>
</div>
<div class="col-lg-3  p-3">
  <div class="row mx-auto">
   <div class="col-3 mx-auto  pt-3">
    <i class="fa fa-briefcase fa-3x text-white"></i>
  </div>
  <div class="col-6 pt-3 px-0 text-muted">
    <h3  class="text-center Count">{{$users2}}</h3>
    <p class="text-muted  text-center font-weight-lighter">{{ App\MaintenanceLocale::getLocale(133) }}</p>
  </div>
</div>
</div>
<div class="col-lg-3   p-3">
  <div class="row mx-auto">
   <div class="col-3 mx-auto  pt-3">
     <i class="fa fa-building-o fa-3x text-white"></i>
   </div>
   <div class="col-6 pt-3 px-0 text-muted">
    <h3  class="text-center Count">{{$users3}}</h3>
    <p class="text-muted text-center font-weight-lighter">{{ App\MaintenanceLocale::getLocale(134) }}</p>
  </div>
</div>
</div>
<div class="col-lg-3   p-3">
  <div class="row mx-auto">
   <div class="col-3 mx-auto  pt-3">
    <i class="fa fa-graduation-cap fa-3x text-white"></i>
  </div>
  <div class="col-6 pt-3 p-0 text-muted">
    <h3  class="text-center Count">{{$users4}}</h3>
    <p class="text-muted text-center font-weight-lighter ">{{ App\MaintenanceLocale::getLocale(135) }}</p>
  </div>
</div>
</div>
</div>
</div>
</div>
@else
<div class="home-bottom1">this</div>
@endif

{{-- about-page-section --}}
<div class="container-fluid home-top1">
 <div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12">
   <div class="row home-page-img1" style="background-image: url('/login-images/{{ $about1->picture }}');">
    <div class="col-lg-6 home-padding">
     <h1 class="text-white home-page-title2"> {{App\MaintenanceLocale::getLocale(483)}}</h1>
     <p class="font-weight-light text-white home-page-description">{!! App\MaintenanceLocale::getLocale(486) !!}</p>
   </div>
 </div>
 <div class="row home-bottom2">
  <div class="col-lg-12 home-padding">
   <img src="login-images/gcc-img-2.png" height="400px;" class="home-padding home-page-img2">
   <h1 class="home-page-title3">{{ App\MaintenanceLocale::getLocale(482) }}</h1>
   <p class="font-weight-light text-muted home-top2">{!! App\MaintenanceLocale::getLocale(485) !!}</p>
 </div>
</div>
<div class="row home-page-img3" style="background-image: url('/login-images/{{ $about2->picture }}');">
  <div class="col-lg-6"></div>
  <div class="col-lg-6 home-padding">
   <h1 class="text-white home-page-title4">{{ App\MaintenanceLocale::getLocale(484) }}</h1>
   <p class="font-weight-light text-white home-page-description2">{!! App\MaintenanceLocale::getLocale(487) !!}</p>
 </div>
</div>
</div>
</div>
</div>

<div class="container">
 <h1 class="text-center pt-1 mt-5 text-muted">{{ App\MaintenanceLocale::getLocale(50) }}</h1>
 <div class="card-columns home-padding">

  @foreach ($subscriptions as $subscription)

  <p hidden>

  </p>
  <div class="card card-margin" style="margin-bottom: 40px;">
    <div class="card-header  text-white  font-weight-lighter text-center" style="background-color:#0175B1;">
      {{ $subscription->title }}
    </div>
    <div class="card-body home-page-body1">
      <h1 class="card-text text-muted text-center home-page-title5">
        ${{ $subscription->price }}</h1>
        <ul class="pricing-details-content">
          <li class="pricing-details">{{ App\MaintenanceLocale::getLocale(93) }} {{$subscription->check_limit == 1 ? ' Unlimited' : $subscription->limit}}</li>
          <li class="pricing-details">{{ App\MaintenanceLocale::getLocale(94) }} {{$subscription->expiration}} Days</li>
          @if($subscription->check_technical)
            <li class="pricing-details">{{ App\MaintenanceLocale::getLocale(95) }}</li>
          @endif
          @if($subscription->check_email)
            <li class="pricing-details">{{ App\MaintenanceLocale::getLocale(96) }}</li>
          @endif
          @if($subscription->check_reserve)
            <li class="pricing-details">{{ App\MaintenanceLocale::getLocale(99) }}</li>
          @endif
          @if($subscription->check_applicant)
            <li class="pricing-details">{{ App\MaintenanceLocale::getLocale(254) }}</li>
          @endif
          @if($subscription->check_blog)
            <li class="pricing-details">{{ App\MaintenanceLocale::getLocale(277) }}</li>
          @endif
        </ul>
      </div>

      <div class="card-footer home-page-footer">
        <a href="pricing"><button class="btn col-lg-6 mx-auto d-block mt-3 mb-3">{{ App\MaintenanceLocale::getLocale(200) }}</button></a>
      </div>
   </div>
   @endforeach
   
 </div>
</div>

<div class="container">
  <h1 class="text-center pt-1 mt-5 text-muted">{{ App\MaintenanceLocale::getLocale(509) }}</h1>
  <div id="carouselExampleSlidesOnly" class="carousel slide home-padding" data-interval="false" style="margin:0 40px 0 40px;">
    <div class="carousel-inner home-page-header2">
      <div class="carousel-item carousel-img active" >
        <img src="login-images/{{ $pagecontents->picture1 }}" class="d-block w-100">
      </div>
      <div class="carousel-item carousel-img">
        <img src="login-images/{{ $pagecontents->picture2 }}" class="d-block w-100">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleSlidesOnly" role="button" data-slide="prev">
      <span  class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;margin-left:-120px;"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleSlidesOnly" role="button" data-slide="next">
      <span  class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;margin-right:-120px;"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
  
      <div class="container">
       <h1 class="text-center pt-1 mt-5 text-muted">Blogs</h1>

        <ul class="nav nav-pills mx-auto row pt-5" id="pills-tab" role="tablist">
          <li class="nav-item col-sm-6 text-center">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Japan</a>
          </li>
          <li class="nav-item  col-sm-6 text-center">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" style="white-space: nowrap;">Philippine</a>
          </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active home-padding" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" style="margin:0 40px 0 40px;">
            <div id="blog-lg2" class="carousel slide  mx-auto" data-ride="carousel" data-interval="false">
              <div class="carousel-inner" data-interval="false">
                @foreach($japanblogs->chunk(3) as $one)
                  <div class="carousel-item  @if($loop->first) active @endif">
                    <div class="row">
                      @foreach($one as $two)
                        <div class="col-sm-4"> 
                          <a href="/blog/{{$two->id}}">
                            <div class="card" style="width: 100%;">
                              <div class="card-img-top" style="background-image: url({{ asset('blogs/' .$two->filename)}}); height: 250px; background-size: cover;  background-position: center;"></div> 
                            </div>
                          </a>
                          <div class="card-body">
                            <h5 class="card-title">{{ $two->title}}</h5>
                            <h6 class="text-muted">{{ $two->subtitle}}</h6>
                            <p class="card-text"><small class="text-muted">Created: {{date('d-m-Y', strtotime($two->created_at))}}</small></p>
                          </div>  
                        </div>
                      @endforeach
                    </div>
                  </div>   
                @endforeach
              </div>

              @if($japanblogs->count() > 3)
              <a class="carousel-control-prev margin-left1" href="#blog-lg2" role="button" data-slide="prev">
                <span  class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;"></span>
                <span class="sr-only">Previous</span>
              </a> 

              <a class="carousel-control-next margin-right1" href="#blog-lg2" role="button" data-slide="next">
                <span  class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;"></span>
                <span class="sr-only">Next</span>
              </a>
              @endif
            </div>
          </div>


          <div class="tab-pane fade home-padding" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" style="margin:0 40px 0 40px;">
            <div id="blog-lg" class="carousel slide  mx-auto" data-ride="carousel" data-interval="false">
              <div class="carousel-inner" data-interval="false">
                @foreach($philippineblogs->chunk(3) as $one)  
                  <div class="carousel-item  @if($loop->first) active @endif">
                    <div class="row">
                      @foreach($one as $two)
                        <div class="col-lg-auto  col-sm-12"> 
                          <a href="/blog/{{$two->id}}">
                            <div class="card" style="width:100%;">
                              <div class="card-img-top" style="background-image: url({{ asset('blogs/' .$two->filename)}}); height: 250px; background-size: cover;  background-position: center;"></div>
                            </div>
                          </a> 
                          <div class="card-body">
                            <h5 class="card-title">{{ $two->title}}</h5>
                            <h6 class="text-muted">{{ $two->subtitle}}</h6>
                            <p class="card-text"><small class="text-muted">Created: {{date('d-m-Y', strtotime($two->created_at))}}</small></p>
                          </div>  
                        </div>
                      @endforeach
                    </div>
                  </div>   
                @endforeach
              </div>

              @if($philippineblogs->count() > 3)
              <a class="carousel-control-prev margin-left1" href="#blog-lg" role="button" data-slide="prev">
                <span  class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next margin-right1" href="#blog-lg" role="button" data-slide="next">
                <span  class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;"></span>
                <span class="sr-only">Next</span>
              </a>
              @endif
            </div>
          </div>
        </div>  
      </div>
</div>
{{-- container-end --}}
<script>

$(document).ready(function() {
  $('.Count').each(function () {
    $(this).prop('Counter',0).animate({
      Counter: $(this).text()
    }, {
      duration: 1000,
      easing: 'swing',
      step: function (now) {
        $(this).text(Math.ceil(now));
      }
    });
  });
});

function createAccount() {
  var account = document.getElementById("account").value;
  if (account == "") {
    alert("Invalid account!");
    return;
  }
  window.location.href='/register/' + account;
}

</script>
@endsection

