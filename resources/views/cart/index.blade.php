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
<<<<<<< HEAD
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
=======
                        <td>{{ $details['name'] }}</td>
                        <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center justify-content-between w-50">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="action" value="decrease" class="btn">-</button>
                                <span class="mx-3 h5">{{ $details['quantity'] }}</span>
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
>>>>>>> 4815c680769f25238fcfce2befe184ec8b29d847
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
                                <form action="{{ route('cart.update', $id) }}" method="POST"
                                    class="d-flex align-items-center justify-content-between w-50">
                                    @csrf
                                    @method('PATCH')

<<<<<<< HEAD
                                    <!-- Tombol Decrease -->
                                    <button type="submit" name="action" value="decrease" class="btn">-</button>

                                    <!-- Quantity di kiri tanpa input box -->
                                    <span class="mx-3 h5">{{ $details['quantity'] }}</span>

                                    <!-- Tombol Increase -->
                                    <button type="submit" name="action" value="increase" class="btn">+</button>
                                </form>
                            </td>
=======
        <div class="text-end fw-bold mb-4">
            Total: Rp {{ number_format($total, 0, ',', '.') }}
        </div>

<form method="GET" action="" onsubmit="return redirectToWhatsapp()" id="orderForm" class="bg-white p-4 shadow-sm rounded mt-4">
    <h5 class="mb-3 fw-bold">Data Pemesan</h5>

    <div class="row g-3 row-cols-1 row-cols-md-2">
        <div class="col">
            <div class="form-floating">
                <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap" required>
                <label for="nama">Nama Lengkap</label>
            </div>
        </div>
>>>>>>> 4815c680769f25238fcfce2befe184ec8b29d847

        <div class="col">
            <div class="form-floating">
                <select class="form-select" id="metode" required>
                    <option selected disabled value="">Pilih Metode</option>
                    <option value="COD">COD</option>
                    <option value="Transfer">Transfer</option>
                </select>
                <label for="metode">Metode Pembayaran</label>
            </div>
        </div>

        <div class="col">
            <div class="form-floating">
                <select class="form-select" id="delivery" required>
                    <option selected disabled value="">Pilih Pengiriman</option>
                    <option value="Diantar">Diantar</option>
                    <option value="Ambil Sendiri">Ambil Sendiri</option>
                </select>
                <label for="delivery">Metode Pengiriman</label>
            </div>
        </div>

        <div class="col">
            <div class="form-floating">
                <textarea class="form-control" id="catatan" style="height: 100px;" placeholder="Tulis catatan jika ada..."></textarea>
                <label for="catatan">Catatan (Opsional)</label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-floating">
                <textarea class="form-control" id="alamat" style="height: 100px;" placeholder="Alamat lengkap" required></textarea>
                <label for="alamat">Alamat Lengkap</label>
            </div>
        </div>
    </div>

    <div class="text-end mt-4">
        <button type="submit" class="btn btn-success px-4 py-2">Pesan via WhatsApp</button>
    </div>
</form>


        {{-- Script Kirim ke WhatsApp --}}
        <script>
            function redirectToWhatsapp() {
                const nama = document.getElementById('nama').value;
                const alamat = document.getElementById('alamat').value;
                const metode = document.getElementById('metode').value;
                const delivery = document.getElementById('delivery').value;
                const catatan = document.getElementById('catatan').value;

                let pesan = "Halo, saya mau pesan:\n";
                @foreach(session('cart') as $details)
                    pesan += "- {{ $details['name'] }} x {{ $details['quantity'] }} = Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}\n";
                @endforeach
                pesan += "\nTotal: Rp {{ number_format($total, 0, ',', '.') }}\n\n";
                pesan += "*Nama:* " + nama + "\n";
                pesan += "*Alamat:* " + alamat + "\n";
                pesan += "*Metode Pembayaran:* " + metode + "\n";
                pesan += "*Pengiriman:* " + delivery + "\n";
                if (catatan) pesan += "*Catatan:* " + catatan + "\n";

                const url = "https://wa.me/6289662315611?text=" + encodeURIComponent(pesan);
                window.open(url, '_blank');
                return false;
            }
        </script>

<<<<<<< HEAD

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
                foreach (session('cart') as $details) {
                    $subtotal = $details['price'] * $details['quantity'];
                    $whatsappMessage .= "- {$details['name']} x {$details['quantity']} = Rp " . number_format($subtotal, 0, ',', '.') . "\n";
                }
                $whatsappMessage .= "\nTotal: Rp " . number_format($total, 0, ',', '.');
                $encodedMessage = urlencode($whatsappMessage);
            @endphp

            <div class="mt-3 text-end">
                <a href="https://wa.me/6289662315611?text={{ $encodedMessage }}" target="_blank" class="btn btn-success">Pesan
                    via WhatsApp</a>
            </div>


        @else
            <div class="alert alert-info">Keranjang belanja kosong.</div>
        @endif
    </div>
@endsection
=======
    @else
        <div class="alert alert-info">Keranjang belanja kosong.</div>
    @endif
</div>

@endsection
>>>>>>> 4815c680769f25238fcfce2befe184ec8b29d847
