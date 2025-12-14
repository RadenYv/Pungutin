<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="login-wrapper d-flex vw-100 vh-100 overflow-hidden p-0 m-0">

    <!-- LEFT SIDE IMAGE -->
    <div class="left-side h-100 p-0">
        <img src="/images/bgbaru.jpg" class="left-img" alt="Login Image">
    </div>

    <!-- RIGHT SIDE -->
    <div class="right-side d-flex align-items-center justify-content-center h-100">

        <div class="login-content">

            <h1 class="login-title text-center fw-bold mb-4">Login Admin</h1>

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <!-- USERNAME -->
                <label class="form-label small">Email</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="email" placeholder="Email">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                </div>

                <!-- PASSWORD -->
                <label class="form-label small">Password</label>
                <div class="input-group mb-4">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                </div>

                <!-- LOGIN BUTTON -->
                <button class="btn btn-primary w-100 mb-2" type="submit">Login</button>


                </p>
            </form>



        </div>

    </div>

</div>

</body>
</html>
