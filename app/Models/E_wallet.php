<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class E_wallet extends Model
{
    use HasFactory;

    protected $table = 'e-wallets';
    protected  $fillable = ['amount'];
    public function processes()
    {
        return $this->hasMany(Processes_e_wallet::class,'e-wallet_id');
    }
}
