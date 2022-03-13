@extends('layouts.header')

@section('title', 'Review')

@section('content')
	<!-- CSS FOR FRONT REVIEW-->
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/front/review-page.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/css/custom/stars.css') }}">

	<div class="container review-container">
		@if($rated) 
		<div class="alert alerts alert-warning" role="alert">
			You can't review this company for multiple times. You can edit your review below.
		</div>
		@endif

		@if(!isset($reviews))
		<form action="{{ route('review.store') }}" method="POST" id="form">
		    @csrf
		<input type="hidden" value="{{$encrypt}}" name="companyId">
		@else
		<form method="POST" action="{{ route('review.update', $encrypt) }}" id="form">
		@method('PUT')
		    @csrf
		@endif
		<div class="card review-contents">
			<div class="card-header review-header">
				<label class="review-title">
					Company Reviews
				</label>
			</div>
			<div class="card-body">
				<div class="review-forms">
					<h1 class="review-label">Review Summary:</h1>

					<input type="text" class="input" name="summary" id="summary" @if(!$login) disabled @endif @if(isset($reviews)) value="{{ $reviews->summary }}" @endif>

					<div class="error-container">
						<label class="label-error error-summary">Review Summary is required.</label>
					</div>
				</div>

				<div class="review-forms">
					<h1 class="review-label">Review:</h1>

					<textarea class="txtarea" name="review" id="review" @if(!$login) disabled @endif>@if(isset($reviews)){{$reviews->review}}@endif</textarea>

					<div class="error-container">
						<label class="label-error error-review">Review is required.</label>
					</div>
				</div>

				<div class="review-forms">
					<h1 class="review-label">Pros:</h1>

					<input type="text" class="input" name="pros" id="pros" @if(!$login) disabled @endif @if(isset($reviews)) value="{{ $reviews->pros }}" @endif>

					<div class="error-container">
						<label class="label-error error-pros">Pros is required.</label>
					</div>
				</div>

				<div class="review-forms">
					<h1 class="review-label">Cons:</h1>

					<input type="text" class="input" name="cons" id="cons" @if(!$login) disabled @endif @if(isset($reviews)) value="{{ $reviews->cons }}" @endif>

					<div class="error-container">
						<label class="label-error error-cons">Cons is required.</label>
					</div>
				</div>


				<div class="review-forms">
					<h1 class="review-label">Overall rating of your experience here:</h1>

					<input type="hidden" name="rating" class="rating" @if(isset($reviews)) value="{{$reviews->rating}}" @endif>
					<div class='rating-stars text-center'>
						<ul id='rating'>
							<li class='star @if(isset($reviews))@if($reviews->rating>=1 && $reviews->rating<=5) selected @endif @endif' title='Poor' data-value='1'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star @if(isset($reviews))@if($reviews->rating>=2 && $reviews->rating<=5) selected @endif @endif' title='Fair' data-value='2'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star @if(isset($reviews))@if($reviews->rating>=3 && $reviews->rating<=5) selected @endif @endif' title='Good' data-value='3'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star @if(isset($reviews))@if($reviews->rating>=4 && $reviews->rating<=5) selected @endif @endif' title='Excellent' data-value='4'>
								<i class='fa fa-star fa-fw'></i>
							</li>

							<li class='star @if(isset($reviews))@if($reviews->rating>=5 && $reviews->rating<=5) selected @endif @endif' title='WOW!!!' data-value='5'>
								<i class='fa fa-star fa-fw'></i>
							</li>
						</ul>
					</div>

					<div class="error-container">
						<label class="label-error error-rating">Rating is required.</label>
					</div>
				</div>

				<div class="review-forms">
					<h1 class="review-label">Would you recommend working here to a friend?</h1>

					<input type="hidden" id="recommend" name="recommend" @if(isset($reviews)) value="{{$reviews->recommend}}" @endif>
						<div class="review-buttons recommend">
						<button type="button" value="1" @if(!$login) disabled @endif @if(isset($reviews)) @if($reviews->recommend==1) class="selected" @endif @endif>Yes</button>
						<button type="button" value="0" @if(!$login) disabled @endif @if(isset($reviews)) @if($reviews->recommend==0) class="selected" @endif @endif>No</button>
					</div>

					<div class="error-container">
						<label class="label-error error-recommend"></label>
					</div>

					<div class="error-container">
						<label class="label-error error-recommend">Recommend is required.</label>
					</div>
				</div>

				<div class="review-footer">
					<button class="btn review-button btn-primary" id="save_button" @if(!$login) disabled @endif>Save</button>
				</div>
			</div>
		</div>
		</form>
	</div>

	<script>
		@if($login)
		$('#rating li').on('mouseover', function() {
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
		 
		$('#rating li').on('click', function() {
			$(".error-rating").hide();
			$("#rating").css('border', '');

			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var employee_relation_rate 	= parseInt($('#rating li.selected').last().data('value'), 10);

			$(".rating").val(employee_relation_rate);
		});

		$(".recommend button").click(function() {
			$(".error-recommend").hide();
			$(".recommend").css('border', '');

			$(".recommend .selected").removeClass('selected');
			var value = $(this).attr('value');
			$(this).addClass('selected');

			$("#recommend").val(value);

			$(this).blur(); 
		})

		$("#save_button").click(function(e) {
			var summary 	= $("#summary").val();
				review 		= $("#review").val();
				pros 		= $("#pros").val();
				cons 		= $("#cons").val();
				rating 		= $(".rating").val();
				recommend 	= $(".recommend").val();

			if(summary===null || summary==="" || review===null || review==="" || pros===null || pros==="" || cons===null || cons==="" || rating===null || rating==="") {
				e.preventDefault();

				if(summary===null || summary==="") {
					$(".error-summary").show();
					$("#summary").css('border', '1px solid red');
				}

				if(review===null || review==="") {
					$(".error-review").show();
					$("#review").css('border', '1px solid red');
				}

				if(pros===null || pros==="") {
					$(".error-pros").show();
					$("#pros").css('border', '1px solid red');
				}

				if(cons===null || cons==="") {
					$(".error-cons").show();
					$("#cons").css('border', '1px solid red');
				}

				if(rating===null || rating==="") {
					$(".error-rating").show();
				}

				if(recommend===null || recommend==="") {
					$(".error-recommend").show();
				}
			}

		})

		$('#summary').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-summary").show();
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-summary").hide();
				$(this).css('border', '');
	        }
	    });

	    $('#review').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-review").show();
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-review").hide();
				$(this).css('border', '');
	        }
	    });

	    $('#pros').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-pros").show();
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-pros").hide();
				$(this).css('border', '');
	        }
	    });

	    $('#cons').keyup(function() {
	        var length = $(this).val().length;

	        if(length < 1) {
				$(".error-cons").show();
				$(this).css('border', '1px solid red');
	        }
	        else {
				$(".error-cons").hide();
				$(this).css('border', '');
	        }
	    });
	    @endif
	</script>
@endsection