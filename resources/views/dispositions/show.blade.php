@extends('layouts.app')

@section('title', 'Detail Disposisi - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2" style="color: var(--secondary-color);">Lembar Disposisi</h1>
        <a href="{{ url('/incoming-letters') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Informasi Surat -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light fw-bold text-uppercase text-muted">
                    Informasi Surat Masuk
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%" class="text-muted">Nomor Surat</th>
                            <td class="fw-bold">SM/2026/05/008</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Pengirim</th>
                            <td>Dinas Pendidikan Provinsi</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal Terima</th>
                            <td>16 Mei 2026</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Perihal</th>
                            <td>Undangan Sosialisasi Program Pendidikan</td>
                        </tr>
                    </table>
                    <hr>
                    <button class="btn btn-outline-primary w-100">Lihat Dokumen PDF</button>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Disposisi -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header text-white"
                    style="background-color: var(--primary-color); color: var(--secondary-color) !important;">
                    <h5 class="mb-0 mt-1 fw-bold">Instruksi Disposisi</h5>
                </div>
                <div class="card-body bg-white">
                    <form action="#" method="POST">
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label fw-bold">Diteruskan Kepada (Member)</label>
                            <select class="form-select" id="assigned_to">
                                <option selected disabled>Pilih Anggota/Divisi...</option>
                                <option value="1">Divisi Humas</option>
                                <option value="2">Divisi Acara</option>
                                <option value="3">Koordinator Lapangan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="instruction" class="form-label fw-bold">Isi Instruksi</label>
                            <textarea class="form-control" id="instruction" rows="4" placeholder="Tuliskan arahan tindak lanjut surat ini..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="due_date" class="form-label fw-bold">Batas Waktu (Tenggat)</label>
                            <input type="date" class="form-control" id="due_date">
                        </div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary-custom">Kirim Disposisi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
