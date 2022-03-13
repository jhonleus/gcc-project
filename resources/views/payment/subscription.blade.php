@extends(Auth::check() ? Auth::user()->roles->id == 2 ? 'employer.layouts.app' : 'layouts.app' : 'layouts.app')

@section('title', 'Subscription')
@section('content')
<div class="aboutsection1">
  <div class="container">

    <div class="row">
      <div class="col-lg-8">
        <div class="container">

          <div class="card shadow mb-4">
            <div class="card-body">

              <h5>Payment Method</h5>
              <p>All transactions are secure and encrypted. Credit card information is never stored.</p>
              <hr class="mb-3">

              <form method="POST" action="{{ route('payment.store') }}">
                @csrf
              
              <input type="text" name="subscriptionId" value="{{ $decrypt }}" class="my-2 form-control" hidden>

              <h6 class="my-2">Card Number</h6>
              <input type="number" name="number" maxlength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="my-2 form-control" required>

              <h6 class="my-2">Name on Card</h6>
              <input type="text" name="name" class="my-2 form-control" required>

              <div class="row my-2">
                <div class="col-lg-4">
                  <h6>Expiration Date</h6>
                  <input type="text" name="expiration" maxlength="5" id="expiration" onkeyup="myFunction()" class="my-2 form-control" required>
                </div>
                
                <div class="col-lg-4">
                  <h6>CCV</h6>
                  <input type="number" name="ccv" maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="my-2 form-control" required>
                </div>
              </div>

              <hr>

              <button type="submit" class="btn btn-primary">Check-Out</button>

              </form>

            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-4">
        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="container">
              <h4 style="float:left">{{ $subscription->title }}</h4>
              <h4 style="float:right; color:green">${{ $subscription->price }}</h4>
            </div>
          </div>
        </div>

        <p hidden>
          @php ($array = [])
          {{ array_push($array, 'You can Post a Job up to '.$subscription->limit) }}
          {{ array_push($array, 'Your Posted Job will lasts '.$subscription->expiration. ' Days') }}
          {{ $subscription->check_reserve ? array_push($array, 'Reserve Applicant') : '' }}
          {{ $subscription->check_technical ? array_push($array, 'Technical Support 24/7') : '' }}
          {{ $subscription->check_email ? array_push($array, 'Recieve an email for matched applicant') : '' }}
        </p>

        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="container">
              <h6>Subscription Summary</h6>
              <hr style="margin:0">
              
              <p class="card-text" >
                <ul style="margin-left:-5%">
                  <li>{{ $subscription->trial }} days subscription</li>
                  @foreach ($array as $val)
                  <li>{{ $val }}</li>
                  @endforeach
                </ul>
              </p>  
            </div>
          </div>
        </div>
      </div>

    </div> <!-- end of row -->

  </div>
</div>
/
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