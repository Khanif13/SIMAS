@extends('layouts.app')

@section('title', 'Buat Surat Keluar - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Buat Surat Keluar</h1>
        <a href="{{ route('outgoing-letters.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i>Gagal menyimpan data:</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-paper-plane me-2 text-success"></i>Form Data Surat
                Keluar</h5>
        </div>
        <div class="card-body p-4 bg-white">
            <form action="{{ route('outgoing-letters.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="letter_number" class="form-label fw-bold text-secondary">Nomor Surat (Otomatis)</label>
                        <input type="text" class="form-control bg-light" id="letter_number" name="letter_number"
                            value="{{ $autoLetterNumber }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="destination" class="form-label fw-bold text-secondary">Tujuan Surat (Instansi/Nama)
                            <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="destination" name="destination"
                            placeholder="Contoh: Kepala SMAN 1 Majene" value="{{ old('destination') }}" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="letter_date" class="form-label fw-bold text-secondary">Tanggal Surat <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="letter_date" name="letter_date"
                            value="{{ old('letter_date') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="subject" class="form-label fw-bold text-secondary">Perihal Surat <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="subject" name="subject"
                            placeholder="Contoh: Permohonan Izin Observasi" value="{{ old('subject') }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-bold text-secondary">Keterangan Singkat / Catatan</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                        placeholder="Tambahkan catatan jika diperlukan...">{{ old('description') }}</textarea>
                </div>

                <div class="mb-5">
                    <label for="file" class="form-label fw-bold text-secondary">Upload File Scan/Draft Surat (.pdf,
                        .jpg, .png)</label>
                    <input class="form-control" type="file" id="file" name="file" accept=".pdf,.jpg,.jpeg,.png">
                    <div class="form-text text-warning"><i class="fa-solid fa-circle-info"></i> Jika file tidak di-upload,
                        surat akan otomatis tersimpan dengan status <strong>Draft</strong>.</div>
                </div>

                <div class="d-flex justify-content-end border-top pt-4">
                    <button type="reset" class="btn btn-light me-2 border shadow-sm"><i
                            class="fa-solid fa-rotate-right me-1"></i> Reset Form</button>
                    <button type="submit" class="btn btn-primary-custom shadow-sm"><i
                            class="fa-solid fa-floppy-disk me-1"></i> Simpan Surat</button>
                </div>
            </form>
        </div>
    </div>
@endsection
