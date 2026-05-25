@extends('layouts.app')

@section('title', 'Daftar Surat Masuk - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Daftar Surat Masuk</h1>
        <a href="{{ route('incoming-letters.create') }}" class="btn btn-primary-custom shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Tambah Surat Masuk
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('incoming-letters.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                            placeholder="Cari nomor surat, pengirim, perihal..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending / Belum
                            Diproses</option>
                        <option value="dispositioned" {{ request('status') == 'dispositioned' ? 'selected' : '' }}>Telah
                            Didisposisikan</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Selesai /
                            Diarsipkan</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-secondary text-white shadow-sm">Filter</button>
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
                            <th>Tanggal Terima</th>
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($letters as $letter)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">{{ $letter->letter_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($letter->receipt_date)->format('d M Y') }}</td>
                                <td>{{ $letter->sender }}</td>
                                <td>{{ $letter->subject }}</td>
                                <td>
                                    @if ($letter->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($letter->status == 'dispositioned')
                                        <span class="badge bg-info">Disposisi</span>
                                    @else
                                        <span class="badge bg-success">Diarsipkan</span>
                                    @endif
                                </td>
                                {{-- <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('incoming-letters.show', $letter->id) }}"
                                            class="btn btn-sm btn-light border" title="Lihat Detail">
                                            <i class="fa-solid fa-eye text-secondary"></i>
                                        </a>
                                        <a href="{{ route('incoming-letters.edit', $letter->id) }}"
                                            class="btn btn-sm btn-light border" title="Edit Data">
                                            <i class="fa-solid fa-pen text-primary"></i>
                                        </a>

                                        <form action="{{ route('incoming-letters.destroy', $letter->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat masuk ini beserta berkasnya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border" title="Hapus Data">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td> --}}
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('incoming-letters.show', $letter->id) }}"
                                            class="btn btn-sm btn-light border" title="Lihat Detail">
                                            <i class="fa-solid fa-eye text-secondary"></i>
                                        </a>
                                        <a href="{{ route('incoming-letters.edit', $letter->id) }}"
                                            class="btn btn-sm btn-light border" title="Edit Data">
                                            <i class="fa-solid fa-pen text-primary"></i>
                                        </a>
                                        @if ($letter->file_path)
                                            <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-light border" title="Unduh / Lihat File">
                                                <i class="fa-solid fa-file-pdf text-danger"></i>
                                            </a>
                                        @endif

                                        <form action="{{ route('incoming-letters.destroy', $letter->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat keluar ini beserta berkasnya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border" title="Hapus Data">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                    Belum ada data surat masuk yang tersimpan di sistem.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center border-top">
            <small class="text-muted ps-2">
                Menampilkan {{ $letters->firstItem() ?? 0 }} hingga {{ $letters->lastItem() ?? 0 }} dari
                {{ $letters->total() ?? 0 }} entri
            </small>
            <div class="pe-2">
                {{ $letters->appends(request()->input())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
