@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(16))

@section('content')
<div class="container-fluid">
    <div class="maintenancesection1">
        <div class="row">
           <div class="col-md-12">

                <div class="card mt-5 shadow-none">
                    <div class="card-header border-0">
                        <h6 style="float:left; margin-top:10px">{{ App\MaintenanceLocale::getLocale(16) }}</h6>
                        <a href="/admin/subscriptions/create" style="float:right" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(149) }}</a>
                    </div>
                </div>

                    <div class="row d-flex mb-5" style="margin-top:-2%">
                        @foreach ($subscriptions as $subscription)
                  
                        <p hidden>
                          @php ($array = [])
                          {{ $subscription->check_limit == 1 ? array_push($array, App\MaintenanceLocale::getLocale(524)) : array_push($array, App\MaintenanceLocale::getLocale(93).' '.$subscription->limit) }}
                          {{ array_push($array, App\MaintenanceLocale::getLocale(94).' '.$subscription->expiration. ' '.App\MaintenanceLocale::getLocale(97)) }}
                          {{ $subscription->check_reserve ? array_push($array, App\MaintenanceLocale::getLocale(99).' ') : '' }}
                          {{ $subscription->check_technical ? array_push($array, App\MaintenanceLocale::getLocale(95)) : '' }}
                          {{ $subscription->check_email ? array_push($array, App\MaintenanceLocale::getLocale(96)) : '' }}
                          {{ $subscription->check_applicant ? array_push($array, App\MaintenanceLocale::getLocale(254)) : '' }}
                          {{ $subscription->check_blog ? array_push($array, App\MaintenanceLocale::getLocale(255)) : '' }}
                        </p>
                  
                        <div class="col-lg-3 mt-5">
                        <div class="card text-center h-100 shadow-none" style="border-style:ridge;">
                          <div class="card-body">
                            <h5 class="card-title" style="float:left; margin-top:10px">{{ $subscription->title }}</h5>

                            <form action="/admin/subscriptions/{{ $subscription->id }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(151) }}')">
                                @csrf
                                @method('DELETE')
                                <button style="background:none; border: none; float:right; color:red"><i class="fa fa-times"></i></button>
                            </form>
                  
                            <h1 class="card-text mt-2">${{ $subscription->price }}</h1>
                  
                            <p class="card-text">
                              <ul>
                              @foreach ($array as $val)
                                  <li style="text-align: left">{{ $val }}</li>
                              @endforeach
                              </ul>
                            </p>   
                          
                          </div>
                          <a href="/admin/subscriptions/{{$subscription->id}}/edit" class="btn btn-primary" style="border-top-right-radius: 0; border-top-left-radius: 0;">{{ App\MaintenanceLocale::getLocale(36) }}</a>
                        </div>
                      </div>
                      @endforeach
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection