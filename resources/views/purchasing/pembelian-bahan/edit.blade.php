@extends('layouts.purchasing')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('wa_link'))
    <script>
        window.open("{{ session('wa_link') }}", "_blank");
    </script>
@endif


<div class="container">
    <h4>Edit Permintaan Pembelian</h4>

    {{-- Tombol Validasi --}}
    <div class="mb-3">
        @if ($pembelian->status !== 'Disetujui')
            <form action="{{ route('pembelian.validasi', $pembelian->id) }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-success">✅ Validasi</button>
            </form>
        @endif

        @if ($pembelian->status !== 'Ditolak')
            <form action="{{ route('pembelian.batalValidasi', $pembelian->id) }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-danger">❌ Cancel Validasi</button>
            </form>
        @endif
    </div>

    {{-- Form Update --}}
    <form action="#" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Proyek</label>
            <select name="proyek_id" class="form-control" disabled>
                @foreach($proyeks as $proyek)
                    <option value="{{ $proyek->id }}" {{ $proyek->id == $pembelian->proyek_id ? 'selected' : '' }}>
                        {{ $proyek->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ $pembelian->lokasi }}" readonly>
        </div>

        <div class="mb-3">
            <label>Tanggal Permintaan</label>
            <input type="date" name="tanggal_permintaan" class="form-control" value="{{ $pembelian->tanggal_permintaan }}" readonly>
        </div>

        <input type="hidden" name="status" value="{{ $pembelian->status }}">

        <hr>
        <h5>Daftar Bahan Material</h5>
        <div id="material-list">
            @foreach($pembelian->materials as $material)
            <div class="row mb-2 align-items-start material-row">
                <div class="col-md-3">
                    <input type="text" name="materials[nama_material][]" class="form-control" value="{{ $material->nama_material }}" readonly>
                </div>

                <div class="col-md-3 jumlah-col {{ $material->satuan === 'meter' ? 'd-none' : '' }}">
                    <input type="number" name="materials[jumlah][]" class="form-control" value="{{ $material->jumlah }}" readonly>
                </div>

                <div class="col-md-3 dimension-fields {{ $material->satuan === 'meter' ? '' : 'd-none' }}">
                    <div class="d-flex gap-1">
                        <input type="number" step="0.01" name="materials[panjang][]" class="form-control" placeholder="P" value="{{ $material->panjang ?? '' }}" readonly>
                        <input type="number" step="0.01" name="materials[lebar][]" class="form-control" placeholder="L" value="{{ $material->lebar ?? '' }}" readonly>
                        <input type="number" step="0.01" name="materials[tinggi][]" class="form-control" placeholder="T" value="{{ $material->tinggi ?? '' }}" readonly>
                    </div>
                </div>

                <div class="col-md-2">
                    <select name="materials[satuan][]" class="form-control satuan-select" disabled>
                        @foreach(['pcs','batang','zak/25 kg','zak/40 kg','meter'] as $opt)
                            <option value="{{ $opt }}" {{ $material->satuan == $opt ? 'selected' : '' }}>
                                {{ $opt }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm delete-btn" disabled>🗑️</button>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Tombol Update dan Tambah Material disembunyikan saat readonly --}}
        {{-- <button type="button" id="add-material-btn" class="btn btn-primary mt-2">+ Tambah Material</button>
        <button type="submit" class="btn btn-success mt-3">Update</button> --}}
        <a href="{{ route('purchasing.pembelian-bahan') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
