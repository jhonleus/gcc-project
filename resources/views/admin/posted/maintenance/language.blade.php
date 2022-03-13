@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(282))

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
          <h6 style="float:left; margin-top:10px">{{ App\MaintenanceLocale::getLocale(282) }}</h6>
        </div>
      </div>

      <!-- DataTales Example -->
      <div class="card shadow-none mb-4">
        <div class="card-body">
          <div class="row justify-row-content mt-3">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable1">
                <thead>
                  <tr>
                    <th>{{ App\MaintenanceLocale::getLocale(34) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(283) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($extras as $extra)
                  <tr class="data-row">
                    <td class="name">{{ $extra->name }}</td>
                    <td class="translated">{{ $extra->translated }}</td>
                    <td><button title="{{ App\MaintenanceLocale::getLocale(36) }}" class="btn" type="button" id="edit-item" data-item-id="{{ $extra->id }}"><i class="fa fa-edit text-dark"></i></button></td>
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
      <form method="POST" id="edit-form" action="{{ route('admin.language.store') }}">
        @csrf
        <div class="modal-body" id="attachment-body-content">

          <input type="hidden" name="id" id="modal-input-id" class="form-control">
          
          <div class="form-group">
            <label class="col-form-label" for="modal-input-name">{{ App\MaintenanceLocale::getLocale(34) }}</label>
            <input type="text" name="name" class="form-control" id="modal-input-name" required>
          </div>

          <div class="form-group">
            <label class="col-form-label" for="modal-input-translated">{{ App\MaintenanceLocale::getLocale(283) }}</label>
            <input type="text" name="translated" class="form-control" id="modal-input-translated" required>
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

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
<script>

$(document).ready(function (){

$('#dataTable1').DataTable({
  "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
  "pageLength": 100,
 "language": {
   "decimal":        "",
   "emptyTable":     "{{ App\MaintenanceLocale::getLocale(205) }}",
   "info":           "{{ App\MaintenanceLocale::getLocale(118) }} _START_ {{ App\MaintenanceLocale::getLocale(206) }} _END_ {{ App\MaintenanceLocale::getLocale(207) }} _TOTAL_ {{ App\MaintenanceLocale::getLocale(208) }}",
   "infoEmpty":      "{{ App\MaintenanceLocale::getLocale(118) }} 0 {{ App\MaintenanceLocale::getLocale(206) }} 0 {{ App\MaintenanceLocale::getLocale(207) }} 0 {{ App\MaintenanceLocale::getLocale(208) }}",
   "infoFiltered":   "({{ App\MaintenanceLocale::getLocale(209) }} _MAX_ {{ App\MaintenanceLocale::getLocale(210) }})",
   "infoPostFix":    "",
   "thousands":      ",",
   "lengthMenu":     "{{ App\MaintenanceLocale::getLocale(211) }} _MENU_ {{ App\MaintenanceLocale::getLocale(208) }}",
   "loadingRecords": "{{ App\MaintenanceLocale::getLocale(212) }}",
   "processing":     "{{ App\MaintenanceLocale::getLocale(213) }}",
   "search":         "{{ App\MaintenanceLocale::getLocale(89) }}:",
   "zeroRecords":    "{{ App\MaintenanceLocale::getLocale(120) }}",
   "paginate": {
     "first":      "{{ App\MaintenanceLocale::getLocale(214) }}",
     "last":       "{{ App\MaintenanceLocale::getLocale(215) }}",
     "next":       "{{ App\MaintenanceLocale::getLocale(216) }}",
     "previous":   "{{ App\MaintenanceLocale::getLocale(217) }}"
   },
   "aria": {
     "sortAscending":  "{{ App\MaintenanceLocale::getLocale(218) }}",
     "sortDescending": "{{ App\MaintenanceLocale::getLocale(219) }}"
   }
 }
});

});

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
        var translated = row.children(".translated").text();

        // fill the data in the input fields
        $("#modal-input-id").val(id);
        $("#modal-input-name").val(name);
        $("#modal-input-translated").val(translated);
      })

    // on modal hide
    $('#edit-modal').on('hide.bs.modal', function() {
      $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
      $("#edit-form").trigger("reset");
    })
  });


</script>
@endsection