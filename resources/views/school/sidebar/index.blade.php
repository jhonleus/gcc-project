<div class="card sidebar-settings">
	<div class="card-body sidebar-contents">
		<h1 class="sidebar-title">
			<i class="fa fa-address-card" aria-hidden="true"></i>
			Details
		</h1>
		<ul class="list-group sidebar-list">
			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('school/details/'.Auth::user()->id) }}" id="detail-list">
					<i class="fas fa-school" aria-hidden="true"></i>
					School Details
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('school/affilations') }}" id="affilations-list">
					<i class="fas fa-globe" aria-hidden="true"></i>
					Affilations
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('school/branches') }}" id="branch-list">
					<i class="fas fa-university" aria-hidden="true"></i>
					Branches
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('school/partners') }}" id="partner-list">
					<i class="fas fa-handshake-o" aria-hidden="true"></i>
					Partners
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
				<a class="sidebar-list-title" href="{{ url('school/course') }}" id="course-list">
					<i class="fa fa-briefcase" aria-hidden="true"></i>
					Posted Course
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('school/students') }}" id="student-list">
					<i class="fa fa-graduation-cap" aria-hidden="true"></i>
					Students
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('school/blogs') }}" id="blog-list">
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
			Summary
		</h1>
		<ul class="list-group sidebar-list">
			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('school/summary/courses') }}" id="coursesum-list">
					<i class="fa fa-briefcase" aria-hidden="true"></i>
					Posted Courses ({{$posted_course}})
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('school/summary/students') }}" id="studentsum-list">
					<i class="fa fa-graduation-cap" aria-hidden="true"></i>
					Students ({{$student_list}})
				</a>
			</li>
		</ul>
	</div>
</div>
