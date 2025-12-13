<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Form CSS -->
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body>

    <div class="container mt-3">
        <h1>Pungut-In User</h1>

        <nav class="mb-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary me-2">Dashboard</a>
            <a href="{{ route('user.transaksi.create') }}" class="btn btn-outline-success me-2">Minta Penjemputan</a>
            <form action="{{ route('user.logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </nav>

        <hr>

        <div>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    