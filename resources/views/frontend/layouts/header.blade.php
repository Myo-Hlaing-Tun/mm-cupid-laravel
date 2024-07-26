<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="@yield('meta_contents')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <title>@yield('title')@yield('subtitle')</title>
    <!-- logo in browser tag -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/images/cupid-32x32.png') }}">
    <!-- bootstrap -->
    <link href="{{ url('/assets/css/frontend/bootstrap.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ url('/assets/css/frontend/bootstrap-icons.min.css') }}"/>
    <!-- Font Awesome -->
    <link href="{{ url('assets/css/fontawesome/font-awesome.min.css') }}" rel="stylesheet"/>
    <!-- custom -->
    <link rel="stylesheet" href="{{ url('assets/css/frontend/custom.css?v=20240704') }}">
    <!-- jquery -->
    <link rel="stylesheet" href="{{ url('/assets/css/frontend/jquery-ui.css') }}">
    <!-- pnotify css -->
    <link href="{{ url('assets/css/pnotify/pnotify.css') }}" rel="stylesheet">
    <!-- jquery -->
    <script src="{{ url('/assets/js/frontend/jquery-3.6.0.js') }}"></script>
    <script src="{{ url('/assets/js/frontend/jquery-ui.js') }}"></script>
    <!-- angular js -->
    <script src="{{ url('/assets/js/frontend/angular.min.js') }}"></script>
    <!-- messages collection -->
    <script src="{{ url('/assets/js/frontend/error_message.js') }}"></script>
    <script src="{{ url('/assets/js/frontend/success_message.js?v=20240628') }}"></script>

    <style>
      .btn-outline-secondary {
        --bs-btn-hover-bg: #6c757d32;
      }
    </style>
  </head>
  <body style="background-color: #e9d8ff">
  <script>
    var base_url = "{{ url('/') }}";
  </script>
  <div class="loading" style="display: none;">Loading&#8230;</div>