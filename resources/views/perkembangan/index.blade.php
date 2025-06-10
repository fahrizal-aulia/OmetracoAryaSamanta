<!DOCTYPE html>
<html>
<head>
    <title>Perkembangan Proyek</title>
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
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 18px; /* lebih kecil */
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
            transition: background-color 0.2s;
        }

        .user-button:hover {
            background-color: #f0f0f0;
        }

        .dropdown {
            position: absolute;
            right: 0;
            top: 38px;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 8px 0;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
            min-width: 160px;
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
        }

        .dropdown a:hover,
        .dropdown button:hover {
            background-color: #f8f8f8;
            color: #007bff;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
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
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            color: black !important;
            font-size: 0.9em;
            vertical-align: middle;
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
            background-color:rgb(195, 189, 199);
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px 8px;
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

        .action {
            display: flex;
            gap: 8px;
            align-items: center;
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

        .btn-upload {
            background-color:rgb(5, 164, 71);
            color: white !important;
        }

        .btn-update {
            background-color:rgb(183, 147, 5);
            color: white !important;
        }

        .btn-view {
            background-color:rgb(137, 50, 171);
            color: white !important;
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

<!-- Sidebar -->
<div class="sidebar">
    <h2>Menu</h2>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('proyek.index') }}">Data Proyek</a>
    <a href="{{ route('kontraktors.index') }}">Data Kontraktor</a>
    <a href="{{ route('perkembangan.proyek') }}">Perkembangan Proyek</a>
    <a href="{{ route('pembelian.index') }}">Pembelian Bahan Material</a>
    <a href="{{ route('penyewaan.index') }}">Penyewaan Alat Proyek</a>
</div>

<!-- Topbar -->
<div class="topbar">
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <div class="user-menu">
        <button onclick="toggleDropdown()" class="user-button">
            {{ Auth::user()->name }} ▾
        </button>
        <div id="dropdown" class="dropdown">
            <a href="{{ route('profile.edit') }}">Edit Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h2>Perkembangan Proyek</h2>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('proyek.index') }}" style="margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Cari Nama Proyek..." value="{{ request('search') }}">
            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
            <button type="submit" class="btn-search">Cari</button>
            <button type="button" class="btn-search reset" onclick="window.location.href='{{ route('proyek.index') }}'">Reset</button>
        </form>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

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
                            <a href="{{ route('perkembangan.upload', $proyek->id) }}" class="btn btn-upload">Upload</a>
                            <a href="{{ route('perkembangan.update', $proyek->id) }}" class="btn btn-update">Update</a>
                            <a href="{{ route('perkembangan.view', $proyek->id) }}" class="btn btn-view">View</a>
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
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.display = (sidebar.style.display === 'none') ? 'block' : 'none';
    }
</script>
</body>
</html>
