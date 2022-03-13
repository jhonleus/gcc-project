<!-- Modal -->

  <div class="modal fade" id="editProfession" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">View User's Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <label for="name">{{ __('ID') }}</label>
            </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val1" readonly>
          </div>
          <div class="row">
            <label for="name">{{ __('FullName') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val2" readonly>
          </div>
          <div class="row">
            <label for="name">{{ __('Age') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val3" readonly>
          </div>    
          <div class="row">
            <label for="name">{{ __('Gender') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val4" readonly>
          </div>    
          <div class="row">
            <label for="name">{{ __('City') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val5" readonly>
          </div>
          <div class="row">
            <label for="name">{{ __('Country') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val6" readonly>
          </div>
          <div class="row" style="margin-bottom: -8px;">
            <label for="name">{{ __('Certificates') }}</label>
          </div>
           <div class="row mt-2">
           <div class="modal_cert">
          </div>
          </div>
          
         
          
         {{--  @foreach($user->certificates() as $certificates)           
            <br>
            <a href="{{url($certificates->path.$certificates->filename )}}" ><button type="button" class="btn btn-primary">
            {{$certificates->filename}}</button>
            </a>
            <br>
          @endforeach --}}
        
           
          <div class="row">
            <label for="name">{{ __('Work Especialization') }}</label>
          </div>
         
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val8" readonly>

          </div>
          <div class="row">
            <label for="name">{{ __('Evaluation Test Result') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val9" readonly>
          </div>
           <div class="row">
            <label for="name">{{ __('Date Registered') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val10" readonly>
          </div>
          @error('name')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
<script>

// function that will allow the admin to view the specific certificate
  $("#download").click(function() {
      var basePath = window.location.origin;
      var id = $(this).data('id');

      window.location = `${basePath}/reports/applicantlist/download/${id}`;
    })

    $(".close-button").click(function() {
      $("#delete-work-button").remove();
    });

    $(".delete-work").click(function() {
      var id = $(this).attr("workId");
      $('#delete-modal').modal('show'); 
      $(".close-button").after(delete_work(id));
    });
</script>
     
