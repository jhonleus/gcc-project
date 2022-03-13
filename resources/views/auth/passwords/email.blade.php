@extends('layouts.header')

@section('title', 'Forgot Password')

@section('content')

<style>
    .email-page-section{
        margin-top: 10%;
        margin-bottom: 10%;
    }

    @media only screen and (max-width: 480px) {
    .email-page-section .email-page-section-card{
      border:0px solid !important
    }
    }

</style>
<div class="container">
    <div class="row ">
        <div class="col-lg-6 col-md-6 col-sm-12 mx-auto email-page-section" >
            <div class="card shadow-0 mx-auto mt-5 email-page-section-card">
                <br>
                 <img src="/login-images/reset-password-gcc.png" class="img-fluid" style="width: 200px; display: block; margin: 0px auto;">
                <div class="card-header border-bottom-0 text-center bg-white">
                    <h3>{{ App\MaintenanceLocale::getLocale(70) }}</h3>
                </div>
                    
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-8 mx-auto">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ App\MaintenanceLocale::getLocale(41) }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 mx-auto">
                                <button type="submit" class="btn btn-primary col-12">
                                    {{ App\MaintenanceLocale::getLocale(71) }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
