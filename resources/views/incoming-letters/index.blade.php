@extends('layouts.app')

@section('title', 'Surat Masuk - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Daftar Surat Masuk</h1>
        <a href="{{ url('/incoming-letters/create') }}" class="btn btn-primary-custom shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Tambah Surat
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="#" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0"
                            placeholder="Cari nomor surat, pengirim, perihal...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="disposition">Disposisi</option>
                        <option value="archived">Diarsipkan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="button" class="btn btn-secondary text-white">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No Surat</th>
                            <th>Tgl Terima</th>
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">SM/2026/05/001</td>
                            <td>18 Mei 2026</td>
                            <td>Universitas Sulawesi Barat</td>
                            <td>Undangan Rapat Koordinasi Fakultas</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <button type="button" class="btn btn-sm btn-light border" title="Lihat File"><i
                                            class="fa-solid fa-eye text-secondary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Edit"><i
                                            class="fa-solid fa-pen text-primary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Disposisi"><i
                                            class="fa-solid fa-share-nodes text-success"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">SM/2026/05/002</td>
                            <td>15 Mei 2026</td>
                            <td>Dinas Pendidikan Provinsi</td>
                            <td>Pemberitahuan Jadwal Audit Internal</td>
                            <td><span class="badge bg-info">Disposisi</span></td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <button type="button" class="btn btn-sm btn-light border" title="Lihat File"><i
                                            class="fa-solid fa-eye text-secondary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Edit"><i
                                            class="fa-solid fa-pen text-primary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Disposisi"><i
                                            class="fa-solid fa-share-nodes text-success"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">SM/2026/05/003</td>
                            <td>10 Mei 2026</td>
                            <td>Kementerian Pendidikan</td>
                            <td>Edaran Kurikulum Baru 2026</td>
                            <td><span class="badge bg-success">Diarsipkan</span></td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <button type="button" class="btn btn-sm btn-light border" title="Lihat File"><i
                                            class="fa-solid fa-eye text-secondary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Edit"><i
                                            class="fa-solid fa-pen text-primary"></i></button>
                                    <button type="button" class="btn btn-sm btn-light border" title="Disposisi"><i
                                            class="fa-solid fa-share-nodes text-success"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
            <small class="text-muted ps-2">Menampilkan 1 hingga 3 dari 142 entri</small>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0 pe-2">
                    <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
