<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<title></title>

	<style>
		@import url({{ URL::to('/font/roboto.css') }});

		label, h3, input, font, table, select, div, li {
			font-family: Roboto;
		}

		@media (min-width: 1200px) {
			.page-container {
			    max-width: 1140px;
			}
		}

		.page-container {
			margin: 20px auto 20px auto;
			padding: 10px 60px 10px 60px;
		}

		.page-content-1 {
			border: 			1px solid rgba(0,0,0,.125);
			display: 			-ms-flexbox;
			box-shadow: 		0 .5rem 1rem rgba(0,0,0,.15)!important;
			border-radius: 		5px;
			margin-bottom: 	15px;
			background-clip: 	border-box;
			background-color: 	#fff;
		}

		.content-head {
			padding: 			15px;
			margin-bottom: 		0;
			border-bottom: 		1px solid rgba(0,0,0,.125);
			background-color: 	rgba(0,0,0,.03);
		}

		.content-head:first-child {
			border-radius: 		calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
		}

		.head-title {
			margin: 			0;
			font-size: 			16px;
			font-weight: 		600;
			margin-block-start: 0;
		    margin-block-end: 	0;
		}

		.head-title-2 {
			margin: 			0 0 0 10px;
			display:			inline;
			font-size: 			18px;
			font-weight: 		700;
			margin-block-start: 0;
		    margin-block-end: 	0;
		}

		.head-title-3 {
			color: 				#007bff;
			margin: 			0 0 0 10px;
			display:			inline;
			font-size: 			20px;
			font-weight: 		700;
			margin-block-start: 0;
		    margin-block-end: 	0;
		}

		.content-body {
			padding: 10px;
		}

		.label-title {
			color: 			#999999;
			font-size:		12px;
			font-weight: 	600;
		}

		.label-description {
			color: 			#000000;
			font-size:		12px;
			font-weight: 	600;
		}

		.label-description-2 {
			color: 			#000000;
			display: 		inline;
			font-size:		12px;
		}


		.two-contents-2 {
			padding: 10px 5px 0 0;
		}

		@media only screen and (min-width: 500px) {
			.first-content,
			.second-content {
				display:		inline-block;
			}
		
			.first-content {
				width: 			120px;
				text-align:		right;
				margin-right:	20px;
			}

			.first-content-2 {
				margin-left: 12px;
			}
		}

		@media only screen and (min-width: 500px) {
			.first-content-2,
			.second-content-2 {
				display:		inline-block;
			}
		
			.first-content-2 {
				width: 			200px;
			}
		}

		@media only screen and (max-width: 500px) {
			.two-contents label:nth-of-type(1) {
				display:block;
			}

			.two-contents label:nth-of-type(2) {
				display:block;
			}
		}

		.menu-content {
			margin:20px;
		}

		.menu-justified {
		    width: 100%;
		}

		.menu {
			font-size: 		14px;
		    list-style: 	none;
		    padding-left: 	0;
		    margin-bottom: 	0;
		}

		ol, ul {
		    margin-top: 0;
		    margin-bottom: 10px;
		}
		
		.menu:before {
			display: table;
			content: " ";
		}

		
		.menu-pills>li {
		    float: left;
		}
		.menu>li {
		    position: relative;
		    display: block;
		}

		.menu-justified>li {
		    float: none;
		}

		@media (min-width: 768px) {
			.menu-justified>li {
			    display: table-cell;
			    width: 1%;
			}
		}

		.menu>li>a {
		    position: relative;
		    display: block;
		    padding: 10px 15px;
		    text-transform: uppercase;
		}

		.menu-pills>li {
		   	padding: 0 10px 0 10px;
		}

		.menu-pills>li>a {
		    color: #495057;
		    border-radius: 4px;
		}

		.menu-justified>li>a {
		    margin-bottom: 5px;
		    text-align: center;
		}

		@media (min-width: 768px) {
			.menu-justified>li>a {
			    margin-bottom: 0;
			}
		}

		.menu-pills>li.active>a, .menu-pills>li.active>a:focus, .menu-pills>li.active>a:hover {
		    color: 				#495057;
		    border: 			1px solid #ced4da;
			text-decoration: 	none;
		    background-clip: 	padding-box;
		    background-color: 	#e9ecef;
		}

		.menu-pills>li>a:focus, .menu-pills>li>a:hover {
		    box-shadow: 		0 0 0 0.2rem rgba(0,123,255,.25);
			text-decoration: 	none;
		}

		a {
			color: #337ab7;
			text-decoration: none;
		}

		.body-description {
			color: 			#000000;
			display:		block;
			font-size:		12px;
			line-height:	25px;
			font-weight: 	500;
			margin-left: 	15px;
		}

		.body-description-2 {
			color: 			#000000;
			display:		block;
			font-size:		12px;
			line-height:	25px;
			font-weight: 	500;
		}

		.body-content {
			padding: 15px;
		}

		.body-title {
			margin-bottom: 15px;
		}

		.body-title-2 {
			border-bottom: 	1px solid #e6e6e6;
			margin-bottom: 	15px;
			padding-bottom: 15px;
		}

		.body-title img {
			margin-top: -6px;
		}

		.body-contents-1 {
			margin-top: 	10px;
			margin-bottom: 	20px;
		}

		.body-footer {
			padding: 		10px;
			text-align: 	right;
		}

		@media (min-width: 768px) {
			.body-footer {
				margin-right: 	20px;
			}
		}

		.label-right {
			color: 			#000000;
			font-size: 		11px;
			font-weight: 	500;
		}

		.input-forms {
			margin-bottom:	10px;
			padding-bottom: 10px;
		}

		.sub-title {
			color: 		#808080;
			font-size: 	14px;
			padding-left: 2px;
			margin-top:0;
		}

		.sub-header {
			padding: .75rem 1.25rem;
			margin-bottom: 0;
			background-color: rgba(0,0,0,.03);
			border-bottom: 1px solid rgba(0,0,0,.125);
			border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
		}

		.sub-menu-title {
			font-size: 20px;
		}

		.input-actions {
			padding: 	30px 10px 10px 10px;
			border-top: 1px solid #cccccc;
		}

		.rating-stars ul {
		  padding:				0;
		  text-align:			left;
		  list-style-type:		none;
		  -moz-user-select:		none;
		  -webkit-user-select:	none;
		}

		.rating-stars-2 ul {
		  padding:				0;
		  text-align:			left;
		  list-style-type:		none;
		  -moz-user-select:		none;
		  -webkit-user-select:	none;
		}

		.rating-stars ul > li.star {
		  display:	inline-block;
		}

		.rating-stars-2 ul > li.star {
		  display:	inline-block;
		}

		.rating-stars ul > li.star > i.fa {
		  color:		#ccc; 
		  font-size: 	25px;
		}

		.rating-stars-2 ul > li.star > i.fa {
		  color:		#ccc; 
		  font-size: 	12px;
		}

		.rating-stars ul > li.star.hover > i.fa {
		  color:	#FFCC36;
		}

		.rating-stars-2 ul > li.star.hover > i.fa {
		  color:	#FFCC36;
		}

		.rating-stars ul > li.star.selected > i.fa {
		  color:	#FF912C;
		}

		.rating-stars-2 ul > li.star.selected > i.fa {
		  color:	#FF912C;
		}

		.total-label {
			font-size: 	67px;
			text-align:	center;
		}
	</style>
