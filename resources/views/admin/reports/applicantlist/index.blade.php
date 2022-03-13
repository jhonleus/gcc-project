
@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(5))

@section('content')

<div class="container-fluid">
   <br>
   <div class="row justify-row-content">
      <div class="col-sm-6">
         <h3 class="m-0 text-dark">{{ App\MaintenanceLocale::getLocale(593) }}</h3>
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
            <div class="card-body">
               <div class="table-responsive">
                  <table id="usersTable" class="table table-bordered">
                     <thead>
                        <tr>
                           <th>{{ App\MaintenanceLocale::getLocale(142) }}</th>
                           <th>Full Name</th>
                           <th>{{ App\MaintenanceLocale::getLocale(418) }}</th>
                           <th>{{ App\MaintenanceLocale::getLocale(436) }}</th>
                           <th>{{ App\MaintenanceLocale::getLocale(331) }}</th>
                           <th>{{ App\MaintenanceLocale::getLocale(332) }}</th>
                           <th>{{ App\MaintenanceLocale::getLocale(425) }}</th>
                           <th>Work Especialization</th>
                           <th>Skill Evaluation Test Result</th>
                           <th>{{ App\MaintenanceLocale::getLocale(601) }}</th>
                           <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($users as $key=>$user)

                           <tr class="tr{{$key}}">
                              <td>
                                 {{$user->id}}
                              </td>
                              <td>
                                 {{$user->firstName}} {{$user->lastName}}
                              </td>
                              <td>
                                 {{ $user->details ? $user->details->age : "Not yet fill out" }}
                              </td>
                              <td>
                                 {{ $user->details ? $user->details->genders ? $user->details->genders->name : "Not yet fill out" : "Not yet fill out" }}
                              </td>
                              <td>
                                 {{$user->address ? $user->address->city : "Not yet fill out" }}
                              </td>
                              <td>  
                                 {{$user->address ? $user->address->country ? $user->address->country->name : "Not yet fill out" : "Not yet fill out" }}
                              </td>
                              <td class="certificates{{$key}}">
                                 @if(!is_null($user->certificates()))
                                    @foreach($user->certificates() as $certificates)           
                                       <a href="{{url($certificates->path.$certificates->filename )}}" >
                                          {{$certificates->filename}}
                                       </a>
                                    @endforeach    
                                 @endif
                              </td>
                              <td>

                                 @if(!is_null($user->specialization))
                                    @foreach($user->specialization as $specialization)
                                       @if(!is_null($specialization->specialization))
                                          {{ $specialization->specialization->name }}, 
                                       @endif
                                    @endforeach
                                 @endif
                              </td>
                              <td>
                                 {{ $user->details ? $user->details->results ? $user->details->results->name : "Not yet fill out" : "Not yet fill out" }}
                              </td>
                              <td>
                                 {{ date('d-m-Y', strtotime( $user->created_at )) }}
                              </td>
                              <td class="row">
                                 <span data-toggle="tooltip" data-placement="top" title="View">
                                    <button class="btn btn primary openEdit" row="{{$key}}">
                                       <i class="fa fa-eye  text-dark"></i>
                                    </button>
                                 </span>
                                 <form action="/admin/reports/applicantlist/{{ $user->id }}" method="POST" onsubmit="return confirm('Are you sure want to delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn primary" data-toggle="tooltip" data-placement="top" title="Delete">
                                       <i class="fa fa-trash  text-dark"></i>
                                    </button>
                                 </form>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@include('admin.reports.applicantlist.modals')

@endsection
