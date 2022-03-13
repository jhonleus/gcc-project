@extends('layouts.header')
@section('title', 'Home')
@section('content')
<style>
.applicant-blog-lg{
   display: block;
}

.applicant-blog-sm{
   display: none;
}


@media only screen and (max-width: 480px){
   .applicant-blog-lg{
   display: none;
}

.applicant-blog-sm{
   display: block;
   margin-bottom:20px;
   margin-top: 25%;
}
}
</style>
<div class="container-fluid px-0">
   {{-- carousel desktop --}}
   <!--<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height: 100vh;">
         <div class="carousel slide applicant-blog-lg" data-ride="carousel">
            <div class="carousel-inner">
               @foreach($displayeds->take(5) as $one)

               <div class="carousel-item @if($loop->first) active @endif" style="background-image: url({{ asset('blogs/' .$one->filename)}}); background-position: center center; background-size: cover; height: 750px; width: 100%;">
                {{--   <a href="/blog/{{$one->id}}"><img src="{{ asset('blogs/' .$one->filename)}}" class="d-block w-100" style="height: 100vh; object-fit: cover;  object-position: center center center"></a> --}}
                  <div class="carousel-caption" style="background-color:black;  opacity: 0.5; margin:0px auto;">
                      <a href="/blog/{{$one->id}}">
                     <h1 class="text-white">{{ $one->title}}</h1>
                     <h3 class="text-white">{{ $one->subtitle}}</h3>
                  </div>
               </a>
               </div>
               @endforeach
            </div>
            {{-- previous button --}}
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
            </a>
            {{-- next button --}}
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="sr-only">Next</span>
            </a>
         </div>
      </div>
   </div>-->

   <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height: 100vh;">
         <div class="carousel slide applicant-blog-lg" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active" style="background-image: url({{ asset('images/temporary.jpg')}}); background-position: center center; background-size: cover; height: 750px; width: 100%;">
               </div>
            </div>
            {{-- previous button --}}
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
            </a>
            {{-- next button --}}
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="sr-only">Next</span>
            </a>
         </div>
      </div>
   </div>

{{-- carousel mobile --}}
   <!--<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div  class="carousel slide applicant-blog-sm" data-ride="carousel">
            <div class="carousel-inner">
               @foreach($displayeds->take(5) as $one)
               <div class="carousel-item @if($loop->first) active @endif" style="background-image: url({{ asset('blogs/' .$one->filename)}}); background-position: center center; background-size: cover; height: 450px; width: 100%;">
                {{--  <img src="{{ asset('blogs/' .$one->filename)}}" class="d-block w-100" style="height: 100vh; object-fit: cover;  object-position: center center center"> --}}
               
                
                  
                  <div class="carousel-caption" style="background-color:black;  opacity: 0.5; margin:0px auto;">
                 <a href="/blog/{{$one->id}}">
                     <h1>{{ $one->title}}</h1>
                     <h3>{{ $one->subtitle}}</h3>
                     </a>
                  </div>
               </div>
               @endforeach

            </div>
            {{-- previous button start --}}
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
            </a>
            {{-- previous button end --}}
            {{-- next button start--}}
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="sr-only">Next</span>
            </a>
            {{-- next button end --}}
         </div>
      </div>
   </div>-->

   <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div  class="carousel slide applicant-blog-sm" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active" style="background-image: url({{ asset('images/temporary.jpg')}}); background-position: center center; background-size: cover; height: 450px; width: 100%;">
               </div>
            </div>
            {{-- previous button start --}}
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
            </a>
            {{-- previous button end --}}
            {{-- next button start--}}
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="sr-only">Next</span>
            </a>
            {{-- next button end --}}
         </div>
      </div>
   </div>
</div>
@endsection