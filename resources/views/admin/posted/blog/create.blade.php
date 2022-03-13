@extends('admin.layouts.master')

@section('title', $blogs ? App\MaintenanceLocale::getLocale(286) : App\MaintenanceLocale::getLocale(287))

@section('content')
<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/events-page.css') }}">
<style>
.imgs-cover {
	height: 500px;
	width: 100%;
}
</style>

<div class="container-fluid">
   <br>
    <div class="row">
        <div class="col-sm-12">
            <div class="card events-contents shadow-none">
                <div class="card-header events-header">
                    <label class="events-title">@if(isset($blogs)) {{ App\MaintenanceLocale::getLocale(286) }} @else {{ App\MaintenanceLocale::getLocale(287) }} @endif </label>
                </div>
                <div class="card-body">
                    @if(isset($blogs))
                <form method="POST" action="{{ route('employer.blogs.update', $blogs->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="events-forms">
                        <h1 class="events-label">{{ App\MaintenanceLocale::getLocale(288) }}:</h1>
                    <img src="{{ asset('blogs/'.$blogs->filename) }}" class="imgs-cover">
                    </div>
                @else
                <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">  
                    @csrf
                @endif
                <div class="row mb-3">
                    <div class="col-lg-4 col-sm-12">
                        <h1 class="events-label">{{ App\MaintenanceLocale::getLocale(31) }}:</h1>
                        <input type="text" class="form-control" name="title" id="title" required value="@if(isset($blogs)){{$blogs->title}}@endif">
                    </div>
                    
                    <div class="col-lg-4 col-sm-12">
                        <h1 class="events-label">{{ App\MaintenanceLocale::getLocale(32) }}:</h1>
                        <input type="text" class="form-control" name="subtitle" id="subtitle" required value="@if(isset($blogs)){{$blogs->subtitle}}@endif">
                    </div>
                    <div class="col-lg-4 col-sm-12">
                         <h1 class="events-label">From</h1>
                            <select class="custom-select" name="type" required="required">
                                <option selected>Choose...</option>
                                <option value="0">Japan</option>
                                <option value="1">Philippine</option>
                            </select>
                    </div>
                    </div>
                    <div class="events-forms">
                        <h1 class="events-label">{{ App\MaintenanceLocale::getLocale(278) }}</h1>
                        <div class="ckeditor-news">
                            <textarea class="form-control" rows="5" name="content" id="content" required>@if(isset($blogs)){{$blogs->content}}@endif</textarea>
                        </div>
                    </div>
<br>
                    <div class="events-forms">
                        <h1 class="events-label">@if(isset($blogs)) {{ App\MaintenanceLocale::getLocale(290) }} @else {{ App\MaintenanceLocale::getLocale(289) }} @endif </h1>

                        <input type="file" name="photo" id="photo" accept="image/*" onchange="readURL(this);" required hidden>
                        <label for="photo" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>

                        <label id="textPreview" class="text-muted small mt-4" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
                        <img class="imgs-cover" id="photoPrev" style="display:none;">

                    </div>

                    <div class="events-footer">
                        <button class="btn events-button btn-primary col-lg-2 col-md-2 col-sm-12" id="post" name="btnBlog" value="btnBlog">@if(isset($blogs)) {{ App\MaintenanceLocale::getLocale(38) }} @else {{ App\MaintenanceLocale::getLocale(29) }} @endif</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function readURL(input) {

        if (input.files && input.files[0])
        {
            var reader = new FileReader();
            reader.onload = function (e)
            {
            document.getElementById('photoPrev').style.display = "";
            document.getElementById('textPreview').style.display = "block";
            $('#photoPrev').attr('src',e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
            
        }
    }
</script>
@endsection