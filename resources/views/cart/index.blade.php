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
    <tr data-id="{{ $id }}">
        <td class="text-center">
            <input type="checkbox" name="selected_items[]" value="{{ $id }}" class="item-checkbox"
                data-subtotal="{{ $subtotal }}">
        </td>
        <td>{{ $name }}</td>
        <td class="price" data-price="{{ $price }}">Rp {{ number_format($price, 0, ',', '.') }}</td>

        <td class="text-center">
            <div class="d-flex justify-content-center align-items-center">
                <button type="button" class="btn btn-sm btn-outline-dark minus">-</button>

                <input type="text" name="quantities[{{ $id }}]" class="form-control text-center mx-1 quantity-input"
                    style="width: 50px;" value="{{ $qty }}" readonly>

                <button type="button" class="btn btn-sm btn-outline-dark plus">+</button>
            </div>
        </td>

        <td class="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>

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

    function updateTotal() {
        let total = 0;
        let checkedCount = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                let row = cb.closest('tr');
                let subtotal = parseFloat(row.querySelector('.subtotal').dataset.value);
                total += subtotal;
                checkedCount++;
            }
        });

        totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        checkoutBtn.disabled = checkedCount === 0;
    }

    document.querySelectorAll('.plus').forEach(btn => {
        btn.addEventListener('click', function () {
            let row = this.closest('tr');
            let qtyInput = row.querySelector('.quantity-input');
            let price = parseFloat(row.querySelector('.price').dataset.price);
            let newQty = parseInt(qtyInput.value) + 1;

            qtyInput.value = newQty;

            let newSubtotal = price * newQty;
            let subtotalEl = row.querySelector('.subtotal');
            subtotalEl.dataset.value = newSubtotal;
            subtotalEl.textContent = 'Rp ' + newSubtotal.toLocaleString('id-ID');

            updateTotal();
        });
    });

    document.querySelectorAll('.minus').forEach(btn => {
        btn.addEventListener('click', function () {
            let row = this.closest('tr');
            let qtyInput = row.querySelector('.quantity-input');
            let price = parseFloat(row.querySelector('.price').dataset.price);
            let currentQty = parseInt(qtyInput.value);

            if (currentQty > 1) {
                let newQty = currentQty - 1;
                qtyInput.value = newQty;

                let newSubtotal = price * newQty;
                let subtotalEl = row.querySelector('.subtotal');
                subtotalEl.dataset.value = newSubtotal;
                subtotalEl.textContent = 'Rp ' + newSubtotal.toLocaleString('id-ID');

                updateTotal();
            }
        });
    });

    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
});
</script>

@endsection
