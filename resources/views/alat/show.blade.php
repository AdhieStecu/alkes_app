@extends('layouts.bootstrap')

@section('title', 'Detail Alat Medis')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                <div>
                    <h1 class="h4 fw-bold text-dark mb-1">
                        <i class="bi bi-info-circle-fill text-teal me-2"></i>Detail Alat Medis
                    </h1>
                    <p class="text-muted small mb-0">Informasi spesifikasi dan inventaris peralatan rumah sakit</p>
                </div>
                <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <!-- Detail Card Info -->
            <div class="p-4 rounded-4 mb-4 border" style="background-color: #f8fafc;">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="p-3 rounded-3 fs-1 d-flex align-items-center justify-center shadow-sm" style="background-color: #e6fffa; color: #0d9488; width: 64px; height: 64px;">
                        🩺
                    </div>
                    <div>
                        <h2 class="h3 fw-bold text-dark mb-1">{{ $alat->nama_alat }}</h2>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary-subtle text-secondary border">Kode ID: #{{ $alat->id }}</span>
                            <span class="badge badge-year rounded-pill px-2.5 py-1">Tahun {{ $alat->tahun }}</span>
                            <span class="badge badge-location rounded-pill px-2.5 py-1">Ruang {{ $alat->lokasi }}</span>
                        </div>
                    </div>
                </div>

                <div class="row g-3 pt-3 border-top">
                    <div class="col-sm-6">
                        <div class="small text-muted fw-semibold">NAMA ALAT MEDIS</div>
                        <div class="fw-bold fs-6 text-dark mt-1">{{ $alat->nama_alat }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted fw-semibold">MEREK / BRAND</div>
                        <div class="fw-bold fs-6 text-dark mt-1">{{ $alat->merek }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted fw-semibold">TAHUN PENGADAAN</div>
                        <div class="fw-bold fs-6 text-dark mt-1">{{ $alat->tahun }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted fw-semibold">LOKASI RUANGAN</div>
                        <div class="fw-bold fs-6 text-dark mt-1">{{ $alat->lokasi }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted fw-semibold">TANGGAL DIDAFTARKAN</div>
                        <div class="small text-secondary mt-1">{{ $alat->created_at ? $alat->created_at->format('d M Y, H:i') : '-' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted fw-semibold">TERAKHIR DIUBAH</div>
                        <div class="small text-secondary mt-1">{{ $alat->updated_at ? $alat->updated_at->format('d M Y, H:i') : '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                <a href="{{ route('alat.index') }}" class="btn btn-light rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('alat.edit', $alat->id) }}" class="btn btn-warning rounded-pill px-4">
                        <i class="bi bi-pencil me-1"></i> Edit Alat Ini
                    </a>
                    <form action="{{ route('alat.destroy', $alat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alat medis ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
