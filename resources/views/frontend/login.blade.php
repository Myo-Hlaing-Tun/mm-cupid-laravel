@extends('frontend.master')
@section('subtitle','Login')
@section('content')
<div class="container my-5" ng-app="myApp" ng-controller="MyController" ng-init="init()">
    <div class="row">
        <div class="col"></div>

        <div class="col-md-5">
          <h1 class="fw-bold" style="font-size: 60px">Login</h1>
          <div class="py-3" style="font-size: 14px;">
            Do not have an account? <a href="{{ url('register') }}" class="text-black">Register</a>
          </div>
          <form action="{{ route('member.login')}}" method="POST" id="form">
            @csrf
            <div>
              <input type="email" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Email" name="email" id="email" ng-model="email" value="{{ old('email') }}" ng-blur="validate('email')" ng-change="change(); validate('email')"/>
              <p ng-if="error_msg_email" class="text-danger">@{{error_msg_email}}</p>
              <div class="position-relative">
                <input type="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Password" name="password" id="password" ng-model="password" ng-blur="validate('password')" ng-change="change(); validate('password')"/>
                <i class="fa fa-eye-slash position-absolute top-50 end-0 fs-4" style="transform: translate(-50%,-50%)" id="password_eye" ng-mousedown="reveal('password')" ng-mouseup="hide('password')"></i>
              </div>
              <p ng-if="error_msg_password" class="text-danger">@{{error_msg_password}}</p>

              <button class="btn btn-dark rounded rounded-5 btn-lg mt-4" type="button" id="next_btn1" style="width: 100%;" ng-click="step1();" ng-disabled="process_error">Login</button>
            </div>

            <input type="hidden" name="form-sub" id="form-sub" value="1"/>
          </form>
          <a href="{{ url('forget-password') }}" class="d-block py-3" style="font-size: 14px;">Foget your password?</a>
          <p class="w-100 mt-4 fw-medium text-center" style="font-size: 12px; line-height:16px;">By signing up, you agree to our
            <a href="javascript:void(0)" class="text-black">Terms & Conditions</a>. Learn how we
            use your data in our
            <a href="javascript:void(0)" class="text-black">Privacy Policy</a>
          </p>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection
@section('javascript')
<!-- angular js -->
<script src="{{ url('/assets/js/frontend/login.js?v=20240703') }}"></script>

<!-- pnotify -->
<script src="{{ url('assets/js/pnotify/pnotify.js') }}"></script>

<!-- sweetalert -->
<script src="{{ url('assets/js/sweetalert2/sweetalert2.all.js') }}"></script>

@if ($errors->has('email') || $errors->has('password'))
		@if($errors->has('email'))
			<script>
				var error_message = "{{ $errors->first('email')}}"
			</script>
		@elseif($errors->has('password'))
			<script>
				var error_message = "{{ $errors->first('password')}}"
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