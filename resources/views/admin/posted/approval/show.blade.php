@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(10))

@section('content')
<div class="container-fluid">
    <div class="maintenancesection1">
        <div class="row">
           <div class="col-md-12">
                <div class="card shadow-none mt-5">
                    <div class="card-header">
                        <a href="#" onclick="window.history.go(-1); return false;"><i class="fa fa-arrow-left"></i> {{ App\MaintenanceLocale::getLocale(156) }}</a>
                    </div>
                </div>

                <div class="row" style="margin-top:2%">
                    @if ($document1)
                    
                        <div class="col-md-4">
                            <div class="card shadow-none" style="padding:30px">
                                

                                <h4 class="card-title my-2">{{ App\MaintenanceLocale::getLocale(226) }}</h4>
                                <div class="card-body" style="border-style: groove;">
                                    <b>{{ App\MaintenanceLocale::getLocale(238) }}:</b><br>{{ $document1->updated_at }}<br>
                                </div>
            
                                <a href="{{url($document1->path.$document1->filename)}}" type="button" class="btn btn-default register" style="margin-top:15px;" target="_blank">{{ App\MaintenanceLocale::getLocale(200) }}</a>
                    
                            </div>
                        </div>
                    @endif
            
                    @if ($document2)
                        <div class="col-md-4">
                            <div class="card shadow-none" style="padding:30px">
            
                                <h4 class="card-title my-2">{{ App\MaintenanceLocale::getLocale(227) }}</h4>
                                <div class="card-body" style="border-style: groove;">
                                    <b>{{ App\MaintenanceLocale::getLocale(238) }}:</b><br>{{ $document2->updated_at }}<br>
                                </div>
            
                                <a href="{{url($document2->path.$document2->filename)}}" type="button" class="btn btn-default register" style="margin-top:15px;" target="_blank">{{ App\MaintenanceLocale::getLocale(200) }}</a>

                            </div>
                        </div>
                    @endif
            
                    @if ($document3)
                        <div class="col-md-4">
                            <div class="card shadow-none" style="padding:30px">
            
                                <h4 class="card-title my-2">{{ App\MaintenanceLocale::getLocale(228) }}</h4>
                                <div class="card-body" style="border-style: groove;">
                                    <b>{{ App\MaintenanceLocale::getLocale(238) }}:</b><br>{{ $document3->updated_at }}<br>
                                </div>
            
                                <a href="{{url($document3->path.$document3->filename)}}" type="button" class="btn btn-default register" style="margin-top:15px;" target="_blank">{{ App\MaintenanceLocale::getLocale(200) }}</a>
                           
                            </div>
                        </div>
                    @endif
            
                    </div>

                    @if ($document3->requirements->isActive == 0 || $document3->requirements->isActive == 3)
                    <form method="POST" action="{{ route('admin.approval.update', $id) }}">
                        @method('PUT')
                        @csrf
                            <button type="button" class="btn btn-danger mt-2" data-toggle="modal" data-target="#exampleModal" style="float:right; width:100px">{{ App\MaintenanceLocale::getLocale(243) }}</button>
                            <button type="submit" class="btn btn-primary mt-2 mr-2" name="btnApprove" value="btnApprove" style="float:right; width:100px">{{ App\MaintenanceLocale::getLocale(244) }}</button>
                    </form> 
                    @endif

            </div>
        </div>
    </div>
</div>

@include('admin.approval.modal')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
<script>

$(document).on('click', '#download', function () {
    
    var basePath = window.location.origin;
    var id = $(this).data('id');

    window.location = `${basePath}/admin/approval/download/${id}`;
});

</script>

@endsection