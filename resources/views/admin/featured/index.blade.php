@extends('admin.layouts.master')

@section('title', "Featured Subscriber")

@section('content')

<style>

.dataTables_filter {
  display: block;
}

</style>

<link rel="stylesheet" href="{{ asset('resources/css/chosen/choices.min.css') }}">

<div class="container-fluid">
  <div class="maintenancesection1">
    <div class="row">
     <div class="col-md-12">

      <div class="card shadow-none mt-5">
        <div class="card-header">
          <h6 style="float:left; margin-top:10px">Featured Subscriber</h6>
          <a type="button" class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#add-modal">{{ App\MaintenanceLocale::getLocale(35) }}</a>
        </div>
      </div>

      <!-- DataTales Example -->
      <div class="card shadow-none mb-4">
        <div class="card-body">
          <div class="row justify-row-content mt-3">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($subscribers as $subscriber)
                  <tr class="data-row">
                    <td>{{ $subscriber->id }}</td>
                    <td>{{ $subscriber->user ? $subscriber->user->rolesId == 4 ? $subscriber->user->school ? $subscriber->user->school->school : "" : $subscriber->user->employer ? $subscriber->user->employer->company : "" : "" }}</td>
                    <td>{{ $subscriber->user ? $subscriber->user->email : "" }}</td>
                    <td class="row">
                      <form action="/admin/featured/{{ $subscriber->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn primary" data-toggle="tooltip" data-placement="top" title="Delete">
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    </td>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label">{{ App\MaintenanceLocale::getLocale(35) }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('admin.featured.store') }}">
        @csrf
        <div class="modal-body" id="attachment-body-content">
          
          <div class="form-group">
            <label class="col-form-label" for="modal-input-name">Subscribers</label>
            <select id="subscribers" placeholder="Subscribers" multiple name="subscribers[]">
            @foreach($users as $user)
              @if($user->rolesId==4)
                  @if(!is_null($user->school))
                    <option value="{{$user->id}}">{{$user->school->school}}</option>
                  @endif
              @else
                  @if(!is_null($user->employer))
                    <option value="{{$user->id}}">{{$user->employer->company}}</option>
                  @endif
              @endif
            @endforeach
            </select>
          </div>
          
        </div>
        <div class="modal-footer">
          <button name="btnAdd" value="btnAdd" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(35) }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
      var multipleCancelButton = new Choices('#subscribers', {
        removeItemButton: true,
        noResultsText: '{{ App\MaintenanceLocale::getLocale(120) }}',
        noChoicesText: '{{ App\MaintenanceLocale::getLocale(357) }}',
        loadingText: '{{ App\MaintenanceLocale::getLocale(212) }}'
      });
  } );
</script>
<script src="{{ asset("resources/js/chosen/choices.min.js") }}"></script>

@endsection