@extends('layouts.app')

@section('title', 'Dashboard - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Dashboard Overview</h1>
        <div class="btn-group shadow-sm">
            <button class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-calendar me-1"></i> Bulan Ini
            </button>
            <button class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-download me-1"></i> Export Laporan
            </button>
        </div>
    </div>

    <div class="row mb-4">
        @if (in_array($role, ['superadmin', 'admin']))
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100 border-0 border-start border-4 border-primary shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Surat Masuk</div>
                                <div class="h5 mb-0 fw-bold text-dark">{{ $totalIncoming ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-inbox fa-2x text-muted opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100 border-0 border-start border-4 border-success shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Surat Keluar</div>
                                <div class="h5 mb-0 fw-bold text-dark">{{ $totalOutgoing ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-paper-plane fa-2x text-muted opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100 border-0 border-start border-4 border-warning shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-warning text-uppercase mb-1">Total Pengguna</div>
                                <div class="h5 mb-0 fw-bold text-dark">{{ $totalUsers ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-users fa-2x text-muted opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($role === 'member')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 border-0 border-start border-4 border-info shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-info text-uppercase mb-1">Tugas / Disposisi Anda</div>
                                <div class="h5 mb-0 fw-bold text-dark">{{ $activeDispositions ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-share-nodes fa-2x text-muted opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-md-6 mb-4">
                <div class="card h-100 border-0 bg-info bg-opacity-10 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div>
                            <h6 class="fw-bold text-info mb-1"><i class="fa-solid fa-bell me-2"></i>Halo,
                                {{ Auth::user()->name }}!</h6>
                            <small class="text-dark">Anda memiliki <strong>{{ $activeDispositions ?? 0 }}</strong> instruksi
                                disposisi aktif dari pengurus. Silakan cek menu "Disposisi Saya" secara berkala untuk
                                menyelesaikan tugas organisasi Anda.</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-bottom-0">
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
                            <th>Ditambahkan Pada</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivities as $activity)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">{{ $activity->letter_number }}</td>

                                <td>
                                    @if ($activity->type == 'masuk')
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary border border-primary">Masuk</span>
                                    @else
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success">Keluar</span>
                                    @endif
                                </td>

                                <td>{{ Str::limit($activity->subject, 40) }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->date)->format('d M Y - H:i') }}</td>

                                <td>
                                    @if ($activity->status == 'pending' || $activity->status == 'draft')
                                        <span class="badge bg-warning text-dark">{{ ucfirst($activity->status) }}</span>
                                    @elseif($activity->status == 'dispositioned' || $activity->status == 'sent')
                                        <span class="badge bg-info text-dark">{{ ucfirst($activity->status) }}</span>
                                    @else
                                        <span class="badge bg-success">{{ ucfirst($activity->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                    Belum ada aktivitas surat di sistem saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if (in_array($role, ['superadmin', 'admin']))
            <div class="card-footer bg-light border-0 text-center py-3">
                <a href="{{ url('/incoming-letters') }}" class="btn btn-sm btn-outline-primary shadow-sm">Kelola Data
                    Surat</a>
            </div>
        @endif
    </div>
@endsection
