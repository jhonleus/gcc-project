@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(13))

@section('content')

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<style>
.imgs-cover {
 height: 100px;
 width: 100px;
}
.dataTables_filter {
  display: block;
}
</style>

<div class="container-fluid">
   <br>
   <div class="row">
      <div class="col-sm-12">
         <h3 class="m-0 text-dark" style="float:left">{{ App\MaintenanceLocale::getLocale(13) }}</h3>
         <a href="{{ url('admin/blog/create')}}"><button class="btn btn-primary" style="float:right">{{ App\MaintenanceLocale::getLocale(277) }}</button></a>
      </div>
   </div>

   <div class="card job-contents mt-3 shadow-none">
      <div class="nav-tabs-wrapper">
         <ul class="nav nav-tabs border-0" data-tabs="tabs">
            <li class="nav-item">
               <a class="nav-link active" href="#pending" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(272) }} <span class="badge badge-light ml-2">{{$pendings->count()}}</span></a>
            </li>

            <li class="nav-item">
               <a class="nav-link" href="#approved" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(273) }} <span class="badge badge-light ml-2">{{$approveds->count()}}</span></a>
            </li>

            <li class="nav-item">
               <a class="nav-link" href="#rejected" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(274) }} <span class="badge badge-light ml-2">{{$rejecteds->count()}}</span></a>
            </li>

            <li class="nav-item">
               <a class="nav-link" href="#displayed" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(275) }} <span class="badge badge-light ml-2">{{$displayeds->count()}}</span></a>
            </li>

            <li class="nav-item">
               <a class="nav-link" href="#posted" data-toggle="tab">{{ App\MaintenanceLocale::getLocale(276) }} <span class="badge badge-light ml-2">{{$admins->count()}}</span></a>
            </li>
         </ul>
      </div>
   </div>

   <div class="tab-content">
      <div class="tab-pane active" id="pending">
         <div class="row justify-row-content mt-3">
            <div class="col-md-12">
               <div class="card shadow-none">
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="dataTable1" class="table table-bordered" style="width:100%">
                           <thead>
                              <tr>
                                 <th>{{ App\MaintenanceLocale::getLocale(34) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(31) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(32) }}</th>
                                 <th style="display:none">{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(279) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(260) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($pendings as $blog)
                              <tr>
                                 <td>{{$blog->users->firstName ." ". $blog->users->lastName}}</td>
                                 <td>{{$blog->title}}</td>
                                 <td>{{$blog->subtitle}}</td>
                                 <td style="display:none">{{$blog->content}}</td>
                                 <td>{{ strlen($blog->content) > 150 ? str_limit($blog->content,150) : ''}} @if(strlen($blog->content) > 150) <span style="color:blue; cursor:pointer" class="blogView">{{ App\MaintenanceLocale::getLocale(280) }}</span> @endif</td>
                                 <td><img src="{{ asset('blogs/'.$blog->filename) }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" class="imgs-cover" style="cursor:zoom-in" onclick="window.open(this.src)"></td>

                                 <td>{{ date('m/d/Y', strtotime( $blog->created_at )) }}</td>
                                 <td class="d-flex">
                                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(264) }}')">
                                       @csrf
                                       @method('PUT')
                                       <button name="btnApprove" value="btnApprove" title="{{ App\MaintenanceLocale::getLocale(244) }}" style="background:none; border: none; float:right; color:green"><i class="fa fa-check-circle-o"></i></button>
                                    </form>
                                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(263) }}')">
                                       @csrf
                                       @method('PUT')
                                       <button name="btnReject" value="btnReject" title="{{ App\MaintenanceLocale::getLocale(243) }}" style="background:none; border: none; float:right; color:red"><i class="fa fa-ban"></i></button>
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

      <div class="tab-pane" id="approved">

         <div class="alert alert-info alert-block">
            <strong>{{ App\MaintenanceLocale::getLocale(270) }} 5 {{ App\MaintenanceLocale::getLocale(281) }} ({{ $displayeds->count()}}/5) <label style="color:red">{{ $displayeds->count() >= 5 ? App\MaintenanceLocale::getLocale(267) : ''}}</label></strong>
         </div>

         <div class="row justify-row-content mt-3">
            <div class="col-md-12">
               <div class="card shadow-none">
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="dataTable2" class="table table-bordered" style="width:100%">
                           <thead>
                              <tr>
                                 <th>{{ App\MaintenanceLocale::getLocale(34) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(31) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(32) }}</th>
                                 <th style="display:none">{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(279) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(260) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($approveds as $blog)
                              <tr>
                                 <td>{{$blog->users->firstName ." ". $blog->users->lastName}}</td>
                                 <td>{{$blog->title}}</td>
                                 <td>{{$blog->subtitle}}</td>
                                 <td style="display:none">{{$blog->content}}</td>
                                 <td>{{ strlen($blog->content) > 150 ? str_limit($blog->content,150) : ''}} @if(strlen($blog->content) > 150) <span style="color:blue; cursor:pointer" class="blogView">{{ App\MaintenanceLocale::getLocale(280) }}</span> @endif</td>
                                 <td><img src="{{ asset('blogs/'.$blog->filename) }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" class="imgs-cover" style="cursor:zoom-in" onclick="window.open(this.src)"></td>
                                 
                                 <td>{{ date('m/d/Y', strtotime( $blog->created_at )) }}</td>
                                 <td class="d-flex">
                                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(261) }}')">
                                       @csrf
                                       @method('PUT')
                                       <button name="btnDisplay" value="btnDisplay" title="{{ App\MaintenanceLocale::getLocale(299) }}" style="background:none; border: none; float:right; color:blue"><i class="fa fa-share"></i></button>
                                    </form>
                                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(262) }}')">
                                       @csrf
                                       @method('PUT')
                                       <button name="btnPending" value="btnPending" title="{{ App\MaintenanceLocale::getLocale(300) }}" style="background:none; border: none; float:right; color:green"><i class="fa fa-recycle"></i></button>
                                    </form>
                                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(263) }}')">
                                       @csrf
                                       @method('PUT')
                                       <button name="btnReject" value="btnReject" title="{{ App\MaintenanceLocale::getLocale(243) }}" style="background:none; border: none; float:right; color:red"><i class="fa fa-ban"></i></button>
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

      <div class="tab-pane" id="rejected">
         <div class="row justify-row-content mt-3">
            <div class="col-md-12">
               <div class="card shadow-none">
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="dataTable3" class="table table-bordered" style="width:100%">
                           <thead>
                              <tr>
                                 <th>{{ App\MaintenanceLocale::getLocale(34) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(31) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(32) }}</th>
                                 <th style="display:none">{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(279) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(260) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($rejecteds as $blog)
                              <tr>
                                 <td>{{$blog->users->firstName ." ". $blog->users->lastName}}</td>
                                 <td>{{$blog->title}}</td>
                                 <td>{{$blog->subtitle}}</td>
                                 <td style="display:none">{{$blog->content}}</td>
                                 <td>{{ strlen($blog->content) > 150 ? str_limit($blog->content,150) : ''}} @if(strlen($blog->content) > 150) <span style="color:blue; cursor:pointer" class="blogView">{{ App\MaintenanceLocale::getLocale(280) }}</span> @endif</td>
                                 <td><img src="{{ asset('blogs/'.$blog->filename) }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" class="imgs-cover" style="cursor:zoom-in" onclick="window.open(this.src)"></td>
                                 
                                 <td>{{ date('m/d/Y', strtotime( $blog->created_at )) }}</td>
                                 <td class="d-flex">
                                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(262) }}')">
                                       @csrf
                                       @method('PUT')
                                       <button name="btnPending" value="btnPending" title="{{ App\MaintenanceLocale::getLocale(300) }}" style="background:none; border: none; float:right; color:green"><i class="fa fa-recycle"></i></button>
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

      <div class="tab-pane" id="displayed">
         <div class="row justify-row-content mt-3">
            <div class="col-md-12">
               <div class="card shadow-none">
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="dataTable4" class="table table-bordered" style="width:100%">
                           <thead>
                              <tr>
                                 <th>{{ App\MaintenanceLocale::getLocale(34) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(31) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(32) }}</th>
                                 <th style="display:none">{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(279) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(260) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($displayeds as $blog)
                              <tr>
                                 <td>{{$blog->users ? $blog->users->firstName ." ". $blog->users->lastName : 'Admin'}}</td>
                                 <td>{{$blog->title}}</td>
                                 <td>{{$blog->subtitle}}</td>
                                 <td style="display:none">{{$blog->content}}</td>
                                 <td>{{ strlen($blog->content) > 150 ? str_limit($blog->content,150) : ''}} @if(strlen($blog->content) > 150) <span style="color:blue; cursor:pointer" class="blogView">{{ App\MaintenanceLocale::getLocale(280) }}</span> @endif</td>
                                 <td><img src="{{ asset('blogs/'.$blog->filename) }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" class="imgs-cover" style="cursor:zoom-in" onclick="window.open(this.src)"></td>
                                 <td>{{ date('m/d/Y', strtotime( $blog->created_at )) }}</td>
                                 <td class="d-flex">
                                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(265) }}')">
                                       @csrf
                                       @method('PUT')
                                       <button name="btnUnDisplay" value="btnUnDisplay" title="{{ App\MaintenanceLocale::getLocale(301) }}" style="background:none; border: none; float:right; color:red"><i class="fa fa-ban"></i></button>
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

      <div class="tab-pane" id="posted">

         <div class="alert alert-info alert-block">
            <strong>{{ App\MaintenanceLocale::getLocale(270) }} 5 {{ App\MaintenanceLocale::getLocale(281) }} ({{ $displayeds->count()}}/5) <label style="color:red">{{ $displayeds->count() >= 5 ? App\MaintenanceLocale::getLocale(267) : ''}}</label></strong>
         </div>
         
         <div class="row justify-row-content mt-3">
            <div class="col-md-12">
               <div class="card shadow-none">
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="dataTable5" class="table table-bordered" style="width:100%">
                           <thead>
                              <tr>
                                 <th>{{ App\MaintenanceLocale::getLocale(31) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(32) }}</th>
                                 <th style="display:none">{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(278) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(279) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(260) }}</th>
                                 <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($admins as $blog)
                              <tr>
                                 <td>{{$blog->title}}</td>
                                 <td>{{$blog->subtitle}}</td>
                                 <td style="display:none">{{$blog->content}}</td>
                                 <td>{{ strlen($blog->content) > 150 ? str_limit($blog->content,150) : ''}} @if(strlen($blog->content) > 150) <span style="color:blue; cursor:pointer" class="blogView">{{ App\MaintenanceLocale::getLocale(280) }}</span> @endif</td>
                                 <td><img src="{{ asset('blogs/'.$blog->filename) }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" class="imgs-cover" style="cursor:zoom-in" onclick="window.open(this.src)"></td>
                                 <td>{{ date('m/d/Y', strtotime( $blog->created_at )) }}</td>
                                 <td class="d-flex">
                                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(261) }}')">
                                       @csrf
                                       @method('PUT')
                                       <button name="btnDisplay" value="btnDisplay" title="{{ App\MaintenanceLocale::getLocale(299) }}" style="background:none; border: none; float:right; color:blue"><i class="fa fa-share"></i></button>
                                    </form>
                                    <form action="/admin/blog/{{ $blog->id }}" method="POST" onsubmit="return confirm('Are you sure want to delete this blog?')">
                                       @csrf
                                       @method('DELETE')
                                       <button title="Delete" style="background:none; border: none; float:right; color:red"><i class="fa fa-trash"></i></button>
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
@include('admin.blog.modals')

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

       $('#dataTable5').DataTable({
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
   
   $(document).ready(function (){
           var table = $("#dataTable1").DataTable();
          
           table.on('click', '.blogView', function (){
               $tr = $(this).closest('tr');
               if ($($tr).hasClass('child')){
                   $tr = $tr.prev('.parent');
               }
               var data = table.row($tr).data();
    
               $('#message').val(data[3]);
               $('#editFeedback').modal('show');
           });
   });
   
   $(document).ready(function (){
           var table = $("#dataTable2").DataTable();
          
           table.on('click', '.blogView', function (){
               $tr = $(this).closest('tr');
               if ($($tr).hasClass('child')){
                   $tr = $tr.prev('.parent');
               }
               var data = table.row($tr).data();
    
               $('#message').val(data[3]);
               $('#editFeedback').modal('show');
           });
   });
   
   $(document).ready(function (){
           var table = $("#dataTable3").DataTable();
          
           table.on('click', '.blogView', function (){
               $tr = $(this).closest('tr');
               if ($($tr).hasClass('child')){
                   $tr = $tr.prev('.parent');
               }
               var data = table.row($tr).data();
    
               $('#message').val(data[3]);
               $('#editFeedback').modal('show');
           });
   });
   
   $(document).ready(function (){
           var table = $("#dataTable4").DataTable();
          
           table.on('click', '.blogView', function (){
               $tr = $(this).closest('tr');
               if ($($tr).hasClass('child')){
                   $tr = $tr.prev('.parent');
               }
               var data = table.row($tr).data();
    
               $('#message').val(data[3]);
               $('#editFeedback').modal('show');
           });
   });

   $(document).ready(function (){
           var table = $("#dataTable5").DataTable();
          
           table.on('click', '.blogView', function (){
               $tr = $(this).closest('tr');
               if ($($tr).hasClass('child')){
                   $tr = $tr.prev('.parent');
               }
               var data = table.row($tr).data();
    
               $('#message').val(data[2]);
               $('#editFeedback').modal('show');
           });
   });
</script>
@endsection