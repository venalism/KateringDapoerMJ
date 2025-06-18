@extends('layouts.app')

@section('title', 'Keranjang Belanja - Dapoer MJ')

@section('content')

<br>
<br>
<div class="container" id="cart">
    <h2 class="fw-bold mb-4">Keranjang Belanja</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $details)
                    @php $subtotal = $details['price'] * $details['quantity']; @endphp
                    <tr>
                        <td>
                            {{ $details['name'] }}
                        </td>
                        <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
<td>
    <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center justify-content-between w-50">
        @csrf
        @method('PATCH')
        
        <!-- Tombol Decrease -->
        <button type="submit" name="action" value="decrease" class="btn">-</button>
        
        <!-- Quantity di kiri tanpa input box -->
        <span class="mx-3 h5">{{ $details['quantity'] }}</span>

        <!-- Tombol Increase -->
        <button type="submit" name="action" value="increase" class="btn">+</button>
    </form>
</td>



                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @php $total += $subtotal; @endphp
                @endforeach
            </tbody>
        </table>

        <div class="text-end fw-bold">
            Total: Rp {{ number_format($total, 0, ',', '.') }}
        </div>

@php
    $whatsappMessage = "Halo, saya mau pesan menu:\n";
    foreach(session('cart') as $details) {
        $subtotal = $details['price'] * $details['quantity'];
        $whatsappMessage .= "- {$details['name']} x {$details['quantity']} = Rp " . number_format($subtotal, 0, ',', '.') . "\n";
    }
    $whatsappMessage .= "\nTotal: Rp " . number_format($total, 0, ',', '.');
    $encodedMessage = urlencode($whatsappMessage);
@endphp

<div class="mt-3 text-end">
    <a href="https://wa.me/6289662315611?text={{ $encodedMessage }}" target="_blank"
       class="btn btn-success">Pesan via WhatsApp</a>
</div>


    @else
        <div class="alert alert-info">Keranjang belanja kosong.</div>
    @endif
</div>
@endsection
