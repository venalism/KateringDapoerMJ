@extends('layouts.app')

@section('title', 'Keranjang Belanja - Dapoer MJ')

@section('content')
<br><br>

<div class="container" id="cart">
    <h2 class="fw-bold mb-4">Keranjang Belanja</h2>

    @php
        $isLoggedIn = Auth::check();
        $cartItems = $isLoggedIn ? $carts : session('cart', []);
    @endphp

    @if(($isLoggedIn && $carts->count() > 0) || (!$isLoggedIn && count($cartItems) > 0))
        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
            @csrf
            <table class="table table-bordered align-middle">
                <thead class="table-warning text-center">
                    <tr>
                        <th>Pilih</th>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        @php
                            $menu = $isLoggedIn ? $item->menu : null;
                            $price = $isLoggedIn ? $menu->price : $item['price'];
                            $name = $isLoggedIn ? $menu->name : $item['name'];
                            $qty = $isLoggedIn ? $item->quantity : $item['quantity'];
                            $subtotal = $price * $qty;
                            $id = $isLoggedIn ? $menu->id : $loop->index;
                        @endphp
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="selected_items[]" value="{{ $id }}" class="item-checkbox"
                                    data-subtotal="{{ $subtotal }}">
                            </td>
                            <td>{{ $name }}</td>
                            <td>Rp {{ number_format($price, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $qty }}</td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3">
                <h5>Total yang dipilih: <span id="selectedTotal">Rp 0</span></h5>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success px-4 py-2" id="checkoutBtn" disabled>
                    Checkout
                </button>
            </div>
        </form>
    @else
        <div class="alert alert-info">Keranjang belanja kosong.</div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalEl = document.getElementById('selectedTotal');
    const checkoutBtn = document.getElementById('checkoutBtn');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });

    function updateTotal() {
        let total = 0;
        let checkedCount = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseFloat(cb.dataset.subtotal);
                checkedCount++;
            }
        });

        totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        checkoutBtn.disabled = checkedCount === 0;
    }
});
</script>
@endsection
