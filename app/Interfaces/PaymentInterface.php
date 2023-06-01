<?php


namespace App\Interfaces;


interface  PaymentInterface
{
    /**
     * Process payment for a user.
     *
     * @return boolean
     */
    public function pay(int $user_id , $amount);
}
