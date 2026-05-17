@extends('layouts.app')

@section('title', 'Surat Masuk - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2" style="color: var(--secondary-color);">Daftar Surat Masuk</h1>

        <!-- Role-based UI: Only Admin and Sekretaris can add letters -->
        @if (in_array(auth()->user()->role, ['admin', 'sekretaris']))
            <a href="{{ route('incoming-letters.create') }}" class="btn btn-primary-custom">
                + Tambah Surat
            </a>
        @endif
    </div>

    <!-- Search Bar -->
    <form action="{{ route('incoming-letters.index') }}" method="GET" class="mb-4">
        <div class="input-group w-50">
            <input type="text" name="search" class="form-control"
                placeholder="Cari nomor surat, pengirim, atau perihal..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark" style="background-color: var(--secondary-color);">
                <tr>
                    <th>No Surat</th>
                    <th>Tgl Terima</th>
                    <th>Pengirim</th>
                    <th>Perihal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($letters as $letter)
                    <tr>
                        <td>{{ $letter->letter_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($letter->receipt_date)->format('d M Y') }}</td>
                        <td>{{ $letter->sender }}</td>
                        <td>{{ $letter->subject }}</td>
                        <td>
                            <!-- Status Tracking Badges -->
                            @if ($letter->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($letter->status == 'dispositioned')
                                <span class="badge bg-info">Disposisi</span>
                            @else
                                <span class="badge bg-success">Diarsipkan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">Lihat File</a>

                            @if (in_array(auth()->user()->role, ['admin', 'sekretaris']))
                                <!-- Disposisi Button triggers a modal or separate page (Phase 4) -->
                                <a href="#" class="btn btn-sm btn-outline-success">Disposisi</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data surat masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $letters->links() }}
    </div>
@endsection
