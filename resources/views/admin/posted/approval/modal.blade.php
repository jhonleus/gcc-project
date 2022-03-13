<!-- The Modal -->
<div class="modal fade" id="exampleModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <form method="POST" action="{{ route('admin.approval.update', $id) }}">
            @method('PUT')
            @csrf
            
            <div class="modal-header">
                <span>{{ App\MaintenanceLocale::getLocale(245) }}:</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

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