<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Proyek</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #f4f6f9;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            background: #2d3748;
            color: #fff;
            position: fixed;
            height: 100vh;
            padding-top: 20px;
            transition: transform 0.3s ease;
            z-index: 200;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
            font-size: 22px; 
        }

        .sidebar a {
            color: white;
            padding: 10px 18px;
            display: block;
            text-decoration: none;
            font-size: 18x; /* kecilkan font */
        }

        .sidebar a:hover {
            background-color: #4a5568;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        .topbar {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            position: sticky;
            top: 0;
            z-index: 150;
            transition: margin-left 0.3s ease;
        }

        .main-content {
            transition: margin-left 0.3s ease;
            padding: 30px;
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
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            min-width: 180px;
            padding: 5px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
        }

        .dropdown a, .dropdown button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            width: 100%;
            border: none;
            background: none;
            text-align: left;
            font-size: 14px;
            color: #333;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .dropdown a:hover, .dropdown button:hover {
            background-color: #f0f0f0;
        }

        .toggle-btn {
            font-size: 24px;
            background: none;
            border: none;
            color: #2d3748;
            cursor: pointer;
        }

        .with-sidebar {
            margin-left: 250px;
        }

        .without-sidebar {
            margin-left: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .with-sidebar {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>Menu</h2>
    <a href="{{ route('dashboard.projectControl') }}">Dashboard</a>
    <a href="{{ route('projectcontrol.proyek.index') }}">Data Proyek</a>
    <a href="{{ route('projectcontrol.kontraktors.index') }}">Data Kontraktor</a>
    <a href="{{ route('projectcontrol.perkembangan.index') }}">Perkembangan Proyek</a>
    <a href="{{ route('projectcontrol.pembelian.index') }}">Pembelian Bahan Material</a>
    <a href="{{ route('projectcontrol.penyewaan.index') }}">Penyewaan Alat Proyek</a>
    </div>

    <!-- Topbar -->
    <div class="topbar with-sidebar" id="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <div class="user-menu">
            <button onclick="toggleDropdown()" class="user-button">
                {{ Auth::user()->name ?? 'Pengguna' }} ▾
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

    <!-- Main Content -->
    <main class="main-content with-sidebar" id="mainContent">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const topbar = document.getElementById('topbar');
            const mainContent = document.getElementById('mainContent');

            const isHidden = sidebar.classList.toggle('sidebar-hidden');

            if (isHidden) {
                topbar.classList.remove('with-sidebar');
                topbar.classList.add('without-sidebar');
                mainContent.classList.remove('with-sidebar');
                mainContent.classList.add('without-sidebar');
            } else {
                topbar.classList.remove('without-sidebar');
                topbar.classList.add('with-sidebar');
                mainContent.classList.remove('without-sidebar');
                mainContent.classList.add('with-sidebar');
            }
        }
    </script>
</body>
</html>
