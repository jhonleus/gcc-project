@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(224))

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/requirement-page.css') }}">

	<div class="container requirement-container" style="margin-bottom: 10%">
        <form method="POST" action="{{ route('requirement.store') }}" enctype="multipart/form-data">
            @csrf

			@if ($document3)
			    @if ($users->isActive == 0)
			        <div class="alert alert-info alert-block">
			            <strong>{{ App\MaintenanceLocale::getLocale(234) }}</strong>
			        </div>
			    @elseif ($users->isActive == 2)
			        <div class="alert alert-danger alert-block">
			            <strong>{{ App\MaintenanceLocale::getLocale(235) }}<br>
			                {{ App\MaintenanceLocale::getLocale(236) }}: <u>{{ $reason ? $reason->reason : '' }}</u>.<br>
			                {{ App\MaintenanceLocale::getLocale(237) }}
			            </strong>
			        </div>
			    @endif
			@else
			    <div class="alert alert-warning alert-block">
			        <strong style="font-size: 80%;">Note: In order to verify your registration, we are requiring you to submit documents such as follows:
			        <br>
		            For Sending & Research Support Organization - POEA Certifcate / Licence
			        <br>
		            For Accepting Company/Organization - Business Permit ("Toubokitouhon")
		        	</strong>
			    </div>
			@endif

	
			<div class="row d-flex justify-content-center">
				<div class="col-sm-12">
					<div class="card requirement-contents">
						<div class="card-header">
							<h4 class="requirement-title">{{ App\MaintenanceLocale::getLocale(228) }}</h4>
						</div>

						<div class="card-body">
        					@if ($document3)
							
							<div class="requirement-footer">
								<a href="{{url($document3->path.$document3->filename)}}" type="button" class="btn btn-info requirement-button" style="margin-top:15px;" target="_blank">{{ App\MaintenanceLocale::getLocale(200) }}</a>
							</div>

        					@else
        					<div class="requirement-forms">
								<h1 class="requirement-label">{{ App\MaintenanceLocale::getLocale(231) }}</h1>
        						
								<input type="file" id="document3" name="document3" accept="application/msword, application/pdf" hidden onchange="fileURL(this, 3);">
								<label for="document3" class="btn btn-light font-weight-normal">{{ App\MaintenanceLocale::getLocale(203) }}</label>
								<label id="filename3" style="display:none;"></label>
							</div>
        					@endif
						</div>
					</div>
				</div>				
			</div>

			@if (!$document3)
			    <button type="submit" style="margin-top:20px; width:200px; float:right" class="btn btn-primary register">{{ App\MaintenanceLocale::getLocale(232) }}</button>
			@elseif ($users->isActive == 2)
			    <button type="submit" name="resubmit" value="resubmit" style="margin-top:20px; width:200px; float:right" class="btn btn-danger register">{{ App\MaintenanceLocale::getLocale(413) }}</button>
			@elseif ($document3)
			    <button type="submit" name="resubmit" value="resubmit" style="margin-top:20px; width:200px; float:right" class="btn btn-danger register">{{ App\MaintenanceLocale::getLocale(413) }}</button>
			@endif
		</form>
	</div>

	@include('subscriber.modal')

	<script type="text/javascript">

		function fileURL(input, num) {
		
			if (input.files && input.files[0])
			{
				var name = document.getElementById('document' + num).files.item(0).name;
				document.getElementById('filename'+ num).style.display = "block";
				document.getElementById('filename'+ num).innerHTML = "{{ App\MaintenanceLocale::getLocale(202) }}: " + name;
			}
		}

		function fileURLs(input, num) {
		
			if (input.files && input.files[0])
			{
				var name = document.getElementById('documents' + num).files.item(0).name;
				document.getElementById('filenames'+ num).style.display = "block";
				document.getElementById('filenames'+ num).innerHTML = "{{ App\MaintenanceLocale::getLocale(202) }}: " + name;
			}
		}

	    $(document).on('click', '#download', function () {
	        
	        var basePath = window.location.origin;
	        var id = $(this).data('id');
	    
	        window.location = `${basePath}/requirement/download/${id}`;
	    });


	    $(".register").click(function(e) {
	    	var document1 = $('#document1').get(0).files.length;
	    		document2 = $('#document2').get(0).files.length;
	    		document3 = $('#document3').get(0).files.length;
	    		count = 0;	


	    	if(document1 !== 0) {
	    		count++;
	    	}

	    	if(document2 !== 0) {
	    		count++;
	    	}

	    	if(document3 !== 0) {
	    		count++;
	    	}

	    	if(document3 === 0) {
	    		e.preventDefault();
				Swal.fire(
				  '{{ App\MaintenanceLocale::getLocale(233) }}',
				  '',
				  'error'
				)
	    	}
	    })
	</script>
@endsection

