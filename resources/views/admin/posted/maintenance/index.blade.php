@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(18))

@section('content')

<style>
.imgs-logo {
  height: 64px;
  width: 321px;
}

.imgs-about {
  height: 400px;
  width: 400px;
}

.imgs-home {
  height: 100px;
  width: 100px;
}

.dataTables_filter {
  display: block;
}

</style>

<script src="{{ asset('resources/js/jquery.min.js') }}"></script>

<div class="container-fluid">
  <div class="maintenancesection1">

   <div class="row pt-5">
    <div class="col-lg-6">

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(162) }}</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">

            <div class="row">
              <div class="col-lg-12">
                <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(288) }}:</label>
                <img class="mb-3" src="/login-images/{{ $pagecontents->head }}" style="width:100%; height:200px;"> 

                <input accept="image/*" type="file" class="form-control-file" id="photo_home0" name="photo_home0" onchange="homeURL(this, 0);" hidden/>
                <label for="photo_home0" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
                
                <label id="homePreview0" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
                <img class="mt-1 mb-2" id="homeimage0" style="display:none; width:100%; height:200px;">

              </div>
            </div>

            <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(509) }}:</label>

            <div class="row">
              <div class="col-lg-12">
                <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(190) }} 1:</label>
                <img class="mb-3" src="/login-images/{{ $pagecontents->picture1 }}" style="width:100%; height:200px;"> 

                <input accept="image/*" type="file" class="form-control-file" id="photo_home1" name="photo_home1" onchange="homeURL(this, 1);" hidden/>
                <label for="photo_home1" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
                
                <label id="homePreview1" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
                <img class="mt-1 mb-2" id="homeimage1" style="display:none; width:100%; height:200px;">

              </div>
            </div>

            <div class="row">
            <div class="col-lg-12">
              <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(190) }} 2:</label>
              <img class="mb-3" src="/login-images/{{ $pagecontents->picture2 }}" style="width:100%; height:200px;"> 

              <input accept="image/*" type="file" class="form-control-file" id="photo_home2" name="photo_home2" onchange="homeURL(this, 2);" hidden/>
              <label for="photo_home2" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
              
              <label id="homePreview2" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
              <img class="mt-1 mb-2" id="homeimage2" style="display:none; width:100%; height:200px;">

            </div>
          </div>
            
            <div class="form-group mt-3">
              <label for="check_users">{{ App\MaintenanceLocale::getLocale(406) }}</label>
              <input type="checkbox" name="check_users" id="check_users" class="mt-1 ml-1" {{ $pagecontents->users == 1 ? 'checked' : '' }}>
            </div>

          </div>
          <div class="card-footer bg-white">
            <button type="submit" name="btnHome" value="btnHome" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
          </div>
        </form>
      </div> 
      <!-- // Card -->

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(168) }}</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(178) }}:</label>
              <img src="/company_logo/{{ $company_logo->photo_name }}" class="imgs-logo"> 

              <label class="text-muted small mt-3" style="width:100%;">{{ App\MaintenanceLocale::getLocale(179) }}</label>
              <input accept="image/*" type="file" class="form-control-file" required id="photo_name" name="photo_name" onchange="readURL(this);" hidden/>
              <label for="photo_name" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
              
              <label id="textPreview" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
              <img class="imgs-logo mt-1" id="image" style="display:none;">
            </div>
          </div>
          <div class="card-footer bg-white">
            <button type="submit" name="btnLogo" value="btnLogo" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
          </div>
        </form>
      </div> 
      <!-- // Card -->

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(170) }}</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="form-group">

              <div class="row">
                <div class="col-lg-12">
                  

                  <!-- PICTURE 1 -->
                  
                  <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(190) }} 1:</label>
                  <img src="/login-images/{{ $about1->picture }}" style="width:100%; height:200px;" title="{{ App\MaintenanceLocale::getLocale(298) }}" style="cursor:zoom-in" onclick="window.open(this.src)"> 

                  <input accept="image/*" type="file" class="form-control-file" id="photo_name1" name="photo_name1" onchange="readURLs(this, 1);" hidden/>
                  <label for="photo_name1" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>

                  <label id="textPreview1" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
                  <img class="mt-1" id="image1" style="display:none; width:100%; height:200px;">
                  
                </div>
              </div>
              <div class="row">

                <div class="col-lg-12">
                  <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(190) }} 2:</label>
                  <img src="/login-images/{{ $about2->picture }}" style="width:100%; height:200px;" title="{{ App\MaintenanceLocale::getLocale(298) }}" style="cursor:zoom-in" onclick="window.open(this.src)"> 

                  <input accept="image/*" type="file" class="form-control-file" id="photo_name2" name="photo_name2" onchange="readURLs(this, 2);" hidden/>
                  <label for="photo_name2" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
                  
                  <label id="textPreview2" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
                  <img class="mt-1" id="image3" style="display:none; width:100%; height:200px;">

                </div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-white">
            <button type="submit" name="btnAbout" value="btnAbout" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
          </div>
        </form>
      </div> 
      <!-- // Card -->

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(502) }}</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(190) }}:</label>
              <img src="/login-images/{{ $pagecontents->login }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" onclick="window.open(this.src)" style="cursor:zoom-in; width:auto; height:200px; display: block; margin: 0px auto;"> 

              <input accept="image/*" type="file" class="form-control-file" required id="photo_other1" name="photo_other1" onchange="otherURL(this, 1);" hidden/>
              <label for="photo_other1" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
              
              <label id="otherPreview1" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
              <img class="mt-1" id="otherimage1" style="display:none; width:100%; height:200px;">
            </div>
          </div>
          <div class="card-footer bg-white">
            <button type="submit" name="btnLogin" value="btnLogin" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
          </div>
        </form>
      </div> 
      <!-- // Card -->

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(523) }}</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(190) }}:</label>
              <img src="/login-images/{{ $pagecontents->register }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" onclick="window.open(this.src)" style="cursor:zoom-in; width:auto; height:200px; display: block; margin: 0px auto;"> 

              <input accept="image/*" type="file" class="form-control-file" required id="photo_other4" name="photo_other4" onchange="otherURL(this, 4);" hidden/>
              <label for="photo_other4" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
              
              <label id="otherPreview4" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
              <img class="mt-1" id="otherimage4" style="display:none; width:100%; height:200px;">
            </div>
          </div>
          <div class="card-footer bg-white">
            <button type="submit" name="btnReg" value="btnReg" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
          </div>
        </form>
      </div> 
      <!-- // Card -->

    </div>

    <div class="col-lg-6">

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(164) }} (NDA)</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">

            @if ($nda) 
            {{ App\MaintenanceLocale::getLocale(201) }}: 
            <div class="mt-1 p-2" style="border-style: groove;">
              <b>{{ App\MaintenanceLocale::getLocale(202) }}:</b> {{ $nda->file }}<br>
            </div>
            @endif

            <input type="file" name="nda" id="nda" class="form-control-file mt-3" accept="application/pdf" onchange="ndaURL(this);" required hidden>
            <label for="nda" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
            <label id="ndaName" style="display:none;"></label>
          </div>

          <div class="card-footer bg-white">
            <button type="submit" name="btnNDA" value="btnNDA" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
            @if ($nda) <button type="button" id="download" class="btn btn-primary" data-id="{{ $nda->id }}">{{ App\MaintenanceLocale::getLocale(200) }}</button> @endif
          </div>
        </form>
      </div> 
      <!-- // Card -->

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(169) }}</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label>{{ App\MaintenanceLocale::getLocale(185) }}:</label>
              <input type="text" name="address" class="form-control" required value="{{ $customerservicesupports->address }}">
            </div>
            <div class="form-group">
              <label>{{ App\MaintenanceLocale::getLocale(41) }}:</label>
              <input type="email" name="email" class="form-control" required value="{{ $customerservicesupports->email }}">
            </div>
            <div class="form-group">
              <label>{{ App\MaintenanceLocale::getLocale(100) }}</label>
              <input type="password" name="password" class="form-control" required value="{{ $customerservicesupports->password }}">
              
            </div>
            <div class="form-group">
              <label>{{ App\MaintenanceLocale::getLocale(187) }}</label>
              <input type="number" name="phone" class="form-control" required value="{{ $customerservicesupports->phone }}">
            </div>
            <div class="form-group">
              <label>{{ App\MaintenanceLocale::getLocale(188) }}</label>
              <input type="number" name="telephone" class="form-control" required value="{{ $customerservicesupports->telephone }}">
            </div>
          </div> 
          <div class="card-footer bg-white">
            <button type="submit" name="btnService" value="btnService" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
          </div>
        </form>
      </div> 
      <!-- // Card  -->

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(64) }}</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}">
          @csrf
          @method('PUT')
          <div class="card-body">

            <div class="form-group">
              <label>{{ App\MaintenanceLocale::getLocale(223) }}</label>
              <div class="row">
                <img class="my-auto" src="/images/Info_100px.png" style="width:30px; height:30px; cursor:pointer" data-toggle="modal" data-target="#myModal"> 
                <input type="text" name="pageurl" class="form-control col-lg-9 ml-2" required placeholder="{{ App\MaintenanceLocale::getLocale(248) }}" value="{{ $pagecontents->url ? $pagecontents->url : '' }}">
              </div>
            </div>
            
          </div>

          <!-- The Modal -->
          <div class="modal fade" id="myModal">
            <div class="modal-dialog">
              <div class="modal-content">
                
                <!-- Modal body -->
                <div class="modal-body">

                  <p><b>(1)</b> {{ App\MaintenanceLocale::getLocale(249) }} <a href="https://www.youtube.com/" target="_blank">Youtube</a> {{ App\MaintenanceLocale::getLocale(250) }}</p>

                  <p><b>(2)</b> {{ App\MaintenanceLocale::getLocale(251) }}</p>
                  <img src="/images/tutorial.png" style="width:100%; height:100px">
                  
                  <p><b>(3)</b> {{ App\MaintenanceLocale::getLocale(252) }}</p>
                  <img src="/images/tutorial2.png" style="width:100%; height:200px">

                  <p><b>(4)</b> {{ App\MaintenanceLocale::getLocale(253) }}</p>
                  <img src="/images/tutorial3.png" style="width:100%; height:300px">
                  
                </div>
                
              </div>
            </div>
          </div>
          
          <div class="card-footer bg-white">
            <button type="submit" name="btnHow" value="btnHow" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
          </div>
        </form>
      </div> 
      <!-- // Card  -->

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(504) }}</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(190) }}:</label>
              <img src="/login-images/{{ $pagecontents->contact }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" onclick="window.open(this.src)" style="cursor:zoom-in; width:auto; height:200px; display: block; margin: 0px auto;"> 

              <input accept="image/*" type="file" class="form-control-file" required id="photo_other2" name="photo_other2" onchange="otherURL(this, 2);" hidden/>
              <label for="photo_other2" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
              
              <label id="otherPreview2" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
              <img class="mt-1" id="otherimage2" style="display:none; width:100%; height:200px;">
            </div>
          </div>
          <div class="card-footer bg-white">
            <button type="submit" name="btnContact" value="btnContact" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
          </div>
        </form>
      </div> 
      <!-- // Card -->

      <!-- Card -->
      <div class="card shadow-none">
        <div class="card-header border-bottom-0">
          <b>{{ App\MaintenanceLocale::getLocale(503) }}</b>
        </div>
        <form method="post" action="{{ route('admin.maintenance.update', 1)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label class="text-muted small" style="width:100%;">{{ App\MaintenanceLocale::getLocale(190) }}:</label>
              <img src="/login-images/{{ $pagecontents->feedback }}" title="{{ App\MaintenanceLocale::getLocale(298) }}" onclick="window.open(this.src)" style="cursor:zoom-in; width:auto; height:200px; display: block; margin: 0px auto;"> 

              <input accept="image/*" type="file" class="form-control-file" required id="photo_other3" name="photo_other3" onchange="otherURL(this, 3);" hidden/>
              <label for="photo_other3" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
              
              <label id="otherPreview3" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
              <img class="mt-1" id="otherimage3" style="display:none; width:100%; height:200px;">
            </div>
          </div>
          <div class="card-footer bg-white">
            <button type="submit" name="btnFeedback" value="btnFeedback" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(38) }}</button>
          </div>
        </form>
      </div> 
      <!-- // Card -->


    </div> <!-- // Col-lg-6 -->
  </div> <!-- // Row -->

  <!-- DataTales Example -->
  <div class="card shadow-none mb-4">
    <div class="card-body">
      <div class="row justify-row-content mt-3">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable">
            <thead>
              <tr>
                <th hidden>{{ App\MaintenanceLocale::getLocale(34) }}</th>
                <th hidden>{{ App\MaintenanceLocale::getLocale(283) }}</th>
                <th>{{ App\MaintenanceLocale::getLocale(34) }}</th>
                <th>{{ App\MaintenanceLocale::getLocale(283) }}</th>
                <th>{{ App\MaintenanceLocale::getLocale(33) }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($extras as $extra)
              <tr class="data-row">
                <td class="name" hidden>{!! $extra->name !!}</td>
                <td class="translated" hidden>{!! $extra->translated !!}</td>
                <td>{!! strlen($extra->name) > 200 ? str_limit($extra->name, 200) : $extra->name !!}</td>
                <td>{!! strlen($extra->translated) > 200 ? str_limit($extra->translated, 200) : $extra->translated !!}</td>
                <td><button title="{{ App\MaintenanceLocale::getLocale(36) }}" class="btn" type="button" id="edit-item" data-item-id="{{ $extra->id }}"><i class="fa fa-edit text-dark"></i></button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

</div> <!-- // Maintenance Section -->
</div> <!-- // Container-fluid -->

<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label">{{ App\MaintenanceLocale::getLocale(36) }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="edit-form" action="{{ route('admin.maintenance.store') }}">
        @csrf
        <div class="modal-body" id="attachment-body-content">

          <input type="hidden" name="locale_id" id="modal-input-id" class="form-control">

          
          
          <div class="form-group">
            <label class="col-form-label" for="modal-input-name">{{ App\MaintenanceLocale::getLocale(34) }}</label>

            <div id="ckeditor-why">
              <textarea class="txtarea-size-2" name="locale_name" id="modal-input-name" required></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-form-label" for="modal-input-translated">{{ App\MaintenanceLocale::getLocale(283) }}</label>

            <div id="ckeditor-why">
              <textarea class="txtarea-size-2" name="locale_translated" id="modal-input-translated" required></textarea>
            </div>
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

<script>

CKEDITOR.replace("modal-input-name");
CKEDITOR.replace("modal-input-translated");

$(document).on('click', '#download', function () {

  var basePath = window.location.origin;
  var id = $(this).data('id');

  window.location = `${basePath}/admin/maintenance/download/${id}`;
});

function ndaURL(input) {
  
  if (input.files && input.files[0])
  {
    var name = document.getElementById('nda').files.item(0).name;
    document.getElementById('ndaName').style.display = "block";
    document.getElementById('ndaName').innerHTML = "{{ App\MaintenanceLocale::getLocale(202) }}: " + name;
  }
}

function otherURL(input, num) {
  
  if (input.files && input.files[0])
  {
    var reader = new FileReader();
    reader.onload = function (e)
    {
      document.getElementById('otherimage' + num).style.display = "";
      document.getElementById('otherPreview' + num).style.display = "block";
      $('#otherimage' + num).attr('src',e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
    
  }
}

function readURL(input) {
  
  if (input.files && input.files[0])
  {
    var reader = new FileReader();
    reader.onload = function (e)
    {
      document.getElementById('image').style.display = "";
      document.getElementById('textPreview').style.display = "block";
      $('#image').attr('src',e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
    
  }
}


function readURLs(input, num) {
  
  if (input.files && input.files[0])
  {
    var reader = new FileReader();
    reader.onload = function (e)
    {
      document.getElementById('image' + num).style.display = "";
      document.getElementById('textPreview' + num).style.display = "block";
      $('#image' + num).attr('src',e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
    
  }
}

function homeURL(input, num) {
  
  if (input.files && input.files[0])
  {
    var reader = new FileReader();
    reader.onload = function (e)
    {
      document.getElementById('homeimage' + num).style.display = "";
      document.getElementById('homePreview' + num).style.display = "block";
      $('#homeimage' + num).attr('src',e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
    
  }
}

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
      CKEDITOR.instances['modal-input-name'].setData(name);
      CKEDITOR.instances['modal-input-translated'].setData(translated);
    })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
});

</script>
@endsection

