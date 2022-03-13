@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(512))

@section('content')
<style>

.dataTables_filter {
  display: block;
}

.imgs-home {
  height: 100px;
  width: 100px;
}

</style>
<div class="container-fluid">
  <div class="maintenancesection1">
    <div class="row">
     <div class="col-md-12">

      <h3 class="m-0 text-dark pt-3" style="float:left">{{ App\MaintenanceLocale::getLocale(512) }} </h3>

    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card shadow-none job-contents mt-3">
        <div class="nav-tabs-wrapper">
         <ul class="nav nav-tabs border-0" data-tabs="tabs">
          <li class="nav-item">
           <a class="nav-link active" href="#pending" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(272) }} <span class="badge badge-light ml-2">{{$pending->count()}}</span></a>
         </li>
         
         <li class="nav-item">
           <a class="nav-link" href="#approved" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(273) }} <span class="badge badge-light ml-2">{{$approves->count()}}</span></a>
         </li>
         
         <li class="nav-item">
           <a class="nav-link" href="#rejected" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(274) }} <span class="badge badge-light ml-2">{{$rejects->count()}}</span></a>
         </li>
         
         <li class="nav-item">
           <a class="nav-link" href="#resubmitted" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(411) }} <span class="badge badge-light ml-2">{{$resubmitted->count()}}</span></a>
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
                  <th>{{ App\MaintenanceLocale::getLocale(513) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(145) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(147) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(514) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(517) }} </th>
                  <th>{{ App\MaintenanceLocale::getLocale(30) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(515) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(516) }}</th>
                  <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                </tr>
              </thead>

              <tbody>
                @foreach($pending as $otc)
                <tr>
                  <td>{{$otc->transaction}}</td>
                  <td>{{$otc->employers->company}}</td>
                  <td>{{$otc->subscriptions->title}}</td>
                  <td>{{$otc->banks->name}}</td>
                  <td>{{$otc->name}}</td>
                  <td>{{$otc->date}}</td>
                  <td>{{$otc->amount}}</td>
                  <td><img class="imgs-home" src="/receipt/{{ $otc->receipt }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" style="cursor:zoom-in" onclick="window.open(this.src)"></td>
                  <td>
                    <form method="POST" action="{{ route('admin.over-the-counter.update', $otc->id) }}">
                    @method('PUT')
                    @csrf
                        <button type="button" class="btn btn-danger mt-2" id="edit-item" data-item-id="{{ $otc->id }}" data-item-userid="{{ $otc->usersId }}" style="float:right; width:100px">{{ App\MaintenanceLocale::getLocale(243) }}</button>
                        <button type="submit" class="btn btn-primary mt-2 mr-2" name="btnApprove" value="btnApprove" style="float:right; width:100px">{{ App\MaintenanceLocale::getLocale(244) }}</button>
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

  <div class="tab-pane" id="approved">
    <div class="card shadow-none-4">
      <div class="card-body">
        <div class="row justify-row-content mt-3">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" style="width:100%">
              <thead>
                <tr>
                    <th>{{ App\MaintenanceLocale::getLocale(513) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(145) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(147) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(514) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(517) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(30) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(515) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(516) }} </th>
                  </tr>
              </thead>
              
              <tbody>
                @foreach($approves as $otc)
                <tr>
                    <td>{{$otc->transaction}}</td>
                    <td>{{$otc->employers->company}}</td>
                    <td>{{$otc->subscriptions->title}}</td>
                    <td>{{$otc->banks->name}}</td>
                    <td>{{$otc->name}}</td>
                    <td>{{$otc->date}}</td>
                    <td>{{$otc->amount}}</td>
                    <td><img class="imgs-home" src="/receipt/{{ $otc->receipt }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" style="cursor:zoom-in" onclick="window.open(this.src)"></td>
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
    <div class="card shadow-none-4">
      <div class="card-body">
        <div class="row justify-row-content mt-3">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable3" style="width:100%">
              <thead>
                <tr>
                    <th>{{ App\MaintenanceLocale::getLocale(513) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(145) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(147) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(514) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(517) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(30) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(515) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(516) }} </th>
                  </tr>
              </thead>
              
              <tbody>
                @foreach($rejects as $otc)
                <tr>
                    <td>{{$otc->transaction}}</td>
                    <td>{{$otc->employers->company}}</td>
                    <td>{{$otc->subscriptions->title}}</td>
                    <td>{{$otc->banks->name}}</td>
                    <td>{{$otc->name}}</td>
                    <td>{{$otc->date}}</td>
                    <td>{{$otc->amount}}</td>
                    <td><img class="imgs-home" src="/receipt/{{ $otc->receipt }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" style="cursor:zoom-in" onclick="window.open(this.src)"></td>
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
    <div class="card shadow-none-4">
      <div class="card-body">
        <div class="row justify-row-content mt-3">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable4" style="width:100%">
              <thead>
                <tr>
                    <th>{{ App\MaintenanceLocale::getLocale(513) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(145) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(147) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(514) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(517) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(30) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(515) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(516) }} </th>
                    <th>{{ App\MaintenanceLocale::getLocale(33) }} </th>
                  </tr>
              </thead>
              
              <tbody>
                @foreach($resubmitted as $otc)
                <tr>
                    <td>{{$otc->transaction}}</td>
                    <td>{{$otc->employers->company}}</td>
                    <td>{{$otc->subscriptions->title}}</td>
                    <td>{{$otc->banks->name}}</td>
                    <td>{{$otc->name}}</td>
                    <td>{{$otc->date}}</td>
                    <td>{{$otc->amount}}</td>
                    <td><img class="imgs-home" src="/receipt/{{ $otc->receipt }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" style="cursor:zoom-in" onclick="window.open(this.src)"></td>
                    <td>
                      <form method="POST" action="{{ route('admin.over-the-counter.update', $otc->id) }}">
                      @method('PUT')
                      @csrf
                          <button type="button" class="btn btn-danger mt-2" id="edit-item" data-item-id="{{ $otc->id }}" data-item-userid="{{ $otc->usersId }}" style="float:right; width:100px">{{ App\MaintenanceLocale::getLocale(243) }}</button>
                          <button type="submit" class="btn btn-primary mt-2 mr-2" name="btnApprove" value="btnApprove" style="float:right; width:100px">{{ App\MaintenanceLocale::getLocale(244) }}</button>
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

</div>
</div>
</div>
</div>

<!-- The Modal -->
<div class="modal fade" id="edit-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST" id="edit-form" action="{{ route('admin.over-the-counter.store') }}">
          @csrf
          
          <div class="modal-header">
              <span>{{ App\MaintenanceLocale::getLocale(245) }}:</span>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <input type="hidden" name="modal-id" id="modal-input-id" class="form-control">
          <input type="hidden" name="modal-userid" id="modal-input-userid" class="form-control">

          <!-- Modal body -->
          <div class="modal-body">
              <textarea rows="5" name="txt_reason" class="mt-2 form-control" required></textarea>
          </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
              <button type="submit"  name="btnReject" value="btnReject" class="btn btn-danger">{{ App\MaintenanceLocale::getLocale(77) }}</button>
          </div>

      </form>
      
    </div>
  </div>
</div>

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
  
          // get the data
          var id = el.data('item-id');
          var userid = el.data('item-userid');
  
          // fill the data in the input fields
          $("#modal-input-id").val(id);
          $("#modal-input-userid").val(userid);
        })
  
      // on modal hide
      $('#edit-modal').on('hide.bs.modal', function() {
        $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $("#edit-form").trigger("reset");
      })
    });
  
  
  </script>
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