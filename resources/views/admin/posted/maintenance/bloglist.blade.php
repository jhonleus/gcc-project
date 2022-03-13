@extends('admin.layouts.master')

@section('title', $title)

@section('content')

<br>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="card shadow-none col-12 p-0">
      		<h5 class="font-weight-bold p-2">Blog list</h5>
				<table class="table table-hover">
  					<thead>
    					<tr>
      						<th scope="col">Date</th>
      						<th scope="col">Title</th>
      						<th scope="col">Sub-title</th>
      						<th scope="col">Edit</th>
       						<th scope="col">Delete</th>
    					</tr>
  					</thead>
  					<tbody>
    					<tr>
      						<th scope="row">20/01/2020</th>
      						<td>Mark</td>
      						<td>Otto</td>
      						<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable">Edit</button></td>
      						<td><button class="btn btn-danger">Delete</button></td>
    					</tr>
  					</tbody>
				</table>
			<nav aria-label="Page navigation example">
  				<ul class="pagination justify-content-left p-2">
    				<li class="page-item">
      					<a class="page-link" href="#" aria-label="Previous">
        					<span aria-hidden="true">&laquo;</span>
        					<span class="sr-only">Previous</span>
      					</a>
    				</li>
    				<li class="page-item"><a class="page-link" href="#">1</a></li>
    				<li class="page-item"><a class="page-link" href="#">2</a></li>
    				<li class="page-item"><a class="page-link" href="#">3</a></li>
    				<li class="page-item">
      					<a class="page-link" href="#" aria-label="Next">
        					<span aria-hidden="true">&raquo;</span>
        					<span class="sr-only">Next</span>
      					</a>
    				</li>
  				</ul>
			</nav>
		</div>
	</div>
</div>

@foreach ($maintenance_blogs)
 {{$maintenance_blogs->id}}
   {{$maintenance_blogs->filename}}
  {{$maintenance_blogs->blog_title}} 
  {{$maintenance_blogs->blog_subtitle}}
  {{$maintenance_blogs->blog_content}}

@endforeach

<!-- Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection