@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(9))

@section('content')
<div class="container-fluid">
	<br>
	<div class="row justify-row-content">
		<div class="col-sm-6">
			<h3 class="m-0 text-dark">Top Rated Companies</h3>
		</div>
	</div>
	<div class="row justify-row-content mt-3">
		<div class="col-sm-3">
			<input type="text" id="datasearchfield" class="form-control" placeholder="Search here..">
		</div>
	</div>
	<div class="row justify-row-content mt-3">
		<div class="col-md-12">
			<div class="card shadow-none">
				<div class="card-body">
					<div class="table-responsive">
						<table id="usersTable" class="table table-bordered">
							<thead>
								<tr>
									<th>Employer ID</th>
									<th>Employer's Company</th>
									<th>Work Environment</th>
									<th>Career Growth</th>
									<th>Job Security</th>
									<th>Employee Relation</th>
									<th>Overall Ratings</th>
								</tr>
							</thead>
							<tbody>
								@foreach($user as $user)
								<tr>
									<td>{{$user->id}}</td>
									<td>{{$user->company}}</td>
									<td>
										<div class="thisone" style="display: none"> {{$user->work_environment_rate}}</div>
										@if($user->environment == 1)
										<span class='fa fa-star'></span>
										@elseif($user->environment==2)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->environment==3)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->environment==4)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->environment==5)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>		
										@endif
									</td>
									<td>
										<div class="thisone" style="display: none"> {{$user->career_growth_rate}}</div>
										@if($user->career_growth == 1)
										<span class='fa fa-star'></span>
										@elseif($user->career_growth==2)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->career_growth==3)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->career_growth==4)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->career_growth==5)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>		
										@endif
									</td>
									<td>
										<div class="thisone" style="display: none"> {{$user->job_security_rate}}</div>
										@if($user->security == 1)
										<span class='fa fa-star'></span>
										@elseif($user->security==2)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->security==3)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->security==4)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->security==5)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>		
										@endif
									</td>
									<td>
										<div class="thisone" style="display: none"> {{$user->employee_relation_rate}}</div>
										@if($user->relation == 1)
										<span class='fa fa-star'></span>
										@elseif($user->relation==2)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->relation==3)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->relation==4)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										@elseif($user->relation==5)
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>
										<span class='fa fa-star'></span>		
										@endif
									</td>
									<td>
										<div class="thisone" style="display: none"> </div>
										<?php

										$first = $user->environment;
										$second = $user->career_growth_rate;
										$third = $user->job_security_rate;
										$forth = $user->employee_relation_rate;
										$forth = $user->employee_relation_rate;

										//adding the each rate and divided to 4

										$overalltotal = $first + $second + $third + $forth / 4;

										$overalltotal = number_format($overalltotal, 2, '.', '');
										?>
									
										{{number_format($user->average, 2, '.', '')}}
								
									</td>
								</tr>
							
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection