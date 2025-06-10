<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Penyewaan Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleVolumeInput(select) {
            const satuan = select.value;
            const volumeSection = document.getElementById('volumeSection');

            if (satuan === 'm3') {
                volumeSection.style.display = 'block';
            } else {
                volumeSection.style.display = 'none';
            }
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <h3>Form Tambah Penyewaan Alat</h3>
    <form action="{{ route('projectcontrol.penyewaan.store') }}" method="POST">
        @csrf

        {{-- Pilih Proyek --}}
        <div class="mb-3">
            <label for="nama_proyek" class="form-label">Nama Proyek</label>
            <select name="nama_proyek" id="nama_proyek" class="form-select" required>
    <option value="" disabled selected>-- Pilih Proyek --</option>
    @foreach ($proyeks as $proyek)
        <option value="{{ $proyek->nama }}">{{ $proyek->nama }}</option>
    @endforeach
</select>

        </div>

        {{-- Lokasi --}}
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" class="form-control" name="lokasi" required>
        </div>

        {{-- Tanggal Permintaan --}}
        <div class="mb-3">
            <label for="tanggal_permintaan" class="form-label">Tanggal Permintaan</label>
            <input type="date" class="form-control" name="tanggal_permintaan" required>
        </div>

        <hr>
<h5>Daftar Alat Proyek</h5>

<div id="alat-container">
    <div class="row mb-2 alat-row">
        <div class="col-md-3">
            <input type="text" name="nama_alat[]" class="form-control" placeholder="Nama Alat" required>
        </div>
        <div class="col-md-2">
            <input type="time" name="mulai_jam[]" class="form-control" placeholder="Mulai Jam" required>
        </div>
        <div class="col-md-2">
            <input type="time" name="selesai_jam[]" class="form-control" placeholder="Selesai Jam" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="total_jam_kerja[]" class="form-control" placeholder="Jam" step="0.1" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="jumlah_alat[]" class="form-control" placeholder="Jumlah" required>
        </div>
        <div class="col-md-2">
            <select name="satuan[]" class="form-select satuan-select" onchange="toggleVolume(this)" required>
                <option value="">Satuan</option>
                <option value="unit">Unit</option>
                <option value="m3">m3</option>
            </select>
        </div>
        <div class="col-md-1 d-flex align-items-center">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapusAlat(this)">
                🗑️
            </button>
        </div>
        <div class="row volume-section mt-2" style="display:none;">
            <div class="col-md-3 offset-md-3">
                <input type="number" name="volume_docket[]" class="form-control" placeholder="Volume Docket" step="0.1">
            </div>
            <div class="col-md-3">
                <input type="number" name="kumulatif[]" class="form-control" placeholder="Kumulatif" step="0.1">
            </div>
        </div>
    </div>
</div>

<button type="button" class="btn btn-sm btn-primary mb-4" onclick="tambahAlat()">+ Tambah Alat</button>

<script>
    function tambahAlat() {
        const container = document.getElementById('alat-container');
        const alatBaru = container.querySelector('.alat-row').cloneNode(true);

        // Reset semua nilai input
        alatBaru.querySelectorAll('input').forEach(input => input.value = '');
        alatBaru.querySelector('select').selectedIndex = 0;
        alatBaru.querySelector('.volume-section').style.display = 'none';

        container.appendChild(alatBaru);
    }

    function hapusAlat(button) {
        const row = button.closest('.alat-row');
        const container = document.getElementById('alat-container');
        if (container.querySelectorAll('.alat-row').length > 1) {
            row.remove();
        }
    }

    function toggleVolume(select) {
        const volumeDiv = select.closest('.alat-row').querySelector('.volume-section');
        if (select.value === 'm3') {
            volumeDiv.style.display = 'flex';
        } else {
            volumeDiv.style.display = 'none';
        }
    }
</script>
        <input type="hidden" name="status" value="menunggu">

        {{-- Tombol Simpan dan Kembali --}}
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('projectcontrol.penyewaan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
</body>
</html>
