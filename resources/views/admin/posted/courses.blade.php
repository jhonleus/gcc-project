@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(462))

@section('content')

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
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
          <h6 style="float:left; margin-top:10px">{{ App\MaintenanceLocale::getLocale(462) }}</h6>
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
                    <th>{{ App\MaintenanceLocale::getLocale(490) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(402) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(84) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(463) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(464) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(465) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(466) }}</th>
                    <th>{{ App\MaintenanceLocale::getLocale(148) }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($courses as $course)
                  <tr>
                    <td>{{ $course->employers->school }}</td>
                    <td>{{ $course->course }}</td>
                    <td>{{ $course->country->nicename }}</td>
                    <td>{{ $course->currency->name }} {{ $course->fee }}</td>
                    <td>{{ date('F d, Y', strtotime($course->class_start)) }}</td>
                    <td>{{ date('F d, Y', strtotime($course->class_end)) }}</td>
                    <td>{{ $course->created_at }}</td>
                    <td>@if ($course->isActive == 1 && $course->isDeleted == 0) 
                      <span class="badge badge-success">{{ App\MaintenanceLocale::getLocale(360) }}</span>
                      @elseif ($course->isActive == 0 && $course->isDeleted == 0)
                      <span class="badge badge-secondary">{{ App\MaintenanceLocale::getLocale(361) }}</span>
                      @elseif ($course->isActive == 0 && $course->isDeleted == 1)
                      <span class="badge badge-danger">{{ App\MaintenanceLocale::getLocale(472) }}</span>
                      @endif
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
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="readmore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

    <div class="modal-header">
        <font id="title"></font>
    </div>
      <div class="modal-body">
        <div class="container">
            <label id="message"></label>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function (){

  $('#dataTable1').DataTable({
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

</script>
@endsection