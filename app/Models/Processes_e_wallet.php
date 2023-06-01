<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processes_e_wallet extends Model
{
    use HasFactory;
    protected $table = 'processes-e-wallets';
    protected  $fillable = ['amount','charge','pay'];
    public function e_wallet()
    {
        return $this->belongsTo(E_wallet::class);
    }
}
