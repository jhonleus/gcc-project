@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">
  <br>
  <div class="row justify-row-content">
      <div class="col-sm-6">
         <h3 class="m-0 text-dark">User Documents</h3>
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
                           <th>Name</th>
                           <th>Document Name</th>
                           <th>File Type</th>
                           <th>View File</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     	@foreach($users as $user)
              			<tr>
                			<td>{{$user->id}}</td>
                			<td>
                      @if(!is_null($user->firstName))
                      @if(!is_null($user->lastName))
                      {{$user->firstName}}, {{$user->lastName}}
                      @endif
                      @endif 
                    </td>
                			<td>
                				@foreach($user->certificates() as $certificates)   
            						{{$certificates->filename}}<br>
          							@endforeach
                				@foreach($user->documents as $thisone)           
            						{{$thisone->filename}}<br>
          							@endforeach
                			</td>
                			<td>
                         @foreach($user->certificates() as $certificates)           
                        {{$certificates->type}}<br>
                        @endforeach
                         
                
                        @foreach($user->documents as $thisone)           
                        {{$thisone->filetype}}<br>
                        @endforeach
                			</td>
                			<td>
                        @foreach($user->certificates() as $certificates)           
                       <a href="{{url($certificates->path.$certificates->filename )}}" >
                        {{$certificates->filename}}
                        </a>
                      <br>
                      @endforeach 

                       @foreach($user->documents as $thistwo)           
                       <a href="{{url($thistwo->path.$thistwo->filename )}}" >
                        {{$thistwo->filename}}
                        </a>
                      <br>
                      @endforeach 


                      </td>
                			<td class="row">
                  				<form action="/admin/reports/documents/" method="POST" onsubmit="return confirm('Are you sure want to delete this record?')">
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
         </div>
      </div>
   </div>
</div>

@endsection