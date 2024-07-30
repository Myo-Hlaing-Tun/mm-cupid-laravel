<footer>
      <div class="pull-right">
        Myanmar Cupid
      </div>
      <div class="clearfix"></div>
    </footer>

  </div>
</div>
<script>
    const base_url = "{{url('/')}}";
</script>
<!-- jQuery -->
<script src="{{ url('assets/js/jqueryv2.2/jqueryv2.2.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{ url('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>

<!-- sweetalert2 -->
<script src="{{ url('assets/js/sweetalert2/sweetalert2.all.js')}}"></script>

<!-- jQuery Sparklines -->
<script src="{{ url('assets/js/sparkline/jquery.sparkline.min.js')}}"></script>

<!-- bootstrap-progressbar -->
<script src="{{ url('assets/js/progressbar/bootstrap-progressbar.min.js')}}"></script>

<!-- Flot -->
<script src="{{ url('assets/js/flot/jquery.flot.js')}}"></script>
<script src="{{ url('assets/js/flot/jquery.flot.time.js')}}"></script>

<script src="{{ url('assets/js/flot/curvedLines.js')}}"></script>

<!-- DateJS -->
<script src="{{ url('assets/js/date/date.js')}}"></script>

<!-- icheck -->
<script src="{{ url('assets/js/icheck/icheck.min.js')}}"></script>  

<!-- Custom Theme Scripts -->
<script src="{{ url('assets/js/custom/custom.js?v=20240614')}}"></script>

<!-- pnotify -->
<script src="{{ url('assets/js/pnotify/pnotify.js')}}"></script>

<script>
    @if (session('success_msg'))
        new PNotify({
            title: 'Success!',
            text: "{{ session('success_msg') }}",
            type: 'success',
            styling: 'bootstrap3'
        });
    @endif

    @if (session('error_msg'))
        new PNotify({
            title: 'Oh No!',
            text: "{{ session('error_msg') }}",
            type: 'error',
            styling: 'bootstrap3'
        });
    @endif
</script>