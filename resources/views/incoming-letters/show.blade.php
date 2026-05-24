@extends('layouts.app')

@section('title', 'Detail Surat Masuk - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Detail Surat Masuk</h1>
        <div>
            <a href="{{ route('incoming-letters.index') }}" class="btn btn-outline-secondary shadow-sm me-2">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>

            <a href="{{ route('incoming-letters.edit', $letter->id) }}"
                class="btn btn-warning shadow-sm me-2 text-dark fw-bold"
                style="background-color: var(--primary-color); border: none;">
                <i class="fa-solid fa-pen me-1"></i> Edit
            </a>
            <form action="{{ route('incoming-letters.destroy', $letter->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini? Seluruh data dan berkas akan hilang.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger shadow-sm">
                    <i class="fa-solid fa-trash me-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <i class="fa-solid fa-inbox fa-lg me-2 text-primary"></i>
                    <h5 class="mb-0 fw-bold text-dark">Informasi Surat Masuk</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="mb-3">
                        <small class="text-muted fw-bold text-uppercase">Nomor Surat (Sistem)</small>
                        <p class="fs-5 fw-bold text-dark mb-0">{{ $letter->letter_number }}</p>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="mb-3">
                        <small class="text-muted fw-bold text-uppercase">Pengirim</small>
                        <p class="fs-6 text-dark mb-0 fw-medium">{{ $letter->sender }}</p>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted fw-bold text-uppercase">Tgl. Surat</small>
                            <p class="text-dark mb-0"><i class="fa-regular fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($letter->letter_date)->format('d M Y') }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted fw-bold text-uppercase">Tgl. Terima</small>
                            <p class="text-dark mb-0"><i class="fa-solid fa-calendar-check me-1"></i>
                                {{ \Carbon\Carbon::parse($letter->receipt_date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="mb-3">
                        <small class="text-muted fw-bold text-uppercase">Perihal</small>
                        <p class="text-dark mb-0 fw-medium">{{ $letter->subject }}</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted fw-bold text-uppercase">Status</small>
                        <div class="mt-1">
                            @if ($letter->status == 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2">Pending / Belum Diproses</span>
                            @elseif($letter->status == 'dispositioned')
                                <span class="badge bg-info px-3 py-2">Telah Didisposisikan</span>
                            @else
                                <span class="badge bg-success px-3 py-2">Selesai / Diarsipkan</span>
                            @endif
                        </div>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="mb-4">
                        <small class="text-muted fw-bold text-uppercase">Catatan Tambahan</small>
                        <div class="p-3 bg-light rounded mt-2 border">
                            {{ $letter->description ?: 'Tidak ada catatan tambahan saat input.' }}
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success shadow-sm fw-bold py-2" data-bs-toggle="modal"
                            data-bs-target="#disposisiModal">
                            <i class="fa-solid fa-share-nodes me-2"></i> Buat Disposisi Surat
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-file-pdf fa-lg me-2 text-danger"></i>
                        <h5 class="mb-0 fw-bold text-dark">Dokumen Lampiran</h5>
                    </div>
                    @if ($letter->file_path)
                        <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-up-right-from-square me-1"></i> Buka Layar Penuh
                        </a>
                    @endif
                </div>
                <div class="card-body p-0 bg-light d-flex align-items-center justify-content-center"
                    style="min-height: 600px;">
                    @if ($letter->file_path)
                        @php
                            $extension = pathinfo($letter->file_path, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/' . $letter->file_path) }}" alt="Lampiran Surat Masuk"
                                class="img-fluid p-3">
                        @else
                            <iframe src="{{ asset('storage/' . $letter->file_path) }}" width="100%" height="100%"
                                style="min-height: 600px; border: none;"></iframe>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fa-solid fa-file-circle-xmark fa-4x mb-3 opacity-50"></i>
                            <h5>File Tidak Ditemukan</h5>
                            <p>Dokumen fisik belum dipindai atau file hilang dari server.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
