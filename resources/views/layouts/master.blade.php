<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>
  
  <!--displaying the company logo in browser's tab-->
  <link rel="shortcut icon" href="{{ asset('images/gcc icon-01.png') }}">

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--font-awesome cdn file-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  <!-- Admin Style -->
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/back.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <script src="{{ asset('resources/ckeditor/ckeditor.js') }}"></script>

</head>

<style>

  .dropdown-menu {
    min-width: 60px !important;
  }

  .table-bordered thead th, .table-bordered thead td {
    border-bottom-width: 1px;
}

/*notification icon*/
.fa-user-plus:before {
    content: "\f234";
    position: relative;
    top: -3px;
}
  
</style>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
     <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>



      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

      

        {{-- User Dropdown Menu --}}
        <li class="nav-item dropdown pr-2">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
             <i class="fa fa-bell fa-lg"></i>
             <span class="badge badge-danger navbar-badge">{{ $registered->total() }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-item ">
              <h5 class="m-0">
                <span class="float-right">
                  <a href="javascript: void(0);" class="text-dark">
                    <small>Clear All</small>
                  </a>
                </span>Notification
              </h5>
            </div>

            @foreach ($registered as $user)
              <p class="dropdown-item" style="overflow :hidden;
      white-space: nowrap; text-overflow: ellipsis;"><i class="fa fa-user-plus  p-2 mr-2" style="border-radius: 50%; height: 30px; width: 30px; background-color: #1C98E0; color: white;"></i>{{ $user->firstName .' '. $user->lastName }} {{App\MaintenanceLocale::getLocale(284)}}<br><small class="text-muted">{{ $user->created_at->diffForHumans() }}.</small></p>
            @endforeach

            @if ($registered->total() > 3)
            <div class="dropdown-divider"></div>
              <span class="dropdown-item dropdown-header" style="cursor:pointer" data-toggle="modal" data-target="#notificationModal">{{App\MaintenanceLocale::getLocale(285)}}</span>
            @endif
 
          </div>
       </li>

         {{-- User Dropdown Menu --}}
        <li class="nav-item dropdown pr-2" style="position: relative;top: 9px;">
              {{-- <a class="dropdown-toggle" id="btnaccount" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</a> --}}
              
              <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: block;border-radius: 50%; height: 25px; width: 25px; background-color: #EF2226;color: white;">
                <span style="font-size: 20px;margin-top: -12px;display: block;position: relative; left: -5px;">{!! Str::limit(Auth::user()->firstName, 1,'') !!}{{-- {!! Str::limit(Auth::user()->lastName, 1,'') !!} --}}</span>
                </a>

              <div class="dropdown-menu pt-2 pb-1" style=" right: auto;  left: -150%; -webkit-transform: translate(-50%, 0);-o-transform: translate(-50%, 0);transform: translate(-50%, 0);">
                <div class="mb-2" style="display: block;margin: 0px auto;background-color: red;height: 80px;width: 80px;border-radius: 50%;  background-position:center center;background-repeat: no-repeat;background-size: cover;"><span style="font-size: 50px;margin-top: -3px;display: block;color: white; text-align: center;">{!! Str::limit(Auth::user()->firstName, 1,'') !!}{{-- {!! Str::limit(Auth::user()->lastName, 1,'') !!} --}}</span></div>
                
                <p class="text-center font-weight-bold" style="font-size: 16px;">{!! ucfirst(Auth::user()->firstName) !!} {!! ucfirst(Auth::user()->lastName) !!}</p>
                <p class="text-center font-weight-light text-muted  pl-5 pr-5" style="font-size: 14px;">{{ Auth::user()->email }}</p>
                <div class="dropdown-divider"></div>
                <p class="text-center"><a class="dropdown-item" href="/admin/password">{{App\MaintenanceLocale::getLocale(137)}}</a></p>
                
                <div class="dropdown-divider"></div>
                <p class="text-center"><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" id="logout">{{ App\MaintenanceLocale::getLocale(114) }}</a></p>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
              </div>
            </li>

         <!-- ========================================= LANGUAGE ==================================================== -->
          @if ($check_locale)
          @if ($check_locale->token == csrf_token())
          @if ($check_locale->locale == 1)
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <img src="{{ asset('images/united-kingdom.svg')}}" width="20px;"><i class="fa fa-caret-down pl-2"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right animate slideIn">
              <a href="{{ url('locale/2') }}" class="dropdown-item" style="margin:0px auto; display: block;"><img src="{{ asset('images/japan.svg')}}" width="20px"  style="margin:0px auto; display: block;"></a>
            </div>
          </li>
          @else
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <img src="{{ asset('images/japan.svg')}}" width="20px;"><i class="fa fa-caret-down pl-2"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right animate slideIn">
              <a href="{{ url('locale/1') }}" class="dropdown-item" style="margin:0px auto; display: block;"><img src="{{ asset('images/united-kingdom.svg')}}" width="20px"  style="margin:0px auto; display: block;"></a>
            </div>
          </li>
          @endif
          @else
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <img src="{{ asset('images/united-kingdom.svg')}}" width="20px;"><i class="fa fa-caret-down pl-2"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right animate slideIn">
              <a href="{{ url('locale/2') }}" class="dropdown-item" style="margin:0px auto; display: block;"><img src="{{ asset('images/japan.svg')}}" width="20px"  style="margin:0px auto; display: block;"></a>
            </div>
          </li>
          @endif
          @else
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <img src="{{ asset('images/united-kingdom.svg')}}" width="20px;"><i class="fa fa-caret-down pl-2"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right animate slideIn">
              <a href="{{ url('locale/2') }}" class="dropdown-item" style="margin:0px auto; display: block;"><img src="{{ asset('images/japan.svg')}}" width="20px"  style="margin:0px auto; display: block;"></a>
            </div>
          </li>
          @endif
          <!-- ========================================= LANGUAGE ==================================================== -->
      </ul>
   </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <!-- Main content -->
      <section class="content" style="background-color:#F3F4F8;">
         @yield('content')
      </section>

      @include('admin.layouts.modal')
      <!-- /.content -->
   </div>
   <!-- /.content-wrapper -->
   <footer class="main-footer">
      <p class="text-center text-muted font-weight-lighter">Copyright &copy; 2014-2019 Global Career Creation. All rights reserved.</p>
   </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) 
