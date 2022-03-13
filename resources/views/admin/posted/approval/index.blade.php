@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(10))

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

      <h3 class="m-0 text-dark pt-3" style="float:left">{{ App\MaintenanceLocale::getLocale(10) }} </h3>

    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card job-contents mt-3 shadow-none">
        <div class="nav-tabs-wrapper">
         <ul class="nav nav-tabs border-0" data-tabs="tabs">
          <li class="nav-item">
           <a class="nav-link active" href="#pending" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(272) }} <span class="badge badge-light ml-2">{{$pending}}</span></a>
         </li>
         
         <li class="nav-item">
           <a class="nav-link" href="#approved" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(273) }} <span class="badge badge-light ml-2">{{$approved}}</span></a>
         </li>
         
         <li class="nav-item">
           <a class="nav-link" href="#rejected" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(274) }} <span class="badge badge-light ml-2">{{$rejected}}</span></a>
         </li>
         
         <li class="nav-item">
           <a class="nav-link" href="#resubmitted" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(411) }} <span class="badge badge-light ml-2">{{$resubmitted}}</span></a>
         </li>
       </ul>
     </div>
   </div>
 </div>
</div>

<div class="tab-content">
  <div class="tab-pane active" id="pending">
    <div class="card shadow-none mb-4">
      <div class="card-body">
        <div class="row justify-row-content mt-3">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable1" style="width:100%">
              <thead>
                <tr>
                  <th>{{ App\MaintenanceLocale::getLocale(73) }} </th>
                  <th>{{ App\MaintenanceLocale::getLocale(39) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(40) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(41) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(42) }}</th>
                </tr>
              </thead>

              <tbody>
                @foreach($dpendings as $document)
                
                <tr>
                  <td>@if ($document->requirements->rolesId == 2) {{ App\MaintenanceLocale::getLocale(79) }} 
                  @elseif ($document->requirements->rolesId == 3) {{ App\MaintenanceLocale::getLocale(80) }} 
                  @elseif ($document->requirements->rolesId == 4) {{ App\MaintenanceLocale::getLocale(81) }} 
                  @endif
                  </td>
                  <td>{{ $document->requirements->firstName }}</td>
                  <td>{{ $document->requirements->lastName }}</td>
                  <td>{{ $document->requirements->email }}</td>
                  <td><a href="/admin/approval/{{Crypt::encrypt($document->usersId)}}" class="btn btn-default register">{{ App\MaintenanceLocale::getLocale(204) }}</button></td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="tab-pane" id="approved">
    <div class="card shadow-none mb-4">
      <div class="card-body">
        <div class="row justify-row-content mt-3">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" style="width:100%">
              <thead>
                <tr>
                  <th>{{ App\MaintenanceLocale::getLocale(73) }} </th>
                  <th>{{ App\MaintenanceLocale::getLocale(39) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(40) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(41) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(42) }}</th>
                </tr>
              </thead>
              
              <tbody>
                @foreach($dapproves as $document)
                <tr>
                  <td>@if ($document->requirements->rolesId == 2) {{ App\MaintenanceLocale::getLocale(79) }} 
                    @elseif ($document->requirements->rolesId == 3) {{ App\MaintenanceLocale::getLocale(80) }} 
                    @elseif ($document->requirements->rolesId == 4) {{ App\MaintenanceLocale::getLocale(81) }} 
                    @endif
                  </td>
                  <td>{{ $document->requirements->firstName }}</td>
                  <td>{{ $document->requirements->lastName }}</td>
                  <td>{{ $document->requirements->email }}</td>
                  <td><a href="/admin/approval/{{Crypt::encrypt($document->usersId)}}" class="btn btn-default register">{{ App\MaintenanceLocale::getLocale(204) }}</button></td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
  </div>

  <div class="tab-pane" id="rejected">
    <div class="card shadow-none mb-4">
      <div class="card-body">
        <div class="row justify-row-content mt-3">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable3" style="width:100%">
              <thead>
                <tr>
                  <th>{{ App\MaintenanceLocale::getLocale(73) }} </th>
                  <th>{{ App\MaintenanceLocale::getLocale(39) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(40) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(41) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(42) }}</th>
                </tr>
              </thead>
              
              <tbody>
                @foreach($drejects as $document)
                
                <tr>
                  <td>@if ($document->requirements->rolesId == 2) {{ App\MaintenanceLocale::getLocale(79) }} 
                    @elseif ($document->requirements->rolesId == 3) {{ App\MaintenanceLocale::getLocale(80) }} 
                    @elseif ($document->requirements->rolesId == 4) {{ App\MaintenanceLocale::getLocale(81) }} 
                    @endif
                  </td>
                  <td>{{ $document->requirements->firstName }}</td>
                  <td>{{ $document->requirements->lastName }}</td>
                  <td>{{ $document->requirements->email }}</td>
                  <td><a href="/admin/approval/{{Crypt::encrypt($document->usersId)}}" class="btn btn-default register">{{ App\MaintenanceLocale::getLocale(204) }}</button></td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
  </div>

  <div class="tab-pane" id="resubmitted">
    <div class="card shadow-none mb-4">
      <div class="card-body">
        <div class="row justify-row-content mt-3">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable4" style="width:100%">
              <thead>
                <tr>
                  <th>{{ App\MaintenanceLocale::getLocale(73) }} </th>
                  <th>{{ App\MaintenanceLocale::getLocale(39) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(40) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(41) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(42) }}</th>
                </tr>
              </thead>
              
              <tbody>
                @foreach($dresubmits as $document)
                
                <tr>
                  <td>@if ($document->requirements->rolesId == 2) {{ App\MaintenanceLocale::getLocale(79) }} 
                    @elseif ($document->requirements->rolesId == 3) {{ App\MaintenanceLocale::getLocale(80) }} 
                    @elseif ($document->requirements->rolesId == 4) {{ App\MaintenanceLocale::getLocale(81) }} 
                    @endif
                  </td>
                  <td>{{ $document->requirements->firstName }}</td>
                  <td>{{ $document->requirements->lastName }}</td>
                  <td>{{ $document->requirements->email }}</td>
                  <td><a href="/admin/approval/{{Crypt::encrypt($document->usersId)}}" class="btn btn-default register">{{ App\MaintenanceLocale::getLocale(204) }}</button></td>
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
</div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
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
  
      $('#dataTable2').DataTable({
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
  
      $('#dataTable3').DataTable({
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
  
      $('#dataTable4').DataTable({
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