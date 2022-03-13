@extends('layouts.header')

@section('title', 'Home')

@section('content')
	<!--FULL home JS-->
	<script src="{{ asset('resources/js/fullcalendar/main.min.js') }}"></script>
	<script src="{{ asset('resources/js/fullcalendar/daygrid.min.js') }}"></script>
	<script src="{{ asset('resources/js/fullcalendar/list.min.js') }}"></script>
	<script src="{{ asset('resources/js/fullcalendar/bootstrap.min.js') }}"></script>
	<script src="{{ asset('resources/js/fullcalendar/tooltip.min.js') }}"></script>
	<script src="{{ asset('resources/js/fullcalendar/popper.min.js') }}"></script>

	<!--FULL home CSS-->
	<link rel="stylesheet" href="{{ asset('resources/css/fullcalendar/main.min.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/css/fullcalendar/list.min.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/css/fullcalendar/daygrid.min.css') }}">
	<link rel="stylesheet" href="{{ asset('resources/css/fullcalendar/bootstrap.min.css') }}">

	<!--CUSTOM CSS-->
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/home-page.css') }}">
	<link rel="stylesheet" href="{{ asset('css/systems/stars.css') }}">

	<div class="container home-container">
		<div class="row">
			<div class="col-sm-4 margin-top">
				<div class="home-tile">
					<a>
						<div class="home-tile-heading">
							<i class="fa fa-users fa-fw fa-3x"></i> 
						</div> 
					</a>

					<div class="home-tile-content">
						<div class="home-tile-description">Applicants</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="home-tile-sub">(pending)</div>
								<div class="home-tile-number">{{$pending_applicant}}</div>
							</div>

							<div class="col-sm-4">
								<div class="home-tile-sub">(scheduled)</div>
								<div class="home-tile-number">{{$sched_applicant}}</div>
							</div>

							<div class="col-sm-4">
								<div class="home-tile-sub">(rejected)</div>
								<div class="home-tile-number">{{$reject_applicant}}</div>
							</div>
						</div>
						<a class="home-tile-footer" href="{{ url('organization/applicants') }}">More Info
							<i class="fa fa-chevron-home-right"></i> 
						</a>
					</div>
				</div>
				
				<div class="home-tile">
					<a>
						<div class="home-tile-heading">
							<i class="fa fa-briefcase fa-fw fa-3x"></i> 
						</div> 
					</a>

					<div class="home-tile-content">
						<div class="home-tile-description">Jobs</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="home-tile-sub">(active)</div>
								<div class="home-tile-number">{{$job_active}}</div>
							</div>

							<div class="col-sm-4">
								<div class="home-tile-sub">(closed)</div>
								<div class="home-tile-number">{{$closed_job}}</div>
							</div>

							<div class="col-sm-4">
								<div class="home-tile-sub">(deleted)</div>
								<div class="home-tile-number">{{$deleted_job}}</div>
							</div>
						</div>
						<a class="home-tile-footer" href="{{ url('organization/jobs') }}">More Info
							<i class="fa fa-chevron-home-right"></i> 
						</a>
					</div>
				</div>
			</div>

			<div class="col-sm-8">
				<div class="card home-contents home-content">
					<div class="card-body">
						<div id='calendar'></div>
					</div>
				</div> 
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				plugins: [ 'dayGrid', 'list', 'bootstrap' ],
				timeZone: 'UTC',
				defaultView: 'listMonth',
				themeSystem: 'bootstrap',
				header: {
					left: 	'prev,next today',
					center: 'title',
					right: 	'listMonth,dayGridMonth'
				},
				eventLimit: true, 
				eventRender: function (info) {
				  $(info.el).tooltip({ title: info.event.extendedProps.description }); 
				},
				events: [
					@foreach($applicants as $applicant)
					{	
						title: 				"{{$applicant->applicant->firstName}} {{$applicant->applicant->lastName}}",
						description: 		'Job Title: {{$applicant->application->title}}',
						start: 				'{{$applicant->scheduled}}',
						backgroundColor: 	'green',
						borderColor: 		'green'
					},
					@endforeach
				],
			});
			calendar.render();
		});
	</script>
@endsection
