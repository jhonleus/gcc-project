@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(1))

@section('content')

<div class="container pt-5">
		<h5 class="mb-4">{{ App\MaintenanceLocale::getLocale(621) }}</h5>
	<div class="row mb-5">
		<div class="col-md-3 col-sm-3">
			<div class="card bg-white shadow-none">
				<div class="card-header-none pl-3">
					<p class="dashbox-title mt-2 text-dark">{{ App\MaintenanceLocale::getLocale(518) }}</p>
				</div>
				<div class="card-body p-0">
					<h1 class="dashbox-content text-center  text-primary">{{$userApproval}}</h1>
				</div>
				<div class="card-footer bg-white"><a href="admin/approval" class="font-weight-lighter">{{ App\MaintenanceLocale::getLocale(136) }}</a></div>
			</div>
		</div>

		<div class="col-md-3 col-sm-3">
			<div class="card bg-white shadow-none">
				<div class="card-header-none pl-3">
				<p class="dashbox-title mt-2 text-dark">{{ App\MaintenanceLocale::getLocale(519) }}</p>
				</div>
				<div class="card-body  p-0">
					<h1 class="dashbox-content text-center text-primary">{{$jobApproval->count()}}</h1>
				</div>
				<div class="card-footer bg-white">
					<a href="admin/jobs" class="font-weight-lighter">{{ App\MaintenanceLocale::getLocale(136) }}</a>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-3">
			<div class="card bg-white shadow-none">
				<div class="card-header-none pl-3">
					<p class="dashbox-title mt-2 text-dark">{{ App\MaintenanceLocale::getLocale(520) }}</p>
				</div>
				<div class="card-body  p-0">	
					<h1 class="dashbox-content text-center  text-primary">{{$reviewApproval->count()}}</h1>
				</div>
				<div class="card-footer bg-white">
					<a href="admin/reviews" class="font-weight-lighter">{{ App\MaintenanceLocale::getLocale(136) }}</a>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-3">
			<div class="card bg-white shadow-none">
				<div class="card-header-none pl-3">
					<p class="dashbox-title mt-2 text-dark">{{ App\MaintenanceLocale::getLocale(521) }}</p>
				</div>
				<div class="card-body  p-0">
					<h1 class="dashbox-content text-center text-primary">{{$otcApproval->count()}}</h1>
				</div>
				<div class="card-footer bg-white">
					<a href="admin/over-the-counter" class="font-weight-lighter">{{ App\MaintenanceLocale::getLocale(136) }}</a>
				</div>
			</div>
		</div>
	</div>
	
	<h5 class="mb-4">{{ App\MaintenanceLocale::getLocale(575) }}</h5>
	<div class="row">
		<div class="col-md-6 col-6">
			<div class="card shadow-none">
				<div class="card-body">
					<div class="row">
						<div class="col-md-3"><img width="100%"  class="img-fluid" alt="Responsive image" src="{{ asset('admin dashboard logo/target.svg')}}">
						</div>
						<div class="col-md-6 mx-auto">
							<br>
							<h1 class="dashbox-content text-primary text-center">{{$users1->count()}}</h1>	
							<p class="dashbox-title mt-2 text-muted text-center">{{ App\MaintenanceLocale::getLocale(132) }}</p>
						</div>
					</div>
				</div>
				<div class="card-footer bg-white"><a href="admin/reports/applicantlist" class="font-weight-lighter">{{ App\MaintenanceLocale::getLocale(136) }}</a></div>
			</div>
		</div>
		<div class="col-md-6 col-6">
			<div class="card shadow-none">
				<div class="card-body">
					<div class="row">
						<div class="col-md-3"><img width="100%" src="{{ asset('admin dashboard logo/building.svg')}}"></div>
							<div class="col-md-6 mx-auto">
								<br>
								<h1 class="dashbox-content text-primary text-center">{{$users2->count()}}</h1>
								<p class="dashbox-title mt-2 text-muted text-center">{{ App\MaintenanceLocale::getLocale(133) }}</p>
							</div>
						</div>
					</div>
					<div class="card-footer bg-white"><a href="admin/reports/companylist" class="font-weight-lighter">{{ App\MaintenanceLocale::getLocale(136) }}</a></div>
				</div>
			</div>
		</div>

	<div class="row">
		<div class="col-md-6 col-6">
			<div class="card shadow-none">
			
					
					<div class="card-body">
						<div class="row">
							<div class="col-md-3"><img src="{{ asset('admin dashboard logo/collaboration.svg')}}"></div>
							<div class="col-md-6 mx-auto">
								<br>
								<h1 class="dashbox-content text-primary text-center">{{$users3->count()}}</h1>
								<p class="dashbox-title mt-2 text-muted text-center">{{ App\MaintenanceLocale::getLocale(134) }}</p>
							</div>
						</div>
					</div>
				
				<div class="card-footer bg-white"><a href="admin/reports/organizationlist" class="font-weight-lighter">{{ App\MaintenanceLocale::getLocale(136) }}</a></div>
			</div>
		</div>
		<div class="col-md-6 col-6">
			<div class="card shadow-none">
				
					
					<div class="card-body">
						<div class="row">
							<div class="col-md-3"><img width="100%" src="{{ asset('admin dashboard logo/graduation-hat.svg')}}"></div>
							<div class="col-md-6 mx-auto">
								<br>
								<h1 class="dashbox-content text-primary text-center">{{$users4->count()}}</h1>
								<p class="dashbox-title mt-2 text-muted text-center">{{ App\MaintenanceLocale::getLocale(135) }}</p>
							</div>
						</div>
					</div>
				
				<div class="card-footer bg-white"><a href="admin/reports/schoolslist" class="font-weight-lighter">{{ App\MaintenanceLocale::getLocale(136) }}</a></div>
			</div>
		</div>
	</div>
	@endsection
