@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(17))

@section('content')
<div class="container-fluid">
    <div class="maintenancesection1">
        <div class="row">
           <div class="col-md-12">

                <div class="card shadow-none mt-5 mb-5">
                    <div class="card-header">
                        <h6 style="float:left; margin-top:10px">{{ App\MaintenanceLocale::getLocale(17) }}</h6>
                        <a href="/admin/faq/create" style="float:right" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(149) }}</a>
                    </div>
                </div>

                    <div class="row d-flex mb-5" style="margin-top:-2%">
                        @foreach ($maintenance_faqs as $faq)
                  
                        <div class="col-lg-6 mb-3">
                        <div class="card text-center h-100" style="border-style:ridge;">
                          <div class="card-body">
                            
                            <form action="/admin/faq/{{ $faq->id }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(151) }}')">
                                @csrf
                                @method('DELETE')
                                <button style="background:none; border: none; float:right; color:red"><i class="fa fa-times"></i></button>
							</form>
							
							<h5 class="mt-4">{{ $faq->question }}</h5><hr>
                            <p class="text-muted">{!!$faq->answer!!}</p>
                  
                          
                          </div>
                          <a href="/admin/faq/{{$faq->id}}/edit" class="btn btn-primary" style="border-top-right-radius: 0; border-top-left-radius: 0;">{{ App\MaintenanceLocale::getLocale(150) }}</a>
                        </div>
                      </div>
                      @endforeach
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection