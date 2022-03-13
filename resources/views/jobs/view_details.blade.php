@extends('layouts.app')
@section('title', 'Job Details')
@section('content')

<style>

td {
    cursor: default;
}
</style>

<div class="aboutsection1">

  <div class="col-lg-12 pt-5">
    <div class="container">

      <div class="card mb-4 pt-5">
        <div class="card-body">
              <div class="row container">

                <div class="col-lg-10">
                    <h1> {{ $jobs->title }} </h1> 
                    <h6> {{ $jobs->employers->company  }} </h6> 
                </div>

                 <div class="col-lg-2 mt-3">
                    @if (Auth::check())
                        <form method="POST" action="{{ route('jobs.store') }}">
                            @csrf
                                @if ($check)

                                    @if ($check->jobId != $jobs->id)
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyModal">APPLY TO THIS JOB</button>
                                    @else 
                                        <button type="button" class="btn btn-primary" disabled>ALREADY APPLIED</button>
                                    @endif
                                    
                                @else
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyModal">APPLY TO THIS JOB</button>
                                @endif
                        </form>
                    @else 
                        <a href="{{ url('login') }}" class="btn btn-default" readonly>LOGIN TO APPLY</a>
                    @endif
                </div> 

            </div>
        </div>
      </div>	  

        <div class="row">

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="container">
                            
                        <h4><i class="fas fa-edit mb-3" style="margin-right:5px"></i>JOB DESCRIPTION</h4><hr>
                        {!! $jobs->description !!}

                        <h4 class="mt-3">Responsibilities</h4><hr>
                        {!! $jobs->responsibilities !!}

                        <h4 class="mt-3">Qualification</h4><hr>
                        {!! $jobs->qualification !!}

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="container">

                        <table>
                            <tr>
                                <td title="Employment Type"><i class="fas fa-user" style="margin-right:5px"></i> </td>
                                <td title="Employment Type">{{ $jobs->employments->name }}</td>
                            </tr>

                            <tr>
                                <td title="Location"><i class="fas fa-map-marker-alt" style="margin-right:5px"></i> </td>
                                <td title="Location">{{ $jobs->country->nicename }}</td>
                            </tr>

                            <tr>
                                <td title="Specialization"><i class="fas fa-address-book" style="margin-right:5px"></i> </td>
                                <td title="Specialization">{{ $jobs->specializations->name }}</td>
                            </tr>

                            <tr>
                                <td title="Position"><i class="fas fa-file" style="margin-right:5px"></i> </td>
                                <td title="Position">{{ $jobs->positions->name }}</td>
                            </tr>

                            <tr>
                                <td title="Salary Range"><i class="fas fa-money" style="margin-right:5px"></i> </td>
                                <td title="Salary Range" style="color:green">{{ $jobs->currency->name }} {{ number_format($jobs->min,2)  }}-{{ number_format($jobs->max,2) }}</td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>
        
            @if (Auth::check())
            <form method="POST" action="{{ route('jobs.store') }}">
                @csrf
                    <input type="text" name="jobId" value="{{$jobs->id}}" hidden>
                    @if ($bookmarks)
                        @foreach ($bookmarks as $bookmark)
                            @if ($bookmark->jobId == $jobs->id)
                                <button type="submit" name="btnUnBook" value="btnUnBook" class="btn btn-warning form-control" style="color:#fff"><i class="fas fa-bookmark" style="margin-right:5px"></i>UNBOOKMARK</button>
                            @endif
                        @endforeach
                    @endif

                    @if ($bookmarks == "[]")
                        <button type="submit" name="btnBook" value="btnBook" class="btn btn-warning form-control" style="color:#fff"><i class="fas fa-bookmark" style="margin-right:5px"></i>BOOKMARK</button>
                    @endif

            </form>
            @endif

            <h6 style="float:right"><a href="{{ url('jobs/company/'.Crypt::encrypt($jobs->usersId)) }}" target="_blank">View Company Profile <i class="fas fa-arrow-right mt-3"></i></a></h6>
        </div>
    </div>
    </div>
  </div>
</div>
@include('jobs.modal')
@endsection