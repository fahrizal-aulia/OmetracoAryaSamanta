<!DOCTYPE html>
<html>
<head>
    <title>Data Proyek</title>
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

        .topbar.full {
            margin-left: 0;
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
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
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

        .btn-search {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background-color: #3498db;
            color: white;
            margin-left: 5px;
        }

        .btn-search.reset {
            background-color: rgb(195, 189, 199);
            color: black;
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

        .action a {
            margin-right: 8px;
            color: #3498db;
            text-decoration: none;
        }

        .success {
            padding: 12px;
            background: #d4edda;
            color: #155724;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
        }

        input[type="date"], input[type="text"] {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        form button, .action button {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .action form {
            display: inline;
        }

        .btn-edit {
            background-color: #f1c40f;
            color: white;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
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
        <h2>Data Proyek</h2>

        <form method="GET" action="{{ route('projectcontrol.proyek.index') }}" style="margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Cari Nama Proyek..." value="{{ request('search') }}">
            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
            <button type="submit" class="btn-search">Cari</button>
            <button type="button" class="btn-search reset" onclick="window.location.href='{{ route('projectcontrol.proyek.index') }}'">Reset</button>
        </form>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('projectcontrol.proyek.create') }}" class="btn">+ Tambah Proyek</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Proyek</th>
                    <th>Lokasi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proyeks as $index => $proyek)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $proyek->nama }}</td>
                        <td>{{ $proyek->lokasi }}</td>
                        <td>{{ date('d F Y', strtotime($proyek->tanggal_mulai)) }}</td>
                        <td>{{ date('d F Y', strtotime($proyek->tanggal_selesai)) }}</td>
                        <td class="action">
                            <form action="{{ route('projectcontrol.proyek.edit', $proyek->id) }}" method="GET">
                                <button type="submit" class="btn-edit">Edit</button>
                            </form>
                            <form action="{{ route('projectcontrol.proyek.destroy', $proyek->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus proyek ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Data tidak ditemukan</td>
                    </tr>
                @endforelse
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
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const mainContent = document.getElementById('main-content');

        sidebar.classList.toggle('hidden');
        mainContent.classList.toggle('full');
        topbar.classList.toggle('full');
    }
</script>

</body>
</html>
