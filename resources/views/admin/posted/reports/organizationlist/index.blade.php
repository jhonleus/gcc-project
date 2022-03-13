@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(7))

@section('content')
    <div class="container-fluid">
      <br>
      <div class="row justify-row-content">
        <div class="col-sm-6">
          <h3 class="m-0 text-dark">Organization list</h3>
        </div>
      </div>
      <div class="row justify-row-content mt-3">
        <div class="col-sm-3">
          <input type="text" id="datasearchfield" class="form-control" placeholder="Search here..">
        </div>
      </div>
      <div class="row justify-row-content mt-3">
        <div class="col-md-12">
          <div class="card shadow-none">
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              <table id="organizationTable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Organization ID</th>
                    <th>Organization Name</th>
                    <th>Type Of Organization</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Subscription Type</th>
                    <th>Date Registered</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
              <tbody>
              @foreach($user as $user)
              <tr>
                <td>{{$user->id}}</td>
                <td> @if(!is_null($user->employer))
                   {{$user->employer->company}}
                     @else
                    Not yet fill out.
                   @endif

                 </td>
                <td>
                {{--   @if(!is_null($user->employer))
                    @if(!is_null($user->employer->industry))
                      {{$user->employer->industry->getName()}}
                        @else
                    Not yet fill out.
                    @endif
                  @endif

                  {{ $user->employer ? $user->employer->type ? $user->employer->type->name : "" : "" }} --}}

                  @if(!is_null($user->employer))
                  @if(!is_null($user->employer->type))
                  {{$user->employer->type->name}}
                 
                  @endif
                   @else
                  Not yet fill out.
                  @endif
                </td>
                
                <td>
                   @if(!is_null($user->address))
                    {{$user->address->city}}
                    @else
                    Not yet fill out.
                 @endif
                </td>
                <td>
                  @if(!is_null($user->address))
                    {{$user->address->country->name}}
                      @else
                    Not yet fill out.
                 @endif
                </td>
                <td>
                    @if($user->subscriptionId == 1)
                    Free Trial
                  @elseif($user->subscriptionId == 2)
                    Gold
                  @elseif($user->subscriptionId == 3)
                    Platinum
                  @else
                  Not yet avail.
                  @endif
                </td>
                <td> {{ date('d-m-Y', strtotime( $user->created_at )) }}</td>
                <td>
                   @if($user->subscriptionId < 1)
                    Inactive
                    @else
                    Active
                    @endif
                </td>
                <td class="row">
                   <span data-toggle="tooltip" data-placement="top" title="View">
                    <button class="btn btn primary openEdit">
                      <i class="fa fa-eye  text-dark"></i>
                    </button>
                  </span>
                  <form action="" method="POST" onsubmit="return confirm('Are you sure want to delete this record?')">
                  @csrf
                  @method('DELETE')
                    <button class="btn btn primary" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash  text-dark"></i></button>
                  </form>
                </td>
              </tr>
            @endforeach
              </tbody>
              </table>
            </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
    </div>

@include('admin.reports.organizationlist.modals')

@endsection