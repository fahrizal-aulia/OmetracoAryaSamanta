<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Proyek</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 18px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }
        
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #2c3e50;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        input:focus {
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
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #555;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -15px;
            margin-bottom: 15px;
        }
    </style>    
</head>
<body>
<div class="container">
    <h2>Tambah Kontraktor</h2>

    <!-- Tampilkan error validasi -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kontraktors.store') }}" method="POST">
        @csrf

        <label for="nama_kontraktor">Nama Kontraktor</label>
        <input type="text" name="nama_kontraktor" value="{{ old('nama_kontraktor') }}">
        @error('nama') <div class="error">{{ $message }}</div> @enderror

        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" value="{{ old('alamat') }}">
        @error('alamat') <div class="error">{{ $message }}</div> @enderror

        <label for="telepon">No. Telepon</label>
        <input type="text" name="telepon" value="{{ old('telepon') }}">
        @error('telepon') <div class="error">{{ $message }}</div> @enderror

        <button type="submit" class="btn">Simpan</button>
    </form>

    <a href="{{ route('kontraktors.index') }}" class="back-link">← Kembali ke Data Kontraktor</a>
</div>

</body>
</html>
