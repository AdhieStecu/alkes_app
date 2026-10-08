@extends('layouts.bootstrap')

@section('title', 'Edit Alat Medis')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                <div>
                    <h1 class="h4 fw-bold text-dark mb-1">
                        <i class="bi bi-pencil-square text-teal me-2"></i>Edit Data Alat Medis
                    </h1>
                    <p class="text-muted small mb-0">Perbarui informasi inventaris untuk alat: <strong>{{ $alat->nama_alat }}</strong></p>
                </div>
                <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('alat.update', $alat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Alat -->
                <div class="mb-3">
                    <label for="nama_alat" class="form-label fw-semibold">
                        Nama Alat Medis <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_alat"
                        id="nama_alat"
                        class="form-control @error('nama_alat') is-invalid @enderror"
                        value="{{ old('nama_alat', $alat->nama_alat) }}"
                        maxlength="100"
                        required
                    >
                    @error('nama_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Merek & Tahun -->
                <div class="row g-3 mb-3">
                    <div class="col-md-7">
                        <label for="merek" class="form-label fw-semibold">
                            Merek / Pabrikan <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="merek"
                            id="merek"
                            class="form-control @error('merek') is-invalid @enderror"
                            value="{{ old('merek', $alat->merek) }}"
                            maxlength="60"
                            required
                        >
                        @error('merek')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label for="tahun" class="form-label fw-semibold">
                            Tahun Pengadaan <span class="text-danger">*</span>
                        </label>
                        <input
                            type="number"
                            name="tahun"
                            id="tahun"
                            class="form-control @error('tahun') is-invalid @enderror"
                            value="{{ old('tahun', $alat->tahun) }}"
                            min="1900"
                            max="2099"
                            required
                        >
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Lokasi Ruangan -->
                <div class="mb-4">
                    <label for="lokasi" class="form-label fw-semibold">
                        Lokasi Ruangan <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="lokasi"
                        id="lokasi"
                        class="form-control @error('lokasi') is-invalid @enderror"
                        value="{{ old('lokasi', $alat->lokasi) }}"
                        maxlength="10"
                        required
                    >
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Contoh: IGD, ICU, POLI, LAB, OK.</div>
                </div>

                <!-- Buttons -->
                <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('alat.index') }}" class="btn btn-light rounded-pill px-4">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-teal rounded-pill px-4 shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
