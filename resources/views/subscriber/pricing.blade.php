@extends('layouts.header')

@section('title', 'Subscription Pricing')

@section('content')
	<!-- CSS FOR PRICING-->
	<link rel="stylesheet" href="{{ asset('resources/css/content-page/subscriber/pricing-page.css') }}">

	<div class="container pricing-container">

		@if(!$profilestatus)
		<div class="alert alerts alert-warning" role="alert">
			{{ App\MaintenanceLocale::getLocale(313) }} <a href="{{ url('employer/details/'.Auth::user()->id.'/edit') }}">{{ App\MaintenanceLocale::getLocale(314) }}</a>!
		</div>
		@endif

		<h3 class="pricing-page-title">Pricing</h3>
		<h1 class="pricing-label-line"></h1>

		<div class="row">
			@foreach ($subscriptions as $subscription)
			<div class="col-sm-4 pricing-list-contents">
				<div class="card pricing-contents">
					<div class="card-body">
						<h3 class="pricing-title">
							{{ $subscription->title }} 
						</h3>
						<h1 class="pricing-price">
							${{number_format($subscription->price, 2, '.', '')}}
						</h1>
						<ul class="pricing-details-content">
							<li class="pricing-details">You can post a job up to {{$subscription->check_limit == 1 ? 'You can Post a Job Unlimited' : $subscription->limit}}</li>
							<li class="pricing-details">Your posted job will lasts {{$subscription->expiration}} Days</li>
							@if($subscription->check_technical)
								<li class="pricing-details">Technical Support 24/7</li>
							@endif
							@if($subscription->check_email)
								<li class="pricing-details">Recieve an email for matched applicant</li>
							@endif
							@if($subscription->check_reserve)
								<li class="pricing-details">Reserve Applicant</li>
							@endif
							@if($subscription->check_applicant)
								<li class="pricing-details">Can email to Applicant</li>
							@endif
							@if($subscription->check_blog)
								<li class="pricing-details">Can post a Blog</li>
							@endif
						</ul>
					</div>
					
						@if($profilestatus)
							@if ($subscription->price > 0)
								@if ($subsId == $subscription->id)
									<a class="btn pricing-button pricing-selected" disabled style="cursor:not-allowed;color:white;">CURRENT SUBSCRIPTION</a>
								@else 
								<a href="{{ url('subscription/'.Crypt::encrypt($subscription->id)) }}" class="btn btn-primary">Get {{ $subscription->title}}</a>
								<!--<form method="POST" action="{{ route('create-payment') }}" style="text-align:center;">
									@csrf
									<input type="text" name="subscriptionId" value="{{ $subscription->id }}" hidden>
									<button class="btn btn-primary">Get {{ $subscription->title}}</button>
								</form>-->
								@endif
							@endif
						@endif
					
				</div>
			</div>
			@endforeach
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			@if($errors->any())
				@if(isset($errors->messages()['subscriptionId']))
					Swal.fire(
					  "{{ $errors->messages()['subscriptionId'][0] }}",
					  '',
					  'error'
					)
				@endif
			@endif
		});
	</script>
@endsection
