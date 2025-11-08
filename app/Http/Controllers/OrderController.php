<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan user.
     */
    public function index()
    {
        $user = Auth::user();

        // Jika admin, tampilkan semua pesanan
        if ($user->isAdmin()) {
            $orders = Order::with('orderItems.menu', 'address', 'user')->latest()->get();
        } else {
            $orders = Order::where('user_id', $user->id)
                ->with('orderItems.menu', 'address')
                ->latest()
                ->get();
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan berdasarkan ID.
     */
    public function show($id)
    {
        $order = Order::with('orderItems.menu', 'address', 'user')->findOrFail($id);

        // Batasi agar user hanya bisa melihat pesanan miliknya sendiri
        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke pesanan ini.');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Update status pesanan (untuk admin).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,paid,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
