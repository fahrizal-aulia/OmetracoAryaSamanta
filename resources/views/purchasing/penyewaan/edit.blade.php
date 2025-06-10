<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Penyewaan Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3>Form Edit Penyewaan Alat</h3>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Utama --}}
        <form action="{{ route('penyewaan.update', $penyewaan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Proyek --}}
            <div class="mb-3">
                <label for="nama_proyek" class="form-label">Nama Proyek</label>
                <input type="text" class="form-control" name="nama_proyek" value="{{ $penyewaan->nama_proyek }}" readonly>
            </div>

            {{-- Lokasi --}}
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control" name="lokasi" value="{{ $penyewaan->lokasi }}" readonly>
            </div>

            {{-- Tanggal Permintaan --}}
            <div class="mb-3">
                <label for="tanggal_permintaan" class="form-label">Tanggal Permintaan</label>
                <input type="date" class="form-control" name="tanggal_permintaan" value="{{ $penyewaan->tanggal_permintaan }}" readonly>
            </div>

            <hr>
            <h5>Daftar Alat Proyek</h5>

            <div id="alat-container">
                @foreach ($alatList as $index => $alat)
                    <div class="row mb-2 alat-row">
                        <div class="col-md-3">
                            <input type="text" name="nama_alat[]" class="form-control" value="{{ $alat->nama_alat }}" readonly>
                        </div>
                        <div class="col-md-2">
                            <input type="time" name="mulai_jam[]" class="form-control" value="{{ $alat->mulai_jam }}" readonly>
                        </div>
                        <div class="col-md-2">
                            <input type="time" name="selesai_jam[]" class="form-control" value="{{ $alat->selesai_jam }}" readonly>
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="total_jam_kerja[]" class="form-control" value="{{ $alat->total_jam_kerja }}" step="0.1" readonly>
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="jumlah_alat[]" class="form-control" value="{{ $alat->jumlah_alat }}" readonly>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" value="{{ $alat->satuan }}" readonly>
                        </div>

                        {{-- Volume --}}
                        <div class="row volume-section mt-2" style="{{ $alat->satuan == 'm3' ? 'display:flex;' : 'display:none;' }}">
                            <div class="col-md-3 offset-md-3">
                                <input type="number" name="volume_docket[]" class="form-control" value="{{ $alat->volume_docket }}" step="0.1" readonly>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="kumulatif[]" class="form-control" value="{{ $alat->kumulatif }}" step="0.1" readonly>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tombol Simpan dan Kembali --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('purchasing.penyewaan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

        {{-- Tombol Validasi & Tolak --}}
        <div class="d-flex gap-2 mt-4">
            @if ($penyewaan->status !== 'disetujui')
                <form action="{{ route('penyewaan.validasi', $penyewaan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">✅ Validasi (Setujui)</button>
                </form>
            @endif

            @if ($penyewaan->status !== 'ditolak')
                <form action="{{ route('penyewaan.batalkanValidasi', $penyewaan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">❌ Cancel Validasi (Tolak)</button>
                </form>
            @endif
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        // Semua fitur interaksi alat dinonaktifkan karena readonly
        function tambahAlat() {}
        function hapusAlat() {}
        function toggleVolume() {}
    </script>
</body>
</html>
