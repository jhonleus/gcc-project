<!-- The Modal -->
<div class="modal fade" id="myModal1">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route('requirement.store') }}" method="POST" enctype="multipart/form-data" style="width:100%">
            @csrf
            
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">{{ App\MaintenanceLocale::getLocale(229) }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <p>{{ App\MaintenanceLocale::getLocale(240) }}</p>
            <input type="file" id="documents1" name="document1" accept="application/msword, application/pdf" style="margin-top:5%" onchange="fileURLs(this, 1);" required hidden>
            <label for="documents1" class="btn btn-default font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
						<p id="filenames1" style="display:none;"></p>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(239) }}</button>
        </div>

        </form>
        
      </div>
    </div>
  </div>

  <!-- The Modal -->
<div class="modal fade" id="myModal2">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route('requirement.store') }}" method="POST" enctype="multipart/form-data" style="width:100%">
            @csrf
            
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">{{ App\MaintenanceLocale::getLocale(230) }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <p>{{ App\MaintenanceLocale::getLocale(240) }}</p>
            <input type="file" id="documents2" name="document2" accept="application/msword, application/pdf" style="margin-top:5%" onchange="fileURLs(this, 2);" required hidden>
            <label for="documents2" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
						<p id="filenames2" style="display:none;"></p>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(239) }}</button>
        </div>

        </form>
        
      </div>
    </div>
  </div>

    <!-- The Modal -->
<div class="modal fade" id="myModal3">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route('requirement.store') }}" method="POST" enctype="multipart/form-data" style="width:100%">
            @csrf
            
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">{{ App\MaintenanceLocale::getLocale(231) }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <p>{{ App\MaintenanceLocale::getLocale(240) }}</p>
            <input type="file" id="documents3" name="document3" accept="application/msword, application/pdf" style="margin-top:5%" onchange="fileURLs(this, 3);" required hidden>
            <label for="documents3" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
						<p id="filenames3" style="display:none;"></p>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(239) }}</button>
        </div>

        </form>
        
      </div>
    </div>
  </div>
