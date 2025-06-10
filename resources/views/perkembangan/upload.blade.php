<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Dokumentasi Foto</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f2f4f8;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .alert {
            background-color: #e0f8e9;
            color: #2e7d32;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }

        .photo-group {
            background-color: #f9fafc;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
            color: #444;
        }

        input[type="file"],
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
            background-color: #fff;
        }

        textarea {
            resize: vertical;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-top: 30px;
        }

        .button-group button,
        .button-group a {
            background-color: #1e88e5;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .button-group a {
            background-color: #6c757d;
        }

        .button-group button:hover {
            background-color: #1565c0;
        }

        .button-group a:hover {
            background-color: #5a6268;
        }

        @media (max-width: 600px) {
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Dokumentasi Perkembangan Proyek</h2>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <form action="{{ route('upload.foto') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Minggu Ke --}}
            <div class="photo-group">
                <label for="weekly_note">Minggu Ke:</label>
                <input type="number" name="weekly_note" id="weekly_note" min="1">
            </div>

            {{-- 6 Foto dan Keterangan --}}
            @for($i = 0; $i < 6; $i++)
                <div class="photo-group">
                    <label for="photo_{{ $i }}">Foto {{ $i+1 }}</label>
                    <input type="file" name="photos[]" id="photo_{{ $i }}" accept="image/*">

                    <label for="caption_{{ $i }}">Keterangan Foto {{ $i+1 }}</label>
                    <input type="text" name="captions[]" id="caption_{{ $i }}" placeholder="Masukkan keterangan foto {{ $i+1 }}">
                </div>
            @endfor

            {{-- Tombol --}}
            <div class="button-group">
                <button type="submit">📤 Upload Dokumentasi</button>
                <a href="{{ route('perkembangan.index') }}">⬅️ Kembali ke Halaman Perkembangan Proyek</a>
            </div>
        </form>
    </div>
</body>
</html>
