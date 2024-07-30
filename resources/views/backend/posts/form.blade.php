@extends('backend.master')
@section('subtitle', isset($post) ? 'Edit Post' : 'Create Post')
@section('content')
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
				    <div class="x_title">
						<h2>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						@if (isset($post))
						<form action="{{ route('post.update') }}" method="POST" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
						<input type="hidden" name="id" value="{{ $post->id }}"/>
						@else
						<form action="{{ route('post.store') }}" method="POST" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
						@endif
                            @csrf
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Title<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="title" name="title" class="form-control" value="{{old('title', isset($post) ? $post->title : '')}}" placeholder="Enter post title"/>
								</div>
							</div>
                            <div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="description">Description<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
                                    <textarea id="description" rows="10" name="description" class="form-control" placeholder="Enter Your Post Description">{{old('description', isset($post) ? $post->description : '')}}</textarea>
								</div>
							</div>

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="company_logo">Post Photo <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <div id="preview" style="width:300px; min-height: 200px; max-height: 400px; overflow:hidden; border:1px solid gray; position: relative; border-radius: 10px;">
										@if(isset($post))
										<img src="{{ url('storage/posts/' . $post->id . '/' . $post->fullsize_photo) }}" class='img-thumb rounded-lg' alt='preview image' width=100% onclick="choosePhoto()"/>
										@else
                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); cursor: pointer; font-size: 18px; border: 1px solid gray; padding: 5px; border-radius: 10px;" onclick="choosePhoto()">Choose File</div>
										@endif
                                    </div>
                                </div>
                            </div>
                            <div class="item form-group">
                                <div class="col-form-label col-md-3 col-sm-3 label-align"><span class="required"></span></div>
                                <div class="col-md-6 col-sm-6 " id="file-container">
                                    <input type="file" id="post_photo" name="post_photo" class="form-control" onchange="showPhoto()" style="display: none;"/>
                                </div>
                            </div>

							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									<button type="submit" name="submit" class="btn btn-success">Submit</button>
									@if(!isset($post))
									<button class="btn btn-primary" type="reset">Reset</button>
									@endif
									
									@if(isset($post))
									<button type="submit" class="btn btn-primary"><a href="{{ url('admin-backend/post/index') }}" class="text-white">Back</a></button>
									@endif
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
</div>
@endsection

@section('javascript')
<script>
	function choosePhoto(){
		$('#post_photo').click();
	}

	function showPhoto(){
		const fileInput     	= document.getElementById('post_photo');
		const fileContainer 	= document.getElementById('file-container');
		const previewElement 	= document.getElementById('preview');
		let files 				= fileInput.files;
		let fileName 			=fileInput.value;
		let allowedExtensions 	= ['jpeg','jpg','png','gif','webp'];

		let extension = fileName.split('.').pop().toLowerCase();
		if(allowedExtensions.indexOf(extension)<0){
			new PNotify({
				title: 'Oh No!',
				text: 'Only JPG,JPEG,PNG and GIF files are accepted',
				type: 'error',
				styling: 'bootstrap3'
			});
			fileContainer.innerHTML = `<input type="file" id="company_logo" name="company_logo" class="form-control" onchange="showPhoto()" style="display: none;"/>`;
			previewElement.style.border = "1px solid gray";
			previewElement.innerHTML = `
										<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); cursor: pointer; font-size: 18px; border: 1px solid gray; padding: 5px; border-radius: 10px;" onclick="choosePhoto()">Choose File</div>`;
		}
		else if (files.length > 0) {
			let file = files[0];

			let reader = new FileReader();

			reader.onload = function(e) {
				let imageLink = e.target.result;
				previewElement.innerHTML = `<img src=${imageLink} class='img-thumb rounded-lg' alt='preview image' width=100% onclick="choosePhoto()"/>`;
				previewElement.style.border = "none";
				previewElement.style.display = '';
			}
			reader.readAsDataURL(file);
		}
	};
</script>
	@if ($errors->has('title') || $errors->has('description') || $errors->has('post_photo'))
		@if($errors->has('title'))
			<script>
				var error_message = "{{ $errors->first('title')}}"
			</script>
		@elseif($errors->has('description'))
			<script>
				var error_message = "{{ $errors->first('description')}}"
			</script>
		@elseif($errors->has('post_photo'))
			<script>
				var error_message = "{{ $errors->first('post_photo')}}"
			</script>
		@endif
		<script>
			new PNotify({
				title: 'Oh No!',
				text: error_message,
				type: 'error',
				styling: 'bootstrap3'
			});
		</script>
	@endif
@endsection