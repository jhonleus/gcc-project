@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(51))

@section('content')

{{-- about-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/about-page.css') }}">

{{-- container-start --}}

	{{-- about-page-section1-start --}}


	{{-- about-page-section2-start --}}
	{{-- <div class="about-page-section1" >
		<div class="row">
			<div class="col-md-6"  data-aos="fade-right">
				<div class="about-page-content2" >
					<img src="abouts/{{ $about1->picture }}">
				</div>
			</div>
			<div class="col-md-6"  data-aos="fade-left">
				<div class="about-page-content3">
					<h1 style="color: #494949">{{ App\MaintenanceLocale::getLocale(482) }}</h1>
					<span class="about-page-line1"></span>	
					<br>
					<p class="text-muted font-weight-light">{{ App\MaintenanceLocale::getLocale(485) }}</p>
				</div>
			</div>
		</div>
	</div> --}}
	{{-- about-page-section2-end --}}

	{{-- about-page-section3-start --}}
	{{-- <div class="about-page-section3" data-aos="fade-down">
		<div class="row">
			<div class="col-md-6" data-aos="slide-up">
				<h1 style="color: #494949">{{ App\MaintenanceLocale::getLocale(483) }}</h1>
				<span class="about-page-line2"></span>	
				<br>
				<p class="text-muted font-weight-light">{{ App\MaintenanceLocale::getLocale(486) }}</p>
			</div>
			<div class="col-md-6" data-aos="slide-down">
					<img src="abouts/{{ $about2->picture }}">
			</div>
		</div>
	</div> --}}
	{{-- about-page-section3-end --}}

	{{-- about-page-section4-start --}}
	{{-- <div class="about-page-section4">
		<div class="row">
			<div class="col-md-6" data-aos="fade-right">
				<img src="abouts/{{ $about3->picture }}">
			</div>
			<div class="col-md-6" data-aos="fade-left">
				<h1 style="color: #494949">{{ App\MaintenanceLocale::getLocale(484) }}</h1>
				<span class="about-page-line3"></span>	
				<br>
				<p class="text-muted font-weight-light">{{ App\MaintenanceLocale::getLocale(487) }}</p>
			</div>
		</div>
	</div> --}}
	{{-- about-page-section4-end --}}

	{{-- about-page-section --}}
{{-- about-page-section --}}
<div class="container-fluid">
	<div class="row">
  		<div class="col-lg-12 col-md-12 col-sm-12">
    		<div class="row" style="background-image: url('{{ asset('login-images/'.$about1->picture)}}'); background-position: center,center; background-attachment: fixed;background-repeat: no-repeat; margin-top: 5%; margin-bottom: 6%;">
      			<div class="col-lg-6 p-5"  data-aos="fade-right" data-aos-duration="500">
        			<h1 style="font-size: 40px; font-weight: bold;"  class="text-white" >{{ App\MaintenanceLocale::getLocale(482) }}</h1>
        			<p style="width: 700px; margin-top: 40px;" class="font-weight-light text-white">{!! App\MaintenanceLocale::getLocale(485) !!}</p>
      			</div>
    {{--   <div class="col-lg-6"  data-aos="fade-left" data-aos-duration="500">
      <img src="login-images/gcc-img-7.jpg" height="400px;" style="display: block;
      margin: 0px auto;" class="p-5">
    </div> --}}
    		</div>
      		<div class="row" style="margin-bottom: 6%;">
      			<div class="col-lg-12 p-5" data-aos="zoom-in" data-aos-duration="500" style="background-image: url('{{ asset('login-images/'.$about2->picture)}}'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
       				{{--  <img src="login-images/gcc-img-2.png" height="400px;" style="display: block;  z-index: -1;margin: 0px auto; opacity: 0.2; position: absolute; left: 230px; top: -60px;" class="p-5"> --}}
        			<h1 class="about-page-global-career-creation">{{ App\MaintenanceLocale::getLocale(483) }}</h1>
        			<p style="margin-top: 40px;" class="font-weight-light text-muted">{!! App\MaintenanceLocale::getLocale(486) !!}</p>
      			</div>
    		</div>
    		<div class="row" style="background-image: url('{{ asset('login-images/gcc-img-6.jpg')}}'); background-position: center,center; background-attachment: fixed;background-repeat: no-repeat;">
      			<div class="col-lg-6" data-aos="fade-right" data-aos-duration="500">
        			{{--  <img src="login-images/gcc-img-6.jpg" height="500px;" style="display: block;
      				margin: 0px auto;" class="p-5"> --}}
      			</div>
      			<div class="col-lg-6 p-5" data-aos="fade-up" data-aos-duration="500">
        			<h1 style="font-size: 40px; font-weight: bold;" class="text-white">{{ App\MaintenanceLocale::getLocale(484) }}</h1>
        			<p style="width: 700px; margin-top: 40px;" class="font-weight-light text-white">{!! App\MaintenanceLocale::getLocale(487) !!}</p>
      			</div>
   			</div>
  		</div>
	</div>
</div>
{{-- container-end --}}
@endsection
