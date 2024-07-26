@extends('backend.master')
@section('subtitle',isset($hobby) ? 'Edit Hobby' : 'Create Hobby')
@section('content')
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>{{ isset($hobby) ? 'Edit hobby' : 'Create hobby' }}</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
				    <div class="x_title">
						<h2>{{ isset($hobby) ? 'Edit hobby' : 'Create hobby' }}</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						@if (isset($hobby))
							<form action="{{ route('hobby.update')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
							<input type="hidden" name="id" value="{{ $hobby->id }}"/>
						@else
							<form action="{{ route('hobby.store')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
						@endif
                            @csrf
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="hobby">hobby Name<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="hobby" name="hobby" class="form-control" value="{{old('hobby', isset($hobby->name) ? $hobby->name : '')}}" placeholder="Enter hobby name">
								</div>
							</div>		
							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									@if(!isset($hobby))
									<button class="btn btn-primary" type="reset">Reset</button>
									@endif
									<button type="submit" name="submit" class="btn btn-success">Submit</button>
									@if(isset($hobby))
										<a href="{{ url('admin-backend/hobby/index') }}" class="btn btn-primary">Back</a>
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
        @if ($errors->has('hobby'))
            new PNotify({
                title: 'Oh No!',
                text: "{{$errors->first('hobby')}}",
                type: 'error',
                styling: 'bootstrap3'
            });
        @endif
    </script>
@endsection