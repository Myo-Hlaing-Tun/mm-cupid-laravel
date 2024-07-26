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
          <form action="{{ route('password.renew') }}" method="post" data-parsley-validate> 
            @csrf
            <input type="password" id="password" name="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" placeholder="Please enter your new password" />
            <input type="password" id="cf-password" name="cf-password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" placeholder="Please enter confirm password" />
            <input type="hidden" id="code" name="code" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" value="{{ $token}} " />
            <button class="btn btn-dark rounded rounded-5 btn-lg mt-4 w-100">Submit</button>
          </form>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection
@section('javascript')
    <!-- pnotify -->
    <script src="{{ url('assets/js/pnotify/pnotify.js')}}"></script>
    @if ($errors->has('password') || $errors->has('cf-password') || $errors->has('code'))
        @if($errors->has('password'))
        <script>
            var error_message = "{{ $errors->first('password') }}"
        </script>
        @elseif($errors->has('cf-password'))
        <script>
            var error_message = "{{ $errors->first('cf-password') }}"
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