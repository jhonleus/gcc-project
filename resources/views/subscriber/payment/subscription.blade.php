@extends('layouts.header')
@section('title', 'Subscription')
@section('content')
  <div class="container" style="padding-top: 10%;">

    <div class="row">
      <div class="col-lg-8">
          <div class="card shadow mb-4">
            <div class="card-body">
              <h5>Payment Method</h5>
              <p>All transactions are secure and encrypted. Credit card information is never stored.</p>

              <hr class="mb-3">
                <section>
                    <div class="bt-drop-in-wrapper">
                        <div id="dropin-container"></div>
                    </div>
                </section>

                <input id="nonce" name="payment_method_nonce" type="hidden" />
                <div class="row mt-2 float-right">
                  <a href="/subscription/over-the-counter/{{Crypt::encrypt($subscription->id)}}"><button type="button" class="button btn btn-primary"><span>Pay Over the Counter</span></button></a>
                  <span class="mx-1 mt-2">- or -</span>

                  <form method="POST" action="{{ route('create-payment') }}" style="text-align:center;">
                    @csrf
                    <input type="text" name="subscriptionId" value="{{ $subscription->id }}" hidden>
                    <button class="button btn btn-primary mr-3" type="submit"><span>Credit Card / Paypal</span></button>
                  </form>
                </div>
            </div>
          </div>

          @foreach($banks as $bank)
          <div class="card shadow mb-4">
            <div class="card-body">
              <h5>Bank Details</h5>
              <p></p>
              <p><b>Bank Name: </b>{{ $bank->bank }}</p>
              <p><b>Name: </b>{{ $bank->name }}</p>
              <p><b>Account Number: </b>{{ $bank->number }}</p>
            </div>
          </div>
          @endforeach
      </div>
      <div class="col-lg-4">
        <div class="card shadow mb-4">
          <div class="card-body">
          
              <h4 style="float:left">{{ $subscription->title }}</h4>
              <h4 style="float:right; color:green">${{ $subscription->price }}</h4>
           
          </div>
        </div>

        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="container">
              <h6>Subscription Summary</h6>
              <hr style="margin:0">
              
              <p class="card-text" >
                <ul style="margin-left:-5%">
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
              </p>  
            </div>
          </div>
        </div>
      </div>

    </div> <!-- end of row -->

  </div>


<script>

  var check = true;
  function myFunction() {

    var x = document.getElementById("expiration").value;
    if (x.length > 1 && check) {
      check = false;
      document.getElementById("expiration").value = x + "/";
    } else if (x.length < 2 && !check) {
      check = true;
    }
  }
</script>
@endsection