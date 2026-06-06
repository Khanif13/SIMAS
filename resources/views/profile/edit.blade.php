@extends('layouts.app')

@section('title', 'Profil Saya - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Profil Saya</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mb-4">
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <i class="fa-solid fa-user-pen fa-lg me-2 text-primary"></i>
                    <h5 class="mb-0 fw-bold text-dark">Informasi Pribadi & Keamanan</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Peran / Jabatan Saat Ini</label>
                            <input type="text" class="form-control bg-light text-muted" value="{{ strtoupper($user->role) }}" disabled>
                            <div class="form-text"><i class="fa-solid fa-circle-info me-1"></i> Peran Anda hanya dapat diubah oleh Administrator Sistem (Superadmin).</div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-key me-2 text-warning"></i>Ubah Kata Sandi (Opsional)</h6>
                        <div class="alert alert-light border small mb-3">
                            Kosongkan seluruh kolom di bawah ini jika Anda tidak bermaksud mengubah kata sandi Anda.
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" placeholder="Ketik sandi lama Anda...">
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-dark">Kata Sandi Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Minimal 8 karakter...">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Konfirmasi Sandi Baru</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Ketik ulang sandi baru...">
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary shadow-sm fw-bold px-4" style="background-color: var(--primary-color); border: none;">
                                <i class="fa-solid fa-save me-2"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-danger shadow-sm">
                <div class="card-header bg-danger text-white py-3 border-bottom-0">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i>Zona Berbahaya (Danger Zone)</h6>
                </div>
                <div class="card-body p-4 bg-white">
                    <p class="text-dark mb-4">Menghapus akun akan menghilangkan seluruh hak akses Anda ke dalam sistem SIMAS secara permanen. Tindakan ini <strong>tidak dapat dibatalkan</strong>.</p>
                    <button type="button" class="btn btn-outline-danger fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fa-solid fa-user-xmark me-2"></i> Hapus Akun Saya
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white border-bottom-0">
                    <h5 class="modal-title fw-bold" id="deleteAccountModalLabel"><i class="fa-solid fa-shield-halved me-2"></i>Verifikasi Penghapusan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-4">
                        <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-start border-4 mb-4">
                            Apakah Anda yakin ingin berpisah dengan kami? Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa ini benar-benar Anda.
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold text-dark">Kata Sandi Anda <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required placeholder="Ketik kata sandi Anda di sini...">
                            @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-secondary fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger fw-bold px-4"><i class="fa-solid fa-trash me-2"></i>Ya, Hapus Permanen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection