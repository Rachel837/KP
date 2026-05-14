<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div class="content py-10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mb-4">
                    <h1 class="fs-3 mb-1">Dashboard Super Admin</h1>
                    <p>Selamat datang di panel kontrol administratif.</p>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card p-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-2 h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-shape icon-md bg-primary text-white rounded-2 d-flex align-items-center justify-content-center">
                            <i class="ti ti-users fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-1 fs-6">Manajemen Pengguna</h2>
                            <p class="text-muted mb-0 small">Kelola seluruh data user dalam sistem.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
