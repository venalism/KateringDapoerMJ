<!DOCTYPE html>
<html>

<head>
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
</body>

</html>