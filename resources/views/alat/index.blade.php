@extends('layouts.bootstrap')

@section('title', 'Daftar Alat Medis')

@section('content')
<div class="card card-custom p-4">
    <!-- Header Card -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-3 mb-4 border-bottom">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">
                <i class="bi bi-hospital me-2 text-teal"></i>Daftar Inventaris Alat Medis
            </h1>
            <p class="text-muted small mb-0">Kelola data inventaris peralatan medis dan laboratorium rumah sakit</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">
                Total: <strong class="text-teal">{{ $alats->total() }}</strong> Alat
            </span>
            <a href="{{ route('alat.create') }}" class="btn btn-teal rounded-pill px-3 shadow-sm d-flex align-items-center gap-1">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Alat Baru</span>
            </a>
        </div>
    </div>

    <!-- Table -->
    @if ($alats->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-top">
                    <tr>
                        <th scope="col" class="text-center" style="width: 60px;">No</th>
                        <th scope="col">Nama Alat Medis</th>
                        <th scope="col">Merek / Brand</th>
                        <th scope="col" class="text-center">Tahun Pengadaan</th>
                        <th scope="col" class="text-center">Lokasi Ruangan</th>
                        <th scope="col" class="text-center" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alats as $index => $item)
                        <tr>
                            <td class="text-center fw-semibold text-muted">
                                {{ $alats->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-teal bg-opacity-10 text-teal p-2 rounded-circle fs-5 d-flex align-items-center justify-center" style="width: 40px; height: 40px; background-color: #f0fdfa; color: #0d9488;">
                                        🩺
                                    </div>
                                    <div>
                                        <a href="{{ route('alat.show', $item->id) }}" class="fw-bold text-dark text-decoration-none hover-teal">
                                            {{ $item->nama_alat }}
                                        </a>
                                        <div class="small text-muted">ID: #{{ $item->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium text-secondary">{{ $item->merek }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-year rounded-pill px-3 py-2">
                                    <i class="bi bi-calendar-event me-1"></i>{{ $item->tahun }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-location rounded-pill px-3 py-2">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $item->lokasi }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('alat.show', $item->id) }}" class="btn btn-outline-info" title="Detail Alat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('alat.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit Alat">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="Hapus Alat">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content card-custom">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start py-3">
                                                Apakah Anda yakin ingin menghapus data alat medis <strong>"{{ $item->nama_alat }}"</strong> (Merek: {{ $item->merek }})?
                                                <div class="alert alert-warning py-2 mt-2 mb-0 small">
                                                    Tindakan ini tidak dapat dibatalkan.
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('alat.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger rounded-pill px-3">
                                                        <i class="bi bi-trash me-1"></i> Ya, Hapus Data
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                Menampilkan {{ $alats->firstItem() }} sampai {{ $alats->lastItem() }} dari {{ $alats->total() }} data
            </div>
            <div>
                {{ $alats->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="fs-1 text-muted mb-3">📦</div>
            <h5 class="fw-bold text-secondary">Belum Ada Data Alat Medis</h5>
            <p class="text-muted small mb-4">Mulai tambahkan data inventaris alat medis ke dalam sistem.</p>
            <a href="{{ route('alat.create') }}" class="btn btn-teal rounded-pill px-4">
                <i class="bi bi-plus-lg me-1"></i> Tambah Data Pertama
            </a>
        </div>
    @endif
</div>
@endsection
