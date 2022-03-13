@extends('admin.layouts.master')

@section('title', "Review Details")

@section('content')
<style>
    .title {
        font-weight:bold;
        color:#808080;
        margin-bottom:0;
        margin-block-start: 0;
        margin-block-end: 0;
        line-height: 15px;
        display: inline;
    }

    .description {
        font-weight:bold;
        color:#000000;
        margin-bottom:0;
        margin-block-start: 0;
        margin-block-end: 0;
        line-height: 15px;
        display: inline;
    }

    .subdiv {
        margin-left: 20px;
        padding: 10px;
    }
    .subtitle {
        font-weight:500;
        color:gray;
        padding-bottom:10px;
        margin-block-start: 0;
        margin-block-end: 0;
        line-height: 15px;
        display: block;
    }

    .joborder{
        font-weight:bold;
        padding-bottom:20px;
        margin-block-start: 0;
        margin-block-end: 0;
        line-height: 15px;
        display: block;
    }
</style>
<div class="container-fluid">
    <div class="maintenancesection1">
        <div class="row">
         <div class="col-md-12">

            <div class="card shadow-none mt-5">
                <div class="card-header">
                    <a href="{{ url('admin/reviews')}}"><i class="fa fa-arrow-left mr-2 mt-1"></i>{{ App\MaintenanceLocale::getLocale(156) }}</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-none">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-9">
                                    <label>{{$review ? $review->summary : ""}}</label>
                                </div>
                                @if(isset($review))
                                @if($review->isActive==0)
                                <div class="col-sm-3 text-right">
                                    <form method="POST" action="{{ route('admin.reviews.update', $review->id) }}" id="form" style="margin:0;padding:0;display:inline">
                                    @method('PUT')
                                    @csrf
                                        <button class="btn btn-primary">Approve</button>
                                        <input type="hidden" value="1" name="isValidate">
                                    </form>
                                    <form method="POST" action="{{ route('admin.reviews.update', $review->id) }}" id="form" style="margin:0;padding:0;display:inline">
                                    @method('PUT')
                                    @csrf
                                        <button class="btn btn-danger">Decline</button>
                                        <input type="hidden" value="2" name="isValidate">
                                    </form>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Summary:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$review ? $review->summary : ""}}
                                        </label>
                                    </div>
                                </div>
							</div>

                            <div class="form-group">
                                <label class="title">Review:</label>
                                <br>
                                <label class="description">
                                    {{$review ? $review->review : ""}}
                                </label>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Pros:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$review ? $review->pros : ""}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Cons:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$review ? $review->cons : ""}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Rating:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            <i class="fa fa-star"></i>
                                            {{$review ? $review->rating : ""}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Recommended:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$review ? $review->recommend() : ""}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
            
        </div>
    </div>
</div>
</div>
@endsection