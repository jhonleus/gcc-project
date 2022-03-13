<div class="card profile-contents">
	<div class="card-body profile-settings">
		<h1 class="profile-label-settings">
			<i class="fa fa-id-card-o" aria-hidden="true"></i>
			{{ App\MaintenanceLocale::getLocale(423) }}
		</h1>
		<ul class="list-group profile-group-settings">
			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/personal') }}" id="personal-list">
					<i class="fas fa-user" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(414) }}
				</a>
			</li>

			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/skills') }}" id="skills-list">
					<i class="fas fa-cogs" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(424) }}
				</a>
			</li>

			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/work_experience') }}" id="works-list">
					<i class="fas fa-briefcase" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(421) }}
				</a>
			</li>

			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/education') }}" id="educations-list">
					<i class="fas fa-graduation-cap" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(422) }}
				</a>
			</li>

			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/certificate') }}" id="certificates-list">
					<i class="fas fa-book-open" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(425) }}
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="card profile-contents">
	<div class="card-body profile-settings">
		<h1 class="profile-label-settings">
			<i class="fa fa-cog" aria-hidden="true"></i>
			{{ App\MaintenanceLocale::getLocale(321) }}
		</h1>
		<ul class="list-group profile-group-settings">
			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/savedjobs') }}" id="jobsaved-list">
					<i class="fas fa-bookmark" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(426) }}
				</a>
			</li>

			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/jobs') }}" id="jobs-list">
					<i class="fas fa-briefcase" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(427) }}
				</a>
			</li>

			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/invitations') }}" id="invitations-list">
					<i class="fa fa-envelope-open" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(528) }}
				</a>
			</li>
        <!--
			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/savedcourses') }}" id="coursesaved-list">
					<i class="fas fa-bookmark" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(428) }}
				</a>
			</li>

			<li class="profile-group-settings">
				<a class="profile-label-settings-content" href="{{ url('applicant/courses') }}" id="courses-list">
					<i class="fas fa-graduation-cap" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(429) }}
				</a>
			</li>
		-->
		</ul>
	</div>
</div>