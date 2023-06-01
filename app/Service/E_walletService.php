<?php


namespace App\Service;


use App\Models\E_wallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class E_walletService
{
    protected E_wallet $wallet;

    /**
     * @param E_wallet $wallet
     */
    public function setWallet(E_wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    public function createWallet($user_id)
    {
        $user = User::findOrFail($user_id);
        $wallet = $user->e_wallet;
        $wallet
            ? $this->wallet = $wallet
            : $this->wallet = $user->e_wallet()->create(['amount' => 0]);
        return $this;
    }

    public function ChargeWallet($amount)
    {
        DB::transaction(function () use ($amount) {
            $this->wallet->amount += $amount;
            $this->wallet->save();
            $this->wallet->processes()->create([
                'amount' => $amount,
                'charge' => true,
                'pay' => false,
            ]);
        });
        return $this;
    }

    public function Pay($amount)
    {
        $this->checkWallet($amount);
        DB::transaction(function () use ($amount) {
            $this->wallet->amount -= $amount;
            $this->wallet->save();
            $this->wallet->processes()->create([
                'amount' => $amount,
                'charge' => false,
                'pay' => true,
            ]);
        });
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function checkWallet($amount)
    {
        if($this->wallet->total < $amount)
            throw new \Exception('not have money in wallet ',500);
    }
}
