@extends('layouts.app')

@section('title', 'Disposisi Saya - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark"><i class="fa-solid fa-share-nodes me-2 text-info"></i>Disposisi Saya</h1>
    </div>

    <div class="alert alert-info bg-info bg-opacity-10 border-info border-start border-4 mb-4 shadow-sm">
        <i class="fa-solid fa-circle-info me-2"></i> Halaman ini menampilkan daftar instruksi atau tugas yang didelegasikan
        kepada Anda berdasarkan Surat Masuk.
    </div>

    <div class="row">
        @forelse ($dispositions as $disp)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm border-top border-4 border-info hover-shadow transition-all">
                    <div
                        class="card-header bg-white border-bottom-0 pt-3 pb-0 d-flex justify-content-between align-items-start">
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">
                            {{ $disp->incomingletter->letter_number ?? 'Surat Dihapus' }}
                        </span>
                        <small class="text-muted"><i
                                class="fa-regular fa-clock me-1"></i>{{ $disp->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="card-body mt-2">
                        <h6 class="fw-bold text-dark mb-3">
                            {{ Str::limit($disp->incomingletter->subject ?? 'Tidak ada perihal', 50) }}
                        </h6>

                        <div class="p-3 bg-light rounded border border-light mb-3">
                            <small class="text-muted d-block fw-bold text-uppercase mb-1"
                                style="font-size: 0.7rem;">Instruksi Tugas:</small>
                            <p class="mb-0 text-dark" style="font-size: 0.9rem;">{{ $disp->instruction }}</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div class="text-muted" style="font-size: 0.8rem;">
                                <i class="fa-solid fa-user-tie me-1"></i> Dari: {{ $disp->user->name ?? 'Admin' }}
                            </div>
                            @if ($disp->due_date)
                                <div class="text-danger fw-bold" style="font-size: 0.8rem;">
                                    <i class="fa-solid fa-calendar-xmark me-1"></i>
                                    {{ \Carbon\Carbon::parse($disp->due_date)->format('d M') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top text-center py-3">
                        @if ($disp->incomingletter && $disp->incomingletter->file_path)
                            <a href="{{ asset('storage/' . $disp->incomingletter->file_path) }}" target="_blank"
                                class="btn btn-sm btn-outline-info w-100 fw-bold">
                                <i class="fa-solid fa-file-pdf me-1"></i> Lihat Lampiran Surat
                            </a>
                        @else
                            <button class="btn btn-sm btn-outline-secondary w-100" disabled>
                                <i class="fa-solid fa-file-circle-xmark me-1"></i> Tidak Ada Lampiran
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="fa-solid fa-mug-hot fa-4x text-muted opacity-25 mb-3"></i>
                        <h5 class="fw-bold text-dark">Belum Ada Tugas</h5>
                        <p class="text-muted mb-0">Anda belum menerima instruksi atau disposisi surat apapun saat ini.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination jika datanya banyak -->
    <div class="d-flex justify-content-center mt-4">
        {{ $dispositions->links('pagination::bootstrap-5') }}
    </div>
@endsection
