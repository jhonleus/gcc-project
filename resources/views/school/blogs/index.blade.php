@extends('layouts.header')

@section('title', 'Posted Blog')

@section('content')
	<link rel="stylesheet" href="{{ asset('resources/css/custom/modal.css') }}">

	<div class="container page-container">
		<div class="row">
			<div class="col-sm-3">
				@include('school.sidebar.profile')
				@include('school.sidebar.index')
			</div>
		
			<div class="col-sm-9">
				<div class="card page-title">
					<div class="nav-tabs-wrapper">
						<ul class="nav nav-tabs" data-tabs="tabs">
							<li class="nav-item">
								<a class="nav-link active" href="#pending" data-toggle="tab">Pending <span class="badge badge-light ml-2">{{$pendings->total()}}</span></a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#approved" data-toggle="tab">Approved <span class="badge badge-light ml-2">{{$approveds->total()}}</span></a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#rejected" data-toggle="tab">Rejected <span class="badge badge-light ml-2">{{$rejecteds->total()}}</span></a>
							</li>
						</ul>
					</div>
				</div>

				<div class="tab-content">
					<div class="tab-pane active" id="pending">
						@php
							$currentDisplay = $pendings->currentPage() * $pendings->perPage();
						@endphp

						<div style="text-align:right"><small class="form-text text-muted mb-2">
							Showing (
							<span id="start-page">{{ $currentDisplay - ($pendings->perPage() - 1) }}</span>
							-
							<span id="end-page">{{ $currentDisplay < $pendings->total() ? $currentDisplay : $pendings->total() }}</span>
							of
							<span id="total-blog">{{ $pendings->total() }}</span> )
						</small></div>

						@foreach($pendings as $blog)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="card-header-2" style="padding-bottom:8%">
									<div class="row">
										<div class="col-sm-7">
											<label class="label-title-2">{{ $blog->title }}</label>
										</div> 
										<div class="col-sm-5">
											<p class="content-right">
												
												<form style="float:right;" action="/school/blogs/{{ $blog->id }}" method="POST" onsubmit="return confirm('{{ App\MaintenanceLocale::getLocale(151) }}')">
													@csrf
													@method('DELETE')
													<a class="label-blue label-button" href="{{ url('school/blogs/'.$blog->id.'/edit') }}">
														<i class="fa fa-edit" aria-hidden="true"></i>
														Edit
													</a>

													<button class="delete-job label-red label-button" style="background:none; border: none;">
														<i class="fa fa-trash" aria-hidden="true"></i> 
														Delete
													</button>
												</form>
					                        </p>
										</div> 
									</div>
								</div>

								<label class="content-details">
									{{ $blog->subtitle }}
								</label>

								<label class="content-details">
									<img class="label-image" style="height: 200px" src="{{ asset('blogs/'.$blog->filename) }}">
								</label>

								<label class="content-details">
									<small class="form-text text-muted font-weight-bold">Content:</small>
									{{ $blog->content }}
								</label>

								<div class="content-footer">
									<label class="label-date">POSTED: {{ $blog->created_at->diffForHumans() }}</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $pendings->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>

					<div class="tab-pane" id="approved">
						@php
							$currentDisplay = $approveds->currentPage() * $approveds->perPage();
						@endphp

						<div style="text-align:right"><small class="form-text text-muted mb-2">
							Showing (
							<span id="start-page">{{ $currentDisplay - ($approveds->perPage() - 1) }}</span>
							-
							<span id="end-page">{{ $currentDisplay < $approveds->total() ? $currentDisplay : $approveds->total() }}</span>
							of
							<span id="total-blog">{{ $approveds->total() }}</span> )
						</small></div>

						@foreach($approveds as $blog)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="card-header-2" style="padding-bottom:8%">
									<div class="row">
										<div class="col-sm-7">
											<label class="label-title-2">{{ $blog->title }}</label>
										</div> 
									</div>
								</div>

								<label class="content-details">
									{{ $blog->subtitle }}
								</label>

								<label class="content-details">
									<img class="label-image" style="height: 200px" src="{{ asset('blogs/'.$blog->filename) }}">
								</label>

								<label class="content-details">
									<small class="form-text text-muted font-weight-bold">Content:</small>
									{{ $blog->content }}
								</label>

								<div class="content-footer">
									<label class="label-date">POSTED: {{ $blog->created_at->diffForHumans() }}</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $approveds->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>

					<div class="tab-pane" id="rejected">
						@php
							$currentDisplay = $rejecteds->currentPage() * $rejecteds->perPage();
						@endphp

						<div style="text-align:right"><small class="form-text text-muted mb-2">
							Showing (
							<span id="start-page">{{ $currentDisplay - ($rejecteds->perPage() - 1) }}</span>
							-
							<span id="end-page">{{ $currentDisplay < $rejecteds->total() ? $currentDisplay : $rejecteds->total() }}</span>
							of
							<span id="total-blog">{{ $rejecteds->total() }}</span> )
						</small></div>

						@foreach($rejecteds as $blog)
						<div class="card page-contents">
							<div class="card-body page-content-body">
								<div class="card-header-2" style="padding-bottom:8%">
									<div class="row">
										<div class="col-sm-7">
											<label class="label-title-2">{{ $blog->title }}</label>
										</div> 
									</div>
								</div>

								<label class="content-details">
									{{ $blog->subtitle }}
								</label>

								<label class="content-details">
									<img class="label-image" style="height: 200px" src="{{ asset('blogs/'.$blog->filename) }}">
								</label>

								<label class="content-details">
									<small class="form-text text-muted font-weight-bold">Content:</small>
									{{ $blog->content }}
								</label>

								<div class="content-footer">
									<label class="label-date">POSTED: {{ $blog->created_at->diffForHumans() }}</label>
								</div>
							</div>
						</div>
						@endforeach

						<div class="mt-2">
							{{ $rejecteds->appends(request()->except('page'))->onEachSide(1)->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#blog-list").removeClass("sidebar-list-title");
			$("#blog-list").addClass("sidebar-list-title-active");
		});
	</script>
@endsection
