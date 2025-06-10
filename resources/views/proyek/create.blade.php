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

        input[type="text"],
        input[type="date"] {
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
    <h2>Tambah Proyek</h2>

    <form action="{{ route('proyek.store') }}" method="POST">
        @csrf

        <label for="nama">Nama Proyek</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama') }}">
        @error('nama') <div class="error">{{ $message }}</div> @enderror

        <label for="lokasi">Lokasi</label>
        <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}">
        @error('lokasi') <div class="error">{{ $message }}</div> @enderror

        <label for="tanggal_mulai">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
        @error('tanggal_mulai') <div class="error">{{ $message }}</div> @enderror

        <label for="tanggal_selesai">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
        @error('tanggal_selesai') <div class="error">{{ $message }}</div> @enderror

        <button type="submit" class="btn">Simpan</button>
    </form>

    <a href="{{ route('proyek.index') }}" class="back-link">← Kembali ke Data Proyek</a>
</div>

</body>
</html>
