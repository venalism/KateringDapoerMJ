@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')
    {{-- CARD UNTUK EDIT DATA UTAMA --}}
    <div class="card mb-4">
        <div class="card-header">
            <h4>Edit Data Utama Menu: {{ $menu->name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- Baris Pertama: Nama, Harga, Stok --}}
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Nama Menu</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $menu->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                            name="price" value="{{ old('price', $menu->price) }}" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
                            name="stock" value="{{ old('stock', $menu->stock) }}" required>
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Baris Kedua: Kategori --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori Menu</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                        name="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Baris Ketiga: Tentang Menu --}}
                <div class="mb-3">
                    <label for="about" class="form-label">Tentang Menu</label>
                    <textarea class="form-control @error('about') is-invalid @enderror" id="about" name="about" rows="4"
                        required>{{ old('about', $menu->about) }}</textarea>
                    @error('about') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Baris Keempat: Upload Gambar Utama --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Ganti Gambar Utama (Opsional)</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if ($menu->image)
                        <img src="{{ Storage::url($menu->image) }}" alt="Current Image" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>

                {{-- Baris Kelima: Checkbox Populer --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" value="1" {{ old('is_popular', $menu->is_popular) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_popular">Tandai sebagai Menu Populer</label>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Data Utama</button>
                    <a href="{{ route('menu.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>


    {{-- CARD UNTUK KELOLA GALERI FOTO --}}
    <div class="card">
        <div class="card-header">
            <h4>Kelola Galeri Foto Tambahan</h4>
        </div>
        <div class="card-body">
            {{-- Tampilkan Foto yang Sudah Ada --}}
            <div class="row">
                @forelse ($menu->photos as $photo)
                    <div class="col-md-3 mb-3">
                        <div class="card position-relative">
                            <img src="{{ Storage::url($photo->photo_path) }}" class="card-img-top" alt="Menu Photo">
                            <form action="{{ route('menu-photos.destroy', $photo->id) }}" method="POST"
                                class="position-absolute top-0 end-0 p-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-circle"
                                    onclick="return confirm('Yakin ingin hapus foto ini?')"><i class="fa fa-times"></i></button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada foto tambahan di galeri.</p>
                @endforelse
            </div>

            <hr>

            {{-- Form untuk Upload Foto Baru --}}
            <form action="{{ route('menu-photos.store', $menu->id) }}" method="POST" enctype="multipart/form-data"
                class="mt-4">
                @csrf
                <div class="mb-3">
                    <label for="photos" class="form-label">Upload Foto Baru ke Galeri (bisa pilih lebih dari satu)</label>
                    <input class="form-control @error('photos.*') is-invalid @enderror" type="file" id="photos"
                        name="photos[]" multiple>
                    @error('photos.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-success">Upload ke Galeri</button>
            </form>
        </div>
    </div>

@endsection