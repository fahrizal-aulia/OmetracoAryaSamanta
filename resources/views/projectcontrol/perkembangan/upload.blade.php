<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Dokumentasi Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #f2f4f8;
        }

        .sidebar {
            width: 250px;
            background: #2d3748;
            color: #fff;
            position: fixed;
            height: 100vh;
            padding-top: 20px;
            transition: all 0.3s ease;
        }

        .sidebar.hidden {
            margin-left: -250px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        .sidebar a {
            color: white;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #4a5568;
        }

        .topbar {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-left: 250px;
            border-bottom: 1px solid #ccc;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: margin-left 0.3s ease;
        }

        .topbar.full {
            margin-left: 0;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .user-menu {
            position: relative;
        }

        .user-button {
            background: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            padding: 6px 10px;
            border-radius: 6px;
        }

        .dropdown {
            position: absolute;
            right: 0;
            top: 45px;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 8px 0;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
            min-width: 160px;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .dropdown.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown a,
        .dropdown button {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            padding: 10px 16px;
            border: none;
            background: none;
            text-decoration: none;
            color: #333;
            cursor: pointer;
            transition: background-color 0.2s ease;
            width: 100%;
        }

        .dropdown a:hover,
        .dropdown button:hover {
            background-color: #f5f5f5;
            color: #007bff;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        .main-content.full {
            margin-left: 0;
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

            .topbar, .main-content {
                margin-left: 0 !important;
            }

            .sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <h2>Menu</h2>
    <a href="{{ route('dashboard.projectControl') }}">Dashboard</a>
    <a href="{{ route('projectcontrol.proyek.index') }}">Data Proyek</a>
    <a href="{{ route('projectcontrol.kontraktors.index') }}">Data Kontraktor</a>
    <a href="{{ route('projectcontrol.perkembangan.index') }}">Perkembangan Proyek</a>
    <a href="{{ route('projectcontrol.pembelian.index') }}">Pembelian Material</a>
    <a href="{{ route('projectcontrol.penyewaan.index') }}">Penyewaan Alat</a>
</div>

<div class="topbar" id="topbar">
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <div class="user-menu">
        <button onclick="toggleDropdown()" class="user-button">
            {{ Auth::user()->name }} ▾
        </button>
        <div id="dropdown" class="dropdown">
            <a href="{{ route('profile.edit') }}">
                <i class="bi bi-person-circle"></i> Edit Profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>

<div class="main-content" id="main-content">
    <div class="container">
        <h2>Upload Dokumentasi Perkembangan Proyek</h2>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <form action="{{ route('projectcontrol.perkembangan.upload.foto', $proyek_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="proyek_id" value="{{ $proyek_id }}">

            <div class="photo-group">
                <label for="minggu_ke">Minggu Ke:</label>
                <input type="number" name="minggu_ke" id="minggu_ke" min="1" required>
            </div>

            @for($i = 0; $i < 6; $i++)
                <div class="photo-group">
                    <label for="photo_{{ $i }}">Foto {{ $i+1 }}</label>
                    <input type="file" name="photos[]" id="photo_{{ $i }}" accept="image/*">
                    <label for="caption_{{ $i }}">Keterangan Foto {{ $i+1 }}</label>
                    <input type="text" name="captions[]" id="caption_{{ $i }}" placeholder="Masukkan keterangan foto {{ $i+1 }}">
                </div>
            @endfor

            <div class="button-group">
                <button type="submit">📤 Upload Dokumentasi</button>
            </div>
        </form>
        @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    </div>
</div>

<script>
    function toggleDropdown() {
        document.getElementById('dropdown').classList.toggle('show');
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const main = document.getElementById('main-content');
        sidebar.classList.toggle('hidden');
        topbar.classList.toggle('full');
        main.classList.toggle('full');
    }
</script>

</body>
</html>
