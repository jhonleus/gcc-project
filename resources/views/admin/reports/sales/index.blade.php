
@extends('admin.layouts.master')

@section('title', "Sales")

@section('content')

<div class="container-fluid">
   <br>
   <div class="row justify-row-content">
      <div class="col-sm-6">
         <h3 class="m-0 text-dark">Sales</h3>
      </div>
   </div>
   <div class="row justify-row-content mt-3">
      <div class="col-sm-3">
         <input type="text" id="datasearchfield" class="form-control" placeholder="Search here..">
      </div>
   </div>

   <div class="row justify-row-content mt-3">
      <div class="col-md-12">
         <div class="card shadow-none">
            <div class="card-body">
               <div class="table-responsive">
                  <table id="usersTable" class="table table-bordered">
                     <thead>
                        <tr>
                          <th>ID</th>
                          <th>Subscription Type</th>
                          <th>Amount</th>
                          <th>Payment Status</th>
                          <th>Mode of Payment</th>
                          <th>Subscription Date</th>
                          <th>Subscription Expiry Date</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($sales as $sale)
                          @if(!is_null($sale->subscription))
                            @if($sale->subscription->price > 0)
                          <tr>
                            <td>{{$sale->id}}</td>
                            <td>{{$sale->subscription ? $sale->subscription->title : "-"}}</td>
                            <td>{{$sale->payment ? "$".number_format($sale->payment->amount, 2) : ""}}</td>
                            <td>SUCCESS</td>
                            <td>{{$sale->isPaypal == 1 ? "Paypal" : "Over the counter"}}</td>
                            <td>{{date_format(date_create($sale->first_day), 'F jS Y')}}</td>
                            <td>{{date_format(date_create($sale->last_day), 'F jS Y')}}</td>
                          </tr>
                            @endif
                          @endif
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
