<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'User Dashboard')</title>
</head>
<body>

    <h1>Pungut-In User</h1>

    <nav>
        <a href="{{ route('user.dashboard') }}">Dashboard</a> |
        <a href="{{ route('user.transaksi.create') }}">Minta Penjemputan</a> |
        <form action="{{ route('user.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <hr>

    <div>
        @yield('content')
    </div>

</body>
</html>
    