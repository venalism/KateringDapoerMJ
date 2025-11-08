@extends('layouts.admin')

@section('title', 'Dashboard Admin - Dapoer MJ')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h3 class="mb-4" style="color: #4E1F00;">Dashboard Admin</h3>
            <p>Halo <strong>{{ Auth::user()->name }}</strong>, selamat datang di panel admin <strong>Dapoer MJ</strong> 👋</p>
            <hr>

            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('menu.index') }}" class="text-decoration-none text-dark">
                        <div class="p-4 border rounded bg-light shadow-sm">
                            <i class="bi bi-journal-text fs-2"></i>
                            <p class="mt-2 mb-0">Kelola Menu</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('categories.index') }}" class="text-decoration-none text-dark">
                        <div class="p-4 border rounded bg-light shadow-sm">
                            <i class="bi bi-tags fs-2"></i>
                            <p class="mt-2 mb-0">Kategori Menu</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('users.index') }}" class="text-decoration-none text-dark">
                        <div class="p-4 border rounded bg-light shadow-sm">
                            <i class="bi bi-people fs-2"></i>
                            <p class="mt-2 mb-0">Manajemen Pengguna</p>
                        </div>
                    </a>
                </div>
            </div>

            <hr>
            <div class="text-center">
                <a href="{{ url('/') }}" class="btn btn-sm text-white" style="background-color:#4E1F00;">
                    <i class="bi bi-arrow-left-circle"></i> Kembali ke Website
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
