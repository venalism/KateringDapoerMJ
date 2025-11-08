@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-5" style="max-width: 420px; width: 100%; border-radius: 16px; background-color: white;">
        <h3 class="text-center mb-4 fw-bold" style="color: #4E1F00;">Daftar Akun Dapoer MJ</h3>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold" style="color: #4E1F00;">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="form-control border border-2" style="border-color:#FEBA17;">
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold" style="color: #4E1F00;">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="form-control border border-2" style="border-color:#FEBA17;">
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold" style="color: #4E1F00;">Password</label>
                <input id="password" type="password" name="password" required
                       class="form-control border border-2" style="border-color:#FEBA17;">
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold" style="color: #4E1F00;">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="form-control border border-2" style="border-color:#FEBA17;">
                @error('password_confirmation')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol daftar --}}
            <button type="submit" class="btn w-100 text-white fw-semibold py-2"
                    style="background-color:#4E1F00; border-radius:8px;">
                Daftar
            </button>
        </form>

        <div class="text-center my-3 text-muted">atau</div>

        {{-- Tombol Google --}}
        <a href="{{ route('google.login') }}" 
           class="btn w-100 d-flex align-items-center justify-content-center gap-2 border py-2"
           style="border-color:#ccc; background-color:white; border-radius:8px;">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" alt="Google">
            <span class="fw-semibold" style="color:#4E1F00;">Daftar dengan Google</span>
        </a>

        <p class="mt-4 text-center mb-0" style="color:#4E1F00;">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="fw-bold" style="color:#FEBA17;">Login di sini</a>
        </p>
    </div>
</div>
@endsection
