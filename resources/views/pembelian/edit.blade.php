@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container">
    <h4>Edit Permintaan Pembelian</h4>

    {{-- Tombol Validasi (diletakkan di luar form update) --}}
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
    <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Proyek</label>
            <select name="proyek_id" class="form-control" required>
                @foreach($proyeks as $proyek)
                    <option value="{{ $proyek->id }}" {{ $proyek->id == $pembelian->proyek_id ? 'selected' : '' }}>
                        {{ $proyek->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ $pembelian->lokasi }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Permintaan</label>
            <input type="date" name="tanggal_permintaan" class="form-control" value="{{ $pembelian->tanggal_permintaan }}" required>
        </div>

        <input type="hidden" name="status" value="{{ $pembelian->status }}">
        
        <hr>
        <h5>Daftar Bahan Material</h5>
        <div id="material-list">
            @foreach($pembelian->materials as $material)
            <div class="row mb-2 align-items-start material-row">
                <div class="col-md-3">
                    <input type="text" name="materials[nama_material][]" class="form-control" value="{{ $material->nama_material }}" required>
                </div>

                <div class="col-md-3 jumlah-col {{ $material->satuan === 'meter' ? 'd-none' : '' }}">
                    <input type="number" name="materials[jumlah][]" class="form-control"
                        value="{{ $material->jumlah }}" {{ $material->satuan === 'meter' ? 'disabled' : '' }}>
                </div>

                <div class="col-md-3 dimension-fields {{ $material->satuan === 'meter' ? '' : 'd-none' }}">
                    <div class="d-flex gap-1">
                        <input type="number" step="0.01" name="materials[panjang][]" class="form-control"
                            placeholder="P" value="{{ $material->panjang ?? '' }}">
                        <input type="number" step="0.01" name="materials[lebar][]" class="form-control"
                            placeholder="L" value="{{ $material->lebar ?? '' }}">
                        <input type="number" step="0.01" name="materials[tinggi][]" class="form-control"
                            placeholder="T" value="{{ $material->tinggi ?? '' }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <select name="materials[satuan][]" class="form-control satuan-select" required>
                        @foreach(['pcs','batang','zak/25 kg','zak/40 kg','meter'] as $opt)
                            <option value="{{ $opt }}" {{ $material->satuan == $opt ? 'selected' : '' }}>
                                {{ $opt }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm delete-btn">🗑️</button>
                </div>
            </div>
            @endforeach
        </div>

        <button type="button" id="add-material-btn" class="btn btn-primary mt-2">+ Tambah Material</button>
        <hr>
        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>

{{-- JavaScript --}}
<script>
    const satuanOptions = ['pcs', 'batang', 'zak/25 kg', 'zak/40 kg', 'meter'];

    function createMaterialRow() {
        const row = document.createElement('div');
        row.className = 'row mb-2 align-items-start material-row';

        row.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="materials[nama_material][]" class="form-control" placeholder="Nama Material" required>
            </div>

            <div class="col-md-3 jumlah-col">
                <input type="number" name="materials[jumlah][]" class="form-control" placeholder="Jumlah">
            </div>

            <div class="col-md-3 dimension-fields d-none">
                <div class="d-flex gap-1">
                    <input type="number" step="0.01" name="materials[panjang][]" class="form-control" placeholder="P">
                    <input type="number" step="0.01" name="materials[lebar][]" class="form-control" placeholder="L">
                    <input type="number" step="0.01" name="materials[tinggi][]" class="form-control" placeholder="T">
                </div>
            </div>

            <div class="col-md-2">
                <select name="materials[satuan][]" class="form-control satuan-select" required>
                    ${satuanOptions.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                </select>
            </div>

            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm delete-btn">🗑️</button>
            </div>
        `;

        const satuanSelect = row.querySelector('.satuan-select');
        const jumlahCol = row.querySelector('.jumlah-col');
        const dimFields = row.querySelector('.dimension-fields');

        satuanSelect.addEventListener('change', () => {
            if (satuanSelect.value === 'meter') {
                jumlahCol.classList.add('d-none');
                dimFields.classList.remove('d-none');
            } else {
                jumlahCol.classList.remove('d-none');
                dimFields.classList.add('d-none');
            }
        });

        row.querySelector('.delete-btn').onclick = () => row.remove();

        return row;
    }

    const materialList = document.getElementById('material-list');
    const addMaterialBtn = document.getElementById('add-material-btn');

    addMaterialBtn.addEventListener('click', () => {
        materialList.appendChild(createMaterialRow());
    });

    document.querySelectorAll('.material-row').forEach(row => {
        const satuanSelect = row.querySelector('.satuan-select');
        const jumlahCol = row.querySelector('.jumlah-col');
        const dimFields = row.querySelector('.dimension-fields');

        satuanSelect.addEventListener('change', () => {
            if (satuanSelect.value === 'meter') {
                jumlahCol.classList.add('d-none');
                dimFields.classList.remove('d-none');
            } else {
                jumlahCol.classList.remove('d-none');
                dimFields.classList.add('d-none');
            }
        });

        row.querySelector('.delete-btn').onclick = () => row.remove();
    });
</script>
@endsection
