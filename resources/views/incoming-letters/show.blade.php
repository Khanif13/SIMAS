@extends('layouts.app')

@section('title', 'Detail Surat Masuk - SIMAS')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Detail Surat Masuk</h1>
        <div>
            <a href="{{ route('incoming-letters.index') }}" class="btn btn-outline-secondary shadow-sm me-2">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>

            <a href="{{ route('incoming-letters.edit', $letter->id) }}"
                class="btn btn-warning shadow-sm me-2 text-dark fw-bold"
                style="background-color: var(--primary-color); border: none;">
                <i class="fa-solid fa-pen me-1"></i> Edit
            </a>
            <form action="{{ route('incoming-letters.destroy', $letter->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini? Seluruh data dan berkas akan hilang.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger shadow-sm">
                    <i class="fa-solid fa-trash me-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-5 mb-4">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <i class="fa-solid fa-inbox fa-lg me-2 text-primary"></i>
                    <h5 class="mb-0 fw-bold text-dark">Informasi Surat Masuk</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="mb-3">
                        <small class="text-muted fw-bold text-uppercase">Nomor Surat (Sistem)</small>
                        <p class="fs-5 fw-bold text-dark mb-0">{{ $letter->letter_number }}</p>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="mb-3">
                        <small class="text-muted fw-bold text-uppercase">Pengirim</small>
                        <p class="fs-6 text-dark mb-0 fw-medium">{{ $letter->sender }}</p>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted fw-bold text-uppercase">Tgl. Surat</small>
                            <p class="text-dark mb-0"><i class="fa-regular fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($letter->letter_date)->format('d M Y') }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted fw-bold text-uppercase">Tgl. Terima</small>
                            <p class="text-dark mb-0"><i class="fa-solid fa-calendar-check me-1"></i>
                                {{ \Carbon\Carbon::parse($letter->receipt_date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="mb-3">
                        <small class="text-muted fw-bold text-uppercase">Perihal</small>
                        <p class="text-dark mb-0 fw-medium">{{ $letter->subject }}</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted fw-bold text-uppercase">Status</small>
                        <div class="mt-1">
                            @if ($letter->status == 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2">Pending / Belum Diproses</span>
                            @elseif($letter->status == 'dispositioned')
                                <span class="badge bg-info px-3 py-2">Telah Didisposisikan</span>
                            @else
                                <span class="badge bg-success px-3 py-2">Selesai / Diarsipkan</span>
                            @endif
                        </div>
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="mb-4">
                        <small class="text-muted fw-bold text-uppercase">Catatan Tambahan</small>
                        <div class="p-3 bg-light rounded mt-2 border">
                            {{ $letter->description ?: 'Tidak ada catatan tambahan saat input.' }}
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success shadow-sm fw-bold py-2" data-bs-toggle="modal"
                            data-bs-target="#disposisiModal">
                            <i class="fa-solid fa-share-nodes me-2"></i> Buat Disposisi Surat
                        </button>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 border-start border-4 border-info">
                <div class="card-header bg-white py-3 border-bottom-0 d-flex align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-clock-rotate-left me-2 text-info"></i>Riwayat
                        Disposisi</h6>
                </div>
                <div class="card-body p-0">
                    @if ($letter->dispositions && $letter->dispositions->count() > 0)
                        <ul class="list-group list-group-flush rounded-bottom">
                            @foreach ($letter->dispositions as $disp)
                                <li class="list-group-item p-3">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-bold text-primary">Ke:
                                            {{ $disp->assignedUser->name ?? 'Pengguna Dihapus' }}</h6>
                                        <small class="text-muted"
                                            style="font-size: 0.75rem;">{{ $disp->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                    <p class="mb-1 text-dark small">{{ $disp->instruction }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted" style="font-size: 0.75rem;"><i
                                                class="fa-solid fa-user-pen me-1"></i>Oleh:
                                            {{ $disp->user->name ?? 'Admin' }}</small>
                                        @if ($disp->due_date)
                                            <span
                                                class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill"
                                                style="font-size: 0.7rem;">
                                                <i class="fa-solid fa-calendar-xmark me-1"></i>Tenggat:
                                                {{ \Carbon\Carbon::parse($disp->due_date)->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center p-4 text-muted">
                            <i class="fa-solid fa-clipboard-check fa-2x mb-2 opacity-25"></i>
                            <p class="mb-0 small">Belum ada instruksi disposisi untuk surat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-file-pdf fa-lg me-2 text-danger"></i>
                        <h5 class="mb-0 fw-bold text-dark">Dokumen Lampiran</h5>
                    </div>
                    @if ($letter->file_path)
                        <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-up-right-from-square me-1"></i> Buka Layar Penuh
                        </a>
                    @endif
                </div>
                <div class="card-body p-0 bg-light d-flex align-items-center justify-content-center"
                    style="min-height: 600px;">
                    @if ($letter->file_path)
                        @php
                            $extension = pathinfo($letter->file_path, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/' . $letter->file_path) }}" alt="Lampiran Surat Masuk"
                                class="img-fluid p-3">
                        @else
                            <iframe src="{{ asset('storage/' . $letter->file_path) }}" width="100%" height="100%"
                                style="min-height: 600px; border: none;"></iframe>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fa-solid fa-file-circle-xmark fa-4x mb-3 opacity-50"></i>
                            <h5>File Tidak Ditemukan</h5>
                            <p>Dokumen fisik belum dipindai atau file hilang dari server.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="disposisiModal" tabindex="-1" aria-labelledby="disposisiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white border-bottom-0">
                    <h5 class="modal-title fw-bold" id="disposisiModalLabel"><i
                            class="fa-solid fa-share-nodes me-2"></i>Buat Disposisi Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('dispositions.store', $letter->id) }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="alert alert-info bg-info bg-opacity-10 border-info border-start border-4 small mb-4">
                            Silakan isi formulir di bawah ini untuk meneruskan tugas/instruksi dari surat
                            <strong>{{ $letter->letter_number }}</strong>.
                        </div>

                        <div class="mb-3">
                            <label for="assigned_user_id" class="form-label fw-bold text-dark">Diteruskan Kepada (PIC)
                                <span class="text-danger">*</span></label>
                            <select class="form-select select2-search" id="assigned_user_id" name="assigned_user_id"
                                required>
                                <option value="" disabled selected>-- Cari dan Pilih Anggota --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}
                                        ({{ strtoupper($user->role) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label fw-bold text-dark">Tenggat Waktu <span
                                    class="text-muted fw-normal">(Opsional)</span></label>
                            <input type="date" class="form-control" id="due_date" name="due_date">
                        </div>

                        <div class="mb-3">
                            <label for="instruction" class="form-label fw-bold text-dark">Instruksi / Catatan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="instruction" name="instruction" rows="3"
                                placeholder="Tuliskan instruksi yang harus dikerjakan..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-secondary fw-bold px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold px-4"><i
                                class="fa-solid fa-paper-plane me-2"></i>Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
            <i class="fa-solid fa-list-check fa-lg me-2 text-primary"></i>
            <h5 class="mb-0 fw-bold text-dark">Tracking Disposisi & Laporan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Penerima Tugas</th>
                            <th style="width: 35%;">Instruksi (Dari Admin)</th>
                            <th style="width: 40%;">Status & Laporan (Feedback Member)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($letter->dispositions as $disp)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">
                                                {{ $disp->assignedUser->name ?? 'Anggota Dihapus' }}</h6>
                                            <small class="text-muted">Tenggat:
                                                {{ $disp->due_date ? \Carbon\Carbon::parse($disp->due_date)->format('d M Y') : '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-dark small">{{ $disp->instruction }}</p>
                                </td>
                                <td>
                                    @if ($disp->status === 'completed')
                                        <span class="badge bg-success mb-2"><i
                                                class="fa-solid fa-check-double me-1"></i>Selesai</span>
                                        <div
                                            class="p-2 bg-light border-start border-4 border-success rounded small text-dark">
                                            <strong>Catatan:</strong> {{ $disp->feedback_note ?? 'Tidak ada catatan.' }}
                                        </div>
                                    @elseif ($disp->feedback_note)
                                        <span class="badge bg-warning text-dark mb-2"><i
                                                class="fa-solid fa-spinner fa-spin me-1"></i>Proses (Ada Update)</span>
                                        <div
                                            class="p-2 bg-light border-start border-4 border-warning rounded small text-dark">
                                            <strong>Update Terkini:</strong> {{ $disp->feedback_note }}
                                        </div>
                                    @else
                                        <span class="badge bg-secondary"><i class="fa-solid fa-clock me-1"></i>Menunggu
                                            Dikerjakan</span>
                                        <p class="mb-0 text-muted small mt-1">Belum ada laporan dari anggota.</p>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-share-nodes fa-2x mb-2 d-block opacity-25"></i>
                                    Belum ada instruksi disposisi yang dibuat untuk surat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-search').select2({
                dropdownParent: $('#disposisiModal'),
                width: '100%',
                placeholder: "-- Cari dan Pilih Anggota --"
            });
        });
    </script>
@endpush
