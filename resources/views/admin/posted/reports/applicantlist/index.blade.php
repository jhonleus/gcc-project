
@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(5))

@section('content')

<div class="container-fluid">
   <br>
   <div class="row justify-row-content">
      <div class="col-sm-6">
         <h3 class="m-0 text-dark">Applicant list</h3>
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
                           <th>Id</th>
                           <th>Full Name</th>
                           <th>Age</th>
                           <th>Gender</th>
                           <th>City</th>
                           <th>Country</th>
                           <th>Certificates</th>
                           <th>Work Especialization</th>
                           <th>Skill Evaluation Test Result</th>
                           <th>Date Registered</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($users as $key=>$user)
                           <tr class="tr{{$key}}">
                              <td>
                                 {{$user->id}}
                              </td>
                              <td>
                                 @if(!is_null($user->firstName))
                                    @if(!is_null($user->lastName))
                                       {{$user->firstName}} {{$user->lastName}}
                                    @endif
                                 @endif 
                              </td>
                              <td>
                                 @if(!is_null($user->details))
                                    @if(!is_null($user->details->age))
                                       {{$user->details->age}}
                                    @endif
                                 @else
                                    Not yet fill  out
                                 @endif
                              </td>
                              <td>
                                 @if(!is_null($user->details))
                                    @if(!is_null($user->details->genders->name))
                                       {{$user->details->genders->name}}
                                    @endif
                                 @else
                                    Not yet fill out
                                 @endif
                              </td>
                              <td>
                                 @if(!is_null($user->address))
                                    @if(!is_null($user->address->city))
                                       {{$user->address->city}}
                                    @endif
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
                              <td class="certificates{{$key}}">
                                 @foreach($user->certificates() as $certificates)           
                                    <a href="{{url($certificates->path.$certificates->filename )}}" >
                                       {{$certificates->filename}}
                                    </a>
                                 @endforeach    
                              </td>
                              <td>
                                 @php 
                                 $spec = "";
                                 $specializations = "";
                                 @endphp

                                 @if(!is_null($user->specialization))
                                    @foreach($user->specialization as $specialization)
                                       @if($user->id==$specialization->usersId)
                                          @if(!is_null($specialization))
                                             @php
                                                $spec = $specialization->specialization->name;
                                             @endphp 
                                          @endif
                                       @else 
                                          @if(!is_null($specialization->name))
                                             @php
                                                $spec = $specialization->name->name;
                                             @endphp 
                                          @endif
                                       @endif
                                       @php
                                          $specializations = $specializations . $spec . ", ";
                                       @endphp
                                    @endforeach
                                 @endif
                                 {{rtrim($specializations, ", ")}}
                              </td>
                              <td>
                                 @if(!is_null($user->details))
                                    {{$user->details->result}}
                                    @if($user->details->result > 75)
                                  Passed 
                                    @else
                                   N/A
                                    @endif
                                 @else
                                    Not yet fill out.
                                 @endif
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
                                 <form action="/admin/reports/companylist/{{ $user->id }}" method="POST" onsubmit="return confirm('Are you sure want to delete this record?')">
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
