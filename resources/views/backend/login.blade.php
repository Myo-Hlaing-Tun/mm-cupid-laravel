<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$company_name}}: ADMIN</title>

    <!-- icon for web tab -->
    <link rel="icon" type="image/jpg" sizes="16x16" href="{{ url('assets/images/cupid-32x32.png')}}"/>
    <!-- Bootstrap -->
    <link href="{{ url('assets/css/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url('assets/css/fontawesome/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ url('assets/css/custom/custom.css')}}" rel="stylesheet">
    <!-- pnotify -->
    <link href="{{ url('assets/css/pnotify/pnotify.css')}}" rel="stylesheet">
</head>

<body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="{{route('admin.login')}}" method="POST">
                @csrf
                <h1>Login Form</h1>
                <div>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="{{old('username')}}"/>
                </div>
                <div>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" />
                </div>
                <div>
                    <button type="submit" id="submit" name="submit" class="btn btn-default submit" href="index.html">Log in</button>
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <div>
                    <p>©2024 All Rights Reserved. </p>
                    </div>
                </div>
            </form>
          </section>
        </div>
      </div>
    </div>

    <!-- jquery v2.2 -->
    <script src="{{ url('assets/js/jqueryv2.2/jqueryv2.2.min.js')}}"></script>

    <!-- pnotify -->
    <script src="{{ url('assets/js/pnotify/pnotify.js')}}"></script>
    @if ($errors->has('username'))
    <script>
        new PNotify({
            title: 'Oh No!',
            text: "{{$errors->first('username')}}",
            type: 'error',
            styling: 'bootstrap3'
        });
    </script>
    @endif
    @if ($errors->has('password'))
    <script>
        new PNotify({
            title: 'Oh No!',
            text: "{{$errors->first('password')}}",
            type: 'error',
            styling: 'bootstrap3'
        });
    </script>
    @endif
    @if ($errors->has('login_error'))
    <script>
        new PNotify({
            title: 'Oh No!',
            text: "{{$errors->first('login_error')}}",
            type: 'error',
            styling: 'bootstrap3'
        });
    </script>
    @endif
</body>
</html>