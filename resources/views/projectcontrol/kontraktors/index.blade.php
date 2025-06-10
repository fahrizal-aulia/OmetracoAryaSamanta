<!DOCTYPE html>
<html>
<head>
    <title>Data Kontraktor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #f4f6f9;
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

        .toggle-btn {
            background: none;
            border: none;
            font-size: 18px;
            padding: 6px 10px;
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
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px 0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
            min-width: 180px;
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
            gap: 10px;
            width: 100%;
            padding: 10px 20px;
            text-align: left;
            border: none;
            background: none;
            text-decoration: none;
            color: #2d3748;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s ease;
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
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 10px;
            text-align: center;
            color: #333;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ecf0f1;
            color: #2c3e50;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action-btn {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: white;
            margin-right: 5px;
        }

        .btn-edit {
            background-color: #f39c12;
        }

        .btn-delete {
            background-color: #e74c3c;
        }

        form {
            display: inline;
        }

        form a {
            padding: 8px 14px;
            background-color: #bdc3c7;
            color: black;
            border-radius: 6px;
            text-decoration: none;
            margin-left: 5px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Menu</h2>
    <a href="{{ route('dashboard.projectControl') }}">Dashboard</a>
    <a href="{{ route('projectcontrol.proyek.index') }}">Data Proyek</a>
    <a href="{{ route('projectcontrol.kontraktors.index') }}">Data Kontraktor</a>
    <a href="{{ route('projectcontrol.perkembangan.index') }}">Perkembangan Proyek</a>
    <a href="{{ route('projectcontrol.pembelian.index') }}">Pembelian Bahan Material</a>
    <a href="{{ route('penyewaan.index') }}">Penyewaan Alat Proyek</a>
</div>

<div class="topbar">
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

<div class="main-content">
    <div class="container">
        <h2>Data Kontraktor</h2>

        <div style="margin-bottom: 20px; text-align: left;">
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kontraktor</th>
                    <th>Alamat</th>
                    <th>No. Telepon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kontraktors as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nama_kontraktor }}</td>
                    <td>{{ $k->alamat }}</td>
                    <td>{{ $k->telepon }}</td>
                    <td>
                        <form action="{{ route('kontraktors.edit', $k->id) }}" method="GET">
                        </form>
                        <form action="{{ route('kontraktors.destroy', $k->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown');
        dropdown.classList.toggle('show');
    }

    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const topbar = document.querySelector('.topbar');
        const mainContent = document.querySelector('.main-content');

        sidebar.classList.toggle('hidden');
        mainContent.classList.toggle('full');
        topbar.style.marginLeft = sidebar.classList.contains('hidden') ? '0' : '250px';
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown');
        const button = document.querySelector('.user-button');
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });
</script>
</body>
</html>
