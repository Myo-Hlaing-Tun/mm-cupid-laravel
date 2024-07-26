@extends('backend.master')
@section('subtitle','Setting')
@section('content')
@if($setting != null)
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
					<div class="x_title">
						<h2>Setting</h2>
						<div class="clearfix"></div>
					</div>

                	<div class="x_content">

                	<!-- <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p> -->

					<div class="table-responsive">
						<table class="table table-striped jambo_table bulk_action">
							<thead class="text-center">
								<tr class="headings">
								<th>
									<input type="checkbox" id="check-all" class="flat">
								</th>
								<th class="column-title">Point</th>
								<th class="column-title">Company Logo</th>
								<th class="column-title">Company Name</th>
								<th class="column-title">Company Email</th>
								<th class="column-title">Company Phone</th>
								<th class="column-title">Company Address</th>
								<th class="column-title">Edit</th>
								<th class="bulk-actions" colspan="7">
									<a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
								</th>
							</tr>
							</thead>

							<tbody class="text-center">
								<tr class="even pointer">
									<td class="a-center align-middle">
										<input type="checkbox" class="flat" name="table_records">
									</td>
									<td class="align-middle">{{ $setting->point }}</td>
									<td class="align-middle">
										<img src="{{ url('storage/images/'.$setting->company_logo)}}" width=100px alt="company logo" />
									</td>
									<td class="align-middle">{{ $setting->company_name }}</td>
									<td class="align-middle">{{ $setting->company_email }}</td>
									<td class="align-middle">{{ $setting->company_phone }}</td>
									<td class="align-middle">{{ $setting->company_address }}</td>
									<td class="align-middle">
										<a href="{{ url('admin-backend/setting/edit')}}" class="btn btn-success"><i class="fa fa-pencil">  Edit Setting</i></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>	
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@else
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
						<form action="{{ route('setting.store')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                            @csrf
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="point">Point<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="number" id="point" name="point" class="form-control" value="{{old('point')}}" placeholder="Enter default point">
								</div>
							</div>
                            <div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="company_name">Company Name <span class="required">*</span>
								</label>
						    	<div class="col-md-6 col-sm-6 ">
									<input type="text" id="company_name" name="company_name" class="form-control" placeholder="Enter company name" value="{{old('company_name')}}"/>
								</div>
							</div>
							<div class="item form-group">
								<label for="company_email" class="col-form-label col-md-3 col-sm-3 label-align">Company Email</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="company_email" name="company_email" class="form-control" placeholder="Enter company email" value="{{old('company_email')}}"/>
								</div>
							</div>
							<div class="item form-group">
								<label for="company_address" class="col-form-label col-md-3 col-sm-3 label-align">Company Address</label>
								<div class="col-md-6 col-sm-6 ">
									<textarea id="company_address" name="company_address" class="form-control" rows="3" placeholder="Enter company address">{{old('company_address')}}</textarea>
								</div>
							</div>
                            <div class="item form-group">
								<label for="company_phone" class="col-form-label col-md-3 col-sm-3 label-align">Company Phone</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="company_phone" name="company_phone" class="form-control" placeholder="Enter company phone" value="{{old('company_phone')}}"/>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="company_logo">Company Logo <span class="required">*</span>
								</label>
                                <div class="col-md-6 col-sm-6">
									<div id="preview" style="width:300px; min-height: 200px; max-height: 400px; overflow:hidden; border:1px solid gray; position: relative; border-radius: 10px;">
										<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); cursor: pointer; font-size: 18px; border: 1px solid gray; padding: 5px; border-radius: 10px;" onclick="choosePhoto()">Choose File</div>
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
									<button class="btn btn-primary" type="reset">Reset</button>
									<button type="submit" name="submit" class="btn btn-success">Submit</button>							
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
@endif
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