@if (Session::has('success'))
<script>
    toastr.success("{{ Session::get('success') }}", "Success", {
        closeButton: true,
        progressBar: true,
        timeOut: 5000,
        positionClass: "toast-top-right"
    });
</script>
@endif
