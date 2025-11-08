@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Detail Pesanan #{{ $order->id }}</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            <p><strong>Status:</strong>
                <span class="badge 
                    @if($order->status == 'pending') bg-warning
                    @elseif($order->status == 'paid') bg-info
                    @elseif($order->status == 'processing') bg-primary
                    @elseif($order->status == 'completed') bg-success
                    @elseif($order->status == 'cancelled') bg-danger
                    @endif
                ">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
            <p><strong>Alamat:</strong> {{ $order->address->alamat ?? '-' }}</p>
        </div>
    </div>

    <h4 class="mb-3">Item Pesanan</h4>
    <table class="table table-bordered">
        <thead class="table-warning">
            <tr>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
            <tr>
                <td>{{ $item->menu->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(Auth::user()->isAdmin())
    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="mt-4">
        @csrf
        <label for="status" class="form-label">Ubah Status Pesanan:</label>
        <select name="status" id="status" class="form-select w-50">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Dibayar</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="btn btn-primary mt-3">Update Status</button>
    </form>
    @endif

    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-4">← Kembali ke Daftar</a>
</div>
@endsection
