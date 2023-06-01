<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'total'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Order_item::class,'order_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment_details::class);
    }
}