<script src="{{ asset('js/pages/dashboard.js') }}"></script>-->

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/demo.js') }}"></script>
<!--datatable-->
<!--<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"></script>
datatable-->

<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">-->

<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<!--importing to excel and other functional buttons of data table-->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script> 

<!--datatable exporting button function-->
<script>

  $(document).ready(function(){
    var multipleCancelButton = new Choices('#affilations', {
      removeItemButton: true,
      noResultsText: '{{ App\MaintenanceLocale::getLocale(120) }}',
      noChoicesText: '{{ App\MaintenanceLocale::getLocale(357) }}',
      loadingText: '{{ App\MaintenanceLocale::getLocale(212) }}'
    });
  });
  //function of printing and downloading data from table
      $(document).ready(function() {
    $('#professionTable').DataTable( {
        dom: 'Bfrtip',
        "dom": '<"dt-buttons"Bf><"clear">lirtp',
      "paging": true,
      "autoWidth": true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

  //function of printing and downloading data from table
        $(document).ready(function() {
    $('#usersTable').DataTable( {
        dom: 'Bfrtip',
        "dom": '<"dt-buttons"Bf><"clear">lirtp',
      "paging": true,
      "autoWidth": true,
      
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

         //function of printing and downloading data from table
        $(document).ready(function() {
    $('#companiesTable').DataTable( {
        dom: 'Bfrtip',
        "dom": '<"dt-buttons"Bf><"clear">lirtp',
      "paging": true,
      "autoWidth": true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );


         //function of printing and downloading data from table
        $(document).ready(function() {
    $('#schoolsTable').DataTable( {
        dom: 'Bfrtip',
           "dom": '<"dt-buttons"Bf><"clear">lirtp',
      "paging": true,
      "autoWidth": true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

         //function of printing and downloading data from table
        $(document).ready(function() {
    $('#organizationTable').DataTable( {
        dom: 'Bfrtip',
        "dom": '<"dt-buttons"Bf><"clear">lirtp',
      "paging": true,
      "autoWidth": true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

  // blogs table
  //function of printing and downloading data from table
//           $(document).ready(function() {
//     $('#blogsTable').DataTable( {
//         dom: 'Bfrtip',
//         buttons: [
//             'copy', 'csv', 'excel', 'pdf', 'print'
//         ]
//     } );
// } );

</script>

<script>

  //pagination of the datatable
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>

<script>

$(document).ready(function() {
    $('#dataTable').DataTable({
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

<script>
  //Search functionality of data table 
  $(document).ready(function(){
    var dataTable = $('#feedbackTable1').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
  $(document).ready(function(){
    var dataTable = $('#feedbackTable2').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
  $(document).ready(function(){
    var dataTable = $('#feedbackTable3').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
  $(document).ready(function(){
    var dataTable = $('#feedbackTable4').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

  //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#usersTable').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#companiesTable').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

   //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#blogsTable').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#adminblogsTable1').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#adminblogsTable2').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#adminblogsTable3').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#adminblogsTable4').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#adminblogsTable5').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#schoolsTable').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

    //Search functionality of data table 
   $(document).ready(function(){
    var dataTable = $('#organizationTable').DataTable();

    $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
      });
    });

   // $(document).ready(function(){
   //  var dataTable = $('#salesTable').DataTable();

   //  $("#datasearchfield").on("keyup search input paste cut", function() {dataTable.search(this.value).draw();
   //    });
   //  });

</script>

<script>

//when the user hover to the icon the corresponding word will show to the buttons
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

</script>

<!--function of datatable-->
<script type="text/javascript">
    $(document).ready(function (){
        var table = $("#feedbackTable2").DataTable();
       
        table.on('click', '.openEdit', function (){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
 
            $('#message').val(data[1]);
            $('#editFeedback').modal('show');
        });
    });

    $(document).ready(function (){
        var table = $("#feedbackTable3").DataTable();
       
        table.on('click', '.openEdit', function (){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
 
            $('#message').val(data[1]);
            $('#editFeedback').modal('show');
        });
    });

    $(document).ready(function (){
        var table = $("#feedbackTable4").DataTable();
       
        table.on('click', '.openEdit', function (){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
 
            $('#message').val(data[1]);
            $('#editFeedback').modal('show');
        });
    });

    $(document).ready(function (){
        var table = $("#adminblogsTable1").DataTable();
       
        table.on('click', '.openEdit', function (){
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
        var table = $("#adminblogsTable2").DataTable();
       
        table.on('click', '.openEdit', function (){
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
        var table = $("#adminblogsTable3").DataTable();
       
        table.on('click', '.openEdit', function (){
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
        var table = $("#adminblogsTable4").DataTable();
       
        table.on('click', '.openEdit', function (){
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
        var table = $("#adminblogsTable5").DataTable();
       
        table.on('click', '.openEdit', function (){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
 
            $('#message').val(data[2]);
            $('#editFeedback').modal('show');
        });
    });

     $(document).ready(function (){
        var table = $("#usersTable").DataTable();
       
        table.on('click', '.openEdit', function (){
          var row = $(this).attr('row');
          certificate = $('.certificates'+row).html();
           $(".modal_cert").html(certificate);
          console.log(certificate);
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            //console.log(data);
            //console.log(data[0] + data[2]);

            $('#name_val1').val(data[0]);  
            $('#name_val2').val(data[1]);
            $('#name_val3').val(data[2]);
            $('#name_val4').val(data[3]);
            $('#name_val5').val(data[4]);
            $('#name_val6').val(data[5]);
            $('#name_val7').val(data[6]);
            $('#name_val8').val(data[7]);
            $('#name_val9').val(data[8]);
            $('#name_val10').val(data[9]);
            $('#name_val11').val(data[10]);
             $('#name_val12').val(data[11]);
            $('#feedback_status').val(data[11]);
            $('#editProfessionForm').attr('action', 'feedback/' + data['0']);
            $('#editProfession').modal('show');
        });
    });

      $(document).ready(function (){
        var table = $("#companiesTable").DataTable();
       
        table.on('click', '.openEdit', function (){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            console.log(data);
            console.log(data[0] + data[2]);

            $('#name_val1').val(data[0]);  
            $('#name_val2').val(data[1]);
            $('#name_val3').val(data[2]);
            $('#name_val4').val(data[3]);
            $('#name_val5').val(data[4]);
            $('#name_val6').val(data[5]);
            $('#name_val7').val(data[6]);
            $('#name_val8').val(data[7]);
            $('#name_val9').val(data[8]);
            $('#feedback_status').val(data[8]);
            $('#editProfessionForm').attr('action', 'feedback/' + data['0']);
            $('#editCompanylist').modal('show');
        });
    });

      $(document).ready(function (){
        var table = $("#blogsTable").DataTable();
       
        table.on('click', '.openEdit', function (){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            console.log(data);
            console.log(data[0] + data[2]);

            $('#name_val1').val(data[0]);  
            $('#name_val2').val(data[1]);
            $('#name_val3').val(data[2]);
            $('#name_val4').val(data[3]);
            $('#blog_status').val(data[5]);
            $('#editBlogForm').attr('action', 'usersblog/' + data['0']);
            $('#editBlog').modal('show');
        });
    });

       $(document).ready(function (){
        var table = $("#adminblogsTable").DataTable();
       
        table.on('click', '.openEdit', function (){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            console.log(data);
            console.log(data[0] + data[2]);

            $('#name_val1').val(data[0]);  
            $('#name_val2').val(data[1]);
            $('#name_val3').val(data[2]);
            $('#name_val4').val(data[3]);
            $('#editBlogForm').attr('action', 'usersblog/' + data['0']);
            $('#editadminblogs').modal('show');
        });
    });

        $(document).ready(function (){
        var table = $("#schoolsTable").DataTable();
       
        table.on('click', '.openEdit', function (){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            console.log(data);
            console.log(data[0] + data[2]);

            $('#name_val1').val(data[0]);  
            $('#name_val2').val(data[1]);
            $('#name_val3').val(data[2]);
            $('#name_val4').val(data[3]);
            $('#name_val5').val(data[4]);
            $('#name_val6').val(data[5]);
            $('#name_val7').val(data[6]);
            $('#name_val8').val(data[7]);
            $('#editBlogForm').attr('action', 'usersblog/' + data['0']);
            $('#editSchoolslist').modal('show');
        });
    });


         $(document).ready(function (){
        var table = $("#organizationTable").DataTable();
       
        table.on('click', '.openEdit', function (){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            console.log(data);
            console.log(data[0] + data[2]);

            $('#name_val1').val(data[0]);  
            $('#name_val2').val(data[1]);
            $('#name_val3').val(data[2]);
            $('#name_val4').val(data[3]);
            $('#name_val5').val(data[4]);
            $('#name_val6').val(data[5]);
            $('#name_val7').val(data[6]);
            $('#name_val8').val(data[7]);
            $('#editBlogForm').attr('action', 'usersblog/' + data['7']);
            $('#editOrganizationlist').modal('show');
        });
    });

</script>


<script>
  /*function of date range*/
  $(document).ready(function(){
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
});

 //this will load the data to the data table 
 load_data();

function load_data(from_date = '', to_date = '')
{
  $('#salesTable').DataTable({
  processing: true,
  serverSide: true,
  pageLength: 100,

   ajax: {
    data:{from_date:from_date, to_date:to_date}
   },
   columns: [
    {
     data:'id',
     name:'id'
    },
     {
     data:'Subscription Type',
     name:'Subscription Type'
    },
    {
     data:'Amount',
     name:'Amount'
    },
    {
     data:'Payment Status',
     name:'Payment Status'
    },
    {
     data:'Mode of Payment',
     name:'Mode of Payment'
    },
    {
     data:'Subscription Date',
     name:'Subscription Date'
    },
    {
     data:'Subscription Expiry Date',
     name:'Subscription Expiry Date'
    },
    {
     data:'Number of Subscription',
     name:'Number of Subscription'
    },



   ],
   
   /*functionality of saving to excel and downloading the file */
    dom: 'Bfrtip', buttons: [
    'excel', 'pdf', 'print'
    ],

  });


}

//filtering the date of the records that users want to know.
 $('#filter').click(function(){

  var from_date = $('#from_date').val();

  var to_date = $('#to_date').val();

  if(from_date != '' &&  to_date != '')
  {

   $('#salesTable').DataTable().destroy();

   load_data(from_date, to_date);

  }
  else
  {

   alert('Both Date is required');

  }
 });

//function of refresh button in date range to clear the previous or old data from input type of data range
$('#refresh').click(function(){

$('#from_date').val('');

$('#to_date').val('');

$('#salesTable').DataTable().destroy();

  load_data();

});

});



</script>

<!--sweet alert cdn-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@include('sweetalert::alert')

<!--chartjs cdn js-->
<script src="https://cdnjs.com/libraries/Chart.js"></script>
<script src="https://www.jsdelivr.com/package/npm/chart.js?path=dist"></script>

</body>
</html>