@extends('layouts.projectcontrol')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Daftar Permintaan Pembelian Material</h4>
        <div>
            <a href="{{ route('projectcontrol.pembelian.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pembelian
            </a>
        </div>
    </div>

    {{-- Form Pencarian --}}
    <form action="{{ route('projectcontrol.pembelian.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama Proyek..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    {{-- Tabel Data --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Proyek</th>
                    <th>Lokasi</th>
                    <th>Tanggal Permintaan</th>
                    <th>Status</th>
                    <th>Aksi</th> 
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-semibold">{{ $item->proyek->nama ?? '-' }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_permintaan)->format('d M Y') }}</td>
                    <td>
                        @if ($item->status == 'Menunggu')
                            <span class="badge rounded-pill bg-warning text-dark">Menunggu</span>
                        @elseif ($item->status == 'Disetujui')
                            <span class="badge rounded-pill bg-success">Disetujui</span>
                        @elseif ($item->status == 'Ditolak')
                            <span class="badge rounded-pill bg-danger">Ditolak</span>
                        @else
                            <span class="badge rounded-pill bg-secondary">Status Tidak Dikenal</span>
                        @endif
                    </td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('projectcontrol.pembelian.edit', $item->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <a href="{{ route('projectcontrol.pembelian.view', ['id' => $item->proyek_id, 'week' => 1]) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <form action="{{ route('projectcontrol.pembelian.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pembelian ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data pembelian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
