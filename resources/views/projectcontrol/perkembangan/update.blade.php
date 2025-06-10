<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Perkembangan Proyek</title>
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
            color: #ffffff;
            font-weight: bold;
            font-size: 20px;
            opacity: 1; /* pastikan tidak transparan */
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
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
            box-sizing: border-box;
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
            box-sizing: border-box;
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

        @media (max-width: 600px) {
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
    <a href="{{ route('projectcontrol.pembelian.index') }}">Pembelian Bahan Material</a>
    <a href="{{ route('projectcontrol.penyewaan.index') }}">Penyewaan Alat Proyek</a>
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
        <h2>Tambah Perkembangan Proyek</h2>

        <form method="POST" action="{{ route('projectcontrol.proyek.perkembangan.store', $proyek->id) }}">
            @csrf

            <label for="minggu_ke">Minggu ke-</label>
            <input type="number" name="minggu_ke" id="minggu_ke" required>

            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" required>

            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" required>

            <label for="struktur">Pekerjaan Struktur (%)</label>
            <input type="number" step="0.01" name="struktur" id="struktur" required>

            <label for="arsitektur">Pekerjaan Arsitektur (%)</label>
            <input type="number" step="0.01" name="arsitektur" id="arsitektur" required>

            <label for="tambah_kurang">Pekerjaan Tambah Kurang (%)</label>
            <input type="number" step="0.01" name="tambah_kurang" id="tambah_kurang" required>

            <label for="total_progres">Total Progres (%)</label>
            <input type="number" step="0.01" name="total_progres" id="total_progres" required>

            <button type="submit" class="btn">Simpan Perkembangan</button>
        </form>
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
