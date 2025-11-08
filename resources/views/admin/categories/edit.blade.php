@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <style>
        .btn-mj {
            background-color: #FEBA17;
            border-color: #FEBA17;
            color: #000;
            font-weight: 600;
        }

        .btn-mj:hover {
            background-color: #e9a90f;
            border-color: #e9a90f;
            color: #000;
        }
    </style>

    <h2>Edit Kategori: {{ $category->name }}</h2>
    <p class="text-muted">Perbarui nama kategori.</p>
    <hr>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-mj">Update</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
