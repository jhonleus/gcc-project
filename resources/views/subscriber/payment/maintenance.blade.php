@extends('layouts.header')
@section('title', 'Oppss!')
@section('content')
  <div class="container" style="padding-top: 10%;">
    <div class="row">
        <div class="col-lg-8 mx-auto" >
            <img src="{{ asset('login-images/under-maintenance (2).png') }}" style="width:100%" class="label-image">
            <h3 class="text-muted text-center">Sorry, This page is under-maintenance. We are working to get it back and running as soon as possible.</h3>
            
            <a class="d-flex justify-content-center mt-4" style="color:#000; text-decoration: underline; margin-bottom:10%" href="javascript:history.back()">
                <small class="text-muted"><i class="fa fa-arrow-left"></i> Get Back</small>
            </a>
        </div>
    </div> <!-- end of row -->
  </div>
@endsection