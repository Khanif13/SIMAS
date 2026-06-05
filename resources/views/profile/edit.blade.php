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

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
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
                                <label class="form-label fw-bold text-dark">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Alamat Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Peran / Jabatan Saat Ini</label>
                            <input type="text" class="form-control bg-light text-muted"
                                value="{{ strtoupper($user->role) }}" disabled>
                            <div class="form-text"><i class="fa-solid fa-circle-info me-1"></i> Peran Anda hanya dapat
                                diubah oleh Administrator Sistem (Superadmin).</div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-key me-2 text-warning"></i>Ubah Kata Sandi
                            (Opsional)</h6>
                        <div class="alert alert-light border small mb-3">
                            Kosongkan seluruh kolom di bawah ini jika Anda tidak bermaksud mengubah kata sandi Anda.
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                name="current_password" placeholder="Ketik sandi lama Anda...">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-dark">Kata Sandi Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Minimal 8 karakter...">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Konfirmasi Sandi Baru</label>
                                <!-- Field ini wajib bernama "password_confirmation" agar validasi 'confirmed' Laravel jalan otomatis -->
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="Ketik ulang sandi baru...">
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary shadow-sm fw-bold px-4"
                                style="background-color: var(--primary-color); border: none;">
                                <i class="fa-solid fa-save me-2"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
