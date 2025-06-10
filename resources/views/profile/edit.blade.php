<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #eef1f4;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #2c3e50;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus {
            border-color: #3498db;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            display: block;
            color: #555;
            text-decoration: none;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -15px;
            margin-bottom: 15px;
        }

        .success {
            background-color: #d4edda;
            padding: 12px;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Profil</h2>

    @if (session('status'))
        <div class="success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nama</label>
        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
        @error('name') <div class="error">{{ $message }}</div> @enderror

        <label for="email">Email</label>
        <input type="email" id="email" value="{{ Auth::user()->email }}" readonly>

        <label for="gender">Jenis Kelamin</label>
        <select id="gender" name="gender">
            <option value="">-- Pilih --</option>
            <option value="Laki-laki" {{ Auth::user()->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ Auth::user()->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('gender') <div class="error">{{ $message }}</div> @enderror

        <label for="phone">Nomor Telepon</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
        @error('phone') <div class="error">{{ $message }}</div> @enderror

        <label for="address">Alamat</label>
        <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address) }}">
        @error('address') <div class="error">{{ $message }}</div> @enderror

        <label for="password">Password Baru (opsional)</label>
        <input type="password" id="password" name="password">
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">

        <button type="submit" class="btn">Simpan Perubahan</button>
    </form>

    <a href="{{ route('dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
</div>

</body>
</html>
