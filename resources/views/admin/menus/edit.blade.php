@extends('layouts.admin')

@section('title', 'Kelola Menu')

@section('content')
    <div class="container mt-5">
        <h2>Edit Menu: {{ $menu->name }}</h2>
        <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $menu->name }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    required>{{ $menu->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $menu->price }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Menu (Kosongkan jika tidak ingin diubah)</label>
                <input type="file" class="form-control" id="image" name="image">
                @if ($menu->image)
                    <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="mt-2" width="150">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('menu.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    {{-- ... di dalam file edit.blade.php setelah form utama ... --}}
    <hr class="my-5">

    {{-- Bagian untuk Mengelola Foto Tambahan --}}
    <h4>Kelola Foto Tambahan</h4>

    {{-- Tampilkan Foto yang Sudah Ada --}}
    <div class="row">
        @forelse ($menu->photos as $photo)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="{{ Storage::url($photo->photo_path) }}" class="card-img-top" alt="Menu Photo">
                    <div class="card-body text-center">
                        <form action="{{ route('menu-photos.destroy', $photo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin hapus foto ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>Belum ada foto tambahan.</p>
        @endforelse
    </div>

    {{-- Form untuk Upload Foto Baru --}}
    <form action="{{ route('menu-photos.store', $menu->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="photos" class="form-label">Upload Foto Baru (bisa pilih lebih dari satu)</label>
            <input class="form-control" type="file" id="photos" name="photos[]" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Upload Foto</button>
    </form>
@endsection