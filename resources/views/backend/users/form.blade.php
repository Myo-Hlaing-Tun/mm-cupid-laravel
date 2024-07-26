@extends('backend.master')
@section('subtitle',isset($user) ? 'Edit User' : 'Create User')
@section('content')
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>{{ isset($user) ? 'Edit User' : 'Create User' }}</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
				    <div class="x_title">
						<h2>{{ isset($user) ? 'Edit User' : 'Create User' }}</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						@if (isset($user))
							<form action="{{ route('user.update')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
							<input type="hidden" name="id" value="{{ $user->id }}"/>
						@else
							<form action="{{ route('user.store')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
						@endif
                            @csrf
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Username<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="username" name="username" class="form-control" value="{{old('username', isset($user->username) ? $user->username : '')}}" placeholder="Enter user name">
								</div>
							</div>
							@if(!isset($user))
                            <div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Password <span class="required">*</span>
								</label>
						    	<div class="col-md-6 col-sm-6 ">
									<input type="password" id="password" name="password" class="form-control" placeholder="Enter user password">
								</div>
							</div>
							<div class="item form-group">
								<label for="confirm_password" class="col-form-label col-md-3 col-sm-3 label-align">Confirm Password<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 ">
									<input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Enter confirm password">
								</div>
							</div>
							@endif
							<div class="item form-group">
								<label for="role" class="col-form-label col-md-3 col-sm-3 label-align">Role<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 ">
									<select class="form-control" name="role" id="role">
										<option value="">Choose user role</option>
										<option value="{{ getUserRole((string) 'admin') }}" {{ old('role', isset($user) ? $user->role : '') == getUserRole((string) 'admin') ? 'selected' : ''}}>Admin</option>
										<option value="{{ getUserRole((string) 'customer-service') }}" {{ old('role', isset($user) ? $user->role : '') == getUserRole((string) 'customer-service') ? 'selected' : ''}}>Customer Service</option>
										<option value="{{ getUserRole((string) 'editor') }}" {{ old('role', isset($user) ? $user->role : '') == getUserRole((string) 'editor') ? 'selected' : ''}}>Editor</option>
									</select>
								</div>
							</div>
							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									@if(!isset($user))
									<button class="btn btn-primary" type="reset">Reset</button>
									@endif
									<button type="submit" name="submit" class="btn btn-success">Submit</button>
									@if(isset($user))
										<a href="{{ url('admin-backend/user/index') }}" class="btn btn-primary">Back</a>
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
	@if ($errors->has('username') || $errors->has('password') || $errors->has('confirm_password') || $errors->has('role'))
		@if($errors->has('username'))
			<script>
				var error_message = "{{ $errors->first('username')}}"
			</script>
		@elseif($errors->has('password'))
			<script>
				var error_message = "{{ $errors->first('password')}}"
			</script>
		@elseif($errors->has('confirm_password'))
			<script>
				var error_message = "{{ $errors->first('confirm_password')}}"
			</script>
		@elseif($errors->has('role'))
			<script>
				var error_message = "{{ $errors->first('role')}}"
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