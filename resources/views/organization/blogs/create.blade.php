@extends('layouts.header')

@section('title', $blogs ? 'Update Blog' : 'Post Blog')

@section('content')
	<div class="container page-container">
		@if(!$isSubscriptionEnded) 
			<div class="alert alerts alert-warning" role="alert">
				Your subscription has been ended, renew your subscription <a href="{{ url('pricing') }}">here</a>!
			</div>
		{{-- @else
			@if($canPostBlog < 1)
				<div class="alert alerts alert-warning" role="alert">
					Your subscription has no blog posting features, upgrade your subscription <a href="{{ url('pricing') }}">here</a>.!
				</div>
			@endif --}}
		@endif

		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="card sidebar-settings">
					<div class="card-header card-header-1">
						<label class="label-information">@if(isset($blogs)) Update @else Post @endif Blog</label>
					</div>
					<div class="card-body">
						@if(isset($blogs))
					<form method="POST" action="{{ route('organization.blogs.update', $blogs->id) }}" enctype="multipart/form-data">
						@method('PUT')
						@csrf

						<div class="contents-form">
							<h1 class="label-select">Current Cover Photo:</h1>
							<img style="height: 200px" src="{{ asset('blogs/'.$blogs->filename) }}" class="label-image">
						</div>
					@else
					<form method="POST" action="{{ route('organization.blogs.store') }}" enctype="multipart/form-data">  
						@csrf
					@endif
            			<div class="contents-form">
							<h1 class="label-select">Title:</h1>

							<input type="text" class="input" name="title" id="title" value="@if($errors->any()){{ old('title') }}@else @if(isset($blogs)){{$blogs->title}}@endif @endif">

							<div class="error-container">
								<label class="label-error error-title">{{ $message['ER:00:89'] }}</label>
							</div>
                        </div>
                        
						<div class="contents-form">
	                        <div class="row">
		                        <div class="col">
									<h1 class="label-select">Sub-Title:</h1>

									<input type="text" class="input" name="subtitle" id="subtitle" value="@if($errors->any()){{ old('title') }}@else @if(isset($blogs)){{$blogs->subtitle}}@endif @endif">

									<div class="error-container">
										<label class="label-error error-subtitle">{{ $message['ER:00:90'] }}</label>
									</div>
								</div>

								<div class="col">
								<h1 class="label-select">From</h1>
		                            <select class="select @if(isset($blogs)) select-selected @endif" name="type" id="type" required="required">
		                                <option selected hidden disabled>Choose...</option>
		                                <option value="0" @if(isset($blogs))@if($blogs->type==0) selected @endif @endif>Japan</option>
		                                <option value="1" @if(isset($blogs))@if($blogs->type==1) selected @endif @endif>Philippines</option>
		                            </select>	

		                            <div class="error-container">
										<label class="label-error error-type">{{ $message['ER:00:94'] }}</label>
									</div>
								</div>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">Content</h1>

							<div class="ckeditor-news">
								<textarea class="txtarea" name="content" id="content">@if($errors->any()){{ old('title') }}@else @if(isset($blogs)){{$blogs->content}}@endif @endif</textarea>
							</div>

							<div class="error-container">
								<label class="label-error error-content">{{ $message['ER:00:91'] }}</label>
							</div>
						</div>

						<div class="contents-form">
							<h1 class="label-select">@if(isset($blogs)) Change @else Choose @endif Cover Photo</h1>

  							<input class="input" type="file" name="photo" id="photo" accept="image/*" onchange="readURL(this);">

							<div class="error-container">
								<label class="label-error error-file">{{ $message['ER:00:91'] }}</label>
							</div>

							<label id="textPreview" class="text-muted small mt-4" style="display:none; width:100%">Preview:</label>
              				<img class="label-image" id="photoPrev" style="display:none; height: 200px">
						</div>

						<div class="content-footer-2">
							<button class="btn label-button btn-primary" id="post">@if(isset($blogs)) Update @else Post @endif</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			@if($errors->any()) 
				@if(isset($errors->messages()['id']))  
					@if(preg_match('/required./', $errors->messages()['id'][0]))
						Swal.fire('Ooops', "{{ $message['ER:00:95'] }}", 'error')
					@else
						Swal.fire('Ooops', "{{ $message['ER:00:96'] }}", 'error')
					@endif
				@endif

				@if(isset($errors->messages()['photo']))  
					@if(preg_match('/required./', $errors->messages()['photo'][0]))
						$(".error-file").show();
						$(".error-file").html("{{ $message['ER:00:92'] }}");
						$("#photo").css("border", "1px solid red");
					@endif
				@endif

				@if(isset($errors->messages()['title']))  
					@if(preg_match('/required./', $errors->messages()['title'][0]))
						$(".error-title").show();
						$(".error-title").html("{{ $message['ER:00:89'] }}");
						$("#title").css("border", "1px solid red");
					@endif
				@endif

				@if(isset($errors->messages()['subtitle']))  
					@if(preg_match('/required./', $errors->messages()['subtitle'][0]))
						$(".error-subtitle").show();
						$(".error-subtitle").html("{{ $message['ER:00:90'] }}");
						$("#subtitle").css("border", "1px solid red");
					@endif
				@endif

				@if(isset($errors->messages()['content']))  
					@if(preg_match('/required./', $errors->messages()['content'][0]))
						$(".error-content").show();
						$(".error-content").html("{{ $message['ER:00:91'] }}");
						$("#content").css("border", "1px solid red");
					@endif
				@endif

				@if(isset($errors->messages()['type']))  
					@if(preg_match('/required./', $errors->messages()['type'][0]))
						$(".error-type").show();
						$(".error-type").html("{{ $message['ER:00:94'] }}");
						$("#type").css("border", "1px solid red");
					@else
						$(".error-type").show();
						$(".error-type").html("{{ $message['ER:00:93'] }}");
						$("#type").css("border", "1px solid red");
					@endif
				@endif
			@endif
		});

		@if($canPostBlog > 0)
		$("#post").click(function(e) {
            var title 		= $("#title").val();
				title 		= title.trim();
                subtitle 	= $("#subtitle").val();
				subtitle 	= subtitle.trim();
				content 	= $("#content").val();
				content 	= content.trim();
				@if(!isset($blogs))
					file 	= $('#photo').get(0).files.length;
				@else 
					file 	= 1;
				@endif
				type 	= $("#type").val();

			if(title==="" || subtitle==="" || content==="" || file === 0 || type===null || type==="") {
				e.preventDefault();
				if(title==="") {
					$(".error-title").show();
					$(".error-title").html("{{ $message['ER:00:89'] }}");
					$("#title").css("border", "1px solid red");
                }
                
                if(subtitle==="") {
					$(".error-subtitle").show();
					$(".error-subtitle").html("{{ $message['ER:00:90'] }}");
					$("#subtitle").css("border", "1px solid red");
				}

				if(content==="") {
					$(".error-content").show();
					$(".error-content").html("{{ $message['ER:00:91'] }}");
					$("#content").css("border", "1px solid red");
				}

				if(type==="" || type===null) {
					$(".error-type").show();
					$(".error-type").html("{{ $message['ER:00:94'] }}");
					$("#type").css("border", "1px solid red");
				}

				if(file === 0) {
					$(".error-file").show();
					$(".error-file").html("{{ $message['ER:00:92'] }}");
					$("#photo").css("border", "1px solid red");
				}
			}
		});

		$("#photo").change(function() {
			var file = $(this).get(0).files.length;

			if(file===0) {
			    $(".error-file").show();
			    $(".error-file").html("{{ $message['ER:00:91'] }}");
				$("#photo").css("border", "1px solid red");
			}
			else {
			    $(".error-file").hide();
				$("#photo").css("border", "");
			}
		});

		$("#title").keyup(function() {
			var file = $(this).val().length;

			if(file < 1) {
			    $(".error-title").show();
			    $(".error-title").html("{{ $message['ER:00:89'] }}");
				$("#title").css("border", "1px solid red");
			}
			else {
			    $(".error-title").hide();
				$("#title").css("border", "");
			}
        });
        
        $("#subtitle").keyup(function() {
			var file = $(this).val().length;

			if(file < 1) {
			    $(".error-subtitle").show();
			    $(".error-subtitle").html("{{ $message['ER:00:90'] }}");
				$("#subtitle").css("border", "1px solid red");
			}
			else {
			    $(".error-subtitle").hide();
				$("#subtitle").css("border", "");
			}
		});

		$("#content").keyup(function() {
			var file = $(this).val().length;

			if(file < 1) {
			    $(".error-content").show();
			    $(".error-content").html("{{ $message['ER:00:91'] }}");
				$("#content").css("border", "1px solid red");
			}
			else {
			    $(".error-content").hide();
				$("#content").css("border", "");
			}
		});

		$("#type").change(function() {
		    $(".error-type").hide();
			$("#type").css("border", "");
		});

		function readURL(input) {
  
			if (input.files && input.files[0])
			{
				var reader = new FileReader();
				reader.onload = function (e)
				{
				document.getElementById('photoPrev').style.display = "";
				document.getElementById('textPreview').style.display = "block";
				$('#photoPrev').attr('src',e.target.result);
				};
				reader.readAsDataURL(input.files[0]);
				
			}
		}
		@endif
	</script>
@endsection