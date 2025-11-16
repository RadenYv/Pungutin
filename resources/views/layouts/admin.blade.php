<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
</head>
<body>
    <div>
        <h2>Pungut-In Admin</h2>
        <nav>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> |
            <a href="{{ route('admin.users.index') }}">Data User</a> |
            <a href="{{ route('admin.petugas.index') }}">Data Petugas</a> |
            <a href="{{ route('admin.kategori.index') }}">Kategori Sampah</a> |
            <a href="{{ route('admin.transaksi.index') }}">Transaksi</a> |
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
        <hr>
    </div>

    <div>
        @yield('content')
    </div>
</body>
</html>
