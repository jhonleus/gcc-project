@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(62))

@section('content')
	<!-- CSS FOR FAQ-->
	<link rel="stylesheet" href="{{ asset('css/content-page/faq-page.css') }}">

	<div class="container faq-container">
		<h3 class="faq-page-title">{{ App\MaintenanceLocale::getLocale(62) }}</h3>
		<h1 class="faq-label-line"></h1>
		<div class="card faq-contents">
			<label class="faq-title">{{ App\MaintenanceLocale::getLocale(117) }}</label>
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text"> 
						<i class="fa fa-search" aria-hidden="true"></i>
					</div>
				</div>
				
				<input type="text" class="form-control" id="search-help-input">
			</div>

			<div class="faq-content-result" style="display:none">
				<div class="faq-content-results">
					<h3 class="faq-search">{{ App\MaintenanceLocale::getLocale(119) }}</h3>
					<ul class="categories_ul">
						@foreach ($faqs as $faq)
						<li class="showContent faq-search-result" id="showContent{{$faq->id}}">
							<div>
								<i class="fa fa-plus"></i>
								{{$faq->question}}
							</div>
						</li>
						<li class="showContent{{$faq->id}} row1 divContent faq-search-answer" style="display:none">
							<div>{!!$faq->answer!!}</div>
						</li>
						@endforeach
						<li id="no_record" class="faq-no-result">{{ App\MaintenanceLocale::getLocale(120) }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<script>
		$("#search-help-input").on("keyup", function() {
	    	var value   = $(this).val().toLowerCase();
				a       = $(".faq-content-results ul .showContent").filter(function() {
		             	$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		         	});

	    	if(value!=="") {
	    		$(".faq-content-result").removeAttr('style');
			 	$("#no_record").hide();
	    		
			 	if($(".showContent").is(':visible') === true) {
			 		$("#no_record").hide();
			 	} else {
			 		$("#no_record").show();
			 	}
	    	} else {
	    		$(".faq-content-result").attr('style', 'display:none');
	    	}
		});

		$(".showContent").click(function() {
				id = $(this).attr("id");
		    $("."+id+".divContent").slideToggle('slow', callback(id));
		});

		function callback(id) {
		    if($('.'+id+".divContent").is(':visible') === true) {
		    	$("#"+id+" i").attr('class', 'fa fa-plus');
		    } 
		    else {
		    	$("#"+id+" i").attr('class', 'fa fa-minus');
		    }
		}
	</script>
@endsection