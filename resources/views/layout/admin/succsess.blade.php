@if (Session::has('success'))
<script>
  Swal.fire({
    title: 'Success!',
    text: "{{ Session::get('success') }}",
    icon: 'success',
    confirmButtonText: 'OK'
  });
</script>
@endif
