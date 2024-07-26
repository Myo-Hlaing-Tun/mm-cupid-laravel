@extends('frontend.master')
@section('subtitle','Forget Password')
@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col"></div>

        <div class="col-md-5">
          <h1 class="fw-bold mb-5" style="font-size: 60px">Forget Password</h1>
          <div class="py-3" style="font-size: 14px;">
            Go back to <a href="{{ url('login') }}" class="text-black">Login</a> page
          </div>
          @if(isset($email))
          <form action="{{ route('password.renew') }}" method="post" data-parsley-validate> 
          @else
          <form action="{{ route('reset.password') }}" method="post" data-parsley-validate>
          @endif
            @csrf
            @if(isset($email))
            <input type="password" id="password" name="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" placeholder="Please enter your new password" />
            <input type="password" id="cf-password" name="cf-password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" placeholder="Please enter confirm password" />
            <input type="hidden" id="email" name="email" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" value="{{ $email}}" />
            @else
            <input type="text" id="email" name="email" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" value="{{ old('email') }}" placeholder="Please enter your email"/>
            @endif
            <button class="btn btn-dark rounded rounded-5 btn-lg mt-4 w-100">Submit</button>
          </form>
          <p class="w-100 mt-4 fw-medium text-center" style="font-size: 12px; line-height:16px;">
            After submitting the email, password reset code will be sent to your email
          </p>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection
@section('javascript')
    <!-- pnotify -->
    <script src="{{ url('assets/js/pnotify/pnotify.js')}}"></script>
    @if ($errors->has('email') || $errors->has('code'))
        @if($errors->has('email'))
        <script>
            var error_message = "{{ $errors->first('email') }}"
        </script>
        @elseif($errors->has('code'))
        <script>
            var error_message = "{{ $errors->first('code') }}"
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