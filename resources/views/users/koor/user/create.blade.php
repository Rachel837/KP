<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="mb-4">
                    <h1 class="fs-3 mb-1">Tambah Pengguna</h1>
                    <p>Silakan isi formulir di bawah ini untuk menambahkan pengguna baru.</p>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('koor.users.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="role_idrole" class="form-label">Role</label>
                                <select class="form-select @error('role_idrole') is-invalid @enderror" id="role_idrole" name="role_idrole" required>
                                    <option value="" selected disabled>Pilih Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->idrole }}" {{ old('role_idrole') == $role->idrole ? 'selected' : '' }}>{{ $role->nama }}</option>
                                    @endforeach
                                </select>
                                @error('role_idrole')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('koor.users.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
