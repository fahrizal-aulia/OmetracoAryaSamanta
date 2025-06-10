@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Permintaan Pembelian</h4>
    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Proyek</label>
            <select name="proyek_id" class="form-control" required>
                <option value="">-- Pilih Proyek --</option>
                @foreach($proyeks as $proyek)
                    <option value="{{ $proyek->id }}">{{ $proyek->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Permintaan</label>
            <input type="date" name="tanggal_permintaan" class="form-control" required>
        </div>

        <!-- Hidden status field -->
        <input type="hidden" name="status" value="Menunggu">

        <hr>
        <h5>Daftar Bahan Material</h5>
        <div id="material-list"></div>
        <button type="button" id="add-material-btn" class="btn btn-sm btn-primary mt-2">+ Tambah Material</button>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
        </div>

    </form>
</div>

{{-- Script --}}
<script>
    const satuanOptions = ['pcs', 'batang', 'zak/25 kg', 'zak/40 kg', 'meter'];

    function createMaterialRow() {
        const row = document.createElement('div');
        row.className = 'row mb-2 align-items-center material-row';

        row.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="materials[nama_material][]" class="form-control" placeholder="Nama Material" required>
            </div>
            <div class="col-md-2 jumlah-col">
                <input type="number" name="materials[jumlah][]" class="form-control" placeholder="Jumlah" step="any">
            </div>
            <div class="col-md-4 d-none qty-meter-cols">
                <div class="input-group">
                    <input type="number" name="materials[panjang][]" class="form-control" placeholder="P" step="any">
                    <input type="number" name="materials[lebar][]" class="form-control" placeholder="L" step="any">
                    <input type="number" name="materials[tinggi][]" class="form-control" placeholder="T" step="any">
                </div>
            </div>
            <div class="col-md-2">
                <select name="materials[satuan][]" class="form-control satuan-select" required>
                    ${satuanOptions.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-link text-danger delete-btn">🗑️</button>
            </div>
        `;

        const satuanSelect = row.querySelector('.satuan-select');
        const jumlahCol = row.querySelector('.jumlah-col');
        const qtyMeterCols = row.querySelector('.qty-meter-cols');

        satuanSelect.addEventListener('change', () => {
            const isMeter = satuanSelect.value === 'meter';
            jumlahCol.classList.toggle('d-none', isMeter);
            qtyMeterCols.classList.toggle('d-none', !isMeter);
        });

        row.querySelector('.delete-btn').onclick = () => row.remove();

        return row;
    }

    const materialList = document.getElementById('material-list');
    const addMaterialBtn = document.getElementById('add-material-btn');

    addMaterialBtn.addEventListener('click', () => {
        materialList.appendChild(createMaterialRow());
    });

    window.onload = () => {
        materialList.appendChild(createMaterialRow());
        materialList.appendChild(createMaterialRow());
    };
</script>

{{-- Optional styling for input P L T --}}
<style>
    .input-group input {
        width: 33.33%;
    }
</style>
@endsection
