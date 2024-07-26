@extends('backend.master')
@section('subtitle','Point Management')
@section('content')
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Point Management</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
				    <div class="x_title">
						<h2>Point Management</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
                        <form action="{{ route('point.update')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
							<input type="hidden" name="id" value="{{ $member->id }}"/>
                            @csrf
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Username
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="username" name="username" class="form-control" value="{{ $member->username}}" readonly/>
								</div>
                            </div>
                            <div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="point">Point<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="point" name="point" class="form-control" value="{{ old('point')}}" placeholder="Please enter the point to be added or subtracted"/>
								</div>
                            </div>
                            <div class="item form-group">
								<label for="action" class="col-form-label col-md-3 col-sm-3 label-align">Action<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 ">
									<select class="form-control" name="action" id="action">
										<option value="{{ getPointAction((string) 'add') }}" {{ old('action') == getPointAction((string) 'add') ? 'selected' : ''}}>Add</option>
										<option value="{{ getPointAction((string) 'subtract') }}" {{ old('action') == getPointAction((string) 'subtract') ? 'selected' : ''}}>Subtract</option>
									</select>
								</div>
							</div>
							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									<button class="btn btn-primary" type="reset">Reset</button>
									<button type="submit" name="submit" class="btn btn-success">Submit</button>
                                    <a href="{{ url('admin-backend/member/index') }}" class="btn btn-primary">Back</a>
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
        @if ($errors->has('point') || $errors->has('action') || $errors->has('id'))
            @if($errors->has('point'))
                var error_message = {{ $errors->first('point')}}
            @elseif($errors->has('action'))
                var error_message = {{ $errors->first('action')}}
            @elseif($errors->has('id'))
                var error_message = {{ $errors->first('id')}}
            @endif
            new PNotify({
                title: 'Oh No!',
                text: error_message,
                type: 'error',
                styling: 'bootstrap3'
            });
        @endif
    </script>
@endsection