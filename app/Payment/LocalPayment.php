<?php


namespace App\Payment;


use App\Interfaces\PaymentInterface;
use App\Models\User;
use App\Service\E_walletService;

class LocalPayment implements PaymentInterface
{

    public function pay(int $user_id , $amount)
    {
        $walletService = new E_walletService();
        $walletService
            ->createWallet($user_id)
            ->Pay($amount);

    }
}
