@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h2>Bayar Pesanan Anda</h2>
    <p>Total Pembayaran: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></p>

    <button id="pay-button" class="btn btn-success px-4 py-2">Bayar Sekarang</button>

    <form id="payment-form" action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="json" id="json_callback">
    </form>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                document.getElementById('json_callback').value = JSON.stringify(result);
                document.getElementById('payment-form').submit();
            },
            onPending: function(result){
                document.getElementById('json_callback').value = JSON.stringify(result);
                document.getElementById('payment-form').submit();
            },
            onError: function(result){
                alert("Terjadi kesalahan saat memproses pembayaran.");
            }
        });
    };
</script>
@endsection
