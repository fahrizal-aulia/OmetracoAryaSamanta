<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .dropdown.show {
            display: block;
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
        }

        .dropdown a:hover,
        .dropdown button:hover {
            background-color: #f5f5f5;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        .main-content.full {
            margin-left: 0;
        }
    </style>
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">
    <h2>Menu</h2>
    <a href="{{ route('users.index') }}">Master User</a>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('proyek.index') }}">Data Proyek</a>
    <a href="{{ route('kontraktors.index') }}">Data Kontraktor</a>
    <a href="{{ route('perkembangan.proyek') }}">Perkembangan Proyek</a>
    <a href="{{ route('pembelian.index') }}">Pembelian Bahan Material</a>
    <a href="{{ route('penyewaan.index') }}">Penyewaan Alat Proyek</a>
</div>

{{-- Topbar --}}
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

{{-- Konten --}}
<div class="main-content" id="main-content">
    <div class="card bg-white p-4 shadow rounded">
        <h1 class="mb-4">Daftar Pengguna</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">+ Tambah Pengguna</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->nama_role ?? 'Belum Dipilih' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin ingin menghapus user ini?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleDropdown() {
        document.getElementById('dropdown').classList.toggle('show');
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const mainContent = document.getElementById('main-content');

        sidebar.classList.toggle('hidden');
        mainContent.classList.toggle('full');
        topbar.style.marginLeft = sidebar.classList.contains('hidden') ? '0' : '250px';
    }

    // Tutup dropdown jika klik di luar
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
