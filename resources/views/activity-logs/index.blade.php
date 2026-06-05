@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark">Log Aktivitas Sistem</h1>
            <p class="text-muted mb-0">Riwayat rekaman seluruh aktivitas pengguna di dalam aplikasi.</p>
        </div>
        <button class="btn btn-outline-secondary shadow-sm" disabled>
            <i class="fa-solid fa-shield-halved me-1 text-success"></i> Secured
        </button>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Waktu</th>
                            <th>Pengguna</th>
                            <th>Aksi</th>
                            <th>Keterangan Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td class="ps-4 text-muted" style="white-space: nowrap;">
                                    <strong>{{ $log->created_at->format('d M Y') }}</strong><br>
                                    <small>{{ $log->created_at->format('H:i:s') }} WITA</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $log->user->name ?? 'Sistem / Dihapus' }}</span><br>
                                    <span class="badge bg-secondary"
                                        style="font-size: 0.65rem;">{{ strtoupper($log->user->role ?? 'UNKNOWN') }}</span>
                                </td>
                                <td>
                                    @php
                                        // Mewarnai badge berdasarkan aksi
                                        $badgeColor = 'bg-primary';
                                        if (Str::contains(strtolower($log->action), ['hapus', 'delete'])) {
                                            $badgeColor = 'bg-danger';
                                        }
                                        if (Str::contains(strtolower($log->action), ['tambah', 'create', 'baru'])) {
                                            $badgeColor = 'bg-success';
                                        }
                                        if (Str::contains(strtolower($log->action), ['edit', 'update', 'ubah'])) {
                                            $badgeColor = 'bg-warning text-dark';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeColor }}">{{ $log->action }}</span>
                                </td>
                                <td class="text-dark">{{ $log->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-server fa-3x mb-3 opacity-25"></i>
                                    <h5>Sistem Belum Mencatat Aktivitas</h5>
                                    <p>Segala aktivitas perubahan data nantinya akan terekam secara otomatis di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($logs->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
