<!-- resources/views/client/profile/index.blade.php -->

@extends('layouts.app') <!-- Nếu bạn sử dụng layout chính của ứng dụng -->

@section('content')
<div class="container">
    <h3>Thông tin cá nhân</h3>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <script>
        document.getElementById('edit-info-btn').addEventListener('click', function() {
            document.getElementById('user-info-display').style.display = 'none';
            document.getElementById('edit-info-form').style.display = 'block';
        });

        document.getElementById('cancel-edit-btn').addEventListener('click', function() {
            document.getElementById('edit-info-form').style.display = 'none';
            document.getElementById('user-info-display').style.display = 'block';
        });
        document.getElementById('cod-btn').addEventListener('click', function() {
            document.getElementById('cod-btn').classList.add('selected');
            document.getElementById('wallet-btn').classList.remove('selected');
        });

        document.getElementById('wallet-btn').addEventListener('click', function() {
            document.getElementById('wallet-btn').classList.add('selected');
            document.getElementById('cod-btn').classList.remove('selected');
        });
        document.getElementById('edit-info-btn').addEventListener('click', function() {
            document.getElementById('edit-form').style.display = 'block';
        });
    </script>
    @endsection