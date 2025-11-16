<!DOCTYPE html>
<html>
<head>
    <title>Form Pendaftaran User</title>
</head>
<body>
    <h2>Daftar User Baru</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('daftar.store') }}">
        @csrf
        <label>Nama Lengkap:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>No HP:</label><br>
        <input type="text" name="no_hp" required><br><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>