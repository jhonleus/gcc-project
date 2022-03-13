@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(8))

@section('content')
<div class="container-fluid">
	<br>
   <div class="row justify-row-content">
      <div class="col-sm-6">
         <h3 class="m-0 text-dark">Top Subscribe</h3>
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
              	<table id="usersTable" class="table table-bordered">
                	<thead>
                  	 <tr>
                    		<th>Id</th>
                    		<th>Company Name</th>
                    		<th>Subscriber Count</th>
                  	</tr>
                	</thead>
              		<tbody>
                       @foreach($users as $user)
	              		<tr>
	                		<td>{{$user->usersId}}</td>
	                		<td>{{$user->company}}</td>
		                	<td>{{$user->id}}</td>
	              		</tr>
                    @endforeach
              		</tbody>
              	</table>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection