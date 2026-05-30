<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pungut-in | User Login</title>

    <script>
        (function() {
            var t = localStorage.getItem('pungutin-theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', t);
        })();
    </script>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<button class="login-theme-toggle" type="button" onclick="toggleTheme()" title="Toggle theme" aria-label="Toggle theme">
    <i class="bi bi-moon-stars-fill"></i>
    <i class="bi bi-sun-fill"></i>
</button>

<script>
function toggleTheme() {
    var current = document.documentElement.getAttribute('data-bs-theme') || 'dark';
    var next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-bs-theme', next);
    localStorage.setItem('pungutin-theme', next);
}
</script>

<div class="login-wrapper">
    <div class="login-card">

        <div class="login-title-wrap">
            <i class="bi bi-person-circle login-title-icon"></i>
            <h2 class="login-title">Login User</h2>
        </div>

        {{-- ERROR MESSAGE --}}
        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.login.submit') }}">
            @csrf

            <!-- EMAIL -->
            <div class="mb-3">

                <div class="input-field">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input 
                        type="email"
                        name="email"
                        class="ocean-input"
                        placeholder="Enter your email"
                        required>
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">

                <div class="input-field">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input 
                        type="password"
                        name="password"
                        class="ocean-input"
                        placeholder="Enter your password"
                        required>
                </div>
            </div>

            <button type="submit" class="btn btn-ocean w-100 py-2">Login</button>

        </form>

    </div>
</div>

</body>
</html>