</head>
<body>
	<div class="page-container">
		<div class="page-contents">
			<div class="page-content-1">
				<div class="content-head">
					<h1 class="head-title">{{ $users->employer ? $users->employer->company : '' }}</h1>
				</div>
				<div class="content-body">
					<div class="two-contents">
						<div class="first-content">
							<label class="label-title">Address:</label>
						</div>

						<div class="second-content">
							<label class="label-description">{{ $users->address ? $users->address->street ? $users->address->street : '' : '' }} {{ $users->address ? $users->address->city ? $users->address->city . ',' : '' : '' }} {{ $users->address ? $users->address->zipcode ? $users->address->zipcode : '' : '' }}</label>
						</div>
					</div>
					<div class="two-contents">
						<div class="first-content">
							<label class="label-title">Telephone Number:</label>
						</div>

						<div class="second-content">
							<label class="label-description">{{ $users->employer ? $users->employer->telephone : '' }}</label>
						</div>
					</div>
					<div class="two-contents">
						<div class="first-content">
							<label class="label-title">Email Address:</label>
						</div>

						<div class="second-content">
							<label class="label-description">{{ $users->employer ? $users->employer->email : '' }}</label>
						</div>
					</div>
					<div class="two-contents">
						<div class="first-content">
							<label class="label-title">Website:</label>
						</div>

						<div class="second-content">
							<label class="label-description"><a href="http://{{ $users->employer ? $users->employer->website : '' }}">{{ $users->employer ? $users->employer->website : '' }}</a></label>
						</div>
					</div>
				</div>
			</div>

			<div class="page-content-1">
				<div class="menu-content">
					<ul class="menu menu-pills menu-justified">
						<li class="active">
							<a data-toggle="tab" href="#overview">OVERVIEW</a> 
						</li>

						<li>
							<a data-toggle="tab" href="#job_posted">JOBS POSTED</a> 
						</li>

						<li>
							<a data-toggle="tab" href="#reviews">REVIEWS</a> 
						</li>

						<li>
							<a data-toggle="tab" href="#contact">CONTACT</a> 
						</li>
					</ul>
				</div>
			</div>

			

			<div class="tab-content">
				<div id="overview" class="tab-pane fade in active">
					<div class="page-content-1">
						<div class="content-body">
							<div class="body-content">
								<div class="body-contents-1">
									<div class="body-title">
										<img src="{{ URL::to('/images/icon/about-icon.svg') }}" width="15" height="15">
										<h1 class="head-title-2">ABOUT US</h1>
									</div>
									<label class="body-description">
										{!! $users->employer?$users->employer->about_us:'' !!}
									</label>
								</div>

								<div class="body-contents-1">
									<div class="body-title">
										<img src="{{ URL::to('/images/icon/globe-icon.svg') }}" width="15" height="15">
										<h1 class="head-title-2">MISSION and VISION</h1>
									</div>
									<label class="body-description">
										{!! $users->employer?$users->employer->mission_vision:'' !!}
									</label>
								</div>

								<div class="body-contents-1">
									<div class="body-title">
										<img src="{{ URL::to('/images/icon/trophy-icon.svg') }}" width="15" height="15">
										<h1 class="head-title-2">PHILOSOPHY</h1>
									</div>
									<label class="body-description">
										{!! $users->employer?$users->employer->philosophy:'' !!}
									</label>
								</div>

								<div class="body-contents-1">
									<div class="body-title">
										<img src="{{ URL::to('/images/icon/warning-icon.svg') }}" width="15" height="15">
										<h1 class="head-title-2">WHY YOU CHOOSE US?</h1>
									</div>
									<label class="body-description">
										{!! $users->employer?$users->employer->why_choose:'' !!}
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="job_posted" class="tab-pane fade">
             		@foreach($jobs as $job)
					<div class="page-content-1">
						<div class="content-body">
							<div class="body-content">
								<div class="body-contents-1">
									<div class="body-title-2">
										<a class="head-title-3" href="{{ url('job/details/'.Crypt::encrypt($job->id)) }}">{{ $job->title }}</a>
									</div>

									<div class="two-contents">
										<div class="first-content-2">
											<label class="body-description-2">
												<img src="{{ URL::to('/images/icon/user-icon.svg') }}" width="14" height="14">
												<h1 class="label-description-2">{{ $job->employments->name }}</h1>
											</label>
										</div>

										<div class="second-content-2">
											<label class="body-description-2">
												<img src="{{ URL::to('/images/icon/contact-icon.svg') }}" width="14" height="14">
												<h1 class="label-description-2">{{ $job->specializations->name }}</h1>
											</label>
										</div>
									</div>

									<div class="two-contents">
										<div class="first-content-2">
											<label class="body-description-2">
												<img src="{{ URL::to('/images/icon/pin-icon.svg') }}" width="14" height="14">
												<h1 class="label-description-2">{{ $job->country->nicename }}</h1>
											</label>
										</div>

										<div class="second-content-2">
											<label class="body-description-2">
												<img src="{{ URL::to('/images/icon/file-icon.svg') }}" width="14" height="14">
												<h1 class="label-description-2">{{ $job->positions->name }}</h1>
											</label>
										</div>
									</div>

									<div class="two-contents">
										<div class="first-content-2">
											<label class="body-description-2">
												<img src="{{ URL::to('/images/icon/money-icon.svg') }}" width="14" height="14">
												<h1 class="label-description-2">{{ $job->currency->name }} {{ $job->min }}-{{ $job->max }}</h1>
											</label>
										</div>
									</div>

									<div class="body-contents-1">
										<label class="body-description-2">
											{!! strlen($job->description)>50?substr($job->description,0,300)."...":$job->description !!}
										</label>
									</div>

									<div class="body-footer">
										<label class="label-right">POSTED: {{ $job->created_at->diffForHumans() }}</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>

				<div id="reviews" class="tab-pane fade">
					<div class="page-content-1">
						<div class="content-body">
							<div class="body-contents-1">
								<div class="body-title-2">
									<h1 class="head-title-2">Overall Rate</h1>
								</div>

								<div class="two-contents">
									<div class="first-content-2" style="text-align:center">
										<label class="total-label">{{$overall_rate}}</label>
										<div class='rating-stars-2 text-center'>
											<h1 class="sub-title">Overall rating</h1>
											<ul style="text-align:center">
												<li class='star <?php if((int)$overall_rate <= 5 && (int)$overall_rate !==0) { echo "selected"; } ?>' title='Poor' data-value='1'>
													<i class='fa fa-star fa-fw'></i>
												</li>

												<li class='star <?php if((int)$overall_rate <= 5 && (int)$overall_rate !==1) { echo "selected"; } ?>' title='Fair' data-value='2'>
													<i class='fa fa-star fa-fw'></i>
												</li>

												<li class='star <?php if((int)$overall_rate <= 5 && (int)$overall_rate !==2) { echo "selected"; } ?>' title='Good' data-value='3'>
													<i class='fa fa-star fa-fw'></i>
												</li>

												<li class='star <?php if((int)$overall_rate <= 5 && (int)$overall_rate !==3) { echo "selected"; } ?>' title='Excellent' data-value='4'>
													<i class='fa fa-star fa-fw'></i>
												</li>

												<li class='star <?php if((int)$overall_rate <= 5 && (int)$overall_rate !==4) { echo "selected"; } ?>' title='WOW!!!' data-value='5'>
													<i class='fa fa-star fa-fw'></i>
												</li>
											</ul>
										</div>
									</div>

									<div class="second-content-2">
										<div class="content-body">
											<h1 class="sub-title">Ratings by category</h1>
											<div class="input-forms">
												<div class='rating-stars-2 text-center'>
													<ul>
														<li class='star selected' title='Poor' data-value='1'>{{$work_environment_rate}}
															<i class='fa fa-star fa-fw'></i> Work Environment
														</li>
													</ul>
												</div>

												<div class='rating-stars-2 text-center'>
													<ul>
														<li class='star selected' title='Poor' data-value='1'>{{$career_growth}}
															<i class='fa fa-star fa-fw'></i> Career Growth Development
														</li>
													</ul>
												</div>

												<div class='rating-stars-2 text-center'>
													<ul>
														<li class='star selected' title='Poor' data-value='1'>{{$job_security}}
															<i class='fa fa-star fa-fw'></i> Job Security
														</li>
													</ul>
												</div>

												<div class='rating-stars-2 text-center'>
													<ul>
														<li class='star selected' title='Poor' data-value='1'>{{$employee_relation}}
															<i class='fa fa-star fa-fw'></i> Employee's Relation
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>

					<div class="page-content-1">
						<form method="POST" action="{{ route('rate.store') }}" id="form"> 
        				@csrf
						<div class="content-body">
							<div class="body-contents-1">
								<div class="body-title-2">
									<h1 class="head-title-2">How would you rate the company on the following:</h1>
								</div>
								<input type="hidden" name="work_environment_rate" class="work_environment_rate">
								<input type="hidden" name="career_growth_rate" class="career_growth_rate">
								<input type="hidden" name="job_security_rate" class="job_security_rate">
								<input type="hidden" name="employee_relation_rate" class="employee_relation_rate">
								<input type="hidden" name="employeeid" value="{{$encrypt}}">
								<div class="card-body">
								<div class="content-body">
									<div class="input-forms">
										<h1 class="sub-title">Work Environment</h1>
										<div class='rating-stars text-center'>
											<ul id='work_environment_rate'>
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
									</div>

									<div class="input-forms">
										<h1 class="sub-title">Career Growth Development</h1>
										<div class='rating-stars text-center'>
											<ul id='career_growth_rate'>
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
									</div>

									<div class="input-forms">
										<h1 class="sub-title">Job Security</h1>
										<div class='rating-stars text-center'>
											<ul id='job_security_rate'>
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
									</div>

									<div class="input-forms">
										<h1 class="sub-title">Employee's Relation</h1>
										<div class='rating-stars text-center'>
											<ul id='employee_relation_rate'>
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
									</div>
								</div>
								<div class="input-actions">
									<button class="btn btn-primary">Submit</button>
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>

				<div id="contact" class="tab-pane fade">
					
				</div>
			</div>
		</div>
	</div>
</body>

<script>

	$(document).ready(function() {
	  
		$('#work_environment_rate li').on('mouseover', function() {
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
	  
		$('#work_environment_rate li').on('click', function() {
			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var work_environment_rate 	= parseInt($('#work_environment_rate li.selected').last().data('value'), 10);

			$(".work_environment_rate").val(work_environment_rate);

		});

		$('#career_growth_rate li').on('mouseover', function() {
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
	  
		$('#career_growth_rate li').on('click', function() {
			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var career_growth_rate 	= parseInt($('#career_growth_rate li.selected').last().data('value'), 10);

			$(".career_growth_rate").val(career_growth_rate);
		});

		$('#job_security_rate li').on('mouseover', function() {
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
	  
		$('#job_security_rate li').on('click', function() {
			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var job_security_rate 	= parseInt($('#job_security_rate li.selected').last().data('value'), 10);

			$(".job_security_rate").val(job_security_rate);
		});

		$('#employee_relation_rate li').on('mouseover', function() {
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
	  
		$('#employee_relation_rate li').on('click', function() {
			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			var employee_relation_rate 	= parseInt($('#employee_relation_rate li.selected').last().data('value'), 10);

			$(".employee_relation_rate").val(employee_relation_rate);
		});
	});
</script>
</html>