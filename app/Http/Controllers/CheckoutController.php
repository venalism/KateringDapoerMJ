<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array|min:1',
        ]);

        // Simpan ID item yang dipilih ke session
        session(['selected_items' => $request->selected_items]);

        return redirect()->route('checkout.form');
    }

    public function form()
{
    $user = Auth::user();
    $addresses = Address::where('user_id', $user->id)->get();

    // Ambil item yang dipilih dari session
    $selectedIds = session('selected_items', []);

    // Ambil data cart sesuai user dan item yang dipilih
    $carts = Cart::where('user_id', $user->id)
        ->whereIn('menu_id', $selectedIds)
        ->with('menu')
        ->get();

    // Hitung total harga
    $total = 0;
    foreach ($carts as $cart) {
        $total += $cart->menu->price * $cart->quantity;
    }

    return view('checkout.form', compact('addresses', 'carts', 'total'));
}


    public function process(Request $request)
{
    $request->validate([
        'address_id' => 'required|exists:addresses,id',
    ]);

    $user = Auth::user();
    $selectedIds = session('selected_items', []);
    $carts = Cart::where('user_id', $user->id)
        ->whereIn('menu_id', $selectedIds)
        ->get();

    $total = 0;
    foreach ($carts as $cart) {
        $total += $cart->menu->price * $cart->quantity;
    }

    // Simpan order ke DB
    $order = Order::create([
        'user_id' => $user->id,
        'address_id' => $request->address_id,
        'total_price' => $total,
        'payment_method' => 'midtrans', // sementara
        'status' => 'pending',
    ]);

    foreach ($carts as $cart) {
    OrderItem::create([
        'order_id' => $order->id,
        'menu_id' => $cart->menu_id,
        'quantity' => $cart->quantity,
        'price' => $cart->menu->price,
        'subtotal' => $cart->menu->price * $cart->quantity, // ⬅️ tambahkan ini
    ]);
}


// Hapus dari keranjang
    Cart::whereIn('menu_id', $selectedIds)
        ->where('user_id', $user->id)
        ->delete();

    session()->forget('selected_items');

    // === MIDTRANS INTEGRATION ===
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = false; // ubah ke true kalau live
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => $order->id,
            'gross_amount' => (int) $order->total_price, // harus angka murni, bukan Rp.
        ],
        'customer_details' => [
            'first_name' => $user->name,
            'email' => $user->email,
        ],
    ];

    // Generate Snap Token
    $snapToken = \Midtrans\Snap::getSnapToken($params);

    // Kirim ke halaman show (pembayaran)
    return view('orders.show', compact('order', 'snapToken'));
}

    
}
