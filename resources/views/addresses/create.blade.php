@extends('layouts.app')
@section('title', 'Tambah Alamat - Dapoer MJ')
@section('content')
<div class="container mt-5">
    <h2>Tambah Alamat Baru</h2>
    <form action="{{ route('addresses.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="no_wa" class="form-label">Nomor WhatsApp</label>
            <input type="text" name="no_wa" id="no_wa" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('checkout.form') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
