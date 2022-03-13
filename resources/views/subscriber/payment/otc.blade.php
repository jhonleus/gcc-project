@extends('layouts.header')
@section('title', 'Over the Counter')
@section('content')
<style>
.imgs-home {
  height: 100px;
  width: 100px;
}
</style>
<div class="container" style="height: 100vh; padding-top: 10%; margin-bottom:20%">

  <div class="row">
    <div class="col-lg-8">
     
      <div class="card shadow mb-4">
        <div class="card-body">
          <h5>Over the Counter</h5>
          <hr class="mb-3">

          <form method="POST" action="{{ route('payment.otc') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="subscription_id" value="{{ $decrypt }}" class="form-control">

          <h1 class="label-select">Select Bank</h1>
          <select name="banks" class="select select-size-2 select-selected" required>
            <option hidden disabled selected></option>
            @foreach($banks as $val)
            <option value="{{ $val->id }}">{{ $val->bank }}</option>
            @endforeach
          </select> 

          <h1 class="label-select mt-2">Transaction ID:</h1>
          <input type="text" name="transaction" class="input input-size-2" required>
          
          <h1 class="label-select mt-2">Name:</h1>
          <input type="text" name="name" class="input input-size-2" required>
          
          <div class="row mt-2">
                <div class="col-lg-6">
                    <h1 class="label-select">Date:</h1>
                    <input type="text" name="date" class="input input-size-2" required>
                </div>
                <div class="col-lg-6">
                    <h1 class="label-select">Amount:</h1>
                    <input type="text" name="amount" class="input input-size-2" required>
                </div>
          </div>

          <label class="text-muted small mt-3" style="width:100%;">Upload Receipt</label>
                  <input accept="image/*" type="file" class="form-control-file" id="photo_name" name="photo_name" onchange="readURLs(this);" hidden required/>
                  <label for="photo_name" class="btn btn-light ">{{ App\MaintenanceLocale::getLocale(203) }}</label>

                  <label id="textPreview" class="text-muted small mt-2" style="display:none; width:100%">{{ App\MaintenanceLocale::getLocale(193) }}:</label>
                  <img class="imgs-home mt-1" id="image" style="display:none;">

          <a class="d-flex justify-content-center mt-4" style="color:#000; text-decoration: underline;" href="{{ url('subscription/'.Crypt::encrypt($subscription->id)) }}   ">
            <small class="text-muted">Choose another way to pay</small>
          </a>

          <div class="row mt-2 float-right">
            <button class="button btn btn-primary mr-3" type="submit"><span>Submit</span></button>
          </div>
        </form>

 
        </div>
      </div>
      
    </div>
    <div class="col-lg-4">
      <div class="card shadow mb-4">
        <div class="card-body">
          
          <h4 style="float:left">{{ $subscription->title }}</h4>
          <h4 style="float:right; color:green">${{ $subscription->price }}</h4>
          
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


<script>

function readURLs(input) {
  
  if (input.files && input.files[0])
  {
    var reader = new FileReader();
    reader.onload = function (e)
    {
      document.getElementById('image').style.display = "";
      document.getElementById('textPreview').style.display = "block";
      $('#image').attr('src',e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
    
  }
}

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