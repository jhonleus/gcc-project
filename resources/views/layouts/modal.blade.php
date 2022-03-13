<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ App\MaintenanceLocale::getLocale(64) }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>

          @if ($pagecontents->url)
          <div style="text-align: center" class="my-5">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$pagecontents->url}}?autoplay=1"></iframe>
         </div>
         @endif

        </div>
  </div>
</div>