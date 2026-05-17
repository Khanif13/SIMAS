@extends('layouts.app')

@section('title', 'Dashboard - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Dashboard Overview</h1>
        <div class="btn-group">
            <button class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-calendar me-1"></i> Bulan Ini
            </button>
            <button class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-download me-1"></i> Export Laporan
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-start border-4 border-primary shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Surat Masuk</div>
                            <div class="h5 mb-0 fw-bold text-dark">142</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-inbox fa-2x text-muted opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-start border-4 border-success shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Surat Keluar</div>
                            <div class="h5 mb-0 fw-bold text-dark">85</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-paper-plane fa-2x text-muted opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-start border-4 border-info shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Disposisi Aktif</div>
                            <div class="h5 mb-0 fw-bold text-dark">12</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-share-nodes fa-2x text-muted opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-start border-4 border-warning shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Perlu Tindakan</div>
                            <div class="h5 mb-0 fw-bold text-dark">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-bell fa-2x text-muted opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 fw-bold text-dark">Aktivitas Surat Terkini</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No Surat</th>
                            <th>Jenis</th>
                            <th>Perihal</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">SM/2026/05/001</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Masuk</span>
                            </td>
                            <td>Undangan Rapat Koordinasi Fakultas</td>
                            <td>18 Mei 2026</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">SK/2026/05/042</td>
                            <td><span
                                    class="badge bg-success bg-opacity-10 text-success border border-success">Keluar</span>
                            </td>
                            <td>Permohonan Izin Laporan Data</td>
                            <td>16 Mei 2026</td>
                            <td><span class="badge bg-success">Terkirim</span></td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">SM/2026/05/002</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Masuk</span>
                            </td>
                            <td>Pemberitahuan Jadwal Audit Internal</td>
                            <td>15 Mei 2026</td>
                            <td><span class="badge bg-info">Disposisi</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white text-center py-3">
            <a href="{{ url('/incoming-letters') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Data</a>
        </div>
    </div>
@endsection
