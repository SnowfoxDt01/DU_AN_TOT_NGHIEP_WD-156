@if (Session::has('import_errors'))
  <script>
    Swal.fire({
      title: 'Errors!',
      html: `
        @foreach (Session::get('import_errors') as $failures)
          <div>Row : {{ $failures->row()}} - Fails : {{ $failures->errors()[0] }}</div>
        @endforeach
      `,
      icon: 'error',
      confirmButtonText: 'OK'
    });
  </script>
@endif
