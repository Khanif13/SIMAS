@extends('layouts.app')

@section('title', 'Surat Keluar - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Daftar Surat Keluar</h1>
        <a href="#" class="btn btn-primary-custom shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Buat Surat Keluar
        </a>
    </div>

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="#" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0"
                            placeholder="Cari nomor surat, tujuan, perihal...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Semua Status</option>
                        <option value="draft">Draft</option>
                        <option value="sent">Terkirim</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="button" class="btn btn-secondary text-white shadow-sm">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No Surat</th>
                            <th>Tanggal</th>
                            <th>Tujuan</th>
                            <th>Perihal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">SK/2026/05/042</td>
                            <td>12 Mei 2026</td>
                            <td>Kepala SMAN 1 Majene</td>
                            <td>Permohonan Izin Observasi Data</td>
                            <td><span class="badge bg-success">Terkirim</span></td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <button type="button" class="btn btn-sm btn-light border" title="Lihat Detail"><i
                                            class="fa-solid fa-eye text-secondary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Edit"><i
                                            class="fa-solid fa-pen text-primary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Cetak PDF"><i
                                            class="fa-solid fa-print text-danger"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">SK/2026/05/043</td>
                            <td>15 Mei 2026</td>
                            <td>BEM Fakultas Teknik</td>
                            <td>Pemberitahuan Peminjaman Ruangan</td>
                            <td><span class="badge bg-warning text-dark">Draft</span></td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <button type="button" class="btn btn-sm btn-light border" title="Lihat Detail"><i
                                            class="fa-solid fa-eye text-secondary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Edit"><i
                                            class="fa-solid fa-pen text-primary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Kirim Surat"><i
                                            class="fa-solid fa-paper-plane text-success"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center border-top">
            <small class="text-muted ps-2">Menampilkan 1 hingga 2 dari 85 entri</small>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0 pe-2">
                    <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
