@extends('layouts.header')

@section('content')

{{-- container start --}}
<div class="container-fluid px-0" style="overflow: hidden;">
{{-- under maintenance page --}}
<div class="row" style="height: 90vh;">

		{{-- under maintenance illustration --}}
	<div class="col-lg-6 col-sm-12">
 		<img src="login-images/under-maintenance (2).png" class="img-fluid" alt="Responsive image" style="display: block;margin: 0px auto; width: 800px; height: 400px; margin-top: 15%; ">
	</div>

	{{-- under maintenance content --}}
	<div class="col-lg-6 col-sm-12">
 		<h1 class="text-align-justify" style="display: block;margin: 0px auto; margin-top: 30%;">"Sorry for the inconvenience. This Feature/Page are still on construction to serve you better." </h1>
 	</div>
</div>
{{-- container-end --}}

@endsection
