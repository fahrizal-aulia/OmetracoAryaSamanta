@extends('layouts.purchasing')

@section('content')
<div class="container">
    <h3 class="text-center fw-bold mb-4">Pembelian Bahan Material</h3>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('purchasing.pembelian-bahan') }}" class="btn btn-outline-secondary">← Kembali</a>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('purchasing.pembelian-bahan.view', ['id' => $proyekId, 'week' => $week - 1]) }}" class="btn btn-light">←</a>
            <div class="text-end">
                <div class="fw-bold">Minggu ke-{{ $week }}</div>
                <div>({{ $startOfWeek->translatedFormat('d M Y') }} – {{ $endOfWeek->translatedFormat('d M Y') }})</div>
            </div>
            <a href="{{ route('purchasing.pembelian-bahan.view', ['id' => $proyekId, 'week' => $week + 1]) }}" class="btn btn-light">→</a>
        </div>
    </div>

    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-secondary text-center">
            <tr>
                <th style="width: 120px">Tanggal</th>
                <th>Nama Bahan Material</th>
                <th>Quantity</th>
                <th>Satuan</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelianPerTanggal as $tanggal => $items)
                @php $rowspan = $items->sum(fn($item) => $item->materials->count()); @endphp
                @foreach($items as $index => $item)
                    @foreach($item->materials as $mIndex => $material)
                        <tr>
                            @if($index == 0 && $mIndex == 0)
                                <td rowspan="{{ $rowspan }}" class="align-middle text-center">
                                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}
                                </td>
                            @endif
                            <td>{{ $material->nama_material }}</td>
                            <td>
                                @if($material->satuan === 'meter')
                                    {{ $material->panjang }} x {{ $material->lebar }} x {{ $material->tinggi }}
                                @else
                                    {{ $material->jumlah }}
                                @endif
                            </td>
                            <td>{{ $material->satuan }}</td>
                            <td>
                                @if ($item->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif ($item->status == 'Disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($item->status == 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">Status Tidak Dikenal</span>
                                @endif
                            </td>
                            <td>{{ $material->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada data pembelian bahan material pada minggu ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
