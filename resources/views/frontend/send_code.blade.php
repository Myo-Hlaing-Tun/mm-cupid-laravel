@extends('frontend.master')
@section('subtitle','Forget Password')
@section('content')
<div class="container my-5" ng-app="myApp" ng-controller="MyController" ng-init="init()">
    <div class="row">
        <div class="col"></div>

        <div class="col-md-5">
          <h1 class="fw-bold mb-5" style="font-size: 60px">Forget Password</h1>
          <div class="py-3" style="font-size: 14px;">
            Go back to <a href="{{ url('login') }}" class="text-black">Login</a> page
          </div>
          <form action="" method="post" data-parsley-validate>
            @csrf
            <input type="text" id="code" name="code" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" ng-model="code" value="{{ old('code') }}" placeholder="Please enter code sent in your email"/>
            <button class="btn btn-dark rounded rounded-5 btn-lg mt-4 w-100" type="button" ng-click="sendCode()">Submit</button>
          </form>
          <p class="w-100 mt-4 fw-medium text-center" style="font-size: 12px; line-height:16px;">
            Please check your email and enter the reset code sent to your email
          </p>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection
@section('javascript')
    <!-- pnotify -->
    <script src="{{ url('assets/js/pnotify/pnotify.js')}}"></script>
    <script src="{{ url('assets/js/frontend/reset_code.js')}}"></script>
    @if($errors->has('code'))
        <script>
            var error_message = "{{ $errors->first('code') }}"
            new PNotify({
                title: 'Oh No!',
                text: error_message,
                type: 'error',
                styling: 'bootstrap3'
            });
        </script>
    @endif
@endsection