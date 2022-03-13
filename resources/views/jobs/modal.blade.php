<!-- The Modal -->
<div class="modal fade" id="applyModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          
            @if ($resume)
            <form method="POST" action="{{ route('applicant.applied.store') }}">
              @csrf
                <input type="text" value="{{Crypt::encrypt($jobs->usersId)}}" name="companyId" hidden>
                <input type="text" value="{{Crypt::encrypt($jobs->id)}}" name="jobId" hidden>
                <button name="btnProfile" value="btnProfile" style="width:100%" class="btn btn-primary">Select Resume From Profile</button>
                <h6 class="my-3" style="text-align: center">---------- OR ----------<h6>
             </form>
            @endif

            <form method="POST" action="{{ route('applicant.applied.store') }}"  enctype="multipart/form-data">
              @csrf
                <input type="text" value="{{Crypt::encrypt($jobs->usersId)}}" name="companyId" hidden>
                <input type="text" value="{{Crypt::encrypt($jobs->id)}}" name="jobId" hidden>
                <input type="file" style="width:100%" required name="resume" accept="application/msword, application/pdf">
                <button name="btnUpload" value="btnUpload" style="width:100%" class="btn btn-primary mt-4">Upload a Resume</button>
            </form>

        </div>
      </div>
    </div>
  </div>