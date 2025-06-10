<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            transition: opacity 0.2s ease, transform 0.2s ease;
            opacity: 0;
            transform: translateY(-10px);
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
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        .chart-container {
            width: 180px;
            height: 180px;
            margin: auto;
        }   

        .main-content.full {
            margin-left: 0;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .deadline-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .deadline-table th,
        .deadline-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .deadline-table thead {
            background-color: #f1f5f9;
        }

        .deadline-table tbody tr:nth-child(odd) {
            background-color: #f9fafb;
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <h2>Menu</h2>
    <a href="{{ route('owner.dashboard') }}">Dashboard</a>
    <a href="{{ route('owner.proyek.index') }}">Data Proyek</a>
    <a href="{{ route('owner.perkembangan.index') }}">Perkembangan Proyek</a>
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
    <div class="card">
        <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
    </div>

    <div class="card">
        <h2>Progress Proyek</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 30px;">
            @foreach($proyeks as $index => $proyek)
                @php
                    $progress = $proyek->perkembangan->sortBy('minggu_ke')->last()?->total_progres ?? 0;
                    $colorList = ['#3490dc', '#ff9f40', '#38c172', '#f56565', '#6b46c1'];
                    $color = $colorList[$index % count($colorList)];
                @endphp
                <div style="text-align: center;">
                    <div class="chart-container">
                        <canvas id="chart{{ $index }}"></canvas>
                    </div>
                    <p><strong>{{ $proyek->nama }} ({{ $progress }}%)</strong></p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <h2>Deadline Terdekat</h2>
        <table class="deadline-table">
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Deadline</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proyeks as $proyek)
                    <tr>
                        <td>{{ $proyek->nama }}</td>
                        <td>{{ date('d F Y', strtotime($proyek->tanggal_selesai)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Tidak ada proyek yang terdaftar.</td>
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
        topbar.style.marginLeft = sidebar.classList.contains('hidden') ? '0' : '250px';
    }

    // Close dropdown if clicked outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown');
        const button = document.querySelector('.user-button');
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });

    // Generate pie charts
    const chartData = [
        @foreach($proyeks as $index => $proyek)
        @php
            $progress = $proyek->perkembangan->sortBy('minggu_ke')->last()?->total_progres ?? 0;
            $color = ['#3490dc', '#ff9f40', '#38c172', '#f56565', '#6b46c1'][$index % 5];
        @endphp
        {
            id: 'chart{{ $index }}',
            percent: {{ $progress }},
            color: '{{ $color }}'
        },
        @endforeach
    ];

    chartData.forEach(item => {
        const ctx = document.getElementById(item.id).getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Selesai', 'Belum'],
                datasets: [{
                    data: [item.percent, 100 - item.percent],
                    backgroundColor: [item.color, '#e2e8f0'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>

</body>
</html>
