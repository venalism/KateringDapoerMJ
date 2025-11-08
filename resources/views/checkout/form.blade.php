@extends('layouts.app')
@section('title', 'Checkout - Dapoer MJ')

@section('content')
<div class="container mt-5">
    <h2>Checkout</h2>

    <form action="{{ route('orders.index') }}" method="POST">
        @csrf

        {{-- Pilih alamat pengiriman --}}
        <div class="mb-3">
            <label for="address_id" class="form-label">Pilih Alamat Pengiriman</label>
            <select name="address_id" id="address_id" class="form-select" required>
                <option value="">-- Pilih Alamat --</option>
                @foreach ($addresses as $address)
                    <option value="{{ $address->id }}">
                        {{ Auth::user()->name }} - {{ $address->no_wa }} | {{ $address->alamat }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Ringkasan Pesanan --}}
        @if(session('selected_items'))
            @php
                $user = Auth::user();
                $selectedIds = session('selected_items', []);
                $carts = \App\Models\Cart::where('user_id', $user->id)
                    ->whereIn('menu_id', $selectedIds)
                    ->get();
                $total = 0;
            @endphp

            <h4 class="mt-4">Ringkasan Pesanan</h4>
            <table class="table table-bordered align-middle mt-2">
                <thead class="table-warning">
                    <tr class="text-center">
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carts as $cart)
                        @php
                            $subtotal = $cart->menu->price * $cart->quantity;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $cart->menu->name }}</td>
                            <td>Rp {{ number_format($cart->menu->price, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $cart->quantity }}</td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end fw-bold fs-5 mt-3">
                Total: Rp {{ number_format($total, 0, ',', '.') }}
            </div>
        @endif

        {{-- Pilih Metode Pembayaran --}}
        <div class="mb-3 mt-4">
            <label for="payment_method" class="form-label">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method" class="form-select" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                <option value="COD">COD (Bayar di Tempat)</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="E-Wallet">E-Wallet (Dana, OVO, Gopay)</option>
            </select>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('addresses.create') }}" class="btn btn-secondary">Tambah Alamat Baru</a>
            <button type="submit" class="btn btn-success px-4 py-2">Konfirmasi Pesanan</button>
        </div>
    </form>
</div>
@endsection
