@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(24))

@section('content')

<style>

.dataTables_filter {
  display: block;
}

</style>

<div class="container-fluid">
  <div class="maintenancesection1">
    <div class="row">
     <div class="col-md-12">

      <div class="card shadow-none mt-5">
        <div class="card-header">
          <h6 style="float:left; margin-top:10px">{{ App\MaintenanceLocale::getLocale(24) }}</h6>
          <button type="button" class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#add-modal">{{ App\MaintenanceLocale::getLocale(35) }}</button>
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
                    <th>{{ App\MaintenanceLocale::getLocale(34) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($extras as $extra)
                  <tr class="data-row">
                    <td class="name">{{ $extra->name }}</td>
                    <td>
                      <form action="/admin/industries/{{ $extra->id }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(151) }}')">
                        @csrf
                        @method('DELETE')
                       <button title="{{ App\MaintenanceLocale::getLocale(36) }}" class="btn" type="button" id="edit-item" data-item-id="{{ $extra->id }}"><i class="fa fa-edit text-dark "></i></button>
                        <button class="btn " title="{{ App\MaintenanceLocale::getLocale(37) }}"><i class="fa fa-trash text-dark "></i></button>
                      </form>
                      
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
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label">{{ App\MaintenanceLocale::getLocale(36) }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="edit-form" action="{{ route('admin.industries.store') }}">
        @csrf
        <div class="modal-body" id="attachment-body-content">

          <input type="hidden" name="id" id="modal-input-id" class="form-control">
          
          <div class="form-group">
            <label class="col-form-label" for="modal-input-name">{{ App\MaintenanceLocale::getLocale(34) }}</label>
            <input type="text" name="name" class="form-control" id="modal-input-name" required autofocus>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" name="btnUpdate" value="btnUpdate" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- // Edit Modal -->

<!-- Add Modal -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label">{{ App\MaintenanceLocale::getLocale(35) }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('admin.industries.store') }}">
        @csrf
        <div class="modal-body" id="attachment-body-content">
          
          <div class="form-group">
            <label class="col-form-label" for="modal-input-name">{{ App\MaintenanceLocale::getLocale(34) }}</label>
            <input type="text" name="name" class="form-control" required autofocus>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" name="btnAdd" value="btnAdd" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(35) }}</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- // Add Modal -->

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
<script>
$(document).ready(function() {

  $(document).on('click', "#edit-item", function() {
        $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

        var options = {
          'backdrop': 'static'
        };
        $('#edit-modal').modal()
      })

    // on modal show
    $('#edit-modal').on('show.bs.modal', function() {
        var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
        var row = el.closest(".data-row");

        // get the data
        var id = el.data('item-id');
        var name = row.children(".name").text();

        // fill the data in the input fields
        $("#modal-input-id").val(id);
        $("#modal-input-name").val(name);
      })

    // on modal hide
    $('#edit-modal').on('hide.bs.modal', function() {
      $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
      $("#edit-form").trigger("reset");
    })
  });


</script>
@endsection