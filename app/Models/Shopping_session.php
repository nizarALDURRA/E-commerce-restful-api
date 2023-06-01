<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shopping_session extends Model
{
    use HasFactory;

    protected $fillable = [
        'total'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Cart_item::class,'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
