<!-- Modal -->
  <div class="modal fade" id="editCompanylist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">View company Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <label for="name">{{ __('Company ID') }}</label>
            </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val1" readonly>
          </div>
          <div class="row">
            <label for="name">{{ __('Company Name') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val2" readonly>
          </div>
          <div class="row">
            <label for="name">{{ __('Industry') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val3" readonly>
          </div>
           <div class="row">
            <label for="name">{{ __('City') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val4" readonly>
          </div>
           <div class="row">
            <label for="name">{{ __('Country') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val5" readonly>
          </div>
           <div class="row">
            <label for="name">{{ __('Type of Company') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val6" readonly>
          </div>
          <div class="row">
            <label for="name">{{ __('Subscription Type') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val7" readonly>
          </div>    
          <div class="row">
            <label for="name">{{ __('Status') }}</label>
          </div>
          <div class="row mt-2">
            <input type="text" class="form-control" id="name_val8" readonly>
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
