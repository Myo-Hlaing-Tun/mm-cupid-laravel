@extends('backend.master')
@section('subtitle','Edit Setting')
@section('content')
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Setting</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
				    <div class="x_title">
						<h2>Setting</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form action="{{ route('setting.update')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                            @csrf
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="point">Point<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="number" id="point" name="point" class="form-control" value="{{old('point', $setting->point)}}" placeholder="Enter default point">
								</div>
							</div>
                            <div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="company_name">Company Name <span class="required">*</span>
								</label>
						    	<div class="col-md-6 col-sm-6 ">
									<input type="text" id="company_name" name="company_name" class="form-control" placeholder="Enter company name" value="{{old('company_name', $setting->company_name)}}"/>
								</div>
							</div>
							<div class="item form-group">
								<label for="company_email" class="col-form-label col-md-3 col-sm-3 label-align">Company Email</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="company_email" name="company_email" class="form-control" placeholder="Enter company email" value="{{old('company_email', $setting->company_email)}}"/>
								</div>
							</div>
							<div class="item form-group">
								<label for="company_address" class="col-form-label col-md-3 col-sm-3 label-align">Company Address</label>
								<div class="col-md-6 col-sm-6 ">
									<textarea id="company_address" name="company_address" class="form-control" rows="3" placeholder="Enter company address">{{old('company_address', $setting->company_address)}}</textarea>
								</div>
							</div>
                            <div class="item form-group">
								<label for="company_phone" class="col-form-label col-md-3 col-sm-3 label-align">Company Phone</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="company_phone" name="company_phone" class="form-control" placeholder="Enter company phone" value="{{old('company_phone', $setting->company_phone)}}"/>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="company_logo">Company Logo <span class="required">*</span>
								</label>
                                <div class="col-md-6 col-sm-6">
									<div id="preview" style="width:300px; min-height: 200px; max-height: 400px; overflow:hidden; border:1px solid gray; position: relative; border-radius: 10px;">
										<img src="{{ url('storage/images/'.$setting->company_logo)}}" class='img-thumb rounded-lg' alt='preview image' width=100% onclick="choosePhoto()"/>
                                    </div>
								</div>
							</div>
							<div class="item form-group">
								<div class="col-form-label col-md-3 col-sm-3 label-align"><span class="required"></span></div>
                                <div class="col-md-6 col-sm-6 " id="file-container">
									<input type="file" id="company_logo" name="company_logo" class="form-control" onchange="showPhoto()" style="display: none;"/>
								</div>
							</div>
							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									<button type="submit" name="submit" class="btn btn-success">Submit</button>
									<a href="{{ url('admin-backend/setting/index') }}" class="btn btn-primary">Back</a>							
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
			$('#company_logo').click();
		}

		function showPhoto(){
		const fileInput     	= document.getElementById('company_logo');
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
	@if ($errors->has('point') || $errors->has('company_name') || $errors->has('company_email') || $errors->has('company_address') || $errors->has('company_phone') || $errors->has('company_logo'))
		@if($errors->has('point'))
			<script>
				var error_message = "{{ $errors->first('point')}}"
			</script>
		@elseif($errors->has('company_name'))
			<script>
				var error_message = "{{ $errors->first('company_name')}}"
			</script>
		@elseif($errors->has('company_email'))
			<script>
				var error_message = "{{ $errors->first('company_email')}}"
			</script>
		@elseif($errors->has('company_address'))
			<script>
				var error_message = "{{ $errors->first('company_address')}}"
			</script>
		@elseif($errors->has('company_phone'))
			<script>
				var error_message = "{{ $errors->first('company_phone')}}"
			</script>
		@elseif($errors->has('company_logo'))
			<script>
				var error_message = "{{ $errors->first('company_logo')}}"
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