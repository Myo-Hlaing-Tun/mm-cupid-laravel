@extends('backend.master')
@section('subtitle','Change Password')
@section('content')
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Change Password</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
				    <div class="x_title">
						<h2>Change Password</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form action="{{ route('password.update')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
							<input type="hidden" name="id" value="{{ $id }}"/>
                            @csrf
                            <div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Password <span class="required">*</span>
								</label>
						    	<div class="col-md-6 col-sm-6 ">
									<input type="password" id="password" name="password" class="form-control" placeholder="Enter user password">
								</div>
							</div>
							<div class="item form-group">
								<label for="confirm_password" class="col-form-label col-md-3 col-sm-3 label-align">Confirm Password <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 ">
									<input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Enter confirm password">
								</div>
							</div>
							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									<button type="submit" name="submit" class="btn btn-success">Submit</button>
									<a href="{{ url('admin-backend/user/index') }}" class="btn btn-primary">Back</a>								
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
	@if ($errors->has('password') || $errors->has('confirm_password'))
		@if($errors->has('password'))
			<script>
				var error_message = "{{ $errors->first('password')}}"
			</script>
		@elseif($errors->has('confirm_password'))
			<script>
				var error_message = "{{ $errors->first('confirm_password')}}"
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