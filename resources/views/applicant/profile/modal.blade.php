<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route('applicant.profile.store') }}" method="POST" enctype="multipart/form-data" style="width:100%">
            @csrf
            
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">{{ App\MaintenanceLocale::getLocale(430) }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <p class="container row">{{ App\MaintenanceLocale::getLocale(240) }}</p>
            <input type="file" id="resumes" name="resume" accept="application/msword, application/pdf" onchange="resumesURL(this);" style="margin-top:5%" required hidden>
            <label for="resumes" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
						<label id="resumesName" style="display:none;"></label>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" name="btnResume" value="btnResume" class="btn btn-danger">{{ App\MaintenanceLocale::getLocale(239) }}</button>
        </div>

        </form>
        
      </div>
    </div>
  </div>

  <!-- The Modal -->
<div class="modal fade" id="myTattoo">
  <div class="modal-dialog">
    <div class="modal-content">
          
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{ App\MaintenanceLocale::getLocale(435) }}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">

          <?php $total = 0; ?>
          @foreach($tattoos as $tattoo)
          @if ($tattoo->filetype == "tattoo")
          <div class="card-body" style="border-style: groove; margin-top:5px;">
          <span style="float:left">#<?php $total++; echo $total; ?></span>
            <form action="/applicant/profile/{{ $tattoo->id }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(151) }}')">
              @csrf
              @method('DELETE')
              <button style="background:none; border: none; float:right; color:red; cursor:pointer"><i class="fa fa-trash"></i> {{ App\MaintenanceLocale::getLocale(37) }}</button>
            </form>

            <img class="imgs" id="image" style="width:100%; margin-top:10px" src="{{ asset($tattoo->path ."". $tattoo->filename) }}" ><br><br>
            <b>{{ App\MaintenanceLocale::getLocale(238) }}:</b><br>{{ $tattoo->updated_at }}<br>
            
          </div>
        
          @endif
          @endforeach

      </div>
      
    </div>
  </div>
</div>