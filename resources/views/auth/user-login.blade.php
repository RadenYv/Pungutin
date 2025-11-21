<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pungut-in | User Login</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>

<body>

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
