@extends('layouts.app')

@section('title', $menu->name . ' - Dapoer MJ')

@section('content')
    <style>
        .menu-detail {
            background-color: #F8F4E1;
            border-radius: 1rem;
            padding: 2rem;
        }

        .price-tag {
            color: #4E1F00;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .popular-badge {
            background-color: #FEBA17;
            color: #4E1F00;
            font-weight: 600;
            border-radius: 0.5rem;
            padding: 0.3rem 0.7rem;
        }

        .order-btn {
            background-color: #74512D;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: bold;
            border-radius: 0.5rem;
        }

        .order-btn:hover {
            background-color: #4E1F00;
        }
    </style>

    <div class="container mt-4">
        <div class="menu-detail shadow">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="{{ asset('image/' . $menu->photos->first()->photo) }}" class="img-fluid rounded shadow"
                        alt="{{ $menu->name }}">
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold">{{ $menu->name }}</h2>
                    <p class="text-muted mb-1">Tersedia mulai:
                        <strong>{{ \Carbon\Carbon::parse($menu->date)->format('d M Y') }}</strong></p>
                    <p class="price-tag">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>

                    @if ($menu->is_popular)
                        <span class="popular-badge">🔥 Populer</span>
                    @endif

                    <p class="mt-4">{!! $menu->about !!}</p>

                    <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100 text-white">Tambah ke Keranjang</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection