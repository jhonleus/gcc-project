@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(49))

@section('content')
<link rel="stylesheet" href="{{ asset('css/content-page/login-page.css') }}">
<br> 
<br>  
<br>  
<br>  
<br>   
<div class="container-fluid">
   <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 login-page-form  mx-auto" data-aos="zoom-in" data-aos-duration="500">
          <img class="img-fluid" alt="Responsive image" src="login-images/{{ $pagecontents->login }}" width="80px;" style="display: block; margin: 0px auto;">
           <h1 class="text-center text-muted mt-1 p-3 font-weight-light "></h1>
         @include('flash-message')
         <form method="POST" action="{{ route('login') }}">
         @csrf
            <div class="form-group row">
               <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mx-auto">
                  <label class="text-muted">{{ App\MaintenanceLocale::getLocale(101) }}</label>
                  <input id="login" type="text" class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" name="login" value="{{ old('username') ?: old('email') }}" required autofocus>
               </div>
            </div>

            <div class="form-group row">
               <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mx-auto">
                  <label class="text-muted">{{ App\MaintenanceLocale::getLocale(100) }}</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
               </div>
            </div>

            <div class="form-group row">
               <div class="col-md-8 mx-auto">
                  <div class="form-check">
                     <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                     <label class="form-check-label" for="remember">
                        {{ App\MaintenanceLocale::getLocale(68) }}
                     </label>
                  </div>
               </div>
            </div>

            <div class="form-group row">
               <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 offset-md-12 mx-auto">
                  <button type="submit" class="btn btn col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="background-color: #FF3333; color: white;">
                     {{ App\MaintenanceLocale::getLocale(49) }}
                  </button>
                  <br><br>
                  @if (Route::has('password.request'))
                     <a class="btn btn-small mx-auto col-12 text-muted" href="{{ route('password.request') }}" style="font-size: 15px;">
                        {{ App\MaintenanceLocale::getLocale(69) }}
                     </a> 
                  @endif
                  <small class="text-center text-muted text-center mx-auto d-block" style="margin-top: 100px;">{{ App\MaintenanceLocale::getLocale(510) }} <a href="{{ route('register') }}">{{ App\MaintenanceLocale::getLocale(48) }}</a></small></p>
               </div>
            </div>
         </form>  
      </div>
   </div>
</div>
@endsection


