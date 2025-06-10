@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Judul Halaman --}}
    <div class="text-center mb-3">
        <h4 class="fw-bold">Daftar Penyewaan Alat Proyek</h4>
    </div>

    {{-- Form Cari Proyek --}}
    <form action="{{ route('penyewaan.index') }}" method="GET" class="d-flex mb-3" role="search">
        <input type="text" name="cari" class="form-control me-2" placeholder="Cari proyek..." value="{{ request('cari') }}">
        <button type="submit" class="btn btn-outline-primary">Cari</button>
    </form>

    {{-- Tombol Tambah Data --}}
    <div class="mb-4">
        <a href="{{ route('penyewaan.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Data
        </a>
    </div>

    {{-- Tampilkan Data --}}
    @if($penyewaans->isEmpty())
        <div class="alert alert-info text-center">Belum ada data penyewaan alat.</div>
    @else
        @php $no = 1; @endphp
        @foreach($penyewaans as $groupKey => $groupItems)
            @php
                list($namaProyek, $bulan) = explode('|', $groupKey);
                $bulanFormat = \Carbon\Carbon::parse($bulan . '-01')->format('F Y');
            @endphp

            <h5 class="mt-4 mb-2 fw-bold">{{ $namaProyek }} — <small class="text-muted">{{ $bulanFormat }}</small></h5>

            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Tanggal Permintaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupItems as $penyewaan)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $penyewaan->lokasi }}</td>
                            <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_permintaan)->format('d M Y') }}</td>
                            <td>
                                @if ($penyewaan->status == 'menunggu')
                                    <span class="badge rounded-pill bg-warning text-dark">Menunggu</span>
                                @elseif ($penyewaan->status == 'disetujui')
                                    <span class="badge rounded-pill bg-success">Disetujui</span>
                                @elseif ($penyewaan->status == 'ditolak')
                                    <span class="badge rounded-pill bg-danger">Ditolak</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary">Status Tidak Diketahui</span>
                                @endif
                            </td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('penyewaan.view', $penyewaan->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('penyewaan.edit', $penyewaan->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('penyewaan.destroy', $penyewaan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif
</div>
@endsection
