<script>
    @if (session('suc_msg'))
        new PNotify({
            title: 'Success!',
            text: "{{ session('suc_msg') }}",
            type: 'success',
            styling: 'bootstrap3'
        });
    @endif

    @if (session('err_msg'))
        new PNotify({
            title: 'Oh No!',
            text: "{{ session('err_msg') }}",
            type: 'error',
            styling: 'bootstrap3'
        });
    @endif
</script>
</body>
</html>