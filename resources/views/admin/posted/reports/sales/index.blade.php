@extends('admin.layouts.master')
@section('content')
 <div class="container-fluid">
      <br>
      <div class="row justify-row-content">
        <div class="col-sm-6">
          <h3 class="m-0 text-dark">Sales Report</h3>
        </div>
      </div>
      <div class="row justify-row-content mt-3">
        <div class="col-sm-3">
          <input type="text" id="datasearchfield" class="form-control" placeholder="Search here..">
        </div>
      </div>
      <br>
      <div class="col">
        <tr>
            <td>Minimum Date:</td>
            <td><input type="text" id="min" name="min"></td>
        </tr>
        <tr>
            <td>Maximum Date:</td>
            <td><input type="text" id="max" name="max"></td>
        </tr>
      </div>
      <div class="row justify-row-content mt-3">
        <div class="col-md-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="salesTable" class="table table-bordered">
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
              <tbody>
            @foreach($sales as $sales)
              <tr>
                <td>{{$sales->id}}</td>
                <td>{{$sales->sales_data}}</td>
                <td>{{$sales->created_at->format('d-m-Y')}}</td>
              </tr>
            @endforeach
              </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
    </div>
@endsection