<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function createTransaction(array $data);
    public function findByTrxIdAndPhoneNumber($bookingTrxId, $phoneNumber);
    public function saveToSession(array $data);
    public function getOrerDataFromSession();
    public function updateSessionData(array $data);
}
