<?php

namespace App\Repositories;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class OrderRepository implements OrderRepositoryInterface
{
    public function createTransaction(array $data)
    {
        return Order::create($data);
    }

    public function findByTrxIdAndPhoneNumber($bookingTrxId, $phoneNumber)
    {
        return Order::where('booking_trx_id', $bookingTrxId)
                    ->where('phone_number', $phoneNumber)
                    ->first();
    }

    public function saveToSession(array $data)
    {
        Session::put('OrderData', $data);
    }

    public function getOrerDataFromSession()
    {
        return session('orderData', []);
    }

    public function updateSessionData(array $data)
    {
        $orderData = session('orderData', []);
        $orderData = array_merge($orderData, $data);
        session(['orderData'=> $orderData]);
    }
}