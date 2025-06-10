<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2779bd;
        }

        .text-center {
            text-align: center;
        }

        .link {
            color: #3490dc;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        .error {
            background-color: #ffe5e5;
            color: #cc0000;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2 class="text-center">Login Admin</h2>

    @if($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <input type="hidden" name="role" value="admin"> <!-- Penting -->

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p class="text-center" style="margin-top: 20px;">
        Belum punya akun?
        <a href="{{ route('register.form') }}" class="link">Daftar</a>
    </p>
</div>

</body>
</html>
