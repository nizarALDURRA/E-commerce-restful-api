<?php


namespace App\Action;


use App\Payment\LocalPayment;
use App\Payment\PayPalPayment;

class PaymentAction
{
    public function initialize(string $payment_type = '')
    {
        return match ($payment_type) {
            'PayPal' => new PayPalPayment(),
            default => new LocalPayment(),
        };
    }
}
