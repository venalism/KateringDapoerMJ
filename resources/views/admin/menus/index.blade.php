@extends('layouts.admin')

@section('title', 'Kelola Menu')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Menu</h2>
        <a href="{{ route('menu.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>Tambah Menu Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col" style="width: 15%;">Gambar Utama</th>
                        <th scope="col">Nama Menu</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $key => $menu)
                        <tr>
                            <th scope="row">{{ $menus->firstItem() + $key }}</th>
                            <td>
                                {{-- Ambil foto pertama dari relasi 'photos' --}}
                                @if ($menu->photos->first())
                                    <img src="{{ Storage::url($menu->photos->first()->photo) }}" alt="{{ $menu->name }}"
                                        class="img-fluid rounded" style="max-height: 75px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->category->name ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td>{{ $menu->stock }}</td>
                            <td>
                                @if ($menu->is_popular)
                                    <span class="badge bg-success">Populer</span>
                                @else
                                    <span class="badge bg-secondary">Biasa</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus menu ini? Semua foto terkait akan dihapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data menu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $menus->links() }}
        </div>
    </div>
@endsection