@if (Auth::check() && Auth::user())
<script>window.location =  "{{Auth::user()->roles->getPrefix()}}";</script>
@endif

@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(63))

@section('content')

<style>

.imgs-home {
  height: 100px;
  width: 100px;
}

.about-page-section2{
    width: 100%;
    display: block;
  }

  .about-page-section2 p{
    font-weight: lighter;
  }
.about-page-content2 img{
    width: 60%;
  }

</style>

{{-- home-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/home-page.css') }}">

{{-- container-start --}}
<div class="container-fluid px-0" style="overflow: hidden;" >
<br>
<br>
<br>
<br>
<br>

{{-- blog carousel content --}}
<ul class="nav nav-pills mb-3 mx-auto row" id="pills-tab" role="tablist">
   <li class="nav-item col-lg-2  col-6 text-center">
      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Japan</a>
   </li>
   <li class="nav-item  col-lg-2  col-6 text-center">
      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" style="white-space: nowrap;">Philippine</a>
   </li>
</ul>

{{-- blog carousel main content --}}
<div class="tab-content" id="pills-tabContent">
   <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
      <div id="blog-lg" class="carousel slide  mx-auto" data-ride="carousel" data-interval="false">
         <div class="carousel-inner" data-interval="false">
            @foreach($japanblogs->chunk(5) as $one)
              <div class="carousel-item  @if($loop->first) active @endif">
                <div class="row">
                  @foreach($one as $two)
                  <div class="col-lg-auto  col-sm-12"> 
                    <a href="/blog/{{$two->id}}">
                      <div class="card" style="width: 18rem;">
                       <div class="card-img-top" style="background-image: url({{ asset('blogs/' .$two->filename)}}); height: 250px; background-size: cover;  background-position: center;"></div>

                    </a>
                    <div class="card-body">
                      <h5 class="card-title">{{ $two->title}}</h5>
                      <h6 class="text-muted">{{ $two->subtitle}}</h6>
                      <p class="card-text"><small class="text-muted">Created: {{date('d-m-Y', strtotime($two->created_at))}}</small></p>
                    </div>  
                  </div>
                </div>
              @endforeach
              </div>   
            </div>
            @endforeach
          </div>
          
          {{-- previous button --}}
          <a class="carousel-control-prev" href="#blog-lg" role="button" data-slide="prev">
            <span  class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;"></span>
            <span class="sr-only">Previous</span>
          </a>

          {{-- next button--}}
          <a class="carousel-control-next" href="#blog-lg" role="button" data-slide="next">
            <span  class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        {{-- blog-mobile --}}
        {{-- mobile and other small screen device  view --}}
        <div id="blog-sm" class="carousel slide  mx-auto" data-ride="carousel" data-interval="false">
          <div class="carousel-inner" data-interval="false">
          @foreach($japanblogs->chunk(1) as $one)
            <div class="carousel-item  @if($loop->first) active @endif">
              <div class="row mx-auto">
              @foreach($one as $two)
                <div class="col-sm-12 mx-auto"> 
                  <a href="/blog/{{$two->id}}">
                    <div class="card mx-auto" style="width: 18rem;">
                     <div class="card-img-top" style="background-image: url({{ asset('blogs/' .$two->filename)}}); height: 250px; background-size: cover;  background-position: center;"></div>
                  </a>
                  <div class="card-body">
                    <h5 class="card-title">{{ $two->title}}</h5>
                    <h6 class="text-muted">{{ $two->subtitle}}</h6>
                    <p class="card-text"><small class="text-muted">Created: {{date('d-m-Y', strtotime($two->created_at))}}</small></p>
                </div>  
              </div>
            </div>
          @endforeach
    </div>   
  </div>
    @endforeach
</div>

{{-- previous button --}}
<a class="carousel-control-prev" href="#blog-sm" role="button" data-slide="prev">
  <span  class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;"></span>
  <span class="sr-only">Previous</span>
</a>

{{-- next button --}}
<a class="carousel-control-next" href="#blog-sm" role="button" data-slide="next">
  <span  class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;"></span>
  <span class="sr-only">Next</span>
</a>
</div>
{{-- blog mobile end --}}
</div>

<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
      <div id="blog-lg" class="carousel slide  mx-auto" data-ride="carousel" data-interval="false">
  <div class="carousel-inner" data-interval="false">
    @foreach($philippineblogs->chunk(5) as $one)  
    <div class="carousel-item  @if($loop->first) active @endif">
      <div class="row">
        @foreach($one as $two)
        <div class="col-lg-auto  col-sm-12"> 
          <a href="/blog/{{$two->id}}">
            <div class="card" style="width: 18rem;">
            <div class="card-img-top" style="background-image: url({{ asset('blogs/' .$two->filename)}}); height: 250px; background-size: cover;  background-position: center;"></div>
          </a>
          <div class="card-body">
            <h5 class="card-title">{{ $two->title}}</h5>
            <h6 class="text-muted">{{ $two->subtitle}}</h6>
            <p class="card-text"><small class="text-muted">Created: {{date('d-m-Y', strtotime($two->created_at))}}</small></p>
          </div>  
        </div>
      </div>
      @endforeach
    </div>   
  </div>
    @endforeach
</div>
  
  <a class="carousel-control-prev" href="#blog-lg" role="button" data-slide="prev">
    <span  class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#blog-lg" role="button" data-slide="next">
    <span  class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


{{-- blog-mobile --}}
{{-- mobile and other small screen device  view --}}
<div id="blog-sm" class="carousel slide  mx-auto" data-ride="carousel" data-interval="false">
  <div class="carousel-inner" data-interval="false">
    @foreach($philippineblogs->chunk(1) as $one)
    <div class="carousel-item  @if($loop->first) active @endif">
      <div class="row mx-auto">
        @foreach($one as $two)
        <div class="col-sm-12 mx-auto"> 
          <a href="/blog/{{$two->id}}">
            <div class="card mx-auto" style="width: 18rem;">
            <div class="card-img-top" style="background-image: url({{ asset('blogs/' .$two->filename)}}); height: 250px; background-size: cover;  background-position: center;"></div>
          </a>
          <div class="card-body">
            <h5 class="card-title">{{ $two->title}}</h5>
            <h6 class="text-muted">{{ $two->subtitle}}</h6>
            <p class="card-text"><small class="text-muted">Created: {{date('d-m-Y', strtotime($two->created_at))}}</small></p>
          </div>  
        </div>
      </div>
      @endforeach
    </div>   
  </div>
    @endforeach
</div>

{{-- carousel previous button --}}
<a class="carousel-control-prev" href="#blog-sm" role="button" data-slide="prev">
  <span  class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;"></span>
  <span class="sr-only">Previous</span>
</a>

{{-- carousel next button --}}
<a class="carousel-control-next" href="#blog-sm" role="button" data-slide="next">
  <span  class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;"></span>
  <span class="sr-only">Next</span>
</a>
</div>
{{-- blog mobile end --}}

  </div>
</div>

<div class="row home-page-section1" style="background-image: url('/login-images/{{ $pagecontents->head }}');height: 80vh; background-size: cover; background-attachment: fixed;background-position: center;background-repeat: no-repeat; "><div class="col-lg-12 col-md-12 col-xs-12 home-page-section1-content">
      @include('flash-message')
      <div class="col-auto col-xs-12" style="top: 50%;transform: translateY(-50%);">
        <h2 class="home-page-title1 position-relative text-center text-white" data-aos="zoom-in-up" data-aos-duration="500" style="color: #6C757D; font-weight: lighter;">{{ $pagecontents->head_title }}This one</h2>
        <br> 
        <p class="home-page-section1-p  mt-5 text-justify mx-auto text-white font-weight-light" data-aos="zoom-in" data-aos-duration="500">{{ $pagecontents->head_body }}Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <a class="p-3 btn home-page-get-started-btn" href="/register" style="background-color: #FF3333; color: white; display: block; margin: 0px auto; width: 150px; margin-top:3%; ">Get Started</a> 
        </div>    
      </div>
   </div>

   @if ($pagecontents->users == 1)
<div class="row  mt-5">
   <div class="col-lg-12 p-5 mx-auto">
      <h4 class="text-center text-muted p-5 home-page-users-count">Number of different users all over the worl</h4>
      <div class="row  mb-5 rounded mx-auto">
         <div class="col-lg-3 p-3">
            <div class="row  mx-auto">
               <div class="col-3 mx-auto  pt-3">
                  <i class="fa fa-user fa-3x text-white" ></i>
               </div>
               <div class="col-6 pt-3 text-muted">
                  <h3 class="text-center  Count">{{$users1->count()}}</h3>
                  <p class="text-muted text-center font-weight-lighter">{{ App\MaintenanceLocale::getLocale(196) }}</p>
               </div>
            </div>
         </div>
         <div class="col-lg-3  p-3">
            <div class="row mx-auto">
               <div class="col-3 mx-auto  pt-3">
                  <i class="fa fa-briefcase fa-3x text-white"></i>
               </div>
               <div class="col-6 pt-3 text-muted">
                  <h3  class="text-center Count">{{$users2->count()}}</h3>
                  <p class="text-muted  text-center font-weight-lighter">{{ App\MaintenanceLocale::getLocale(197) }}</p>
               </div>
            </div>
         </div>
         <div class="col-lg-3   p-3">
            <div class="row mx-auto">
               <div class="col-3 mx-auto  pt-3">
                     <i class="fa fa-building-o fa-3x text-white"></i>
               </div>
               <div class="col-6 pt-3 text-muted">
                  <h3  class="text-center  Count">{{$users3->count()}}</h3>
                  <p class="text-muted text-center font-weight-lighter">{{ App\MaintenanceLocale::getLocale(198) }}</p>
               </div>
            </div>
         </div>
         <div class="col-lg-3   p-3">
            <div class="row mx-auto">
               <div class="col-3 mx-auto  pt-3">
                  <i class="fa fa-graduation-cap fa-3x text-white"></i>
               </div>
               <div class="col-6 pt-3 text-muted">
                  <h3  class="text-center Count">{{$users4->count()}}</h3>
                  <p class="text-muted text-center font-weight-lighter ">{{ App\MaintenanceLocale::getLocale(199) }}</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@else
<div style="margin-bottom: 10%;">this</div>
@endif


{{-- about-page-section --}}
<div class="container-fluid" style="margin-top: -10%;">
   <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
         <div class="row" style="background-image: url('/login-images/{{ $about1->picture }}'); background-position: center,center center; background-attachment: fixed;background-repeat: no-repeat; margin-top: 10%; margin-bottom: 6%; height: 50vh;">
            <div class="col-lg-6 p-5"  data-aos="fade-right" data-aos-duration="500">
               <h1 style="font-size: 40px; font-weight: bold;"  class="text-white" >-Our Mission.</h1>
               <p style="width: 700px; margin-top: 40px;" class="font-weight-light text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
               tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
               quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
               consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
               cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
               proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
         </div>
         <div class="row" style="margin-bottom: 6%;">
            <div class="col-lg-12 p-5" data-aos="zoom-in" data-aos-duration="500">
               <img src="login-images/gcc-img-2.png" height="400px;" style="display: block;  z-index: -1;margin: 0px auto; opacity: 0.2; position: absolute; left: 230px; top: -60px;" class="p-5">
               <h1 style="font-size: 40px; font-weight: bold; letter-spacing: 5px; ">-About Global <br>Career Creation</h1>
               <p style="margin-top: 40px;" class="font-weight-light text-muted">Lorem ipsum dolor sit amet, consectetur         adipisicing elit, sed do eiusmod
               tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
               quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
               consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
               cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
               proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
         </div>
         <div class="row" style="background-image: url('/login-images/{{ $about2->picture }}'); background-position: center,center, center; background-attachment: fixed;background-repeat: no-repeat; height: 50vh;">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="500"></div>
            <div class="col-lg-6 p-5" data-aos="fade-left" data-aos-duration="500">
               <h1 style="font-size: 40px; font-weight: bold;" class="text-white">-Our Vision.</h1>
               <p style="width: 700px; margin-top: 40px;" class="font-weight-light text-white">Loremipsumdolorsitamet, consectetur adipisicing elit, sed do eiusmod
               tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
               quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
               consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
               cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
               proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
         </div>
      </div>
   </div>
</div>


{{-- <div class="row">
   @foreach($reviews->chunk(5) as $review)
 @foreach($reviews as $reviewthis)
@foreach($reviewthis->documents as $thistwo)
<div class="col-lg-6"> 
  @if($thistwo->filetype==="profile")
        <img src="{{ asset($thistwo->path ."/". $thistwo->filename) }}" width="100px" height="100px" style="border-radius: 50%; display: block; margin: 0px auto;">
        @endif
<h1 class="text-muted text-center mt-3">{{$reviewthis->users->employerdetails->company}}</h1>
        </div>
@endforeach
@endforeach
@endforeach
</div> --}}


<div class="row" style="margin-top: 10%; margin-bottom: 3%;">
  <div class="col-12">
    <div id="user-review-lg" class="carousel slide" data-ride="carousel" data-interval="false">
    <h1 class="text-center mb-5 text-muted">User Reviews</h1>
      <div class="carousel-inner" data-interval="false">
        @foreach($reviews->chunk(5) as $review)

        <div class="carousel-item  @if($loop->first) active @endif">
          <div class="row">
               @foreach($reviews as $reviewthis)

@foreach($reviewthis->documents as $thistwo)
          
        
            <div class="col-3"> 
             
              <div class="card p-2" style="width: 18rem;">
        @if($thistwo->filetype==="profile")
        <img src="{{ asset($thistwo->path ."/". $thistwo->filename) }}" width="100px" height="100px" style="border-radius: 50%; display: block; margin: 0px auto;">
        @endif

                <small class="text-muted text-center mt-3">{{$reviewthis->users->employerdetails->company}}</small>
                <hr class="col-3 mx-auto">
                <div class='overall-ratings'>
                  <ul class="list-group list-group-horizontal">
                    <li class="list-group-item border-0 mx-auto">
                      <i class=' star <?php if((int)$reviewthis->rating <= 5 && (int)$reviewthis->rating !==0) { echo "selected"; } ?>' title='Poor' data-value='1'>
                          <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                      </i>

                      <i class='star <?php if((int)$reviewthis->rating <= 5 && (int)$reviewthis->rating >= 2) { echo "selected"; } ?>' title='Fair' data-value='2'>
                          <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                      </i>

                      <i class='star <?php if((int)$reviewthis->rating <= 5 && (int)$reviewthis->rating >= 3) { echo "selected"; } ?>' title='Good' data-value='3'>
                      <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                      </i>

                      <i class='star <?php if((int)$reviewthis->rating <= 5 && (int)$reviewthis->rating >= 4) { echo "selected"; } ?>' title='Excellent' data-value='4'>
                      <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                      </i>

                      <i class='star <?php if((int)$reviewthis->rating <= 5 && (int)$reviewthis->rating >= 5) { echo "selected"; } ?>' title='WOW!!!' data-value='5'>
                      <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                        </i>
                    </li>
                  </ul>
                </div>
                 <div class="card-body">
                <label class="profile-review-title text-center"> 
                  {{$reviewthis->summary}}
                </label>


                <p class="profile-review font-weight-lighter text-muted  text-justify mx-auto">
                  {{ str_limit($reviewthis->review, 100)}}
                </p>


                <label class="profile-review-date mx-auto"> 
                  @if($reviewthis->recommend==1)
                    <small>Recommend company.</small>
                  @else
                    <small>Not recommend company.</small>
                  @endif
                </label>
              </div> 
            </div>
             
          </div>
          
          @endforeach
 @endforeach
          </div>   
        </div>
            
             @endforeach
      </div>

  <a class="carousel-control-prev" href="#user-review-lg" role="button" data-slide="prev">
    <span  class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#user-review-lg" role="button" data-slide="next">
    <span  class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

</div>
</div>
{{-- user review section desktop view end --}}

{{-- user review section mobile view --}}
<div class="row">
  <div class="col-lg-12">
    <div id="user-review-sm" class="carousel slide" data-ride="carousel" data-interval="false">
      <h1 class="text-center mb-5 text-muted">User Reviews</h1>
      <div class="carousel-inner" data-interval="false">
        @foreach($reviews->chunk(1) as $review)
        <div class="carousel-item  @if($loop->first) active @endif">
          <div class="row">
            @foreach($review as $userreview)
            <div class="col"> 
              <div class="card p-2 mx-auto" style="width: 18rem;">
                <img src="{{ asset("images/icon/profile-icon.svg") }}" class="profile-review-icon mx-auto" width="100px" height="100px">
                <small class="text-muted text-center mt-5">{{$userreview->users->employerdetails->company}}</small>
                <hr class="col-3 mx-auto">
                <div class='overall-ratings'>
                  <ul class="list-group list-group-horizontal">
                    <li class="list-group-item border-0 mx-auto">
                      <i class=' star <?php if((int)$userreview->rating <= 5 && (int)$userreview->rating !==0) { echo "selected"; } ?>' title='Poor' data-value='1'>
                          <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                      </i>

                      <i class='star <?php if((int)$userreview->rating <= 5 && (int)$userreview->rating >= 2) { echo "selected"; } ?>' title='Fair' data-value='2'>
                          <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                      </i>

                      <i class='star <?php if((int)$userreview->rating <= 5 && (int)$userreview->rating >= 3) { echo "selected"; } ?>' title='Good' data-value='3'>
                      <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                      </i>

                      <i class='star <?php if((int)$userreview->rating <= 5 && (int)$userreview->rating >= 4) { echo "selected"; } ?>' title='Excellent' data-value='4'>
                      <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                      </i>

                      <i class='star <?php if((int)$userreview->rating <= 5 && (int)$userreview->rating >= 5) { echo "selected"; } ?>' title='WOW!!!' data-value='5'>
                      <i class='fa fa-star fa-fw' style="color: yellow;"></i>
                        </i>
                    </li>
                  </ul>
                </div>
                <div class="card-body"> 
                <label class="profile-review-title text-center"> 
                  {{$userreview->summary}}
                </label>

                <p class="profile-review font-weight-lighter text-muted  text-justify mx-auto p-1">
                 {{ str_limit($userreview->review, 100)}}
                </p>

                <label class="profile-review-date mx-auto"> 
                  @if($userreview->recommend==1)
                    <small>Recommend company.</small>
                  @else
                    <small>Not recommend company.</small>
                  @endif
                </label>
              </div>
            </div>
            @endforeach
          </div>   
        </div>
      </div>
        @endforeach
      </div>

  <a class="carousel-control-prev" href="#user-review-sm" role="button" data-slide="prev">
    <span  class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#user-review-sm" role="button" data-slide="next">
    <span  class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

</div>
</div>


{{-- user review section mobile view end--}}


<div class="row" style="margin-bottom: 5%;">
  <div class="col-lg-12 md-12 col-sm-12" >
      <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <h1 class="text-center text-muted font-weight-bold" style="margin-top: 5%">Our Process</h1>
        <div class="carousel-inner" style="height: 500px;">
          <div class="carousel-item active" >
            <img src="login-images/{{ $pagecontents->footer }}" class="d-block w-100" style="  position: absolute;
    top: 0;
    left: 0;
    min-height: 300px; object-position: 50% 50%; object-fit: cover ">
             <div class="carousel-caption" >
                <h5 class="text-white text-center p-3"  >{{ App\MaintenanceLocale::getLocale(476) }}</h5>
                <p class="text-white text-center">{{ App\MaintenanceLocale::getLocale(479) }}</p>
              </div>
          </div>
          <div class="carousel-item">
            <img src="login-images/{{ $pagecontents->picture2 }}" class="d-block w-100" style="  position: absolute;
    top: 0;
    left: 0;
    min-height: 300px;">
             <div class="carousel-caption">
              <h5 class="text-white text-center p-3" >{{ App\MaintenanceLocale::getLocale(477) }}</h5>
              <p class="text-white text-center">{{ App\MaintenanceLocale::getLocale(480) }}</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="login-images/{{ $pagecontents->picture3 }}" class="d-block w-100" style="  position: absolute;
    top: 0;
    left: 0;
    min-height: 300px;">
              <div class="carousel-caption">
              <h1 class="text-white text-center p-3"  >{{ App\MaintenanceLocale::getLocale(478) }}</h1>
              <p class="text-white text-center">{{ App\MaintenanceLocale::getLocale(481) }}</p>
            </div>
    </div>
  </div>
</div>    
  </div>
</div>


<div class="container">
 <h1 class="text-center pt-1 mt-5 text-muted">{{ App\MaintenanceLocale::getLocale(50) }}</h1>
<div class="card-columns p-5">

@foreach ($subscriptions as $subscription)

      <p hidden>
        @php ($array = [])
        {{ array_push($array, App\MaintenanceLocale::getLocale(93).' '.$subscription->limit) }}
        {{ array_push($array, App\MaintenanceLocale::getLocale(94).' '.$subscription->expiration. ' '.App\MaintenanceLocale::getLocale(97)) }}
        {{ $subscription->check_reserve ? array_push($array, App\MaintenanceLocale::getLocale(99).' ') : '' }}
        {{ $subscription->check_technical ? array_push($array, App\MaintenanceLocale::getLocale(95)) : '' }}
        {{ $subscription->check_email ? array_push($array, App\MaintenanceLocale::getLocale(96)) : '' }}
      </p>
      <div class="card">
        <div class="card-header  text-white  font-weight-lighter text-center" style="background-color:#0175B1;">
          {{ $subscription->title }}
        </div>
        {{-- @if($subscription->get()->first())
        <div class="home-page-pricing-icon" style="background-color: red; width: 80px; height: 80px; border-radius: 50%; margin: 0px auto; margin-top: 10px;"></div>
        @elseif($subscription->get()->first())
        <div class="home-page-pricing-icon" style="background-color: green; width: 80px; height: 80px; border-radius: 50%; margin: 0px auto; margin-top: 10px;"></div>
        @endif --}}

          <div class="card-body">
          <h1 class="card-text text-muted text-center" style="font-size: 50px;">
            ${{ $subscription->price }}</h1>
          </div>

           <div class="card-footer text-muted text-center">
          <small>{{ $subscription->trial }} {{ App\MaintenanceLocale::getLocale(97) }}</small>
          </div>
         {{--  <p class="card-text">
            <ul class="list-group p-3"> --}}
           {{--  @foreach ($array as $val)
            @if(Auth::check() && Auth::user()->rolesId == null)
                this
                @elseif(Auth::check() && Auth::user()->rolesId == 2)
                <li class="home-page-priceinfo" style="text-align: justify; font-size: 15px; color: #636B6F;">{{ $val }}</li>
                @elseif(Auth::check() && Auth::user()->rolesId == 3)
                <li class="home-page-priceinfo" style="text-align: justify; font-size: 15px; color: #636B6F;">{{ $val }}</li>
                @elseif(Auth::check() && Auth::user()->rolesId == 4)
                <li class="home-page-priceinfo" style="text-align: justify; font-size: 15px; color: #636B6F;">{{ $val }}</li>
                @endif
            @endforeach --}}
  
  </div>
  @endforeach
  
 
</div>
</div>

{{-- background-image: url('{{ asset('/login-images/gcc-img-3.png') }}'); --}}
{{-- <div class="container-fluid px-0">    
  <h1 class="text-center pt-1 mt-5 text-muted">{{ App\MaintenanceLocale::getLocale(50) }}</h1>
      <div class="home-page-line2 mx-auto"></div>
      <div class="row col-12  mx-auto home-page-subscription-container" data-aos="zoom-in" data-aos-delay="100">

      @foreach ($subscriptions as $subscription)

      <p hidden>
        @php ($array = [])
        {{ array_push($array, App\MaintenanceLocale::getLocale(93).' '.$subscription->limit) }}
        {{ array_push($array, App\MaintenanceLocale::getLocale(94).' '.$subscription->expiration. ' '.App\MaintenanceLocale::getLocale(97)) }}
        {{ $subscription->check_reserve ? array_push($array, App\MaintenanceLocale::getLocale(99).' ') : '' }}
        {{ $subscription->check_technical ? array_push($array, App\MaintenanceLocale::getLocale(95)) : '' }}
        {{ $subscription->check_email ? array_push($array, App\MaintenanceLocale::getLocale(96)) : '' }}
      </p>
  
      <div class="col-lg-4 mx-auto home-page-pricebox-container">
      <div class=" text-center home-page-pricebox">
        <div class="card border-0">
          <h3 class="card-title text-muted mb-3 font-weight-lighter">{{ $subscription->title }}</h3>
          
          <div class="home-page-subscription-pricing-container" style="background-color:red; border-radius:50%; display:block;width: 200px;height:200px; margin:0px auto;">
          <h1 class="card-text text-white" style="top: 50%;transform: translateY(100%); font-size: 50px">${{ $subscription->price }}</h1>
          </div>
         

          <p class="card-text mt-5" style="color: #B5B5B5; font-size: 13px; font-weight: lighter; letter-spacing: 1px;" >{{ $subscription->trial }} {{ App\MaintenanceLocale::getLocale(97) }}</p>
          <br>
          <p class="card-text">
            <ul class="list-group p-3">
            @foreach ($array as $val)
            @if(Auth::check() && Auth::user()->rolesId == null)
                this
                @elseif(Auth::check() && Auth::user()->rolesId == 2)
                <li class="home-page-priceinfo" style="text-align: justify; font-size: 15px; color: #636B6F;">{{ $val }}</li>
                @elseif(Auth::check() && Auth::user()->rolesId == 3)
                <li class="home-page-priceinfo" style="text-align: justify; font-size: 15px; color: #636B6F;">{{ $val }}</li>
                @elseif(Auth::check() && Auth::user()->rolesId == 4)
                <li class="home-page-priceinfo" style="text-align: justify; font-size: 15px; color: #636B6F;">{{ $val }}</li>
                @endif
            @endforeach
            </ul>
          </p>   
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div> --}}

  <div class="row mb-5 p-5" style="margin-top: 10%;">
    <div class="col-lg-12 col-md-12 col-sm-12" style="background-image: url('{{ asset('/login-images/gcc-img-9.png') }}'); background-size: cover;  background-position:center; background-repeat: no-repeat; ">
      <h2 class="text-center p-1 text-muted">Our Company Partners</h2>
      <div class="row p-5 mx-auto">
        <div class="col-lg-3  co-md-3 col-sm-12  mx-auto text-center"  data-aos="slide-up" data-aos-delay="100">Company 1</div>
        <div class="col-lg-3 co-md-3 col-sm-12 mx-auto text-center" data-aos="slide-up" data-aos-delay="200">Company 2</div>
        <div class="col-lg-3 co-md-3 col-sm-12 mx-auto text-center" data-aos="slide-up" data-aos-delay="300">Company 3</div>
        <div class="col-lg-3 co-md-3 col-sm-12 mx-auto  text-center" data-aos="slide-up" data-aos-delay="400">Company 4</div>
      </div>
    </div>  
  </div>

@if ($feedbacks->count() > 0)
<div class="row p-3 mb-1">
  <div class="col-lg-12 mb-5">
    <h2 class="text-muted text-center">Testimony</h2>
    <div class="home-page-line2 mx-auto"></div>
    <div id="carouselExampleIndicators" class="carousel slide mt-2" data-ride="carousel">
     
      <div class="carousel-inner h-100">

        @foreach ($feedbacks as $feedback)
        @if ($loop->first)
        <div class="carousel-item active"> 
          <div class="text-center">
            <h5><i class="fa fa-user-circle fa-5x"></i></h5>
            <h5 class="m-0 text-muted">{{ $feedback->name }}</h5>
            <small class="text-muted">{{ $feedback->work }}</small>
            <hr class="col-3">
            <p class="font-italic text-muted col-lg-5 col-md-5 col-sm-12 mx-auto">"{{ $feedback->message }}"</p>
          </div>
        </div>
        @else
        <div class="carousel-item"> 
          <div class="text-center">
            <h5 class="m-0 text-muted">{{ $feedback->name }}</h5>
            <small class="text-muted">{{ $feedback->work }}</small>
            <hr class="col-3">
            <p class="font-italic text-muted col-5 mx-auto">"{{ $feedback->message }}"</p>
          </div>
        </div>
        @endif
        @endforeach
        
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="fa fa-angle-left fa-5x" aria-hidden="true" style="color: red;"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="fa fa-angle-right fa-5x" aria-hidden="true" style="color: red;"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
</div>
@endif

{{-- <div class="row">
<div class="col-lg-12">
       
          <img src="login-images/Untitled-1.png"  class="position-relative float-right" alt="Responsive image" width="28%;" style=" top: 180px; z-index: -1; transform: rotate(4deg);">
       </div>
      </div>
 --}}
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

