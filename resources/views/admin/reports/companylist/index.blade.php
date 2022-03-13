@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(4))

@section('content')
    <div class="container-fluid">
      <br>
      <div class="row justify-row-content">
         <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ App\MaintenanceLocale::getLocale(594) }}</h3>
         </div>
      </div>
      <div class="row justify-row-content mt-3">
         <div class="col-sm-3">
            <input type="text" id="datasearchfield" class="form-control" placeholder="{{ App\MaintenanceLocale::getLocale(89) }}">
         </div>
      </div>
      <div class="row justify-row-content mt-3">
         <div class="col-md-12">
            <div class="card shadow-none">
               <!-- /.card-header -->
               <div class="card-body">
                  <div class="table-responsive">
                  <table id="companiesTable" class="table table-bordered">
               
                <thead>
                  <tr>
                    <th>{{ App\MaintenanceLocale::getLocale(144) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(145) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(146) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(331) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(332) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(600) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(147) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(148) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(601) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                  </tr>
                </thead>
              <tbody>
              @foreach($users as $user)
              <tr>
                <td>{{$user->id}}</td>
                <td>
                 @if(!is_null($user->employer))
                   {{$user->employer->company}}
                   @else
                    {{$user->firstName}}
                 @endif
                </td>
                <td>
                  @if(!is_null($user->employer))
                    @if(!is_null($user->employer->industry))
                      {{$user->employer->industry->getName()}}
                     
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

                  @if(!is_null($user->employer))
                  @if(!is_null($user->employer->type))
                  {{$user->employer->type->name}}
                 
                  @endif
                   @else
                  Not yet fill out.
                  @endif
                  
                </td>
                <td>
                 @if(!is_null($user->subscriber()))
                   @if(!is_null($user->subscriber()->subscription))
                     {{$user->subscriber()->subscription->title}}
                   @endif
                  @else
                  Not yet subscribe
                 @endif
                </td>
                 <td>
                   @if($user->subscriptionId < 1)
                    Inactive
                    @else
                    Active
                    @endif
                </td>
                <td>{{ date('d-m-Y', strtotime( $user->created_at )) }}</td>
                <td class="row">
                  <span data-toggle="tooltip" data-placement="top" title="View">
                     <button class="btn btn primary openEdit">
                        <i class="fa fa-eye  text-dark"></i>
                     </button>
                  </span>
                  <form action="/admin/reports/companylist/{{ $user->id }}" method="POST" onsubmit="return confirm('Are you sure want to delete this record?')">
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

@include('admin.reports.companylist.modals')


@endsection