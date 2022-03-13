@extends('layouts.header')

@section('title', 'Rating')

@section('content')
	<!-- CSS FOR FRONT RATINGS-->
	<link rel="stylesheet" href="{{ asset('resources/css/custom/stars.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/rating-page.css') }}">

	<div class="container rating-container">
		<form action="{{ route('rate.store') }}" method="POST" id="form">
		    @csrf
		<input type="hidden" value="{{$encrypt}}" name="companyId">
		<div class="card rating-contents">
			<div class="card-header rating-header">
				<label class="rating-title">
					How would you rate the {{ $class }} on the following:
				</label>
			</div>
			<div class="card-body">
				<div class="rating-forms">
					<h1 class="rating-label">{{$fee}}</h1>
					<input type="hidden" class="fees_rate" name="fees_rate">
					<div class='rating-stars text-center'>
						<ul id='fees_rate'>
							<li class='star' title='Poor' data-value='1'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Fair' data-value='2'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Good' data-value='3'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Excellent' data-value='4'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='WOW!!!' data-value='5'>
								<i class='fa fa-star fa-fw'></i>
							</li>
						</ul>
					</div>

					<div class="error-container">
						<label class="label-error error-fees">{{$fee}} is required.</label>
					</div>
				</div>

				<div class="rating-forms">
					<h1 class="rating-label">{{$class}} Environment</h1>
					<input type="hidden" class="environment_rate" name="environment">
					<div class='rating-stars text-center'>
						<ul id='environment_rate'>
							<li class='star' title='Poor' data-value='1'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Fair' data-value='2'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Good' data-value='3'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Excellent' data-value='4'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='WOW!!!' data-value='5'>
								<i class='fa fa-star fa-fw'></i>
							</li>
						</ul>
					</div>

					<div class="error-container">
						<label class="label-error error-environment">{{$class}} Environment is required.</label>
					</div>
				</div>

				<div class="rating-forms">
					<input type="hidden" class="growth_rate" name="career_growth">
					<h1 class="rating-label">Career Growth Development</h1>
					<div class='rating-stars text-center'>
						<ul id='growth_rate'>
							<li class='star' title='Poor' data-value='1'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Fair' data-value='2'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Good' data-value='3'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Excellent' data-value='4'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='WOW!!!' data-value='5'>
								<i class='fa fa-star fa-fw'></i>
							</li>
						</ul>
					</div>

					<div class="error-container">
						<label class="label-error error-career">Career Growth Development is required.</label>
					</div>
				</div>

				<div class="rating-forms">
					<h1 class="rating-label">{{$class}} Security</h1>
					<input type="hidden" class="security_rate" name="security">
					<div class='rating-stars text-center'>
						<ul id='security_rate'>
							<li class='star' title='Poor' data-value='1'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Fair' data-value='2'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Good' data-value='3'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Excellent' data-value='4'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='WOW!!!' data-value='5'>
								<i class='fa fa-star fa-fw'></i>
							</li>
						</ul>
					</div>

					<div class="error-container">
						<label class="label-error error-security">{{$class}} Security is required.</label>
					</div>
				</div>

				<div class="rating-forms">
					<h1 class="rating-label">{{$env}}</h1>
					<input type="hidden" class="relation_rate" name="relation">
					<div class='rating-stars text-center'>
						<ul id='relation_rate'>
							<li class='star' title='Poor' data-value='1'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Fair' data-value='2'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Good' data-value='3'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='Excellent' data-value='4'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star' title='WOW!!!' data-value='5'>
								<i class='fa fa-star fa-fw'></i>
							</li>
						</ul>
					</div>

					<div class="error-container">
						<label class="label-error error-relation">{{$env}} is required.</label>
					</div>
				</div>

				<div class="rating-footer">
					<button class="btn rating-button btn-primary" id="save_button">Save</button>
				</div>
			</div>
		</div>
		</form>
	</div>

	<script>
		$('#fees_rate li').on('mouseover', function() {
			var onStar = parseInt($(this).data('value'), 10);

			$(this).parent().children('li.star').each(function(e) {
				if (e < onStar) {
					$(this).addClass('hover');
				}
				else {
					$(this).removeClass('hover');
				}
			});
		}).on('mouseout', function() {
			$(this).parent().children('li.star').each(function(e){
				$(this).removeClass('hover');
			});
		});
		 
		$('#fees_rate li').on('click', function() {
			$(".error-fees").hide();

			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var fees_rate 	= parseInt($('#fees_rate li.selected').last().data('value'), 10);

			$(".fees_rate").val(fees_rate);

		});
		 
		$('#environment_rate li').on('mouseover', function() {
			var onStar = parseInt($(this).data('value'), 10);

			$(this).parent().children('li.star').each(function(e) {
				if (e < onStar) {
					$(this).addClass('hover');
				}
				else {
					$(this).removeClass('hover');
				}
			});
		}).on('mouseout', function() {
			$(this).parent().children('li.star').each(function(e){
				$(this).removeClass('hover');
			});
		});
		 
		$('#environment_rate li').on('click', function() {
			$(".error-environment").hide();

			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var environment_rate 	= parseInt($('#environment_rate li.selected').last().data('value'), 10);

			$(".environment_rate").val(environment_rate);

		});

		$('#growth_rate li').on('mouseover', function() {
			var onStar = parseInt($(this).data('value'), 10);

			$(this).parent().children('li.star').each(function(e) {
				if (e < onStar) {
					$(this).addClass('hover');
				}
				else {
					$(this).removeClass('hover');
				}
			});
		}).on('mouseout', function() {
			$(this).parent().children('li.star').each(function(e){
				$(this).removeClass('hover');
			});
		});
		 
		$('#growth_rate li').on('click', function() {
			$(".error-career").hide();

			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var growth_rate 	= parseInt($('#growth_rate li.selected').last().data('value'), 10);

			$(".growth_rate").val(growth_rate);
		});

		$('#security_rate li').on('mouseover', function() {
			var onStar = parseInt($(this).data('value'), 10);

			$(this).parent().children('li.star').each(function(e) {
				if (e < onStar) {
					$(this).addClass('hover');
				}
				else {
					$(this).removeClass('hover');
				}
			});
		}).on('mouseout', function() {
			$(this).parent().children('li.star').each(function(e){
				$(this).removeClass('hover');
			});
		});
		 
		$('#security_rate li').on('click', function() {
			$(".error-security").hide();

			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var security_rate 	= parseInt($('#security_rate li.selected').last().data('value'), 10);

			$(".security_rate").val(security_rate);
		});

		$('#relation_rate li').on('mouseover', function() {
			var onStar = parseInt($(this).data('value'), 10);

			$(this).parent().children('li.star').each(function(e) {
				if (e < onStar) {
					$(this).addClass('hover');
				}
				else {
					$(this).removeClass('hover');
				}
			});
		}).on('mouseout', function() {
			$(this).parent().children('li.star').each(function(e){
				$(this).removeClass('hover');
			});
		});
		 
		$('#relation_rate li').on('click', function() {
			$(".error-relation").hide();

			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var relation_rate 	= parseInt($('#relation_rate li.selected').last().data('value'), 10);

			$(".relation_rate").val(relation_rate);
		});

		$("#save_button").click(function(e) {
			var fees 			= $(".fees_rate").val();
				environment 	= $(".environment_rate").val();
				career_growth 	= $(".growth_rate").val();
				security 		= $(".security_rate").val();
				relation 		= $(".relation_rate").val();

			if(fees==="" || environment==="" || career_growth==="" || security==="" || relation==="" || !fees.match(/^\d+$/) || !environment.match(/^\d+$/) || !career_growth.match(/^\d+$/) || !security.match(/^\d+$/) || !relation.match(/^\d+$/)) {

				e.preventDefault();
				if(fees==="") {
					$(".error-fees").show();
				}

				if(environment==="") {
					$(".error-environment").show();
				}

				if(career_growth==="") {
					$(".error-career").show();
				}

				if(security==="") {
					$(".error-security").show();
				}

				if(relation==="") {
					$(".error-relation").show();
				}
			}
		})
	</script>
@endsection