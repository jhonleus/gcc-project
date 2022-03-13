@extends('admin.layouts.master')

@section('title', App\MaintenanceLocale::getLocale(3))

@section('content')
<!--jquery for the functionality of date range table important! -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<div class="container-fluid">    
  <br />
  <div class="row input-daterange">
    <div class="col-md-4">
      <label>{{ App\MaintenanceLocale::getLocale(138) }}</label>
      <input type="text" name="from_date" id="from_date" class="form-control" readonly />
    </div>
    <div class="col-md-4">
      <label>Date Paid</label>
      <input type="text" name="to_date" id="to_date" class="form-control" readonly />
    </div>
    <div class="col-md-4 mt-4">
      <button type="button" name="filter" id="filter" class="btn btn-primary">{{ App\MaintenanceLocale::getLocale(140) }}</button>
      <button type="button" name="refresh" id="refresh" class="btn btn-default">Date</button>
    </div>
  </div>
  <br/>
  <div class="table-responsive">
    <table class="table table-bordered" id="salesTable">
      <thead>
        <tr>
          <th>ID</th>
                    <th>Subscription Type</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Mode of Payment</th>
                    <th>Subscription Date</th>
                    <th>Subscription Expiry Date</th>
                    <th>Number of Subscription</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

