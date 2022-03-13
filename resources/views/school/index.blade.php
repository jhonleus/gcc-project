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
						<div class="home-tile-description">{{ App\MaintenanceLocale::getLocale(196) }}</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="home-tile-sub">({{ App\MaintenanceLocale::getLocale(272) }})</div>
								<div class="home-tile-number">{{$pending_applicant}}</div>
							</div>

							<div class="col-sm-4">
								<div class="home-tile-sub">({{ App\MaintenanceLocale::getLocale(380) }})</div>
								<div class="home-tile-number">{{$sched_applicant}}</div>
							</div>

							<div class="col-sm-4">
								<div class="home-tile-sub">({{ App\MaintenanceLocale::getLocale(274) }})</div>
								<div class="home-tile-number">{{$reject_applicant}}</div>
							</div>
						</div>
						<a class="home-tile-footer" href="{{ url('school/students') }}">{{ App\MaintenanceLocale::getLocale(136) }}
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
						<div class="home-tile-description">{{ App\MaintenanceLocale::getLocale(460) }}</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="home-tile-sub">({{ App\MaintenanceLocale::getLocale(360) }})</div>
								<div class="home-tile-number">{{$course_active}}</div>
							</div>

							<div class="col-sm-4">
								<div class="home-tile-sub">({{ App\MaintenanceLocale::getLocale(361) }})</div>
								<div class="home-tile-number">{{$closed_course}}</div>
							</div>

							<div class="col-sm-4">
								<div class="home-tile-sub">({{ App\MaintenanceLocale::getLocale(472) }})</div>
								<div class="home-tile-number">{{$deleted_course}}</div>
							</div>
						</div>
						<a class="home-tile-footer" href="{{ url('school/course') }}">{{ App\MaintenanceLocale::getLocale(136) }}
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
					@foreach($students as $student)
					{
						title: 				"{{ucfirst($student->user->firstName)}} {{ucfirst($student->user->lastName)}} application for {{ucfirst($student->course->course)}}",
						description: 		'@if(!is_null($student->response)) @if($student->response->isAccept==1) will be able to attend to your invitation @elseif($student->response->isAccept==2) would like to request for re-scheduled of date of your invitation on {{Helper::getDate($student->response->availability)}} @else will not be able to attend to your invitation @endif @else no response @endif',
						start: 				'{{$student->schedule_date}}',
						backgroundColor: 	'@if(!is_null($student->response)) @if($student->response->isAccept==1) #28a745 @elseif($student->response->isAccept==2) #17a2b8 @else #dc3545 @endif @else #6c757d @endif',
						borderColor: 		'green',
						url: 				'{{url("/school/students")}}'
					},
					@endforeach
				],
			});
			calendar.render();
		});
	</script>
@endsection
