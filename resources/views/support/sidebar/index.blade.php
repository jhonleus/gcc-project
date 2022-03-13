<div class="card sidebar-settings">
	<div class="card-body sidebar-contents">
		<h1 class="sidebar-title">
			<i class="fa fa-address-card" aria-hidden="true"></i>
			Details
		</h1>
		<ul class="list-group sidebar-list">
			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('support/details/'.Auth::user()->id) }}" id="detail-list">
					<i class="fas fa-building" aria-hidden="true"></i>
					Organization Details
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('support/affilations') }}" id="affilations-list">
					<i class="fas fa-globe" aria-hidden="true"></i>
					Affilations
				</a>
			</li>

			<li class="sidebar-list">
				<a class="sidebar-list-title" href="{{ url('support/branches') }}" id="branch-list">
					<i class="fas fa-university" aria-hidden="true"></i>
					Branches
				</a>
			</li>

			<li class="sidebar-list">
				<a href="{{ route('support.payment.index') }}" class="sidebar-list-title">
					<i class="fas fa-credit-card" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(560) }}
				</a>
			</li>

			<li class="sidebar-list">
				<a href="{{ url('support/subscription') }}" class="sidebar-list-title" id="subscription-list">
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
				<a class="sidebar-list-title" href="{{ url('support/blogs') }}" id="blog-list">
					<i class="fa fa-newspaper-o" aria-hidden="true"></i>
					{{ App\MaintenanceLocale::getLocale(326) }}
				</a>
			</li>
		</ul>
	</div>
</div>
