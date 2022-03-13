<!-- The Modal -->
<div class="modal fade" id="notificationModal">
    <div class="modal-dialog">
      <div class="modal-content">
            
            <!-- Modal body start -->
            <div class="modal-body p-0">
                <ul class="list-group">
                    @foreach ($registered2 as $user)
                    <li class="list-group-item"><i class="fa fa-user-plus  p-2 mr-2" style="border-radius: 50%; height: 30px; width: 30px; background-color: #1C98E0; color: white;"></i>{{ $user->firstName .' '. $user->lastName }} has been registered {{ $user->created_at->diffForHumans() }}.</li>
                    @endforeach
                </ul>
            </div>
            {{-- Modal body end --}}
            
      </div>
    </div>
  </div>