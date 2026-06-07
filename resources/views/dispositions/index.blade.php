@extends('layouts.app')

@section('title', 'Tugas & Disposisi Saya - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Tugas & Disposisi Saya</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($dispositions as $disposisi)
            <div class="col-md-6 mb-4">
                <div
                    class="card h-100 border-0 shadow-sm {{ $disposisi->status === 'completed' ? 'border-start border-4 border-success' : 'border-start border-4 border-warning' }}">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <span
                            class="badge {{ $disposisi->status === 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $disposisi->status === 'completed' ? 'Tugas Selesai' : 'Perlu Dikerjakan' }}
                        </span>
                        <small class="text-muted"><i class="fa-solid fa-clock me-1"></i>Tenggat:
                            {{ $disposisi->due_date ? \Carbon\Carbon::parse($disposisi->due_date)->format('d M Y') : 'Tidak ada' }}</small>
                    </div>
                    <div class="card-body bg-white p-4">
                        <h6 class="fw-bold text-primary mb-1">Surat:
                            {{ $disposisi->incomingletter->subject ?? 'Surat Dihapus' }}</h6>
                        <small class="text-muted d-block mb-3">No:
                            {{ $disposisi->incomingletter->letter_number ?? '-' }}</small>

                        <div class="p-3 bg-light rounded border border-secondary border-opacity-25 mb-4">
                            <small class="fw-bold d-block text-dark mb-1">Instruksi dari Admin:</small>
                            <p class="mb-0 text-dark">{{ $disposisi->instruction }}</p>
                        </div>

                        @if ($disposisi->status === 'completed')
                            <div class="p-3 bg-success bg-opacity-10 border border-success rounded">
                                <small class="fw-bold text-success d-block mb-1"><i
                                        class="fa-solid fa-check-double me-1"></i>Laporan / Feedback Anda:</small>
                                <p class="mb-0 text-dark">{{ $disposisi->feedback_note }}</p>
                            </div>
                        @else
                            @if ($disposisi->feedback_note)
                                <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded mb-3">
                                    <small class="fw-bold text-warning d-block mb-1"><i
                                            class="fa-solid fa-spinner fa-spin me-1"></i>Update Progress Terkini:</small>
                                    <p class="mb-0 text-dark">{{ $disposisi->feedback_note }}</p>
                                </div>
                            @endif

                            <button type="button" class="btn btn-primary w-100 fw-bold shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#feedbackModal-{{ $disposisi->id }}">
                                <i class="fa-solid fa-reply me-1"></i>
                                {{ $disposisi->feedback_note ? 'Update Lagi & Selesaikan Tugas' : 'Laporkan Hasil Tugas' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            @if ($disposisi->status !== 'completed')
                <div class="modal fade" id="feedbackModal-{{ $disposisi->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-primary text-white border-bottom-0">
                                <h5 class="modal-title fw-bold"><i class="fa-solid fa-reply me-2"></i>Laporkan Hasil Tugas
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('dispositions.feedback', $disposisi->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Status Pekerjaan</label>
                                        <select class="form-select" name="status" required>
                                            <option value="pending">Masih Dikerjakan (Update Catatan)</option>
                                            <option value="completed">Tugas Telah Selesai</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Catatan / Laporan Feedback <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" name="feedback_note" rows="4" required
                                            placeholder="Tuliskan hasil pekerjaan atau kendala Anda di sini...">{{ $disposisi->feedback_note }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light border-top-0">
                                    <button type="button" class="btn btn-secondary fw-bold px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary fw-bold px-4"><i
                                            class="fa-solid fa-paper-plane me-2"></i>Kirim Laporan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="fa-solid fa-mug-hot fa-3x text-muted opacity-25 mb-3"></i>
                        <h5 class="text-dark fw-bold">Belum Ada Tugas</h5>
                        <p class="text-muted">Anda tidak memiliki instruksi disposisi dari Admin saat ini.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @if (isset($dispositions) && $dispositions->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $dispositions->links('pagination::bootstrap-5') }}
        </div>
    @endif
@endsection
