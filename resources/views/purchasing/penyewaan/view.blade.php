@extends('layouts.purchasing')

@section('content')
<div class="container">
    @php
        use Carbon\Carbon;

        $defaultBulan = Carbon::parse($penyewaan->tanggal_permintaan)->format('Y-m');
        $current = Carbon::parse(request('bulan', $defaultBulan));

        $awal = Carbon::parse($penyewaan->tanggal_permintaan)->startOfMonth();
        $akhir = now()->startOfMonth();
        $loopingBulan = $awal->copy();

        $penyewaanBulanIni = \App\Models\Penyewaan::with('alatPenyewaan')
            ->whereYear('tanggal_permintaan', $current->year)
            ->whereMonth('tanggal_permintaan', $current->month)
            ->get();
    @endphp

    {{-- Judul --}}
    <div class="mb-2">
        <h3 class="fw-bold">Penyewaan Alat Proyek</h3>
    </div>

    {{-- Pilih Bulan di bawah judul, rata kanan --}}
    <div class="d-flex justify-content-end mb-4">
        <form action="{{ route('purchasing.penyewaan.view', $penyewaan->id) }}" method="GET" class="d-flex align-items-center">
            <label for="bulan" class="me-2 fw-semibold">Pilih Bulan:</label>
            <select name="bulan" id="bulan" class="form-select w-auto" onchange="this.form.submit()">
                @while ($loopingBulan <= $akhir)
                    @php $value = $loopingBulan->format('Y-m'); @endphp
                    <option value="{{ $value }}" {{ $current->format('Y-m') == $value ? 'selected' : '' }}>
                        {{ $loopingBulan->translatedFormat('F Y') }}
                    </option>
                    @php $loopingBulan->addMonth(); @endphp
                @endwhile
            </select>
        </form>
    </div>

    {{-- Daftar Alat --}}
    <h5 class="fw-semibold mb-3">Daftar Alat yang Disewa</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover shadow-sm align-middle text-center">
            <thead class="table-secondary">
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Alat</th>
                    <th>Mulai Jam</th>
                    <th>Selesai Jam</th>
                    <th>Total Jam</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Volume Docket</th>
                    <th>Kumulatif</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($penyewaanBulanIni->count())
                    @foreach ($penyewaanBulanIni as $p)
                        @foreach ($p->alatPenyewaan as $alat)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_permintaan)->translatedFormat('d F Y') }}</td>
                                <td class="text-start">{{ $alat->nama_alat }}</td>
                                <td>{{ $alat->mulai_jam }}</td>
                                <td>{{ $alat->selesai_jam }}</td>
                                <td>{{ $alat->total_jam_kerja }}</td>
                                <td>{{ $alat->jumlah_alat }}</td>
                                <td>{{ $alat->satuan }}</td>
                                <td>{{ $alat->satuan == 'm3' ? $alat->volume_docket : '-' }}</td>
                                <td>{{ $alat->satuan == 'm3' ? $alat->kumulatif : '-' }}</td>
                                <td>{{ ucfirst($p->status) }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="10" class="text-muted">Tidak ada data penyewaan alat pada bulan ini.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-4">
        <a href="{{ route('purchasing.penyewaan.index') }}" class="btn btn-outline-secondary">← Kembali</a>
    </div>
</div>
@endsection
