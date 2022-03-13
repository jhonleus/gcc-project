@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(17))

@section('content')

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">

<div class="container-fluid">
    <div class="maintenancesection1">
        <div class="row">
         <div class="col-md-12">

            <div class="card mt-5 shadow-none">
                <div class="card-header">
                    <a href="{{ url('admin/faq')}}"><i class="fa fa-arrow-left mr-2 mt-1"></i>{{ App\MaintenanceLocale::getLocale(156) }}</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
					@if (isset($faqs))
                    <form method="POST" action="{{ route('admin.faq.update', $faqs->id) }}" id="form">
						@method('PUT')
						@csrf
					@else
					<form method="POST" action="{{ route('admin.faq.store') }}">
						@csrf
					@endif

                        <div class="card shadow-none">
                            <div class="card-body">

                                <div class="form-group">
									<small class="form-text text-muted mt-2">{{ App\MaintenanceLocale::getLocale(157) }}</small>
                                    <textarea class="form-control" rows="6" name="question" id="question" required><?php if(isset($faqs)) { echo $faqs->question; }?></textarea>
								</div>

								<div class="form-group">
									<small class="form-text text-muted mt-2">{{ App\MaintenanceLocale::getLocale(159) }}</small>
                                    <div class="input-summer">
										<textarea class="form-control" name="answer" id="answer" required><?php if(isset($faqs)) { echo $faqs->answer; }?></textarea>
									</div>
								</div>
                            </div>

                        <button type="submit" class="btn btn-primary mb-5 col-lg-2 col-sm-12 ml-lg-3">@if(isset($faqs)) {{ App\MaintenanceLocale::getLocale(38) }} @else {{ App\MaintenanceLocale::getLocale(35) }} @endif</button>
                        </div>

                    </form> 
                </div>
            </div>    
            
        </div>
    </div>
</div>
</div>

<script>
$('#answer').summernote({
    height: 200
});
</script>
@endsection