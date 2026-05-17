@extends('layouts.app')

@section('title', 'Tambah Surat Masuk - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Tambah Surat Masuk</h1>
        <a href="{{ url('/incoming-letters') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-file-lines me-2 text-primary"></i>Form Data Surat</h5>
        </div>
        <div class="card-body p-4 bg-white">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="letter_number" class="form-label fw-bold text-secondary">Nomor Surat (Otomatis)</label>
                        <input type="text" class="form-control bg-light" id="letter_number" value="SM/2026/05/004"
                            readonly>
                        <div class="form-text">Nomor surat di-generate otomatis oleh sistem.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="sender" class="form-label fw-bold text-secondary">Instansi/Nama Pengirim <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sender"
                            placeholder="Contoh: Universitas Sulawesi Barat" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="letter_date" class="form-label fw-bold text-secondary">Tanggal Surat <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="letter_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="receipt_date" class="form-label fw-bold text-secondary">Tanggal Terima <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="receipt_date" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="subject" class="form-label fw-bold text-secondary">Perihal Surat <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="subject"
                        placeholder="Contoh: Undangan Rapat Koordinasi Tahunan" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-bold text-secondary">Keterangan Singkat / Catatan</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                </div>

                <div class="mb-5">
                    <label for="file" class="form-label fw-bold text-secondary">Upload File Scan Surat <span
                            class="text-danger">*</span></label>
                    <input class="form-control" type="file" id="file" accept=".pdf,.jpg,.jpeg,.png" required>
                    <div class="form-text">Format yang didukung: PDF, JPG, PNG. Maksimal 2MB.</div>
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
