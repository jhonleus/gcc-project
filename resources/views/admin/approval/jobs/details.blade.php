@extends('admin.layouts.master')

@section('title', "Job Details")

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
                    <a href="{{ url('admin/jobs')}}"><i class="fa fa-arrow-left mr-2 mt-1"></i>{{ App\MaintenanceLocale::getLocale(156) }}</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-none">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-9">
                                    <label>{{$job ? $job->title : ""}}</label>
                                </div>
                                @if(isset($job))
                                @if($job->isValidate==0)
                                <div class="col-sm-3 text-right">
                                    <form method="POST" action="{{ route('admin.jobs.update', $job->id) }}" id="form" style="margin:0;padding:0;display:inline">
                                    @method('PUT')
                                    @csrf
                                        <button class="btn btn-primary">Approve</button>
                                        <input type="hidden" value="1" name="isValidate">
                                    </form>
                                    <form method="POST" action="{{ route('admin.jobs.update', $job->id) }}" id="form" style="margin:0;padding:0;display:inline">
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
                                        <label class="title">Job Title:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$job ? $job->title : ""}}
                                        </label>
                                    </div>
                                </div>
							</div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Position:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$job ? $job->positions ? $job->positions->name : "" : ""}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Specialization:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$job ? $job->specializations ? $job->specializations->name : "" : ""}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Employment Type:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$job ? $job->employments ? $job->employments->name : "" : ""}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Location:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$job ? $job->country ? $job->country->nicename : "" : ""}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="title">Salary:</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <label class="description">
                                            {{$job ? $job->currency ? $job->currency->name : "" : ""}} {{$job ? $job->min : "" }} - {{$job ? $job->max : ""}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="title">Description:</label>
                                <label class="description">
                                    {!!$job ? $job->description : ""!!}
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="title">Responsibility:</label>
                                <label class="description">
                                    {!!$job ? $job->responsibilities : ""!!}
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="title">Qualification:</label>
                                <label class="description">
                                    {!!$job ? $job->qualification : ""!!}
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="title">Job Order:</label>
                                <div class="subdiv">
                                    <label class="subtitle">File:</label>
                                    <a href="{{ url($job ? $job->jobOrder : "")}}" class="joborder">{{$job ? $job->jobOrder: ""}}</a>

                                    <label class="subtitle">Uploaded on:</label>
                                    <label class="description">
                                        {{$job ? Helper::getDate($job->created_at) : ""}}
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
@endsection