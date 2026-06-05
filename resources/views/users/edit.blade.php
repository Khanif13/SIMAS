@extends('layouts.app')

@section('title', 'Edit Pengguna - SIMAS')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h3 fw-bold text-dark">Edit Data Pengguna</h1>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <i class="fa-solid fa-user-shield fa-lg me-2 text-warning"></i>
                    <h5 class="mb-0 fw-bold text-dark">Pengaturan Hak Akses & Sandi</h5>
                </div>
                <div class="card-body p-4 bg-white">

                    <!-- Area Info Pengguna (Hanya Tampilan / Read-Only) -->
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded border">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="fa-solid fa-user fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">{{ $user->name }}</h5>
                            <p class="mb-0 text-muted">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Area Form Update (Hanya Role & Password) -->
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Peran (Role) <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                                <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member
                                </option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="superadmin"
                                    {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted"><i class="fa-solid fa-circle-info me-1"></i> Perubahan peran
                                akan langsung berdampak pada hak akses sistem pengguna ini.</div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <div
                            class="alert alert-warning bg-warning bg-opacity-10 border-warning border-start border-4 small mb-3">
                            <i class="fa-solid fa-lock me-2"></i><strong>Reset Password:</strong> Kosongkan kolom di bawah
                            ini jika Anda tidak ingin mengubah kata sandi pengguna.
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Kata Sandi Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Ketik sandi baru (minimal 8 karakter)...">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning shadow-sm fw-bold py-2 text-dark"
                                style="background-color: var(--primary-color); border: none;">
                                <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
