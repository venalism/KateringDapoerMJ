@extends('layouts.profile')

@section('content')
<h3 class="mb-4">Edit Alamat</h3>

<form action="{{ route('profile.address.update') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">No WhatsApp</label>
        <input type="text" name="no_wa" class="form-control" value="{{ $address->no_wa ?? '' }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Alamat Lengkap</label>
        <textarea name="alamat" class="form-control" required>{{ $address->alamat ?? '' }}</textarea>
    </div>

    <button class="btn btn-primary px-4">Simpan Alamat</button>
    <a href="{{ route('profile.index') }}" class="btn btn-secondary px-4">Batal</a>
</form>
@endsection
