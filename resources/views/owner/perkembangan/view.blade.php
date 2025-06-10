@extends('layouts.owner')

@section('content')
<div class="container">
    <div style="margin-bottom: 15px;">
        <a href="{{ route('perkembangan.index') }}"
           style="padding: 8px 12px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px;">
            ←
        </a>
    </div>

    <h1 style="text-align: center;">Grafik Perkembangan Proyek</h1>
    <div style="position: relative; height: 300px; width: 100%; max-width: 600px; margin: 0 auto;">
        <canvas id="progresChart"></canvas>
    </div>

    <h2 style="margin-top: 50px; text-align: center;">Dokumentasi Foto Perkembangan</h2>

    @if(isset($dokumentasi) && $dokumentasi->isNotEmpty())
        @foreach ($dokumentasi as $minggu => $items)
        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h4>Minggu ke-{{ $minggu }}</h4>
            <p><strong>Catatan:</strong> {{ $items->first()->weekly_note }}</p>

            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                @foreach ($items as $photo)
                    <div style="flex: 1 1 200px;">
                        <img src="{{ asset('storage/' . $photo->file_path) }}" alt="Foto"
     style="width: 100%; height: auto; border-radius: 5px; border: 1px solid #ccc;">

                        <p style="margin-top: 6px;"><strong>Keterangan:</strong> {{ $photo->caption }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@else
    <p style="text-align: center; color: #888;">Belum ada dokumentasi foto yang tersedia.</p>
@endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('progresChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Struktur',
                    data: {!! json_encode($struktur) !!},
                    borderColor: 'blue',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Arsitektur',
                    data: {!! json_encode($arsitektur) !!},
                    borderColor: 'orange',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Tambah Kurang',
                    data: {!! json_encode($tambah_kurang) !!},
                    borderColor: 'red',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Total Progres',
                    data: {!! json_encode($total) !!},
                    borderColor: 'green',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        tooltip: {
            mode: 'index',
            intersect: false,
            callbacks: {
                title: function(tooltipItems) {
                    return tooltipItems[0].label;
                },
                label: function(tooltipItem) {
                    let label = tooltipItem.dataset.label || '';
                    let value = tooltipItem.raw ?? '';
                    return label + ': ' + value;
                }
            }
        }
    },
    interaction: {
        mode: 'nearest',
        axis: 'x',
        intersect: false
    },
    scales: {
        x: {
            ticks: {
                callback: function(value, index, values) {
                    return this.getLabelForValue(value).split('\n');
                }
            }
        },
        y: {
            beginAtZero: true,
            max: 100
        }
    }
}
    });
</script>
@endsection
