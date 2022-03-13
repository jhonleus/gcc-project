<div class="card sidebar-settings">
	<div class="card-body sidebar-contents">
		<h1 class="sidebar-title">
			<i class="fa fa-address-card" aria-hidden="true"></i>
			{{ App\MaintenanceLocale::getLocale(320) }}
		</h1>
		<ul class="list-group sidebar-list">
			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/details/'.Auth::user()->id) }}" id="detail-list">
					<i class="fas fa-building" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(316) }}
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/affilations') }}" id="affilations-list">
					<i class="fas fa-globe" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(317) }}
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/branches') }}" id="branch-list">
					<i class="fas fa-university" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(318) }}
				</a>
			</li>

			<li class="sidebar-list">
				<a href="{{ route('employer.payment.index') }}" class="sidebar-list-title">
					<i class="fas fa-credit-card" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(560) }}
				</a>
			</li>

			<li class="sidebar-list">
				<a href="{{ url('employer/subscription') }}" class="sidebar-list-title" id="subscription-list">
					<i class="fas fa-shopping-cart" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(16) }}
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="card sidebar-settings">
	<div class="card-body sidebar-contents">
		<h1 class="sidebar-title">
			<i class="fa fa-cog" aria-hidden="true"></i>
			{{ App\MaintenanceLocale::getLocale(321) }}
		</h1>
		<ul class="list-group sidebar-list">
			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/jobs') }}" id="job-list">
					<i class="fa fa-briefcase" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(322) }}
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/applicants') }}" id="applicant-list">
					<i class="fa fa-user" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(78) }}
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/invitations') }}" id="invitation-list">
					<i class="fa fa-envelope-open" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(561) }}
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/saved') }}" id="saved-list"> 
					<i class="fa fa-bookmark" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(327) }}
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/blogs') }}" id="blog-list">
					<i class="fa fa-newspaper-o" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(326) }}
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="card sidebar-settings">
	<div class="card-body sidebar-contents">
		<h1 class="sidebar-title">
			<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
			{{ App\MaintenanceLocale::getLocale(506) }}
		</h1>
		<ul class="list-group sidebar-list">
			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/summary/jobs') }}" id="jobsum-list">
					<i class="fa fa-briefcase" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(461) }} ({{$posted_jobs}})
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('employer/summary/applicants') }}" id="applicantsum-list">
					<i class="fa fa-user" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(196) }} ({{$applicant_list}})
				</a>
			</li>
		</ul>
	</div>
</div>
