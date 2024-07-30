@extends('backend.master')
@section('subtitle',isset($city) ? 'Edit City' : 'Create City')
@section('content')
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>{{ isset($city) ? 'Edit City' : 'Create City' }}</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
				    <div class="x_title">
						<h2>{{ isset($city) ? 'Edit City' : 'Create City' }}</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						@if (isset($city))
							<form action="{{ route('city.update')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
							<input type="hidden" name="id" value="{{ $city->id }}"/>
						@else
							<form action="{{ route('city.store')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
						@endif
                            @csrf
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="city_name">City Name<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="city_name" name="city_name" class="form-control" value="{{old('city_name', isset($city->name) ? $city->name : '')}}" placeholder="Enter city name">
								</div>
							</div>		
							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									<button type="submit" name="submit" class="btn btn-success">Submit</button>
									@if(!isset($city))
									<button class="btn btn-primary" type="reset">Reset</button>
									@endif
									@if(isset($city))
										<a href="{{ url('admin-backend/city/index') }}" class="btn btn-primary">Back</a>
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
        @if ($errors->has('city_name'))
            new PNotify({
                title: 'Oh No!',
                text: "{{$errors->first('city_name')}}",
                type: 'error',
                styling: 'bootstrap3'
            });
        @endif
    </script>
@endsection