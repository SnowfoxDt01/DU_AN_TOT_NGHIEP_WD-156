@if (Session::has('error'))
<script>
    toastr.error("{{ Session::get('error') }}", "Error", {
        closeButton: true,
        progressBar: true,
        timeOut: 5000,
        positionClass: "toast-top-right"
    });
</script>
@endif
