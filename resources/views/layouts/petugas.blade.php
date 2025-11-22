<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Petugas Dashboard')</title>
</head>
<body>
    
    <h1>petugas dashboard</h1>

    <nav>
        <a href="{{ route('placeholder.route') }}">Cuming Soon</a>
        <a href="{{ route('placeholder.route') }}">Cuming Soon</a>
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