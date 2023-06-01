<?php


namespace App\Payment;


use App\Interfaces\PaymentInterface;

class PayPalPayment implements PaymentInterface
{
    public function pay(int $user_id , $amount)
    {

    }
}
