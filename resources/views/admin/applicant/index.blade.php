@extends('admin.layouts.master')
@section('content')
<div class="container pt-5">
  <div class="row justify-row-content">
  	<div class="col-sm-6">
  		<h3 class="m-0 text-dark">{{ App\MaitenanceLocale::getLocale(196) }}</h3>
  	</div>
  	<div class="col-sm-6"></div>
  </div>
  <div class="row justify-row-content mt-3">
  	<div class="col-sm-3">
  		<input type="text" id="datasearchfield" class="form-control">
  	</div>
  </div>
  <div class="row justify-row-content mt-3">
  	<div class="col-md-12">
  		<div class="card">
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ App\MaitenanceLocale::getLocale(34) }}</th>
                <th>{{ App\MaitenanceLocale::getLocale(576) }}</th>
                <th>{{ App\MaitenanceLocale::getLocale(41) }}</th>
                <th>{{ App\MaitenanceLocale::getLocale(148) }}</th>
                <th>Date Registered</th>
                <th>{{ App\MaitenanceLocale::getLocale(33) }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr style="white-space: nowrap;">
                <td>{{ $user->id }}</td>
                <td>{{ $user->firstName }} {{ $user->lastName }}</td>
                <td>{{ $user->firstName }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->isActive }}</td>
                <td>{{ $user->created_at }}</td>
                <td class="row">
                  <button class="btn btn primary" data-toggle="tooltip" data-placement="top" title="View">
                    <i class="fa fa-eye"></i>
                  </button>
                  <span data-toggle="tooltip" data-placement="top" title="Edit">
                    <button class="btn btn primary" data-toggle="modal" data-target="#addRoles" data-id="">
                      <i class="fa fa-edit"></i>
                    </button>
                  </span>
                  <form action="/admin/roles/" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn primary" data-toggle="tooltip" data-placement="top" title="Delete">
                      <i class="fa fa-trash"></i>
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
@include('admin.roles.modals')
@endsection